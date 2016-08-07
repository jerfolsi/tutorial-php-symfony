<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animal;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Repository\AnimalFoodRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("user/search", name="searchUser")
     *
     */
    public function searchAction(Request $request)
    {
        return $this->render("user/search.html.twig", [

        ]);
    }

    /**
     * @Route("/user/logout", name="logout")
     *
     */
    public function logoutAction(Request $request)
    {

    }

    /**
     * @Route("/user/login", name="loginUser")
     *
     */
    public function loginAction(Request $request)
    {
        $user = $this->getUser();

        //dump($user);
        //dump($user);
        if($user instanceof UserInterface){
            return $this->redirectToRoute('animaList');
        }
        $exception = $this->get('security.authentication_utils')
            ->getLastAuthenticationError();

        //dump($exception);

        //exemple d'utilisatin du serveir userlogger !!
        if($exception != null) {
            $this->get('app.logger.userlogger')->log($exception->getMessage());
        }

        return $this->render('user/login.html.twig', [
            'error' => $exception ? $exception->getMessage() : NULL
        ]);
    }

    /**
     * @Route("/user/{id}", name="UpdateUserForm", requirements={"id" : "\d+"})
     */
    public function updateAction($id, Request $request)
    {
        //--step : get the doctrine's manager
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("AppBundle:User")->find($id);

        $savedPassword = $user->getPassword();

        //--step : create a form
        /*
        $form = $this->createFormBuilder($user)
            ->add("login", TextType::class)
            ->add("password", TextType::class, [
                'required' => false,
                'data' => ''
            ])
            ->add("save", SubmitType::class);
        $form = $form->getForm();
        */

        $form = $this->createForm(UserType::class, $user);

        //--step : handle the pressed button action
        $form->handleRequest($request);

        if($form->isValid()){
            //prepare toi, je vais vouloir l'enregistrer
            $em->persist($user);

            if($user->getPassword() != ''){
                $user->setPassword(
                    password_hash($user->getPassword(),
                        PASSWORD_BCRYPT)
                );
            }else{
                $user->setPassword($savedPassword);
            }

            //let's go
            $em->flush();

            //redirect to the animal list
            return $this->redirectToRoute("animalList");
        }

        //--step : generate the html form
        return $this->render("user/add.html.twig",
            ["myform" => $form->createView()]);
    }

    /**
     * @Route("/user/add", name="AddUserForm")
     */
    public function addAction(Request $request)
    {
        //--step : get the doctrine's manager
        $em = $this->getDoctrine()->getManager();

        $newUser = new User();

        //--step : create a form
        /*
        $form = $this->createFormBuilder($newUser)
            ->add("login", TextType::class)
            ->add("password", TextType::class)
            ->add("save", SubmitType::class);
        */

        //we create a form using our UserType class
        //this is the good way to implement a form with symfony
        $form = $this->createForm(UserType::class, $newUser);

        //--step : handle the pressed button action
        $form->handleRequest($request);

        if($form->isValid()){
            //prepare toi, je vais vouloir l'enregistrer
            $em->persist($newUser);

            $newUser->setPassword(
                password_hash($newUser->getPassword(),
                    PASSWORD_BCRYPT)
            );

            //let's go
            $em->flush();

            //redirect to the animal list
            return $this->redirectToRoute("animalList");
        }

        //--step : generate the html form
        return $this->render("user/add.html.twig",
            ["myform" => $form->createView()]);
    }

}
