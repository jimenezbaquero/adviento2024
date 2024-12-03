<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$numbersLeft = [];
$numbersRight = [];

foreach ($data as $line){
  $numbers = explode('   ',$line);
  $numbersLeft[] = (int)$numbers[0];
  $numbersRight[] = (int)$numbers[1];
}

sort($numbersLeft);
sort($numbersRight);

$total = 0;

for($i = 0; $i < count($numbersLeft); $i++){
  $total += abs($numbersLeft[$i] - $numbersRight[$i]);
}

echo 'Solution: '.$total;
