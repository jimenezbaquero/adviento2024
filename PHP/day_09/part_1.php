<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;

$file = true;
$index = 0;
$chain = [];

foreach (str_split($data[0]) as $value){
  if($file) {
    $character = $index++;
  }else {
    $character = '.';
  }
  for($i=0; $i < $value; $i++) {
    $chain[] = $character;
  }
  $file = !$file;
}
$newChain = [];

$length = count($chain);
$maxIndex = $length - 1;

for($i=0; $i < $length; $i++) {
  if($i>$maxIndex){
    break;
  }
  if($chain[$i] == '.'){
    for($j=$maxIndex; $j > $i; $j--) {
      if($chain[$j] != '.') {
        $newChain[] = $chain[$j];
        $maxIndex = $j -1;
        break;
      }
    }
  }else{
    $newChain[] = $chain[$i];
  }
}

foreach ($newChain as $key=>$value){
  $total += $value*$key;
}


echo 'Solution: '.$total;

