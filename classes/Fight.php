<?php
class Fight {
    //TO-DO: Possible refactor. Make this consts an enum?
    const LOW_AIM = 30;  
    const MED_AIM = 50;
    const HIGH_AIM = 70;
 
    function __construct(private Fighter $fighter1, private Fighter $fighter2){}

    public function fight() {
        while($this->areFightersAlive()) {
            $this->startFight();
            //Decisión de diseño, puedo hacerlo desde fighter 1, o no.
            $fighter1_hits = $this->fighter1hits();
            if($fighter1_hits) $this->fighterLoseLife($this->fighter1, $this->fighter2);
            else $this->fighterLoseLife($this->fighter2,$this->fighter1);
            $this->showPlayersLife();
        }
        $this->announceWinner();
    }

    private function startFight(): void {
        echo "---------------------------------".PHP_EOL;
        echo "Taday we have ".$this->fighter1->getName()." and ".$this->fighter2->getName()." fighting for glory!".PHP_EOL;
        echo "Ready? Fight!".PHP_EOL;
        echo "---------------------------------".PHP_EOL;
    }

    private function areFightersAlive(): bool {
        return $this->fighter1->getLife() > 0 && $this->fighter2->getLife() > 0;
    }

    private function fighter1hits(): bool {
        $hit_aim = self::MED_AIM;
        $random_number = rand(1,100);
        if ($this->isFighter1Stronger()) $hit_aim = self::HIGH_AIM;
        else $hit_aim = self::LOW_AIM;
        if($random_number <= $hit_aim) return true;
        return false;
    }

    private function isFighter1Stronger(): bool {
        if ($this->fighter1->getStrength() > $this->fighter2->getStrength()) return true;
        return false;
    }

    private function fighterLoseLife(Fighter $attacker, Fighter $defender): void {
        $damage = $attacker->getStrength() - $defender->getDefense();
        if($damage <= 0) $damage = 1;
        echo "WOw! ".$attacker->getName()." did hurt ".$damage." to ".$defender->getName().PHP_EOL;
        $defender->receiveDamage($damage);
    }

    private function showPlayersLife(): void {
        echo $this->fighter1->getName()." has ".$this->fighter1->getLife()." life points left".PHP_EOL;
        echo $this->fighter2->getName()." has ".$this->fighter2->getLife()." life points left".PHP_EOL;
        echo "---------------------------------".PHP_EOL;
    }

    private function announceWinner(): void {
        $winner = $this->fighter1;
        if($this->fighter1->getLife() <= 0) $winner = $this->fighter2;
        echo $winner->getName()." won the battle!";
    }
}

?>