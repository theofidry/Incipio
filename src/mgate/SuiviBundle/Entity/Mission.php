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
 * mgate\SuiviBundle\Entity\Mission.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Mission extends DocType
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
     * @ORM\ManyToOne(targetEntity="Etude", inversedBy="missions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $etude;

    /**
     * @ORM\ManyToOne(targetEntity="mgate\PersonneBundle\Entity\Membre")
     * @ORM\JoinColumn(nullable=true)
     */
    private $referentTechnique;

    /**
     * @ORM\ManyToOne(targetEntity="\mgate\PersonneBundle\Entity\Membre", inversedBy="missions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $intervenant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debutOm", type="datetime", nullable=true)
     */
    private $debutOm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finOm", type="datetime", nullable=true)
     */
    private $finOm;

    /**
     * @var float
     *
     * @ORM\Column(name="pourcentageJunior", type="float", nullable=true)
     */
    private $pourcentageJunior;

    /**
     * @var RepartitionJEH
     * @ORM\OneToMany(targetEntity="mgate\SuiviBundle\Entity\RepartitionJEH", mappedBy="mission", cascade={"persist", "merge", "remove"})
     */
    private $repartitionsJEH;

    /**
     * @var int
     *
     * @ORM\Column(name="avancement", type="integer", nullable=true)
     */
    private $avancement;

    /**
     * @var bool
     *
     * @ORM\Column(name="rapportDemande", type="boolean", nullable=true)
     */
    private $rapportDemande;

    /**
     * @var bool
     *
     * @ORM\Column(name="rapportRelu", type="boolean", nullable=true)
     */
    private $rapportRelu;

    /**
     * @var bool
     *
     * @ORM\Column(name="remunere", type="boolean", nullable=true)
     */
    private $remunere;

//Ajout fonction rapide
    public function getReference()
    {
        if ($this->getIntervenant()) {
            return $this->getEtude()->getReference().'-RM-'.$this->getIntervenant()->getIdentifiant().'-'.$this->getVersion();
        } else {
            return $this->getEtude()->getReference().'-RM-XYn-'.$this->getVersion();
        }
    }

    /**
     * @deprecated since version 0.1
     *
     * @return array('jehRemuneration','montantRemuneration');
     */
    public function getRemuneration()
    {
        $nbrJEHRemuneration = (int) 0;
        $prixRemuneration = (float) 0;
        foreach ($this->getRepartitionsJEH() as $repartitionJEH) {
            $nbrJEHRemuneration += $repartitionJEH->getNbrJEH();
            $prixRemuneration += $repartitionJEH->getNbrJEH() * $repartitionJEH->getPrixJEH();
        }
        $prixRemuneration *= 1 - $this->getPourcentageJunior();

        return array('jehRemuneration' => $nbrJEHRemuneration, 'montantRemuneration' => $prixRemuneration);
    }

    public function getRemunerationBrute()
    {
        $prixRemuneration = (float) 0;
        foreach ($this->getRepartitionsJEH() as $repartitionJEH) {
            $prixRemuneration += $repartitionJEH->getNbrJEH() * $repartitionJEH->getPrixJEH();
        }
        $prixRemuneration *= 1 - $this->getPourcentageJunior();

        return $prixRemuneration;
    }

    public function getNbrJEH()
    {
        $nbr = 0;
        foreach ($this->repartitionsJEH as $repartition) {
            $nbr += $repartition->getNbrJEH();
        }

        return $nbr;
    }

//Block astuce pour ajout direct d'intervenant dans formulaire
    public function getMission()
    {
        return $this;
    }

    private $knownIntervenant = false;
    private $newIntervenant;

    public function isKnownIntervenant()
    {
        return $this->knownIntervenant;
    }

    public function setKnownIntervenant($boolean)
    {
        $this->knownIntervenant = $boolean;
    }

    public function getNewIntervenant()
    {
        return $this->newIntervenant;
    }

    public function setNewIntervenant($var)
    {
        $this->newIntervenant = $var;
    }

// Fin du block

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
     * Set intervenant.
     *
     * @param mgate\PersonneBundle\Entity\Membre $intervenant
     *
     * @return Mission
     */
    public function setIntervenant(\mgate\PersonneBundle\Entity\Membre $intervenant)
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    /**
     * Get intervenant.
     *
     * @return mgate\PersonneBundle\Entity\Membre
     */
    public function getIntervenant()
    {
        return $this->intervenant;
    }

    /**
     * Set debutOm.
     *
     * @param \DateTime $debutOm
     *
     * @return Mission
     */
    public function setDebutOm($debutOm)
    {
        $this->debutOm = $debutOm;

        return $this;
    }

    /**
     * Get debutOm.
     *
     * @return \DateTime
     */
    public function getDebutOm()
    {
        return $this->debutOm;
    }

    /**
     * Set finOm.
     *
     * @param \DateTime $finOm
     *
     * @return Mission
     */
    public function setFinOm($finOm)
    {
        $this->finOm = $finOm;

        return $this;
    }

    /**
     * Get finOm.
     *
     * @return \DateTime
     */
    public function getFinOm()
    {
        return $this->finOm;
    }

    /**
     * Set avancement.
     *
     * @param int $avancement
     *
     * @return Mission
     */
    public function setAvancement($avancement)
    {
        $this->avancement = $avancement;

        return $this;
    }

    /**
     * Get avancement.
     *
     * @return int
     */
    public function getAvancement()
    {
        return $this->avancement;
    }

    /**
     * Set rapportDemande.
     *
     * @param bool $rapportDemande
     *
     * @return Mission
     */
    public function setRapportDemande($rapportDemande)
    {
        $this->rapportDemande = $rapportDemande;

        return $this;
    }

    /**
     * Get rapportDemande.
     *
     * @return bool
     */
    public function getRapportDemande()
    {
        return $this->rapportDemande;
    }

    /**
     * Set rapportRelu.
     *
     * @param bool $rapportRelu
     *
     * @return Mission
     */
    public function setRapportRelu($rapportRelu)
    {
        $this->rapportRelu = $rapportRelu;

        return $this;
    }

    /**
     * Get rapportRelu.
     *
     * @return bool
     */
    public function getRapportRelu()
    {
        return $this->rapportRelu;
    }

    /**
     * Set remunere.
     *
     * @param bool $remunere
     *
     * @return Mission
     */
    public function setRemunere($remunere)
    {
        $this->remunere = $remunere;

        return $this;
    }

    /**
     * Get remunere.
     *
     * @return bool
     */
    public function getRemunere()
    {
        return $this->remunere;
    }

    /**
     * Set etude.
     *
     * @param mgate\SuiviBundle\Entity\Etude $etude
     *
     * @return Mission
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

    /**
     * Set pourcentageJunior.
     *
     * @param int $pourcentageJunior
     *
     * @return Phase
     */
    public function setPourcentageJunior($pourcentageJunior)
    {
        $this->pourcentageJunior = $pourcentageJunior;

        return $this;
    }

    /**
     * Get pourcentageJunior.
     *
     * @return int
     */
    public function getPourcentageJunior()
    {
        return $this->pourcentageJunior;
    }

    /**
     * Set referentTechnique.
     *
     * @param \mgate\PersonneBundle\Entity\Membre $referentTechnique
     *
     * @return Mission
     */
    public function setReferentTechnique(\mgate\PersonneBundle\Entity\Membre $referentTechnique = null)
    {
        $this->referentTechnique = $referentTechnique;

        return $this;
    }

    /**
     * Get referentTechnique.
     *
     * @return \mgate\PersonneBundle\Entity\Membre
     */
    public function getReferentTechnique()
    {
        return $this->referentTechnique;
    }

    /**
     * Add repartitionsJEH.
     *
     * @param \mgate\SuiviBundle\Entity\RepartitionJEH $repartitionsJEH
     *
     * @return Mission
     */
    public function addRepartitionsJEH(\mgate\SuiviBundle\Entity\RepartitionJEH $repartitionsJEH)
    {
        $this->repartitionsJEH[] = $repartitionsJEH;

        return $this;
    }

    /**
     * Remove repartitionsJEH.
     *
     * @param \mgate\SuiviBundle\Entity\RepartitionJEH $repartitionsJEH
     */
    public function removeRepartitionsJEH(\mgate\SuiviBundle\Entity\RepartitionJEH $repartitionsJEH)
    {
        $this->repartitionsJEH->removeElement($repartitionsJEH);
    }

    /**
     * Get repartitionsJEH.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRepartitionsJEH()
    {
        return $this->repartitionsJEH;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->repartitionsJEH = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pourcentageJunior = 0.4;
    }
}
