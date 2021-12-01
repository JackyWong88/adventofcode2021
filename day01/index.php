<style>
body {
    font-family: monospace;
}
</style>
<pre>
<?php
$lines = file("input");
print_r($lines);

$increased = 0;
foreach ($lines as $k=>$value) {
    $value = (int) $value;
    if (($k - 1) >= 0 && $value > $lines[$k-1]) {
        $increased++;
    }
}

echo("Part 1: ". $increased);
echo "<br>";

// part 2
$measurements = [];
foreach ($lines as $k => $value) {
    $value = (int) $value;
    if (($k - 2) >= 0) {
        $measurements[] = $value + $lines[$k-1] + $lines[$k-2];
    }
}
print_r($measurements);
$increased = 0;
foreach ($measurements as $k => $value) {
    $value = (int) $value;
    if (($k - 1) >= 0 && $value > $measurements[$k - 1]) {
        $increased++;
    }
}
echo ("Part 2: " . $increased);