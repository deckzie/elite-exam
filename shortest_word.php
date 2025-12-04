<?php 
    function shortestWordLength($str){
        $words = explode(" ", $str);
        $lengths = array_map('strlen', $words);
        
        $shortest = min($lengths);
        
        return $shortest;
    }

    // TEST CASES
    print(shortestWordLength("TRUE FRIENDS ARE ME AND YOU"));
    echo "\n";
    print(shortestWordLength("I AM THE LEGENDARY VILLAIN"));
?>