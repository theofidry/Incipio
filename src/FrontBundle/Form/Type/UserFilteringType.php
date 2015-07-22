<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * FormType used to generate the form for filtering users by their type and mandates.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserFilteringType extends AbstractType
{
    /**
     * @var array
     */
    private $mandates;

    /**
     * @param array $mandates Array where keys are Mandate IRI and values are their matching name.
     */
    public function __construct(array $mandates)
    {
        $this->mandates = array_merge(['Tous' => -1], $mandates);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'mandate_id',
                'choice',
                [
                    'choices'           => $this->mandates,
                    'choices_as_values' => true,
                    'label'             => 'Mandat :'
                ]
            )
            ->add(
                'user_type',
                'choice',
                [
                    'choices'           => [
                        'Tous'        => -1,
                        'Membre'      => 0,
                        'Intervenant' => 1,
                    ],
                    'choices_as_values' => true,
                    'label'             => 'Type :'
                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'front_user_filtering';
    }
}
