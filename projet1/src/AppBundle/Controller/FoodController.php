<?php

namespace AppBundle\Controller;

use AppBundle\Repository\AnimalFoodRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FoodController extends Controller
{
    /**
     * @Route("/food/{id}", name="foodFiche")
     */
    public function getAction($id, Request $request)
    {
        //entite manager : em
        $em = $this->getDoctrine()->getManager();

        //recupere l'animal depuis le $id passé en paramètre
        $food = $em->getRepository("AppBundle:Food")->find($id);

        $totalCost = $em->getRepository("AppBundle:AnimalFood")->getTotalCostFood($food->getId());

        return $this->render('food/fiche.html.twig', [
            'food' => $food,
            'totalCost' => $totalCost[0]['totalCost'],
        ]);
    }


}
