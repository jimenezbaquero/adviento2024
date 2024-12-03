<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$numbersLeft = [];
$numbersRight = [];

foreach ($data as $line){
  $numbers = explode('   ',$line);
  $numbersLeft[] = (int)$numbers[0];
  $number = (int)$numbers[1];
  if(isset($numbersRight[$number])){
    $numbersRight[$number] ++;
  }else{
    $numbersRight[$number] = 1;
  }
}

$total = 0;

for($i = 0; $i < count($numbersLeft); $i++){
  if(isset($numbersRight[$numbersLeft[$i]])){
    $times = $numbersRight[$numbersLeft[$i]];
  }else{
    $times = 0;
  }
  $total += $times*$numbersLeft[$i];
}

echo 'Solution: '.$total;
