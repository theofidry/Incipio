<?php

namespace ApiBundle\Tests\Entity;

use ApiBundle\Entity\Job;

/**
 * Class JobTest.
 *
 * @see    ApiBundle\Entity\Job
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class JobTest extends EntityTestCaseAbstract
{
    /**
     * {@inheritdoc}
     */
    public function testPropertyAccessors()
    {
        // TODO: Implement testPropertyAccessors() method.
    }

    /**
     * Provides an optimal set of data for generating a complete entity.
     */
    public function fluentDataProvider()
    {
        return [
            [
                [
                    'title' => 'President',
                    'abbreviation' => 'Pres',
                    'enabled' => true,
                ],
            ],
        ];
    }

    /**
     * @return string Tested entity fully qualified name.
     */
    public function getClass()
    {
        return get_class(new Job());
    }
}
