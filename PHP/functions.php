<?php
function loadFile($file){
    $rows = [];
    $input = fopen($file,'rb');
    while ($line = fgets($input)) {
        $line = trim($line);
        $rows[] = $line;
    }
    return $rows;
}

function transpose($array) {
    $response = [];
    foreach ($array as $numRow => $row){
        foreach ($row as $numCol => $element){
            $response[$numCol][$numRow] = $element;
        }
    }
    return $response;
}

function paint($array ,$key = null){
    $keys = array_keys($array);
    $minKey = min($keys);
    $maxKey = max($keys);
    for ($i = $minKey; $i <= $maxKey; $i++){
        $text = '';
        for ($j = $minKey; $j <= $maxKey; $j++){
            if(!is_null($key)){
                $text.=$array[$i][$j][$key];
            }else{
                $text .= $array[$i][$j];
            }
        }
        echo $text.PHP_EOL;
    }
    echo '---------------'.PHP_EOL;
}

function paintFull($array){
  foreach ($array as $i=>$row){
    echo implode('',$row).PHP_EOL;
  }
  echo '---------------'.PHP_EOL;
}