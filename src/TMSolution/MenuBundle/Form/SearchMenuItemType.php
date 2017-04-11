<?php

namespace TMSolution\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class SearchMenuItemType extends AbstractType {

    
    /**
     * 
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name',Filters\TextFilterType::class)->add('route',Filters\TextFilterType::class)
                ->add('position',Filters\NumberFilterType::class)->add('parent', null, ['attr' => ["class" => "chosen"]]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TMSolution\MenuBundle\Entity\MenuItem',
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'menu_menuitem';
    }
    
    
    

}
