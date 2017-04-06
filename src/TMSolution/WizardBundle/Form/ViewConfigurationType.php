<?php

namespace TMSolution\WizardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViewConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('address')->add('viewType')
        ->add('entity', ChoiceType::class, [
            'label' => 'Entity',
            'choices' => $options['form_options']['entities']
        ]);
        
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TMSolution\WizardBundle\Entity\ViewConfiguration',
            'form_options'=>[]
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tmsolution_wizardbundle_viewconfiguration';
    }


}
