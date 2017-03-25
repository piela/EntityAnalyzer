<?php

namespace TMSolution\EntityAnalyzerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateFrom')->add('dateTo')->add('transactionName')->add('payed')->add('quantity')->add('endPrice')->add('currency')->add('productDefinition')->add('transaction')->add('paymentFrequency');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TMSolution\EntityAnalyzerBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tmsolution_entityanalyzerbundle_product';
    }


}
