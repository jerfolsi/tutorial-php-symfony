<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/07/16
 * Time: 15:59
 */

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class UserLastAuthenticated
{
    private $doctrineManager;

    public function __construct(ObjectManager $doctrineManager)
    {
        $this->doctrineManager = $doctrineManager;
    }

    public function authenticationSuccess(AuthenticationEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if(!$user instanceof User){
            return;
        }
        $user->setLastAuthenticatedAt(new \DateTime());
        $this->doctrineManager->flush($user);
    }
}