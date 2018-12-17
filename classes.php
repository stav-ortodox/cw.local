
<?php

class Human {
    private $weight = 10;
    private $height = 10;
    private $name = 'Иван';
    private $lastName = 'Пупкин';


    public function getWeight() {
        return $this->weight;
    }

    public function getHeight() {
        return $this->height;
    }

    public function  __construct($name, $lastName, $weight, $height) {
        if (is_numeric($name)) {
            die ("Неверное имя!");
        }
        $this->name = $name;
        $this->lastName = $lastName;
        $this->weight = $weight;
        $this->height = $height;
        Nation::increasePopulation();
    }

    public function  __destruct() {
        Nation::decreasePopulation();
    }

    public function getFullName() {
        return "{$this->name} {$this->lastName}";
    }
}

class Nation
{
    public $population = [];

    public static $allPopulation = 0;

    public static function increasePopulation($count = 1)
    {
        self::$allPopulation += $count;
    }

    public static function decreasePopulation($count = 1)
    {
        self::$allPopulation -= $count;
    }

    public static function getPopulation()
    {
        return self::$allPopulation;
    }

    public function add(Human $human)
    {
        $this->population[spl_object_id($human)] = $human;
    }

    public function remove(Human $human)
    {
        $objectId = spl_object_id($human);
        if (in_array($objectId, $this->population)) {
            unset($this->population[$objectId]);
        }
    }

    public function getFullInfo(Human $human)
    {
        return "Полное имя: {$human->getFullName()} Вес: {$human->getWeight()} Рост: {$human->getHeight()}" . PHP_EOL;
    }

    public function getFullInfoAboutAllPopulation($nation){
        foreach ($nation as $value => $humans) {
            foreach ($humans as $human) {
                echo "Полное имя: {$human->getFullName()} Вес: {$human->getWeight()} Рост: {$human->getHeight()}" . PHP_EOL;
            }
        }
    }
}




$human1 = new Human ("Стас", "Переходченко", "80", "165");
$human2 = new Human ('Петя', "Шляпкин", "90", "186");
$human3 = new Human ("Коля", "Круглов", "95", "183");
$human4 = new Human ("Женя", "Кукушкин", "190", "179");


$nation = new Nation();

$nation->add($human1);
$nation->add($human2);
$nation->add($human3);
$nation->add($human4);



print_r($nation);

$nation->getFullInfoAboutAllPopulation($nation);


?>


