<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/07/16
 * Time: 14:50
 */

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @Route("/api/user/search/{q}", name="ApiUserSearch")
     *
     */
    public function searchAction($q, Request $resquest)
    {

        $em = $this->getDoctrine()->getManager();
        $userList = $em->getRepository("AppBundle:User")->getUsersByNameQuery($q);
        $result = [];

        foreach($userList as $user)
        {
            //$result[$user->getId()] = $user->getLogin();
            $result[] = $user;
        }

        return new JsonResponse($result);
    }
}
