<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$toAct = false;
$actualizations = [];
$rules = [];
$especificRules = [];

foreach ($data as $line) {
  if($line == ''){
    $toAct = true;
    continue;
  }
  if(!$toAct){
    $rules[] = $line;
  }else{
    $actualizations[] = $line;
  }
}

foreach ($rules as $rule) {
  $aux = explode('|', $rule);
  isset($especificRules[$aux[0]])?array_push($especificRules[$aux[0]], $aux[1]):$especificRules[$aux[0]] = [$aux[1]];
}

$correctActualizations = [];

foreach ($actualizations as $actualization) {
  $correct = true;
  $aux = explode(',', $actualization);
  foreach ($aux as $key=>$page) {
    for ($i = $key + 1; $i < count($aux); $i++) {
      if (isset($especificRules[$aux[$i]]) && in_array($page, $especificRules[$aux[$i]])) {
        $correct = false;
      }
    }
  }
  if($correct){
    $total+= $aux[floor(count($aux)/2)];
  }
}

echo 'Solution: '.$total;

