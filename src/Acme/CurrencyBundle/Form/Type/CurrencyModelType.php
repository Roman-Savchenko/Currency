<?php

namespace Acme\CurrencyBundle\Form\Type;

use Acme\CurrencyBundle\Entity\CurrencyDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyModelType extends AbstractType
{
    const NAME = 'currency_type';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currency_abbreviation', 'entity', array(
                'label' => 'Currency',
                'class' => 'AcmeCurrencyBundle:Currency',
                'choice_label' => 'currency_abbreviation'
            ))
            ->add('date', 'date', array(
                'label' => 'Date',
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd',
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\CurrencyBundle\Model\CurrencyModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
