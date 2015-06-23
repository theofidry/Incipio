<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\PersonneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use mgate\PersonneBundle\Entity\Prospect;

class ProspectType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nom', 'text')
                ->add('entite', 'choice', array('choices' => Prospect::getEntiteChoice(), 'required' => false))
                ->add('adresse', 'text', array('required' => false));
    }

    public function getName()
    {
        return 'mgate_suivibundle_prospecttype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\PersonneBundle\Entity\Prospect',
        ));
    }
}
