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

$incorrectActualizations = [];

foreach ($actualizations as $actualization) {
  $correct = true;
  $aux = explode(',', $actualization);
  foreach ($aux as $key=>$page) {
    for ($i = $key + 1; $i < count($aux); $i++) {
      if (isset($especificRules[$aux[$i]]) && in_array($page, $especificRules[$aux[$i]])) {
        $correct = false;
      }
    }
    if(!$correct){
      continue;
    }
  }
  if(!$correct){
    $incorrectActualizations[] = $aux;
  }
}

foreach ($incorrectActualizations as $incorrectActualization) {
  $find = false;
  $view = [$incorrectActualization];
  while (!$find) {
    $incorrectActualization = changePages($incorrectActualization,$especificRules);
    if(!in_array($incorrectActualizations,$view)){
      $view[] = $incorrectActualization;
      $correct = true;
      foreach ($incorrectActualization as $key=>$page) {
        for ($i = $key + 1; $i < count($incorrectActualization); $i++) {
          if (isset($especificRules[$incorrectActualization[$i]]) && in_array($page, $especificRules[$incorrectActualization[$i]])) {
            $correct = false;
          }
        }
      }
      if($correct){
        $find = true;
      }
    }
  }
  $total+= $incorrectActualization[floor(count($incorrectActualization)/2)];
}


echo 'Solution: '.$total;

function changePages($array,$rules){
  $newArray = $array;
  for($i=0;$i<count($array) - 1;$i++){
    if(isset($rules[$array[$i+1]]) && in_array($array[$i],$rules[$array[$i+1]])){
      $newArray[$i] = $array[$i+1];
      $newArray[$i+1] = $array[$i];
      return $newArray;
    }
  }
  return $newArray;
}