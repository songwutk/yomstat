<?php
require_once('scraper.php' );
require_once('simple_html_dom.php');

$scraper = new Scraper();
$pageUrl = 'http://hydro-1.net/08HYDRO/HD-04/houly/water_today.php?station_id1=Y.20&station_id2=Y.1C';
$pageHtmlContent = $scraper->curl($pageUrl);
$subHtmlContent =  $scraper->getValueByTagName($pageHtmlContent, '<div id="yom"></div>', '<div id="nan"></div>');
$subHtmlContent =  $scraper->getValueByTagName($subHtmlContent, '<TABLE class="table-bordered" width="87%">', '<DIV align=left>');
$subHtmlContent= '<TABLE class="table-bordered" width="87%">'.$subHtmlContent;

$subHtmlContent =  $scraper->getValueByTagName($subHtmlContent, '<TD width=56 bgColor=#333333><DIV align=center><FONT face=Tahoma color=#ffffff size=2>01.00</FONT>', '<TD width=65 bgColor=#333333><DIV align=center><FONT face=Tahoma color=#ffcc99 size=2>24.00</FONT></DIV></TD>');
$subHtmlContent = '<tr><td>01.00'.$subHtmlContent;
//echo $subHtmlContent;
 
$html=str_get_html($subHtmlContent);
$table = array();

foreach($html->find('tr') as $row) {
	
    $table[(int)$row->find('td',0)->plaintext]['y20md1'] = $row->find('td',1)->plaintext;
    $table[(int)$row->find('td',0)->plaintext]['y20fd1'] = $row->find('td',2)->plaintext;

	$table[(int)$row->find('td',0)->plaintext]['y1cmd1'] = $row->find('td',3)->plaintext;
	$table[(int)$row->find('td',0)->plaintext]['y1cfd1'] = $row->find('td',4)->plaintext;

    $table[(int)$row->find('td',0)->plaintext]['y20md2'] = $row->find('td',5)->plaintext;
    $table[(int)$row->find('td',0)->plaintext]['y20fd2'] = $row->find('td',6)->plaintext;
	$table[(int)$row->find('td',0)->plaintext]['y1cmd2'] = $row->find('td',7)->plaintext;
	$table[(int)$row->find('td',0)->plaintext]['y1cfd2'] = $row->find('td',8)->plaintext;	
	
    $table[(int)$row->find('td',0)->plaintext]['y20md3'] = $row->find('td',9)->plaintext;
    $table[(int)$row->find('td',0)->plaintext]['y20fd3'] = $row->find('td',10)->plaintext;
	$table[(int)$row->find('td',0)->plaintext]['y1cmd3'] = $row->find('td',11)->plaintext;
	$table[(int)$row->find('td',0)->plaintext]['y1cfd3'] = $row->find('td',12)->plaintext;
}

echo '<pre>';
print_r($table);
echo '</pre>';

echo '<hr>';
echo " This hours = ". $table[(int)date("H")]['y1cmd3']." flow ".$table[(int)date("H")]['y1cfd3'];

?>
