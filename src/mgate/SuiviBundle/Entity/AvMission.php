<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\SuiviBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mgate\SuiviBundle\Entity\AvMission.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AvMission extends DocType
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
     * @ORM\ManyToOne(targetEntity="Etude", inversedBy="avMissions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $etude;

    /**
     * @var Mission
     * @ORM\ManyToOne(targetEntity="mgate\SuiviBundle\Entity\Mission")
     */
    private $mission;

    /**
     * @var int
     * @ORM\OneToMany(targetEntity="mgate\SuiviBundle\Entity\RepartitionJEH", mappedBy="avMission", cascade={"persist","remove"})
     */
    private $nouvelleRepartition;

    /**
     * @var interger
     * @ORM\Column(name="nouveauPourcentage", type="integer")
     */
    private $nouveauPourcentage;

    /**
     * @var int
     * @ORM\Column(name="differentielDelai", type="integer")
     */
    private $differentielDelai;

    /**
     * @ORM\ManyToOne(targetEntity="Av", inversedBy="avenantsMissions")
     */
    private $avenant;

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
     * Constructor.
     */
    public function __construct()
    {
        $this->nouvelleRepartition = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set differentielDelai.
     *
     * @param int $differentielDelai
     *
     * @return AvMission
     */
    public function setDifferentielDelai($differentielDelai)
    {
        $this->differentielDelai = $differentielDelai;

        return $this;
    }

    /**
     * Get differentielDelai.
     *
     * @return int
     */
    public function getDifferentielDelai()
    {
        return $this->differentielDelai;
    }

    /**
     * Add nouvelleRepartition.
     *
     * @param \mgate\SuiviBundle\Entity\RepartitionJEH $nouvelleRepartition
     *
     * @return AvMission
     */
    public function addNouvelleRepartition(\mgate\SuiviBundle\Entity\RepartitionJEH $nouvelleRepartition)
    {
        $this->nouvelleRepartition[] = $nouvelleRepartition;

        return $this;
    }

    /**
     * Remove nouvelleRepartition.
     *
     * @param \mgate\SuiviBundle\Entity\RepartitionJEH $nouvelleRepartition
     */
    public function removeNouvelleRepartition(\mgate\SuiviBundle\Entity\RepartitionJEH $nouvelleRepartition)
    {
        $this->nouvelleRepartition->removeElement($nouvelleRepartition);
    }

    /**
     * Get nouvelleRepartition.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNouvelleRepartition()
    {
        return $this->nouvelleRepartition;
    }

    /**
     * Set mission.
     *
     * @param \mgate\SuiviBundle\Entity\Mission $mission
     *
     * @return AvMission
     */
    public function setMission(\mgate\SuiviBundle\Entity\Mission $mission = null)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get mission.
     *
     * @return \mgate\SuiviBundle\Entity\Mission
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set nouveauPourcentage.
     *
     * @param int $nouveauPourcentage
     *
     * @return AvMission
     */
    public function setNouveauPourcentage($nouveauPourcentage)
    {
        $this->nouveauPourcentage = $nouveauPourcentage;

        return $this;
    }

    /**
     * Get nouveauPourcentage.
     *
     * @return int
     */
    public function getNouveauPourcentage()
    {
        return $this->nouveauPourcentage;
    }

    /**
     * Set avenant.
     *
     * @param \mgate\SuiviBundle\Entity\Av $avenant
     *
     * @return AvMission
     */
    public function setAvenant(\mgate\SuiviBundle\Entity\Av $avenant = null)
    {
        $this->avenant = $avenant;

        return $this;
    }

    /**
     * Get avenant.
     *
     * @return \mgate\SuiviBundle\Entity\Av
     */
    public function getAvenant()
    {
        return $this->avenant;
    }

    /**
     * Set etude.
     *
     * @param mgate\SuiviBundle\Entity\Etude $etude
     *
     * @return AvMission
     */
    public function setEtude(\mgate\SuiviBundle\Entity\Etude $etude)
    {
        $this->etude = $etude;

        return $this;
    }

    /**
     * Get etude.
     *
     * @return mgate\SuiviBundle\Entity\Etude
     */
    public function getEtude()
    {
        return $this->etude;
    }
}
