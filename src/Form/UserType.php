<?php
namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType 
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('email', EmailType::class,['attr' => ['class' => 'form-control']])

            ->add('username', TextType::class,['attr' => ['class' => 'form-control']])

            ->add('plainPassword', RepeatedType::class,[
               'type' => PasswordType::class,
               'first_options' => ['label' => 'Password'],
               'second_options' => ['label' => 'Repeat Password'],
               'options' => ['attr' => ['class' => 'form-control']]
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'form-control btn-success'],
                'label' => 'Register']
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}