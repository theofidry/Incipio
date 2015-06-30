<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\PubliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'Nom du fichier', 'required' => false))
                ->add('file', 'file', array('label' => 'Fichier', 'required' => true, 'attr' => array('cols' => '100%', 'rows' => 5)));
        if ($options['etude'] || $options['etudiant'] || $options['prospect'] || $options['formation']) {
            $builder->add('relation', new RelatedDocumentType(), array(
                'label' => '',
                'etude' => $options['etude'],
                'etudiant' => $options['etudiant'],
                'prospect' => $options['prospect'],
                'formation' => $options['formation'], ));
        }
    }

    public function getName()
    {
        return 'mgate_suivibundle_documenttype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\PubliBundle\Entity\Document',
            'etude' => null,
            'etudiant' => null,
            'prospect' => null,
            'formation' => null,
        ));
    }
}
