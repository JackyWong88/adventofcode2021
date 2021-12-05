<pre>

<?php

$lines = file("input", FILE_IGNORE_NEW_LINES);
$flatLines = [];
$map = [];
$overlapCount = 0;

foreach ($lines as $k=>$line) {
    $line = new Line($line);
    if ($line->isFlat()) {
        $flatLines[] = $line;
        // print_r($line);
        // array_walk_recursive($map, 'sumArray', $line->getArray());
        // print_r($line->getArray());
        $map = sumArray2($map, $line->getArray(), $overlapCount);
    }
}
print_r($map);

echo ("Part 1: " . $overlapCount);
echo "<br>";

echo ("Part 2: " . $part2);
echo "<br>";

function sumArray($item, $key, $array) {
    foreach ($array as $row=>$value) {
        if (is_array($value)) {
            foreach ($value as $col=>$v) {
                
            }
        }
    }
}

function sumArray2($array1, $array2, &$overlapCount) {
    foreach ($array2 as $day => $value) {
        foreach ($value as $eat => $count) {
            if (!isset($array1[$day][$eat])) $array1[$day][$eat] = 0;
            $array1[$day][$eat] = $count + $array1[$day][$eat];
            if ($array1[$day][$eat] == 2) {
                $overlapCount++;
            }
        }
    }
    return $array1;
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
            $length = abs($this->startPoint->x - $this->endPoint->x);
            $array[$this->startPoint->y] = array_fill($this->endPoint->x > $this->startPoint->x ? $this->startPoint->x : $this->endPoint->x, $length, 1);
        } else {
            $length = abs($this->startPoint->y - $this->endPoint->y);
            $startY = $this->endPoint->y > $this->startPoint->y ? $this->startPoint->y : $this->endPoint->y;
            for ($i = $startY; $i <= $startY + $length; $i++) {
                $array[$i][$this->startPoint->x] = 1;
            }
        }
        return $array;
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