<?php

$input = file("input");
$x = 0;
$y = 0;
foreach ($input as $string) {
    $instructions = explode(" ", $string);

    $magnitude = $instructions[1];
    $direction = $instructions[0];

    if ($direction == "forward") {
        $x += $magnitude;
    } else {
        if ($direction == "down") {
            $y += $magnitude;
        } else {
            $y -= $magnitude;
        }
    }
}
echo ("Part 1: " . $x * $y);
echo "<br>";

$aim = 0;
$x = 0;
$y = 0;
foreach ($input as $string) {
    $instructions = explode(" ", $string);

    $magnitude = $instructions[1];
    $direction = $instructions[0];

    if ($direction == "forward") {
        $x += $magnitude;
        $y += $aim * $magnitude;
    } else {
        if ($direction == "down") {
            $aim += $magnitude;
        } else {
            $aim -= $magnitude;
        }
    }
}
echo ("Part 2: " . $x * $y);