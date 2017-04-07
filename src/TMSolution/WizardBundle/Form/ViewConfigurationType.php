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
    
    protected $mapReader;
    
    public function __construct($mapReader)
    {
        $this->mapReader=$mapReader;
        
    }
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('address')->add('viewType')
        ->add('entity', ChoiceType::class, [
            'label' => 'Entity',
            'choices' => $this->mapReader->getEntities()
        ]);
        
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TMSolution\WizardBundle\Entity\ViewConfiguration',
   
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
