<?php

use Sanpi\Behatch\HttpCall\HttpCallResultPool;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class JsonLdContext extends \Sanpi\Behatch\Context\RestContext
{
    /**
     * @var JsonContext
     */
    protected $jsonContext;

    /**
     * @param string             $evaluationMode
     * @param HttpCallResultPool $httpCallResultPool
     */
    public function __construct($evaluationMode = 'javascript', HttpCallResultPool $httpCallResultPool)
    {
        $this->jsonContext = new JsonContext($evaluationMode, $httpCallResultPool);
    }

    /**
     * Check if the response is in JSON-LD. Is considered as JSON-LD response a valid JSON with the property
     * content-type header.
     *
     * @Then the response should be in JSON-LD
     */
    public function jsonLdResponse()
    {
        $isJson = json_decode($this->getSession()->getDriver()->getContent());
        if (!$isJson) {
            throw new \Exception('Expected response content to be JSON.');
        }

        $this->theHeaderShouldBeEqualTo('content-type', 'application/ld+json');
    }

    /**
     * Check if the response is an hydra paginated collection. 
     * 
     * @Then I get a paged collection with the context :context
     *
     * @param string $context
     */
    public function iGetAPagedCollectionWithContext($context)
    {
        // Response should be in JSON-LD
        $this->jsonLdResponse();

        $this->jsonContext->theJsonNodeShouldBeEqualTo('@context', $context);
        $this->jsonContext->theJsonNodeShouldBeEqualTo('@type', 'hydra:PagedCollection');
        $this->jsonContext->theJsonNodeShouldExist('hydra:totalItems');
        $this->jsonContext->theJsonNodeShouldExist('hydra:itemsPerPage');
    }

    /**
     * Check if the response is an hydra resource page.
     *
     * @Then I get a resource page with the context :context
     *
     * @param string $context
     */
    public function iGetAResourcePageWithContext($context)
    {
        // Response should be in JSON-LD
        $this->jsonLdResponse();

        $this->jsonContext->theJsonNodeShouldBeEqualTo('@context', $context);
    }
}
