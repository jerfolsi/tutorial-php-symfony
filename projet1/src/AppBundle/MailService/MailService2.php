<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/07/16
 * Time: 12:07
 */

namespace AppBundle\MailService;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailService2 implements EventSubscriberInterface
{
    public function __construct()
    {

    }

    public function onNewContactMsg($message)
    {
        dump($message);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'new_contact_msg' => array('onNewContactMsg', -10),
        );
    }

}