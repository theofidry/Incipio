<?php

/*
 * This file is part of the DunglasApiBundle package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\EventListener;

use ApiBundle\Doctrine\ORM\Manager\JobManager;
use ApiBundle\Doctrine\ORM\Manager\MandateManager;
use ApiBundle\Entity\Job;
use ApiBundle\Entity\Mandate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * Call {@see ApiBundle\Doctrine\ORM\Manager\MandateManager} when dealing with {@see ApiBundle\Entity\Mandate} entities.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class MandateManagerListener
{
    /**
     * @var MandateManager
     */
    private $mandateManager;

    public function __construct(MandateManager $mandateManager)
    {
        $this->mandateManager = $mandateManager;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $mandate = $event->getControllerResult();

        if (false === $mandate instanceof Mandate) {
            return;
        }

        switch ($event->getRequest()->getMethod()) {

            case Request::METHOD_POST:
            case Request::METHOD_PUT:
                $this->mandateManager->updateName($mandate);
                break;
        }
    }
}
