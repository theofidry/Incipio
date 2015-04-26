<?php

namespace ApiBundle\Bundles\UserBundle\Entity;

use ApiBundle\Entity\Mandate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User: user that have an account in the application.
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class User extends BaseUser
{
    /*
     * Hook timestampable behavior: updates `createdAt` and `updatedAt fields
     */
    use TimestampableEntity;

    /**
     * {@inheritdoc}
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"user"})
     */
    protected $id;

    /**
     * {@inheritdoc}
     *
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Groups({"user"})
     */
    protected $username;

    /**
     * {@inheritdoc}
     *
     * @Assert\Email
     * @Assert\NotBlank
     * @Groups({"user"})
     */
    protected $email;

    /**
     * {@inheritdoc}
     *
     * @Assert\Length(
     *      min="8",
     *      max="32"
     * )
     * @Assert\NotBlank
     *
     * @TODO: validation for the password!
     */
    protected $password;

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
     * @var ArrayCollection<Mandate> List of users for this mandate.
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Mandate", inversedBy="users")
     * @ORM\JoinTable(name="users_mandates")
     * @Groups({"user"})
     *
     * @TODO: validation: may have no user
     **/
    protected $mandates;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->mandates = new ArrayCollection();
    }

    /**
     * Adds Mandate.
     *
     * @param Mandate $mandate
     *
     * @return $this
     */
    public function addMandate(Mandate $mandate)
    {
        $this->mandates[] = $mandate;
        if (false === $mandate->getUsers()->contains($this)) {
            $mandate->addUser($this);
        }

        return $this;
    }

    /**
     * Removes mandate.
     *
     * @param Mandate $mandate
     *
     * @return $this
     */
    public function removeMandate(Mandate $mandate)
    {
        $key = array_search($mandate, $this->mandates->toArray(), true);
        if (false !== $key) {
            unset($this->mandates[$key]);
        }

        return $this;
    }

    /**
     * Gets mandate.
     *
     * @return ArrayCollection<Mandate>
     */
    public function getMandates()
    {
        return $this->mandates;
    }
}
