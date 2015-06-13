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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dunglas\ApiBundle\Annotation\Iri;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mandate.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ApiBundle\Entity\MandateRepository")
 * @UniqueEntity("name")
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class Mandate
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @Iri("https://schema.org/endDate")
     * @ORM\Column(name="end_at", type="datetime", nullable=true)
     * @Assert\Date
     * @Groups({"user"})
     */
    private $endAt;

    /**
     * @var ArrayCollection<Job> List of jobs attached to this mandate.
     *
     * @ORM\OneToMany(targetEntity="Job", mappedBy="mandate")
     *
     * TODO: validation: may have no jobs but a job requires at least one mandate
     */
    private $jobs;

    /**
     * @var string
     *
     * @Iri("https://schema.org/name")
     * @ORM\Column(name="name", type="string")
     * @Assert\Type("string")
     * @Assert\Length(min="5", max="30")
     * @Groups({"user"})
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @Iri("https://schema.org/startDate")
     * @ORM\Column(name="start_at", type="datetime")
     * @Assert\Date
     * @Assert\NotNull
     * @Groups({"user"})
     */
    private $startAt;

    /**
     * Default constructor.
     */
    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set endAt.
     *
     * @param \DateTime|null $endAt
     *
     * @return $this
     */
    public function setEndAt(\DateTime $endAt = null)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt.
     *
     * @return \DateTime|null
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Adds Job. Will automatically update job's mandate too.
     *
     * @param Job $job
     *
     * @return $this
     */
    public function addJob(Job $job)
    {
        if (false === $this->jobs->contains($job)) {
            $this->jobs->add($job);
        }
        $job->setMandate($this);

        return $this;
    }

    /**
     * Removes job. Will automatically update job's mandate too.
     *
     * @param Job $job
     *
     * @return $this
     */
    public function removeJob(Job $job)
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            $job->setMandate(null);
        }

        return $this;
    }

    /**
     * Gets Jobs.
     *
     * @return ArrayCollection<Job>
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Sets Name.
     *
     * @param \DateTime $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets Name.
     *
     * @return \DateTime|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startAt.
     *
     * @param \DateTime $startAt
     *
     * @return $this
     */
    public function setStartAt(\DateTime $startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt.
     *
     * @return \DateTime|null
     */
    public function getStartAt()
    {
        return $this->startAt;
    }
}
