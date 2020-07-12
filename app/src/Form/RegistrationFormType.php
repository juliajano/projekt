<?php
/**
 * Registration type.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationFormType.
 */
class RegistrationFormType extends AbstractType
{
    /**
     * Builder form.
     *
     * @param FormBuilderInterface $builder Form Builder Interface
     * @param array                $options Array
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'label_email',
                    'required' => true,
                ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'type' => PasswordType::class,
                    'required' => true,
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank(),
                        new Length(
                            [
                                'min' => 6,
                                'max' => 255,
                            ]
                        ),
                    ],
                    'first_options' => ['label' => 'label_password'],
                    'second_options' => ['label' => 'label_confirm_password'],
                ]
            )
            ->add(
                'userdata',
                UserDataType::class,
                [
                    'label' => 'label_userdata',
                    'required' => true,
                ]
            );
    }

    /**
     * Configure options.
     *
     * @param OptionsResolver $resolver Options Resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
