<?php

namespace AppBundle\Form;

use AppBundle\Entity\EvacuationProvider;
use AppBundle\Entity\Rescue;
use AppBundle\Entity\RescueProvider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\RescueType as RTE;

class RescueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('time', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('type', EntityType::class, [
                'class' => RTE::class,
                'choice_label' => 'name',
            ])
            ->add('evacuationProvider', EntityType::class, [
                'class' => EvacuationProvider::class,
                'choice_label' => 'name',
                'empty_data' => null,
                'placeholder' => 'form.rescue.no_evacuation',
                'required' => false,
            ])
            ->add('provider', EntityType::class, [
                'class' => RescueProvider::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rescue::class,
            'label_format' => 'form.rescue.%name%',
        ]);
    }

    public function getName()
    {
        return 'rescue_form';
    }
}
