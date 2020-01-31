<?php

/**
 * Class managing paiement ways
 */
Class PaiementWays
{
	/**
	 * paiement ways name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Constructor
	 *
	 * @param string $name
	 */
	public function __construct(
		string $name
	) {
		$this->name = $name;
	}
}