<?php
$b = array_fill(1, 1, 1);//this is not what we want
$b = array_fill(2, 1, 2);
$b = array_fill(3, 1, 3);
//$c = array_fill_keys(range(-2,1),'pear');//these are negative indices
print_r($b);
//print_r($c);
?>