<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animal;
use AppBundle\Entity\Bird;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class BirdController extends Controller
{
    /**
     * @Route ("/birds/list", name="birdList")
     *
     */
     public function listAction(Request $request)
     {
         //step1 : get the entity manager
         $em = $this->getDoctrine()->getManager();

         //step2 : use the repository to make a request
         $birds = $em->getRepository("AppBundle:Bird")->findAll();

         //step3 : rendrer the result
         return $this->render("bird/list.html.twig", [
             'birds' => $birds
         ]);
     }

    /**
     * @Route ("/birds/add", name="birdadd")
     *
     */
    public function addAction(Request $request)
    {
        //step1 : get the entity manager
        $em = $this->getDoctrine()->getManager();

        //step2 : get the request Builder
        $newBird = new Bird();

        //step3 : get the form
        //le bird est un objet descandant de animal : on peut inclure une liste
        //déroulante permettant de chosiir un animal
        $form = $this->createFormBuilder($newBird)
            ->add("animal", EntityType::class, [
                'class' => 'AppBundle\Entity\Animal',
                'choice_label' => 'name'
            ])
            ->add("wingLength", IntegerType::class)
            ->add("save", SubmitType::class);
        $form = $form->getForm();

        $form->handleRequest($request);

        if($form->isValid()){
            $em->persist($newBird);
            $em->flush();
            return $this->redirectToRoute("animalList");
        }

        //--step : generate the html form
        return $this->render("bird/add.html.twig",
            ["myform" => $form->createView()]);
    }
}
