<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/07/16
 * Time: 09:48
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="Contact")
     */
    public function contactAction(Request $request)
    {
        //-- var to display a message to the user
        $messageFinal = "";

        //-- we create a form without any entity
        $form = $this->createFormBuilder()
            ->add("Name", TextType::class, [
                'label' => 'Enter your name',
            ])
            ->add("Email", EmailType::class, [
                'label' => 'Your email',
            ])
            ->add("Sex", ChoiceType::class, [
                'choices' => [
                    'Female' => 'f',
                    'Male' => 'm',
                ]
            ])
            ->add("countries", EntityType::class, [
                'class' => 'AppBundle\Entity\Country',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add("Message", TextareaType::class, [
                'label' => 'Your message',
            ])
            ->add("Send Message", SubmitType::class);
        $form = $form->getForm();

        //-- populate the form with user's entries
        $form->handleRequest($request);

        if($form->isValid()){
            //-- when the form is valid, we prepare the finalMessage
            //-- we use $form->getData() to get an array containing all
            //-- the form parameters
            $messageFinal = "Merci "
                . $form->getData()["Name"] . ", "
                . "nous vous contacterons prochainement";


            //-- genere un event
            $this->get('event_dispatcher')->dispatch(
                'new_contact_msg', new GenericEvent($messageFinal)
            );

        }

        //-- generate the html form
        return $this->render("contact/contact.html.twig",
            ["myForm" => $form->createView(),
            "messageFinal" => $messageFinal]);
    }
}