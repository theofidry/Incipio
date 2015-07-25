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
use PHPUnit_Framework_Assert as PHPUnit;
use Sanpi\Behatch\Context\JsonContext as SampiJsonContext;
use Sanpi\Behatch\HttpCall\HttpCallResultPool;
use Sanpi\Behatch\Json\Json;
use Sanpi\Behatch\Json\JsonInspector;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class JsonContext extends SampiJsonContext implements Context
{
    /**
     * @var JsonInspector
     */
    private $inspector;

    /**
     * @inheritdoc
     */
    public function __construct($evaluationMode = 'javascript', HttpCallResultPool $httpCallResultPool)
    {
        parent::__construct($evaluationMode, $httpCallResultPool);

        $this->inspector = new JsonInspector($evaluationMode);
    }

    /**
     * @Then the JSON node :node should be greater than :value
     *
     * @param $node
     * @param $value
     */
    public function theJsonNodeShouldBeHigher($node, $value)
    {
        $json = $this->getJson();
        $actual = $this->inspector->evaluate($json, $node);

        PHPUnit::assertGreaterThanOrEqual(
            $value,
            $actual,
            sprintf('Expected `%s` to be greater than `%s`.', $value, $actual)
        );
    }

    /**
     * @Then the JSON node :node should be less than :value
     *
     * @param $node
     * @param $value
     */
    public function theJsonNodeShouldBeLower($node, $value)
    {
        $json = $this->getJson();
        $actual = $this->inspector->evaluate($json, $node);

        PHPUnit::assertLessThanOrEqual(
            $value,
            $actual,
            sprintf('Expected `%s` to be less than `%s`.', $value, $actual)
        );
    }

    /**
     * Helper to get the JSON object from the response.
     *
     * @return Json
     */
    private function getJson()
    {
        return new Json($this->getSession()->getPage()->getContent());
    }
}
