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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CcType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('cc', new SubCcType(), array('label' => ' ', 'prospect' => $options['prospect']))
                    ->add('acompte', 'checkbox', array('label' => 'Acompte', 'required' => false))
                    ->add('pourcentageAcompte', 'percent', array('label' => 'Pourcentage acompte', 'required' => false));
    }

    public function getName()
    {
        return 'mgate_suivibundle_cctype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\SuiviBundle\Entity\Etude',
            'prospect' => '',
        ));
    }
}

class SubCcType extends DocTypeType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        DocTypeType::buildForm($builder, $options);
        // aucun champ propre a CC
    }

    public function getName()
    {
        return 'mgate_suivibundle_subcctype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\SuiviBundle\Entity\Cc',
            'prospect' => '',
        ));
    }
}
