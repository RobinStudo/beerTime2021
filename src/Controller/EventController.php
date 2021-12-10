<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Booking;
use App\Form\EventType;
use App\Service\PaymentService;
use Symfony\Component\Uid\Uuid;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/event', name: 'event_')]
class EventController extends AbstractController
{
    private $em;
    private $eventRepository;
    private $paymentService;

    public function __construct(
        EntityManagerInterface $em, 
        EventRepository $eventRepository,
        PaymentService $paymentService
    ){
        $this->em = $em;
        $this->eventRepository = $eventRepository;
        $this->paymentService = $paymentService;
    }

    #[Route('', name: 'list')]
    public function list(): Response
    {
        $events = $this->eventRepository->findAll();

        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $event = $this->eventRepository->find($id);

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/new', name: 'new')]
    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    #[IsGranted('EVENT_FORM', subject: 'event')]
    public function form(Request $request, Event $event = null): Response
    {
        if($event){
            $isNew = false;
        }else{
            $event = new Event();
            $event->setOwner($this->getUser());
            $isNew = true;
        }
        $form = $this->createForm(EventType::class, $event);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($event);
            $this->em->flush();

            $message = sprintf('Votre événement à bien été %s', $isNew ? 'créé' : 'modifié');
            $this->addFlash('notice', $message);
            return $this->redirectToRoute('event_show', [
                'id' => $event->getId(),
            ]);
        }

        return $this->render('event/form.html.twig', [
            'form' => $form->createView(),
            'isNew' => $isNew
        ]);
    }

    #[Route('/{id}/booking', name: 'booking', requirements: ['id' => '\d+'])]
    public function booking(Request $request, Event $event): Response
    {
        if($request->query->has('payment_intent')){
            $paymentIntentId = $request->query->get('payment_intent');

            if($this->paymentService->checkPaymentIntent($paymentIntentId)){
                $booking = new Booking();
                $booking->setEvent($event);
                $booking->setUser($this->getUser());
                $booking->setReference(Uuid::v4());

                $this->em->persist($booking);
                $this->em->flush();

                return $this->render('event/booking-confirmation.html.twig', [
                    'booking' => $booking,
                ]);
            }
        }

        $paymentIntent = $this->paymentService->createPaymentIntent($event->getPrice());

        return $this->render('event/booking.html.twig', [
            'event' => $event,
            'paymentPublicKey' => $this->paymentService->getPublicKey(),
            'paymentIntentSecret' => $paymentIntent->client_secret
        ]);
    }
}
