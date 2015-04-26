<?php

namespace ApiBundle\Entity;

use ApiBundle\Bundles\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dunglas\ApiBundle\Annotation\Iri;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mandate.
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @Iri("https://schema.org/startDate")
     * @ORM\Column(name="start_at", type="datetime")
     * @Assert\Date
     * @Assert\NotNull
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @Iri("https://schema.org/endDate")
     * @ORM\Column(name="end_at", type="datetime", nullable=true)
     * @Assert\Date
     */
    private $endAt;

    /**
     * @var ArrayCollection List of jobs attached to this mandate.
     *
     * @ORM\ManyToMany(targetEntity="Job")
     * @ORM\JoinTable(
     *  name="mandates_jobs",
     *  joinColumns={
     *      @ORM\JoinColumn(name="mandate_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="job_id", referencedColumnName="id", unique=false, nullable=false)
     *  }
     * )
     * TODO: validation: may have no jobs but a job requires at least one mandate
     */
    private $jobs;

    /**
     * @var ArrayCollection List of users for this mandate.
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Bundles\UserBundle\Entity\User", mappedBy="mandates")
     * TODO: validation: may have no user
     **/
    private $users;

    /**
     * Default constructor.
     */
    public function __construct()
    {
        $this->jobs  = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt.
     *
     * @param \DateTime $endAt
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
     * Adds Job.
     *
     * @param Job $jobs
     *
     * @return $this
     */
    public function addJob(Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Removes job.
     *
     * @param Job $job
     *
     * @return $this
     */
    public function removeJob(Job $job)
    {
        $key = array_search($job, $this->jobs->toArray(), true);
        if (false !== $key) {
            unset($this->jobs[$key]);
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
     * Adds User.
     *
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
        if (false === $user->getMandates()->contains($this)) {
            $user->addMandate($this);
        }

        return $this;
    }

    /**
     * Removes user.
     *
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user)
    {
        $key = array_search($user, $this->users->toArray(), true);
        if (false !== $key) {
            unset($this->users[$key]);
        }

        return $this;
    }

    /**
     * Gets Users.
     *
     * @return ArrayCollection<User>
     */
    public function getUsers()
    {
        return $this->users;
    }
}
