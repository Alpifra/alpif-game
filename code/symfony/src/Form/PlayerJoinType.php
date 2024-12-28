<?php

namespace App\Form;

use App\Config\AvatarEnum;
use App\Entity\Player;
use App\Form\DataTransformer\SessionHashTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerJoinType extends AbstractType
{
    public function __construct(
        private readonly SessionHashTransformer $sessionHashTransformer
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar', EnumType::class, [
                'class' => AvatarEnum::class
            ])
            ->add(
                'username',
                TextType::class,
                ['attr' => ['placeholder' => 'Username']]
            )
            ->add(
                'session',
                TextType::class,
                [
                    'mapped' => false,
                    'attr'   => ['placeholder' => 'Code de session']
                ]
            )
        ;
        $builder->get('session')->addModelTransformer($this->sessionHashTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
