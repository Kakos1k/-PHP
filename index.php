<?php
require('example_persons_array.php');

$surname = 'Иванов';
$name = 'Иван';
$patronomyc = 'Иванович';

function getFullnameFromParts($surname, $name, $patronomyc) {
    return $surname . ' ' . $name . ' ' . $patronomyc;
}
echo getFullnameFromParts($surname, $name, $patronomyc);
echo "<hr>";

function getPartsFromFullname($name) {
    $a = ['surname', 'name', 'patronomyc'];
    $b = explode(' ', $name);
    return array_combine($a, $b);
}

foreach ($example_persons_array as $value) {
    $name = $value['fullname'];
    print_r(getPartsFromFullname($name));
    echo "<br>";
}
echo "<hr>";

function getShortName($name) {
    $arr = getPartsFromFullname($name);
    $firstName = $arr['name'];
    $surname = $arr['surname'];
    return $firstName . ' ' . mb_substr($surname, 0, 1) . '.';
}

foreach ($example_persons_array as $value) {
    $name = $value['fullname'];
    echo getShortName($name) . "<br>";
}
echo "<hr>";


function getGenderFromName($name) {
    $arr = getPartsFromFullname($name);
    $surname = $arr['surname'];
    $firstName = $arr['name'];
    $patronomyc = $arr['patronomyc'];
    $sumGender = 0;

    if (mb_substr($surname, -1, 1) === 'в') {
        $sumGender++;
    } elseif (mb_substr($surname, -2, 2) === 'ва') {
        $sumGender--;
    }
    
    if ((mb_substr($firstName, -1, 1) == 'й') || (mb_substr($firstName, -1, 1) == 'н')) {
        $sumGender++;
    } elseif (mb_substr($firstName, -1, 1) === 'а') {
        $sumGender--;
    }
   
    if (mb_substr($patronomyc, -2, 2) === 'ич') {
        $sumGender++;
    } elseif (mb_substr($patronomyc, -3, 3) === 'вна') {
        $sumGender--;
    }

    return ($sumGender <=> 0);
}

foreach ($example_persons_array as $value) {
    $name = $value['fullname'];
    echo getGenderFromName($name) . "<br>";
}

echo "<hr>";

function getGenderDescription($persons) {

    $men = array_filter($persons, function ($persons) {
        $fullname = $persons['fullname'];
        $genderMen = getGenderFromName($fullname);
        if ($genderMen > 0) {
            return $genderMen;
        }
    });

    $women = array_filter($persons, function ($persons) {
        $fullname = $persons['fullname'];
        $genderWomen = getGenderFromName($fullname);
        if ($genderWomen < 0) {
            return $genderWomen;
        }
    });

    $failedGender = array_filter($persons, function ($persons) {
        $fullname = $persons['fullname'];
        $genderFailed = getGenderFromName($fullname);   
        if ($genderFailed == 0) {                       
            return $genderFailed + 1;                   
        }
    });

    
    $allMan = count($men);                       
    $allWomen = count($women);                   
    $allFailedGender = count($failedGender);     
    $allPiople = $allMan + $allWomen + $allFailedGender;   

    $percentMen = round((100 / $allPiople * $allMan), 0);
    $percentWomen = round((100 / $allPiople * $allWomen), 0);
    $percenFailedGender = round((100 / $allPiople * $allFailedGender), 0);

    echo 'Гендерный состав аудитории:<br>';
    echo '------------------------------------------------------<br>';
    echo "✦ Мужчины - $percentMen% <br>";
    echo "✦ Женщины - $percentWomen% <br>";
    echo "✦ Неудалось определить - $percenFailedGender%";
}
getGenderDescription($example_persons_array);
echo "<hr>";

$surname = 'Славин';
$name = 'Семён';
$patronomyc = 'Сергеевич';

function getPerfectPartner($surname, $name, $patronomyc, $persons) {

    $surnameNorm = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
    $nameNorm = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
    $patronomycNorm = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE);

    $fullNameNorm = getFullnameFromParts($surnameNorm, $nameNorm, $patronomycNorm);  
    $shortNameNorm = getShortName($fullNameNorm);                                    
    $genderFullNameNorm = getGenderFromName($fullNameNorm);                          

    if ($genderFullNameNorm == 0) {
        echo "Заданы аргументы неопределенного пола";
        die;
    }

    do {
        $personsNumRand = array_rand($persons);
        $personFullNameRand = $persons[$personsNumRand]['fullname'];         
        $personFullNameRandGender = getGenderFromName($personFullNameRand);  
    } while (($genderFullNameNorm == $personFullNameRandGender) || ($personFullNameRandGender == 0));

    $personShortNameRand = getShortName($personFullNameRand);   
    $percentPerfect = rand(5000, 10000) / 100;                  
    
    echo "$shortNameNorm + $personShortNameRand = <br>";
    echo "♡ Идеально на $percentPerfect% ♡";
}
getPerfectPartner($surname, $name, $patronomyc, $example_persons_array);