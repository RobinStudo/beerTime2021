<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Form\EventType;
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

    public function __construct(EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $this->em = $em;
        $this->eventRepository = $eventRepository;
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
}
