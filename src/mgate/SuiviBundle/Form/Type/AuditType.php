<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\SuiviBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilder;

class AuditType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'n' => 'Non audité',
                'e' => 'Exhaustive',
                'd' => 'Déontologique',
            ),
        ));
    }

    public function getParent(array $options)
    {
        return 'choice';
    }

    public function getName()
    {
        return 'auditType';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('gender_code', new GenderType(), array(
            'placeholder' => 'Type d\'audit',
        ));
    }
}
