<?php

namespace App\EventSubscriber;

use App\Event\ContainsEvents;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class DomainEventsSubscriber implements EventSubscriber
{
    private $entities;

    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
        $this->entities = new ArrayCollection();
    }

    public function getSubscribedEvents(): array
    {
        return [
            'prePersist',
            'preUpdate',
            'preRemove',
            'preFlush',
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->addContainsEventsEntityToCollection($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->addContainsEventsEntityToCollection($args);
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->addContainsEventsEntityToCollection($args);
    }

    public function preFlush(PreFlushEventArgs $args): void
    {
        $unitOfWork = $args->getEntityManager()->getUnitOfWork();
        foreach ($unitOfWork->getIdentityMap() as $class => $entities) {
            if (!\in_array(ContainsEvents::class, class_implements($class), true)) {
                continue;
            }
            foreach ($entities as $entity) {
                $this->entities->add($entity);
            }
        }

        $events = new ArrayCollection();
        foreach ($this->entities as $entity) {
            foreach ($entity->getRecordedEvents() as $domainEvent) {
                $events->add($domainEvent);
            }
            $entity->clearRecordedEvents();
        }
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event, get_class($event));
        }
    }

    private function addContainsEventsEntityToCollection(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof ContainsEvents) {
            $this->entities->add($entity);
        }
    }
}
