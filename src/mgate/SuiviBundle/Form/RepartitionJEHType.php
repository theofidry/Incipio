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

class RepartitionJEHType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('nbrJEH', 'integer', array('required' => true))
                ->add('prixJEH', 'integer', array('required' => true, 'attr' => array('min' => 80, 'max' => 320)));
    }

    public function getName()
    {
        return 'mgate_suivibundle_RepartitionJEHType';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\SuiviBundle\Entity\RepartitionJEH',
            'type' => '',
            'prospect' => '',
            'phases' => '',
        ));
    }
}
