<?php

/**
 * Class managing Vats
 */
Class Vat
{
    /**
     * Vat name
     *
     * @var string
     */
    public $name;

    /**
     * Vat rate
     *
     * @var float
     */
    public $rate;

    /**
     * Constructor
     *
     * @param string $name
     * @param float $rate
     */
    public function __construct(
        string $name,
        float $rate
    ) {
        $this->name = $name;
        $this->rate = $rate;
    }
}