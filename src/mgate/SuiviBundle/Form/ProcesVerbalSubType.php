<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\SuiviBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProcesVerbalSubType extends DocTypeType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $phaseNum = $options['phases'];
        if ($options['type'] == 'pvi') {
            $builder->add('phaseID', 'integer', array('label' => 'Phases concernées', 'required' => false, 'attr' => array('min' => '1', 'max' => $phaseNum)));
        }

        DocTypeType::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'mgate_suivibundle_procesverbalsubtype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\SuiviBundle\Entity\ProcesVerbal',
            'type' => null,
            'prospect' => null,
            'phases' => null,
        ));
    }
}
