<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $types = (isset($options['data']['types']))? $options['data']['types']: [];

        $builder
            ->add(
                'username',
                'text',
                [
                    'attr'  => [
                        'placeholder' => 'prenom.nom',
                    ],
                    'label' => 'Nom d\'utilisateur',
                ])
            ->add(
                'fullname',
                'text',
                [
                    'attr'  => [
                        'placeholder' => 'Prénom NOM',
                    ],
                    'label' => 'Nom complet',
                ])
            ->add(
                'email',
                'email',
                [
                    'attr'  => [
                        'placeholder' => 'email@example.com',
                    ],
                    'label' => 'Email',
                ])
            ->add(
                'organizationEmail',
                'email',
                [
                    'label'    => 'Email professionnel',
                    'attr'     => [
                        'placeholder' => 'email@example.com',
                    ],
                    'required' => false,
                ])
            ->add(
                'endingSchoolYear',
                'integer',
                [
                    'attr'      => [
                        'placeholder' => 2015,
                    ],
                    'precision' => 0,
                    'required'  => false,
                ])
            ->add(
                'user_type',
                'choice',
                [
                    'choices'  => [
                        'TYPE_MEMBER'     => 'Membre',
                        'TYPE_CONTRACTOR' => 'Intervenant',
                    ],
                    'label'    => 'Type(s) :',
                    'expanded' => true,
                    'multiple' => true,
                    'data'     => $types
                ]
            )
            ->add('enabled', 'checkbox', ['label' => 'Activé'])
            // convention étudiante
            // mandate
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'front_user';
    }
}
