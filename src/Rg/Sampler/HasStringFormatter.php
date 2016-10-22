<?php
namespace Rg\Sampler;

trait HasStringFormatter
{
    /**
     * @param string $chunk
     *
     * @return string
     */
    protected function stripLineBreaks($chunk)
    {
        return preg_replace('/\r|\n/', '', $chunk);
    }
}
