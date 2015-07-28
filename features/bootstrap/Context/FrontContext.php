<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Incipio\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class FrontContext extends MinkContext implements Context
{
    /**
     * Fill login page for admin user.
     *
     * @Given I authenticate myself as admin
     */
    public function authenticateAs()
    {
        $this->visit('/login');
        $this->fillField('username', 'admin');
        $this->fillField('password', 'admin');
        $this->pressButton('_submit');
    }
}
