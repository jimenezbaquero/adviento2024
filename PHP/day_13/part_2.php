<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$toAdd = 10000000000000;

$prizes = [];
$aux = [];

foreach ($data as $row) {
  if($row == ''){
    if(!empty($aux)) {
      $prizes[] = $aux;
    }
    $aux = [];
    continue;
  }
  $arrayAux = explode(": ", $row);
  $coords = explode(", ", $arrayAux[1]);
  if($arrayAux[0] == 'Prize') {
    $aux['prize'] = [str_replace('X=','',$coords[0])+$toAdd,str_replace('Y=','',$coords[1])+$toAdd];
  }else{
    $aux[substr($arrayAux[0], -1)] = [str_replace('X+','',$coords[0]),str_replace('Y+','',$coords[1])];
  }
}
$prizes[] = $aux;

foreach ($prizes as $key=>$prize) {
  $a = ($prize['prize'][0]*$prize['B'][1] - $prize['prize'][1]*$prize['B'][0])/($prize['A'][0]*$prize['B'][1] - $prize['A'][1]*$prize['B'][0]);
  $b = ($prize['prize'][1]*$prize['A'][0] - $prize['prize'][0]*$prize['A'][1])/($prize['A'][0]*$prize['B'][1] - $prize['A'][1]*$prize['B'][0]);

  if(is_int($a) && is_int($b)) {
    $total += $a*3+$b;
  }
}

echo 'Solution: '.$total;



