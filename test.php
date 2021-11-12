<?php
$a = [80 => 20, 20 => 10, 56 => 100, 70 => 33, 90 => 44];
$b = [70 => 33, 56 => 100, 90 => 44, 80 => 20, 20 => 10, 55 => 100];
echo '<pre>';
print_r($a);
echo '</pre>';
echo '<pre>AAAAAAAAAAAAAAA';
print_r($b);
echo '</pre>';

$c = array_intersect_assoc ($a, $b);
echo '<pre>intersect';
print_r($c);
echo '</pre>';

if($a == $b){
    echo 'Có';
}else{
    echo 'Không';
}