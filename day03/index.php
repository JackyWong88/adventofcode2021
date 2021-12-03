<pre>
<?php

$lines = file("input", FILE_IGNORE_NEW_LINES);

// set the size of the array
$n = count($lines);
$onesCounts = [];
$length = strlen($lines[0]);

foreach ($lines as $binary) {
    foreach (str_split($binary) as $k=>$bit) {
        if ($bit == "1") {
            $onesCounts[$k]++;
        }
    }
}
ksort($onesCounts);
print_r($onesCounts);

// build binary from result
$gamma = "";
foreach ($onesCounts as $onesCount) {
    if ($onesCount > $n/2) {
        $gamma .= "1";
    } else {
        $gamma .= "0";
    }
}

// form epsilon
$epsilon = "";
foreach (str_split($gamma) as $bit) {
    if ($bit == 1) {
        $epsilon .= "0";
    } else {
        $epsilon .= "1";
    }
}

echo ("Part 1: " . binaryToInt($gamma) * binaryToInt($epsilon));
echo "<br>";

$gamma2 = "";
for ($i = 0; $i < $length; $i++) {
    $gamma2 .= countMostCommonBit($lines, $i);
}
var_dump($gamma);
var_dump($gamma2);


$epsilon2 = "";
for ($i = 0; $i < $length; $i++) {
    $epsilon2 .= countLeastCommonBit($lines, $i);
}
var_dump($epsilon);
var_dump($epsilon2);


$oxygenGeneratorRating = array_merge(array(), $lines);
var_dump(strlen($oxygenGeneratorRating[0]));
for ($i = 0; $i < $length; $i++) {
    $mostCommonBit = countMostCommonBit($oxygenGeneratorRating, $i);
    var_dump("Most common bit is ".$mostCommonBit);
    foreach ($oxygenGeneratorRating as $k=>$binary) {
        if ($binary[$i] != $mostCommonBit) {
            unset($oxygenGeneratorRating[$k]);
        }
    }
    var_dump(count($oxygenGeneratorRating)." binaries remaining");
}

print_r($oxygenGeneratorRating);

$co2ScrubberRating = array_merge(array(), $lines);
for ($i = 0; $i < $length; $i++) {
    $leastCommonBit = countLeastCommonBit($co2ScrubberRating, $i);
    var_dump("Least common bit is " . $leastCommonBit);
    foreach ($co2ScrubberRating as $k => $binary) {
        if ($binary[$i] != $leastCommonBit) {
            unset($co2ScrubberRating[$k]);
        }
    }
    var_dump(count($co2ScrubberRating) . " binaries remaining");

    if (count($co2ScrubberRating) == 1) {
        break;
    }
}
print_r($co2ScrubberRating);

echo ("Part 2: " . binaryToInt(array_shift($oxygenGeneratorRating)) * binaryToInt(array_shift($co2ScrubberRating)));

function binaryToInt($binary) {
    $result = 0;
    $length = strlen($binary);
    foreach (str_split($binary) as $k=>$bit) {
        if ($bit == 1) {
            $result += pow(2, $length - $k - 1);
        }
    }
    return $result;
}

function countMostCommonBit($binaries, $bitLocation) {
    $n = count($binaries);
    $onesCount = 0;

    foreach ($binaries as $binary) {
        $bit = $binary[$bitLocation];
        if ($bit == "1") {
            $onesCount++;
        }
    }

    return $onesCount >= $n / 2 ? 1 : 0;
}

function countLeastCommonBit($binaries, $bitLocation)
{
    $n = count($binaries);
    $onesCount = 0;

    foreach ($binaries as $binary) {
        $bit = $binary[$bitLocation];
        if ($bit == "1") {
            $onesCount++;
        }
    }
    var_dump($onesCount . " 1s out of $n");

    return $onesCount < $n / 2 ? 1 : 0;
}