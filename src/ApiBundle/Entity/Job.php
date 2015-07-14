<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dunglas\ApiBundle\Annotation\Iri;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 * @ORM\Entity
 * @UniqueEntity("title")
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class Job
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Iri("http://schema.org/roleName")
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(min=2, max=100)
     * @Groups({"job", "user"})
     */
    private $title;

    /**
     * @var string Job title abbreviation.
     *
     * @Iri("https://schema.org/alternateName")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=20)
     * @Groups({"job", "user"})
     */
    private $abbreviation;

    /**
     * @var bool If false the job cannot be used anymore.
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     * @Assert\NotNull
     */
    private $enabled = true;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="jobs")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Groups({"job"})
     */
    private $user;

    /**
     * @var Mandate
     *
     * @ORM\ManyToOne(targetEntity="Mandate", inversedBy="jobs")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Groups({"job", "user"})
     */
    private $mandate;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $abbreviation
     *
     * @return $this
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(User $user = null)
    {
        if (null === $user && null !== $this->user) {
            $this->user->removeJob($this);
        } elseif (null !== $user && !$user->getJobs()->contains($this)) {
            $user->addJob($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Mandate|null $mandate
     *
     * @return $this
     */
    public function setMandate(Mandate $mandate = null)
    {
        if (null === $mandate && null !== $this->mandate) {
            $this->mandate->removeJob($this);
        } elseif (null !== $mandate && !$mandate->getJobs()->contains($this)) {
            $mandate->addJob($this);
        }

        $this->mandate = $mandate;

        return $this;
    }

    /**
     * @return Mandate|null
     */
    public function getMandate()
    {
        return $this->mandate;
    }
}
