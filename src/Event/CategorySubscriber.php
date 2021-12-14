<?php
namespace App\Event;

use App\Entity\Event;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;

class CategorySubscriber implements EventSubscriberInterface
{
    private $em;
    private $eventRepository;
    private $categoryRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->eventRepository = $this->em->getRepository(Event::class);
        $this->categoryRepository = $this->em->getRepository(Category::class);
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityDeletedEvent::class => ['unsetEventCategory'],
        ];
    }

    public function unsetEventCategory(BeforeEntityDeletedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if(!$entity instanceof Category){
            return;
        }

        $newCategory = $this->categoryRepository->getOneWithExclusion($entity);

        $events = $this->eventRepository->findBy([
            'category' => $entity,
        ]);

        foreach($events as $event){
            $event->setCategory($newCategory);
        }

        $this->em->flush();
    }
}