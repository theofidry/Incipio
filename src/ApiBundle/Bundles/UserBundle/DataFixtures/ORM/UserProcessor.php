<?php

namespace ApiBundle\Bundles\UserBundle\DataFixtures\ORM;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManager;
use Nelmio\Alice\ProcessorInterface;

/**
 * Class UserProcessor.
 *
 * This processor is used to handle the special case of the ApiBundle\Bundles\UserBundle\Entity\User which extends
 * the FOSUserBundle user.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserProcessor implements ProcessorInterface
{
    /** @var UserManager */
    protected $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function preProcess($object)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function postProcess($object)
    {
        if (!($object instanceof UserInterface)) {
            return;
        }
        $this->userManager->updateUser($object);
    }
}
