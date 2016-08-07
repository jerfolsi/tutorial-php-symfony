<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/07/16
 * Time: 10:40
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("login", TextType::class)
            ->add("password", RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm password'],
            ])
            ->add("isAdmin", CheckboxType::class, [
                'required' => false,
                'role_min' => 'ROLE_ADMIN',
            ])
            ->add("isManager", CheckboxType::class,[
                'required' => false,
                'role_min' => 'ROLE_ADMIN',
            ])
            ->add("save", SubmitType::class);
    }
}