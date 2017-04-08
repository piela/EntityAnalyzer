<?php

namespace TMSolution\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TMSolution\MenuBundle\Transformer\ArrayToJSONStringTransformer;

class MenuItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('route')->add('routeParameters')
                ->add('position')->add('parent',null,['attr'=>["class"=>"chosen"]]);
    
        $builder->get('routeParameters')->addModelTransformer(new ArrayToJSONStringTransformer());
        
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TMSolution\MenuBundle\Entity\MenuItem'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tmsolution_menubundle_menuitem';
    }


}
