<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Doctrine\ORM\Manager;

use ApiBundle\Entity\Mandate;
use Doctrine\ORM\Decorator\EntityManagerDecorator;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class MandateManager extends EntityManagerDecorator
{
    /**
     * Updates Mandate name: if there is no name, one is generated.
     *
     * @param Mandate $mandate
     */
    public function updateName(Mandate $mandate)
    {
        if (false === empty($mandate->getName())) {
            return;
        }

        if (null !== $mandate->getEndAt() && $mandate->getStartAt()->format('Y') !== $mandate->getEndAt()->format('Y')) {
            $name = sprintf('Mandate %s/%s', $mandate->getStartAt()->format('Y'), $mandate->getEndAt()->format('Y'));
        } else {
            $name = sprintf('Mandate %s %s', $mandate->getStartAt()->format('m'), $mandate->getStartAt()->format('Y'));
        }

        $mandate->setName($name);
    }
}
