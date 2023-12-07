<?php

namespace App\ApiModel\Resource\Trait;

trait ArrayMappable
{
    protected function mapArray(array $input, array $arrayTypes = null): void
    {
        foreach ($input as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = in_array($key, $arrayTypes) ? explode(',', $val) : $val;
            }
        }
    }
}