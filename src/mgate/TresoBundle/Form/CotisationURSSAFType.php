<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\TresoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CotisationURSSAFType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'text', array('label' => 'Libelle'))
            ->add('dateDebut', 'genemu_jquerydate', array('label' => 'Applicable du', 'required' => true, 'widget' => 'single_text'))
            ->add('dateFin', 'genemu_jquerydate', array('label' => 'Applicable au', 'required' => true, 'widget' => 'single_text'))
            ->add('tauxPartJE', 'percent', array('label' => 'Taux Part Junior', 'required' => false, 'precision' => 2))
            ->add('tauxPartEtu', 'percent', array('label' => 'Taux Part Etu', 'required' => false, 'precision' => 2))
            ->add('isSurBaseURSSAF', 'checkbox', array('label' => 'Est indexé sur la base URSSAF ?', 'required' => false))
            ->add('deductible', 'checkbox', array('label' => 'Est déductible ?', 'required' => false));
    }

    public function getName()
    {
        return 'mgate_tresobundle_cotisationurssaftype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\TresoBundle\Entity\CotisationURSSAF',
        ));
    }
}
