<?php

namespace FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UserFilteringForm.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserFilteringForm extends AbstractType
{
    /**
     * @var array
     */
    private $mandates;

    /**
     * @param array $mandates Array where keys are Mandate IRI and values are their matching name.
     */
    function __construct(array $mandates)
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
