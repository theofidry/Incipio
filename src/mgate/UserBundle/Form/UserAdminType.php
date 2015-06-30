<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use mgate\UserBundle\Entity\User as User;
use mgate\UserBundle\Form\EventListener\AddMembreFieldSubscriber;

//use mgate\PersonneBundle\Form\EventListener\AddMembreFieldSubscriber;

class UserAdminType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new AddMembreFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);

        $builder->add('enabled', 'checkbox', array(
             'label' => 'Adresse email validé ?',
             'required' => false,
        ));
        $builder->add('roles', 'choice', array(
         'choices' => User::getRolesNames(),
         'required' => false, 'label' => 'Roles', 'multiple' => true,
         ));

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'mgate_user_useradmin';
    }
}
