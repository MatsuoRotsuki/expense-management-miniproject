<?php

//For testing, logging

interface Beverage {
    public function drink() : void;
}

class Coffee implements Beverage {
    public function drink() : void
    {
        echo "Drinking coffee";
    }
}

class Soda implements Beverage {
    public function drink() : void
    {
        echo "Drinking soda";
    }
}

abstract class BeverageDecorator implements Beverage {

    protected $beverage;

    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }

    protected function callDrink() {
        if ($this->beverage) {
            $this->beverage->drink();
        }
    }

    public abstract function drink(): void;
}

class Milk extends BeverageDecorator{

    private $percentage;

    public function __construct(Beverage $beverage, float $percentage)
    {
        parent::__construct($beverage);
        $this->percentage = $percentage;
    }

    public function drink(): void
    {
        $this->callDrink();
        echo ", with milk of richness " . $this->percentage . "%";
    }
}

class IceCubes extends BeverageDecorator {
    private $count;

    public function __construct(Beverage $beverage, int $count)
    {
        parent::__construct($beverage);
        $this->count = $count;
    }

    public function drink(): void
    {
        $this->callDrink();
        echo ", with " . $this->count . " ice cubes";
    }
}

class Sugar extends BeverageDecorator {
    private $spoons = 1;

    public function __construct(Beverage $beverage, int $spoons)
    {
        parent::__construct($beverage);
        $this->spoons = $spoons;
    }

    public function drink() : void
    {
        $this->callDrink();
        echo ", with " . $this->spoons . " spoons of sugar";
    }
}

$soda = new Soda();
$soda = new IceCubes($soda, 3);
$soda = new Sugar($soda, 1);

$soda->drink();
echo PHP_EOL;
// Drinking soda, with 3 ice cubes, with 1 spoons of sugar
$coffee = new Coffee();
$coffee = new IceCubes($coffee, 16);
$coffee = new Milk($coffee, 3.);
$coffee = new Sugar($coffee, 2);

$coffee->drink();
echo PHP_EOL;
// Drinking coffee, with 16 ice cubes, with milk of richness 3%, with 2 spoons of sugar
?>