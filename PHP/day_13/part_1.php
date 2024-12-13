<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;

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
    $aux['prize'] = [str_replace('X=','',$coords[0]),str_replace('Y=','',$coords[1])];
  }else{
    $aux[substr($arrayAux[0], -1)] = [str_replace('X+','',$coords[0]),str_replace('Y+','',$coords[1])];
  }
}
$prizes[] = $aux;

foreach ($prizes as $key=>$prize) {
  $gcds = [gmp_gcd($prize['A'][0],$prize['B'][0]),gmp_gcd($prize['A'][1],$prize['B'][1])];
  if($prize['prize'][0]%$gcds[0] == 0 &&
    $prize['prize'][1]%$gcds[1] == 0) {
    for ($b = 100; $b >= 0; $b--) {
      for ($a = 0; $a <= 100; $a++) {
        if ($b * $prize['B'][0] + $a * $prize['A'][0] == $prize['prize'][0] &&
          $b * $prize['B'][1] + $a * $prize['A'][1] == $prize['prize'][1]) {
          $total += $a * 3 + $b;
          break;
        }
      }
    }
  }
}



echo 'Solution: '.$total;

