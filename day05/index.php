<pre>

<?php

$lines = file("input", FILE_IGNORE_NEW_LINES);
$flatLines = [];
$part1Map = [];
$part2Map = [];
$overlapCount1 = 0;
$overlapCount2 = 0;

foreach ($lines as $k=>$line) {
    $line = new Line($line);
    if ($line->isFlat()) {
        $flatLines[] = $line;
        // print_r($line)
        // print_r($line->getArray());
        $part1Map = plotLine($part1Map, $line->getArray(), $overlapCount1);
    } else {
//        print_r($line);
//        print_r($line->getArray());
    }
    $part2Map = plotLine($part2Map, $line->getArray(), $overlapCount2);
}
//print_r($part2Map);

echo ("Part 1: " . $overlapCount1);
echo "<br>";

echo ("Part 2: " . $overlapCount2);
echo "<br>";


function plotLine($map, $lineArray, &$overlapCount) {
    foreach ($lineArray as $rowIdx => $row) {
        foreach ($row as $colIdx => $count) {
            if (!isset($map[$rowIdx][$colIdx])) $map[$rowIdx][$colIdx] = 0;
            $map[$rowIdx][$colIdx] = $count + $map[$rowIdx][$colIdx];

            // determine overlap
            if ($map[$rowIdx][$colIdx] == 2) {
                $overlapCount++;
            }
        }
    }

    return $map;
}


class Line {
    var $startPoint, $endPoint, $isVertical, $isHorizontal;

    public function __construct($raw) {
        $points = explode(" -> ", $raw);
        $this->startPoint = new Point($points[0]);
        $this->endPoint = new Point($points[1]);
        // set is vertical/horizontal
        $this->isFlat();
    }

    public function isFlat() {
        if ($this->startPoint->x == $this->endPoint->x || $this->startPoint->y == $this->endPoint->y) {
            if ($this->startPoint->x == $this->endPoint->x) {
                $this->isVertical = true;
            } else {
                $this->isHorizontal = true;
            }
            return true;
        }
        return false;
    }

    public function getArray() {
        $array = [];
        if ($this->isHorizontal === true) {
            // set the row index
            $length = $this->getDistance();
            $array[$this->startPoint->y] = array_fill($this->endPoint->x > $this->startPoint->x ? $this->startPoint->x : $this->endPoint->x, $length+1, 1);
        } else if ($this->isVertical === true) {
            $length = abs($this->startPoint->y - $this->endPoint->y);
            $startY = $this->endPoint->y > $this->startPoint->y ? $this->startPoint->y : $this->endPoint->y;
            for ($i = $startY; $i <= $startY + $length; $i++) {
                $array[$i][$this->startPoint->x] = 1;
            }
        } else {
            // these are diagonal lines
            // figure slope
            $ySlope = ($this->endPoint->y - $this->startPoint->y);
            $xSlope =  ($this->endPoint->x - $this->startPoint->x);
            $slope = $ySlope/$xSlope;

            // figure start point
            $startY = $this->endPoint->y > $this->startPoint->y ? $this->startPoint->y : $this->endPoint->y;
            $startX = $this->endPoint->y > $this->startPoint->y ? $this->startPoint->x : $this->endPoint->x;
            $endY = $this->endPoint->y < $this->startPoint->y ? $this->startPoint->y : $this->endPoint->y;

            // plot the line
            for ($i = 0; $i <= ($endY - $startY); $i++) {
                $array[$startY + $i][$startX + ($i * $slope)] = 1;
            }

            if (abs($ySlope/$xSlope) != 1) {
                var_dump("WTF");
            }
        }
        return $array;
    }

    public function getDistance() {
        return sqrt(pow($this->startPoint->x - $this->endPoint->x, 2) + pow($this->startPoint->y - $this->endPoint->y, 2));
    }
}

class Point {
    var $x, $y;

    public function __construct($coordinate) {
        $coordinates = explode(",", $coordinate);
        $this->x = $coordinates[0];
        $this->y = $coordinates[1];
    }
}