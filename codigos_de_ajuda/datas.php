<?php
//$result = date('Y-m-t') - date('Y-m-01');
//$result = date('Y-m-01') + 26;
echo 'Hoje é dia: ' . date('Y-m-d');
echo '<br>';
echo 'Hoje é dia: ' . date('d-m-Y');
echo '<br>';
echo 'Hoje é dia: ' . strtotime(date('d-m-Y'));
echo '<br>';
$anterior = strtotime("-1 day", strtotime(date('Y-m-01')));
echo '<br>';
echo 'Dia anterior ao dia primeiro: ' . date("Y-m-d", $anterior);
echo '<br>';
$anterior = strtotime("+1 day", strtotime(date('Y-m-01')));
echo 'Dia posterior ao dia primeiro TESTEEE ' . date("Y-m-d", strtotime("+1 day", strtotime(date('Y-m-01'))));
echo '<br>';
$date = "2007-02-28";

$date = strtotime("+1 day", strtotime($date));
echo date("Y-m-d", $date);
//echo date('Y-m-t');




echo '<br>';
$anterior = strtotime("-1 day", strtotime("2016-01-19"));
echo date("Y-m-d", $anterior);


echo '<br>';
$anterior = strtotime("-2 day", strtotime("2016-01-19"));
echo date("Y-m-d", $anterior);


echo '<br>';
$anterior = strtotime("+4 day", strtotime("2016-01-19"));
echo date("Y-m-d", $anterior);
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
$quatro = 4;
$anterior = strtotime('+'.($quatro - 1).'day', strtotime("2016-01-19"));
echo date("Y-m-d", $anterior);
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
$midnight = mktime(12,0,0);
$date = date('d-m-Y h:i:s');
echo $date;
echo '<br>';
echo date($date, $midnight)."\n";
echo '<br>';
echo date('d-m-Y h:i:s ',$midnight+60)."\n"; // One minute
echo '<br>';
echo date('d-m-Y h:i:s ',$midnight+(60*60))."\n"; // One hour
echo '<br>';
?>