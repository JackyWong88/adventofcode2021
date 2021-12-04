<pre>
<?php

$lines = file("input", FILE_IGNORE_NEW_LINES);

$draws = explode(",", array_shift($lines));
array_shift($lines);

$boardRows = [];
$boards = [];
$part1Result = null;

// set up all the boards
foreach ($lines as $line) {
    if ($line == "") {
        // create a new board
        $boards[] = new Board($boardRows);
        $boardRows = [];
    } else {
        $boardRows[] = $line;
    }
}

// simulate draws and marking off boards
foreach ($draws as $draw) {
    // check each board for the draw
    foreach ($boards as $k=>$board) {
        $board->markNumber($draw);

        // check if board has bingo
        if ($board->isBingo()) {
            if ($part1Result == null) {
                $part1Result = $board->sumRemainingNumbers() * $draw;
            }

            // remove board
            $part2Board = $board;
            unset($boards[$k]);
            $lastDraw = $draw;
        }
    }
}
$part2Result = $part2Board->sumRemainingNumbers() * $lastDraw;

// part 1
echo "Winning board result: ".$part1Result.PHP_EOL;
// part 2
echo "Last board to win: ".$part2Result.PHP_EOL;

class Board {
    var $rows = [];
    var $columns = [];

    public function __construct($boardRows) {
        // form rows
        foreach ($boardRows as $boardRow) {
            $this->rows[] = preg_split("/[\s,]+/", trim($boardRow));
        }
        // form columns
        foreach ($this->rows as $row) {
            foreach ($row as $k=>$value) {
                $this->columns[$k][] = $value;
            }
        }
    }

    public function markNumber($number) {
        $this->rows = findAndDeleteElement($this->rows, $number);
        $this->columns = findAndDeleteElement($this->columns, $number);
    }

    public function isBingo() {
        foreach ($this->columns as $column) {
            if (count($column) == 0) {
                return true;
            }
        }
        foreach ($this->rows as $row) {
            if (count($row) == 0) {
                return true;
            }
        }
        return false;
    }

    public function sumRemainingNumbers() {
        $sum = 0;
        foreach ($this->columns as $column) {
            foreach ($column as $value) {
                $sum += $value;
            }
        }
        return $sum;
    }
}

function findAndDeleteElement($array, $element) {
    foreach ($array as &$item) {
        foreach ($item as $k=>&$value) {
            if ($value == $element) {
                unset($item[$k]);
            }
        }
    }
    return $array;
}