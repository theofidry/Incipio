<?php

namespace ApiBundle\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ApiUserBundle: child bundle of the FOSUserBundle.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class ApiUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
