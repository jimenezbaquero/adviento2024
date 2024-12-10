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

$prev = '';
$totalLength = 0;
$spaces = [];

foreach ($chain as $key =>$value){
  if($key == 0){
    $prev = $value;
    $length = 1;
    continue;
  }
  if($value != $prev){
    $newChain[$totalLength] = ['value' => $prev,'length' => $length,'moved' => false];
    if($prev == '.'){
      $spaces[$totalLength] = $length;
    }
    $totalLength+= $length;
    $length = 1;
  }else{
    $length++;
  }
  $prev = $value;
}
$newChain[$totalLength] = ['value' => $prev,'length' => $length,'moved' => false];

$copyChain = $newChain;
krsort($copyChain);

$cells = [];
foreach ($newChain as $key =>$value){
  for($i=0; $i < $value['length']; $i++) {
    $cells[] = $value['value'];
  }
}

foreach ($copyChain as $key1=>$block1){
  if($block1['value'] != '.'){
    $length = $block1['length'];
    ksort($spaces);
    foreach ($spaces as $key2=> $value2){
      if($key2 > $key1){
        break;
      }
      if($value2 >= $length){
        for($t=0; $t<$block1['length']; $t++){
          $cells[$key2+$t] = $block1['value'];
          $cells[$key1+$t] = '.';
        }
        if($value2 > $block1['length']){
          $spaces[$key2+$length] = $value2 - $length;

        }
        unset($spaces[$key2]);
        break;
      }
    }
  }
}

foreach ($cells as $key=> $value){
  if($value != '.'){
    $total += $value*$key;
  }
}

echo 'Solution: '.$total;

