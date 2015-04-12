<?php

namespace ApiBundle\Bundles\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class User: user that have an account in the application.
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /*
     * Hook timestampable behavior: updates `createdAt` and `updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"user"})
     */
    protected $id;

    /**
     * {@inheritdoc}
     *
     * @Assert\NotBlank
     * @Groups({"test"})
     */
    protected $username;

    /**
     * @Assert\NotBlank
     * @Groups({"user"})
     */
    protected $email;

    /**
     * {@inheritdoc}
     *
     * @Groups({"user"})
     */
    protected $groups;

    /**
     * {@inheritdoc}
     *
     * @Groups({"user"})
     */
    protected $roles;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
    }
}
