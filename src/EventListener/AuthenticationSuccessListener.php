<?php

namespace App\EventListener;

use ApiPlatform\Metadata\IriConverterInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function __construct(
        private IriConverterInterface $iriConverter
    ) {
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['@id'] = $this->iriConverter->getIriFromResource($user);
        $data['id'] = $user->getId();
        $data['email' ] = $user->getUserIdentifier();
        $data['firstname'] = $user->getFirstName();
        $data['lastname'] = $user->getLastName();
        $data['fullname'] = $user->getFullname();
        $data['roles'] = $user->getRoles();

        $event->setData($data);
    }
}
