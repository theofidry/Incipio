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

class GroupePhasesType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('numero', 'hidden', array('attr' => array('class' => 'position')))
                ->add('titre', 'text')
                ->add('description', 'textarea', array('label' => 'Description', 'required' => false));
    }

    public function getName()
    {
        return 'mgate_suivibundle_groupePhasestype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\SuiviBundle\Entity\GroupePhases',
        ));
    }
}
