<?php

require_once('PaiementWays.php');
require_once('Vat.php');

/**
 * Class managing operations
 */
Class Operations
{
    /**
     * name of the operation
     *
     * @var string
     */
    public $name;

    /**
     * date of the operation
     *
     * @var Datetime
     */
    public $date;

    /**
     * ht amount of the operation
     *
     * @var float
     */
    public $htAmount;

    /**
     * vat of the operation
     *
     * @var Vat
     */
    public $vat;

    /**
     * vat amount of the operation
     *
     * @var float
     */
    public $vatAmount;

    /**
     * ttc amount of the operation
     *
     * @var float
     */
    public $ttcAmount;

    /**
     * discountPercentage of the operation in percentage
     *
     * @var float
     */
    public $discountPercentage;

    /**
     * paiement way of the operation
     *
     * @var PaiementWays
     */
    public $paiementWay;
    
    /**
     * Constructor
     *
     * @param string $name
     * @param float $htAmount
     * @param Vat $vat
     * @param float $discountPercentage
     * @param string $date
     * @param PaiementWays $paiementWay
     */
    public function __construct(
        string $name,
        float $htAmount,
        Vat $vat,
        float $discountPercentage,
        string $date,
        PaiementWays $paiementWay
    ) {
        $this->name = $name;
        $this->discountPercentage = $discountPercentage;
        $this->vat = $vat;
        $this->paiementWay = $paiementWay;
        $this->htAmount = $htAmount;
        $this->date = $date;
        $this->setConstructValues();
    }

    /**
     * create new operation
     *
     * @param string $name
     * @param float $htAmount
     * @param Vat $vat
     * @param float $discountPercentage
     * @param string $date
     * @param PaiementWays $paiementWay
     * @return Operations
     */
    public function create(
        string $name,
        float $htAmount,
        Vat $vat,
        float $discountPercentage,
        string $date,
        PaiementWays $paiementWay
    ): Incomes {
        return new Operations($name,$htAmount,$vat,$discountPercentage,$date,$paiementWay);
    }

    /**
     * update an operation
     *
     * @param string $name
     * @param float $htAmount
     * @param Vat $vat
     * @param float $discountPercentage
     * @param string $date
     * @param PaiementWays $paiementWay
     * @return void
     */
    public function update(
        string $name,
        float $htAmount,
        Vat $vat,
        float $discountPercentage,
        string $date,
        PaiementWays $paiementWay
    ) {
        $this->name = $name;
        $this->discountPercentage = $discountPercentage;
        $this->vat = $vat;
        $this->paiementWay = $paiementWay;
        $this->htAmount = $htAmount;
        $this->date = $date;
        $this->setConstructValues();
    }

    /**
     * allow the echo function on the Incomes Class.
     *
     * @return string
     */
    public function __toString()
    {
        $txt = "";
        $txt .= "L'élément Income sélectionné porte le nom de " . $this->name . ". \n";
        $txt .= "Il a été vendu avec une remise de " . $this->discountPercentage . "%. \n";
        $txt .= "Le prix HT du produit après remise est donc de " . $this->htAmount . "€. \n";
        $txt .= "La TVA étant de " . $this->vat->name . " le montant de celle-ci s'élève à " . $this->vatAmount . "€. \n";
        $txt .= "Le montant TTC du produit vendu après remise, s'élève donc à " . $this->ttcAmount . "€. \n";
        $txt .= "La vente à eu lieu le " . $this->date . " et a été payée en " . $this->paiementWay->name . ". \n";
        return $txt;
    }

    /**
     * Calculate the amount of the vat
     *
     * @return float
     */
    private function calculateVatAmount(): float
    {
        return $this->htAmount * $this->vat->rate / 100;
    }

    /**
     * Calculate the total amount
     *
     * @return float
     */
    private function calculateTtcAmount(): float
    {
        return $this->htAmount + $this->vatAmount;
    }

    /**
     * calculate the HT amount depending on the discount percentage
     *
     * @return float
     */
    private function calculateHtAmount(): float
    {
        $percentage = $this->htAmount * $this->discountPercentage / 100;
        return $this->htAmount - $percentage;
    }

    /**
     * execute all the calculations
     *
     * @return void
     */
    private function setConstructValues(): void
    {
        $this->htAmount = $this->calculateHtAmount();
        $this->vatAmount = $this->calculateVatAmount();
        $this->ttcAmount = $this->calculateTtcAmount();
    }
}
