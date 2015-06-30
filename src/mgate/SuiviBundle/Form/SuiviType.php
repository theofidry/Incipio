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

class SuiviType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'date', array('label' => 'Date du suivi'))
                ->add('etat', 'textarea', array('label' => 'Etat de l\'étude', 'attr' => array('cols' => '100%', 'rows' => 5)))
                ->add('todo', 'textarea', array('label' => 'Taches à faire', 'attr' => array('cols' => '100%', 'rows' => 5)));
    }

    public function getName()
    {
        return 'mgate_suivibundle_clientcontacttype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'mgate\SuiviBundle\Entity\Suivi',
            ));
    }
}
