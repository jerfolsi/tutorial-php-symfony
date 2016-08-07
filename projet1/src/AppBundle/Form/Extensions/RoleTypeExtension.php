<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/07/16
 * Time: 11:05
 */

namespace AppBundle\Form\Extensions;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class RoleTypeExtension extends AbstractTypeExtension
{
    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(null !== $options['role_min'] && !$this->authorizationChecker->isGranted($options['role_min'])){
           $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
               //recupere la ligne du formulaire sur laquelle l'evenement s'est déclenché
               $form = $event->getForm();

               //si l'element est racine alors on ne fait rien
               //je ne sais pas pourquoi on fait ce test d'ailleurs?
               if($form->isRoot()){
                   return;
               }

               //on retire l'élement du formulaire
               $form->getParent()->remove($form->getName());
           });
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('role_min', null);
    }

    public function getExtendedType()
    {
        return FormType::class;
    }
}