<?php 
function countTheIsland($matrix){
    foreach ($matrix as $row) {
        echo '"' . str_replace(['1','0'],['X','~'], implode('',$row)) . '"' . PHP_EOL;
    }
}

// TEST CASE
$matrix = [
    [1,1,1,1],
    [0,1,1,0],
    [0,1,0,1],
    [1,1,0,0]
];

countTheIsland($matrix);