<?php
require_once 'base_classes.php';


$layer = new Human ("Стас", "Переходченко", "80", "165");
$scientist = new Human ('Петя', "Шляпкин", "90", "186");
$human3 = new Human ("Коля", "Круглов", "95", "183");
$human4 = new Human ("Женя", "Кукушкин", "190", "179");

$contract = $layer->makeContract();
$technology = $scientist->inventTecnology();

$nation = new Nation();

$nation->add($human1);
$nation->add($human2);
$nation->add($human3);
$nation->add($human4);



print_r($nation);

$nation->getFullInfoAboutAllPopulation();


?>
