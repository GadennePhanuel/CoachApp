<?php

namespace App\Tests\Behat;

use Behatch\Context\RestContext;
use Behatch\HttpCall\Request;
use Behatch\Json\Json;
use Behatch\Json\JsonInspector;

class FeatureContext extends RestContext
{
    /**
     * @var JsonInspector
     */
    private $inspector;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->inspector = new JsonInspector('javascript');
    }

    /**
     * @Then the JSON node :node should be greater than the number :number
     */
    public function theJsonNodeShouldBeGreaterThanTheNumber($node, $number)
    {
        $value = $this->inspector->evaluate(new Json($this->request->getContent()), $node);

        $this->assertTrue($value > $number);
    }

    /**
     * @Then dump the response
     */
    public function dumpTheResponse()
    {
        $response = $this->request->getContent();

        var_dump($response);
    }

    /**
     * @Then the JSON node :node length should be :length
     */
    public function theJsonNodeLengthShouldBeEqualsTo($node, $length)
    {
        $value = $this->inspector->evaluate(new Json($this->request->getContent()), $node);

        $this->assertEquals($length, strlen($value));
    }
}
