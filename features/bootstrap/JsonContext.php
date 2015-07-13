<?php

use Sanpi\Behatch\HttpCall\HttpCallResultPool;
use Sanpi\Behatch\Json\Json;
use Sanpi\Behatch\Json\JsonInspector;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class JsonContext extends \Sanpi\Behatch\Context\JsonContext
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
     * @Then the JSON node :node should be higher than :value
     *
     * @param $node
     * @param $value
     *
     * @throws Exception
     */
    public function theJsonNodeShouldBeHigher($node, $value)
    {
        $json = $this->getJson();
        $actual = $this->inspector->evaluate($json, $node);

        if ($actual < $value) {
            throw new \Exception(
                sprintf('Expected `%s` to be higher than `%s`.', $value, $actual)
            );
        }
    }

    /**
     * @Then the JSON node :node should be lower than :value
     *
     * @param $node
     * @param $value
     *
     * @throws Exception
     */
    public function theJsonNodeShouldBeLower($node, $value)
    {
        $json = $this->getJson();
        $actual = $this->inspector->evaluate($json, $node);

        if ($actual > $value) {
            throw new \Exception(
                sprintf('Expected `%s` to be lower than `%s`.', $value, $actual)
            );
        }
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
