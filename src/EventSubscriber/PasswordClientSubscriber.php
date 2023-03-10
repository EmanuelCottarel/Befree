<?php

namespace App\EventSubscriber;

use App\Entity\Clients;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class PasswordClientSubscriber implements EventSubscriberInterface
{

    public function __construct(protected UserPasswordHasherInterface $passwordHasher)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onBeforeEntityPersistedClient',
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityPersistedClient',
        ];
    }

    public function onBeforeEntityPersistedClient(BeforeEntityUpdatedEvent|BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Clients) {
            return;
        }

        if (!is_null($entity->getPlainPassword()) && '' != $entity->getPlainPassword()) {
            $entity->setPassword(
                $this->passwordHasher->hashPassword($entity, $entity->getPlainPassword())
            );
        }
    }
}
