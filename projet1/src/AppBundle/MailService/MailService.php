<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/07/16
 * Time: 12:07
 */

namespace AppBundle\MailService;


class MailService
{
    public function __construct()
    {

    }

    public function onNewContactMsg($message)
    {
        dump($message);
    }

}