<?php

require_once('./Classes/Vat.php');
require_once('./Classes/PaiementWays.php');
require_once('./Classes/Incomes.php');
require_once('./Classes/Spendings.php');

// => calculer la marge brute de chaque mois de l'année courante 
// => calculer les montants de TVA par période choisie
// => calculer la marge brute de l'année courante
// => calculer le CA par période choisie 

/**
 * Class managing everything
 */
Class Bar
{
    /**
     * Existing paiement ways array
     *
     * @var array
     */
    public $paiementWays;

    /**
     * Existing Vats array
     *
     * @var array
     */
    public $vats;

    /**
     * Existing incomes
     *
     * @var array
     */
    public $incomes;

    /**
     * Existing spendings
     *
     * @var array
     */
    public $spendings;

    /**
     * constructor
     */
    public function __construct() {
        $this->setVats();
        $this->setPaiementWays();
        $this->setIncomes();
        $this->setSpendings();
        $this->tests();
    }

    /**
     * Calculate the percentage of use by each paiement way
     *
     * @return array
     */
    public function paiementWaysPercentageUsed(): array
    {
        // set the base array to enable calculation
        $pwpu = [];
        foreach ($this->paiementWays as $paiementWay) {
            $pwpu[$paiementWay->name] = 0;
        }

        // count each iterations of paiement ways in operations
        foreach (array_merge($this->spendings, $this->incomes) as $si) {
            $pwpu[$si->paiementWay->name] += 1;
        }

        // calculate percentage
        $total = count($this->incomes) + count($this->spendings);
        foreach($pwpu as $key => $value) {
            $percentage = $value * 100 / $total;
            $pwpu[$key] = round($percentage, 2);
        }
        
        return $pwpu;
    }

    /**
     * Calculate the percentage of use by each vat rate
     *
     * @return array
     */
    public function vatPercentageUsed(): array
    {
        // set the base array to enable calculation
        $pwpu = [];
        foreach ($this->vats as $vat) {
            $pwpu[$vat->name] = 0;
        }

        // count each iterations of paiement ways in operations
        foreach (array_merge($this->spendings, $this->incomes) as $si) {
            $pwpu[$si->vat->name] += 1;
        }

        // calculate percentage
        $total = count($this->incomes) + count($this->spendings);
        foreach($pwpu as $key => $value) {
            $percentage = $value * 100 / $total;
            $pwpu[$key] = round($percentage, 2);
        }
        
        return $pwpu;
    }

    /**
     * Get incomes per period
     *
     * @param string $startDate
     * @param string $endDate
     * @return void
     */
    public function getIncomeAmountByPeriod(string $startDate, string $endDate){
        $total_income = 0;
        $startDate = date_create_from_format("d/m/Y", $startDate);
        $endDate = date_create_from_format("d/m/Y", $endDate);
        foreach($this->incomes as $item){
            $item_date = date_create_from_format("d/m/Y", $item->date);
            if ($item_date >= $startDate && $idem_date <= $endDate) {
                $total_income += $item->ttcAmount;
            }
        }
        return $total_income;
    }

    /**
     * Get spending amount per period
     *
     * @param string $startDate
     * @param string $endDate
     * @return void
     */
    public function getSpendingAmountByPeriod(string $startDate, string $endDate){
        $total_income = 0;
        $startDate = date_create_from_format("d/m/Y", $startDate);
        $endDate = date_create_from_format("d/m/Y", $endDate);
        foreach($this->spendings as $item){
            $item_date = date_create_from_format("d/m/Y", $item->date);
            if ($item_date >= $startDate && $idem_date <= $endDate) {
                $total_income += $item->ttcAmount;
            }
        }
        return $total_income;
    }

    /**
     * Define vats
     *
     * @return void
     */
    private function setVats(): void
    {
        $this->vats[] = new Vat("5,5%", 5.5);
        $this->vats[] = new Vat("10%", 10);
        $this->vats[] = new Vat("20%", 20);
    }

    /**
     * define paiement ways
     *
     * @return void
     */
    private function setPaiementWays(): void
    {
        $this->paiementWays[] = new PaiementWays("cb");
        $this->paiementWays[] = new PaiementWays("cash");
        $this->paiementWays[] = new PaiementWays("cheque");
    }

    /**
     * define incomes
     *
     * @return void
     */
    private function setIncomes(): void
    {
        $this->incomes[] = new Incomes( "coca", 40, $this->vats[2], 50, "20/01/2020", $this->paiementWays[1]);
        $this->incomes[] = new Incomes( "orangina", 3, $this->vats[2], 80, "19/01/2020", $this->paiementWays[1]);
        $this->incomes[] = new Incomes( "menthe a l'eau", 10, $this->vats[2], 99, "18/01/2020", $this->paiementWays[1]);
    }

    /**
     * define spendings
     *
     * @return void
     */
    private function setSpendings(): void
    {
        $this->spendings[] = new Spendings( "coca", 4, $this->vats[0], 0, "21/01/2020", $this->paiementWays[1]);
        $this->spendings[] = new Spendings( "orangina", 0.3, $this->vats[2], 20, "20/01/2020", $this->paiementWays[0]);
        $this->spendings[] = new Spendings( "menthe a l'eau", 0.1, $this->vats[1], 5, "19/01/2020", $this->paiementWays[2]);
    }

    /**
     * Tests function which is execute on the instanciation of this object
     *
     * @return void
     */
    private function tests()
    {
        echo("<pre>");
        echo("<code>");
        var_dump($this);
        // var_dump($this->paiementWaysPercentageUsed());
        // var_dump($this->vatPercentageUsed());
        // var_dump($this->getIncomeAmountByPeriod("19/01/2020", "20/01/2020"));
        // var_dump($this->getSpendingAmountByPeriod("19/01/2020", "20/01/2020"));
        var_dump($this->getVatAmountByPeriod("18/01/2020", "30/01/2020"));
        echo("</code>");
        echo("</pre>");
    }

}