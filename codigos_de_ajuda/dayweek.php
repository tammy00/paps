<?php
echo date('w', strtotime('2016-01-01'));
echo '<br>';
echo (date('Y-m-01'));
echo '<br>';
echo '<br>';
$ano = 2016;
$mes = 02;
$date = $ano .'-'.$mes.'-01';
echo 'Data: ' . $date . '<br>';
echo 'Data contatenada: ' . (date('w', strtotime($date)));
echo '<br>';
echo 'Dia da data: '. date('d', strtotime($date)) . '<br>';
echo 'ÚLtimo dia do mês data especificada: ' . date('d', strtotime(date('Y-m-t', strtotime($date)))) . '<br>';
echo 'Última data do mês da data especificada: ' . date('Y-m-t', strtotime($date)) . '<br>';
?>