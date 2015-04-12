<?php


namespace ApiBundle\Bundles\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User: user that have an account in the application.
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends \FOS\UserBundle\Model\User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
    }
}
