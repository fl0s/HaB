<?php

namespace AppBundle\Form;

use AppBundle\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'date', [
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'placeholder' => 'jj/mm/aaaa',
            ])
            ->add('description', 'textarea', [
                'label' => 'Rapport publique',
                'required' => false,
            ])
            ->add('privateDescription', 'textarea', [
                'label' => 'Rapport interne',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }

    public function getName()
    {
        return 'event_form';
    }
}
