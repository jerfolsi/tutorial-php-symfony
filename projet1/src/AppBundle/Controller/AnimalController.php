<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animal;
use AppBundle\Repository\AnimalFoodRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class AnimalController extends Controller
{
    /** ---------------------------------------------------------------
     * @Route("/animal/addbasket/{id}", name="addAnimalBasket")
     *
     */
    public function addAnimalBasket($id, Request $request)
    {
        //-- we get a reference to the service 'app.shop.basket'
        $basket = $this->get("app.shop.basket");

        //-- get the Doctrine manager
        $em = $this->getDoctrine()->getManager();

        //-- we use the repository to get the right instance of animal
        $animal = $em->getRepository("AppBundle:Animal")->find($id);

        //-- add our instance to the basket
        $basket->add($animal);

        //-- we get a reference to the referer before redirecting to it
        //-- we get back to the page from where we come
        $referer = $request->headers->get("referer");
        return $this->redirect($referer);
    }

    /** ---------------------------------------------------------------
     * @Route("/animal/{id}/addCountry", name="animalAddCountryForm")
     *
     */
    public function addCountryAction($id, Request $request)
    {
        //--step : get the doctrine's manager
        $em = $this->getDoctrine()->getManager();

        //--get the instance of current animal
        $animal = $em->getRepository("AppBundle:Animal")->find($id);

        //--step : create a form
        $form = $this->createFormBuilder($animal)
            ->add("countries", EntityType::class, [
                'class' => 'AppBundle\Entity\Country',
                'choice_label' => 'name',
                'multiple' => 'true'
            ])
            ->add("save", SubmitType::class);
        $form = $form->getForm();

        //--step : handle the pressed button action
        $form->handleRequest($request);

        if($form->isValid()){
            //prepare toi, je vais vouloir l'enregistrer
            $em->persist($animal);

            //let's go
            $em->flush();

            //redirect to the animal list
            return $this->redirectToRoute("animalList");
        }

        //--step : generate the html form
        return $this->render("animal/addCountry.html.twig",
            ["myform" => $form->createView()]);
    }



    /** -------------------------------------------------------------
     * @Route("/animal/add", name="animalForm")
     */
    public function addAction(Request $request)
    {
        //--step : get the doctrine's manager
        $em = $this->getDoctrine()->getManager();

        //--step : create a empty instance of animal
        $newAnimal = new Animal();

        //--step : create a form. A form is associated to 1 instance of an entity
        $form = $this->createFormBuilder($newAnimal)
                ->add("name", TextType::class)
                ->add("weight", IntegerType::class)
                ->add("save", SubmitType::class);
        $form = $form->getForm();

        //--step : handle the pressed button action
        $form->handleRequest($request);

        if($form->isValid()){
            //prepare toi, je vais vouloir l'enregistrer
            $em->persist($newAnimal);

            //let's go
            $em->flush();

            //redirect to the animal list
            return $this->redirectToRoute("animalList");
        }

        //--step : generate the html form
        return $this->render("animal/add.html.twig",
            ["myform" => $form->createView()]);
    }


    /** -------------------------------------------------------------
     * @Route("/animal/{id}", name="animalFiche", requirements={"id":"\d+"})
     */
    public function getAction(Animal $animal, Request $request)
    {
        //requirements={'id':'\d+'} => on lui dit que ce param contient 1 ou + digits

        //entite manager : em
        $em = $this->getDoctrine()->getManager();

        //-- on a plus besoin de récupérer l'animal via 'find($id)' car
        //-- on a utilisé le paramConverter dans cet exempe
        //recupere l'animal depuis le $id passé en paramètre
        //$animal = $em->getRepository("AppBundle:Animal")->find($id);

        //construit un tableau des aliments mangés par l'animal
        $foodList = $em->getRepository("AppBundle:AnimalFood")->findAllFromAnimal($animal->getId());

        $totalEaten = $em->getRepository("AppBundle:AnimalFood")->getTotalNbUnityEaten($animal->getId());

        $totalCost = $em->getRepository("AppBundle:AnimalFood")->getTotalCostFoodByAnimal($animal->getId());


        return $this->render('animal/fiche.html.twig', [
            'animal' => $animal,
            'foodList' => $foodList,
            'totalEaten' => $totalEaten[0]['totalFoodEaten'],
            'totalCost' => $totalCost[0]['totalCost']
        ]);
    }


    /** -------------------------------------------------------------
         * @Route("/animal/list", name="animalList")
     */
    public function listAction(Request $request)
    {
        //entite manager : em
        $em = $this->getDoctrine()->getManager();

        $animals = $em->getRepository("AppBundle:Animal")->findAll();

        $heaviestAnimals = $em->getRepository("AppBundle:Animal")->findHeaviest(10);

        $animalsFromFrance = $em->getRepository("AppBundle:Animal")->findAllFromCountry("France");

        $basket = $this->get("app.shop.basket");
        dump($basket);



        return $this->render('animal/list.html.twig', [
            'animals' => $animals,
            'heaviestAnimals' => $heaviestAnimals,
            'animalsFromFrance' => $animalsFromFrance
        ]);
    }

    /** -------------------------------------------------------------
     * @Route ("/birds/list", name="birdList")
     *
     */
     public function birdListAction(Request $request)
     {
         //step1 : get the entity manager
         $em = $this->getDoctrine()->getManager();

         $birds = $em->getRepository("AppBundle:Bird")->findAll();

         return $this->render("animal/list.html.twig", [
             'animals' => $birds
         ]);
     }


}
