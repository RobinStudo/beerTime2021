<?php
namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // TODO - Remplacer par l'utilisateur connecté
            $user = $this->em->getRepository(User::class)->find(1);
            $event->setOwner($user);

            $this->em->persist($event);
            $this->em->flush();

            $this->addFlash('notice', 'Votre événement à bien été créé');
            return $this->redirectToRoute('event_show', [
                'id' => $event->getId(),
            ]);
        }

        return $this->render('event/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

// Formulaire d'inscription
// Etape 1
// Création du formulaire via ligne de commande /
// Création d'un contrôleur / d'une route / d'une vue /
// Initialiser le formulaire dans le contrôleur et le passer à la vue /
// Etape 2
// Afficher et mettre en forme le formulaire
// Et le configurer via les options du Type
// Etape 3
// Connecter la requête au formulaire
// Mettre en place les contraintes de validation
// (facultatif) Hasher le mot de passe
// Ajouter en base de donnée si formulaire ok
// Gérer le retour utilisateur (redirection / confikrmation)