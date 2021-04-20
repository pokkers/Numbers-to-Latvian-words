<?php

//Free to use.
//Script for transform numbers to Latvian words.
//V1.0 - Functionality only. Grammar checks not performed.
//Author K.Pokkers

$ones = [
    0 => '',
    1 => 'viens',
    2 => 'divi',
    3 => 'trīs',
    4 => 'četri',
    5 => 'pieci',
    6 => 'seši',
    7 => 'septiņi',
    8 => 'astoņi',
    9 => 'deviņi',
    10 => 'desmit'
];

$tens = [
    0 => '',
    1 => 'vien',
    2 => 'div',
    3 => 'trīs',
    4 => 'četr',
    5 => 'piec',
    6 => 'seš',
    7 => 'septiņ',
    8 => 'astoņ',
    9 => 'deviņ',
];

$hundreds = [
    1 => 'simts',
    2 => 'simtu',
    3 => 'simti'
];

$thousands = [
    1 => 'tūkstotis',
    2 => 'tūkstoši'
];

$millions = [
    1 => 'miljons',
    2 => 'miljoni'
];

//Input field without integer validation
$input = readline('ievadiet skaitli: ');

$splitNumber = number_format($input);

$numberType = explode(',', $splitNumber);

$words = [];
foreach ($numberType as $key => $value) {

    $number = '';

    //Splitting hundreds (Peculiarities of the Latvian language)
    $splitHundreds = substr_replace($value, ',', -2, 0);
    $hundredsOperator = explode(',', $splitHundreds);

    //Operating hundreds
    if ($hundredsOperator[0] == 1) {
        if ($hundredsOperator[1] == 0) {
            $number .= $hundreds[1];
        } else if ($hundredsOperator[1] > 0) {
            $number .= $hundreds[2] . ' ';
        }
    } else if ($hundredsOperator[0] > 1) {
        $number .= $ones[$hundredsOperator[0]] . ' ' . $hundreds[3] . ' ';
    }

    //Operating tens and ones
    if ($hundredsOperator[1] == 0 && strlen($value) == 1) {
        $number .= 'nulle';
    } else if ($hundredsOperator[1] <= 10) {
        $number .= $ones[$hundredsOperator[1][0]];
    } else if ($hundredsOperator[1] > 10 && $hundredsOperator[1] < 20) {
        $number .= $tens[$hundredsOperator[1][1]] . 'padsmit';
    } else {
        $number .= $tens[$hundredsOperator[1][0]] . 'desmit ' . $ones[$hundredsOperator[1][1]];
    }

    array_push($words, $number);
}

//Operate and output millions
if (count($words) == 3 && strpos($words[0], 'viens') !== false) {
    echo $millions[1] . ' ' . $words[1] . ' ' . $thousands[2] . ' ' . $words[2];
} else if (count($words) == 3) {
    echo $words[0] . ' ' . $millions[2] . ' ' . $words[1] . ' ' . $thousands[2] . ' ' . $words[2];
}

//Operate and output thousands
if (count($words) == 2 && strpos($words[0], 'viens') !== false) {
    echo $thousands[1] . ' ' . $words[1];
} else if (count($words) == 2) {
    echo $words[0] . ' ' . $thousands[2] . ' ' . $words[1];
}

//Output hundreds
if (count($words) == 1) {
    echo $words[0];
}

