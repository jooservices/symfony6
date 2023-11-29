<?php

namespace App\Tests;

trait AssertHelper
{
    public function assertObjectHasProperties($response, array $expectedProperties)
    {
        foreach ($expectedProperties as $property) {
            $this->assertObjectHasProperty($property, $response, "The property '$property' was not found in the response");
        }
    }
}
