<?php // content="text/plain; charset=utf-8"
date_default_timezone_set('America/Caracas');
require_once ('libs/jpgraph-4.1.0/src/jpgraph.php');
require_once ('libs/jpgraph-4.1.0/src/jpgraph_bar.php');
require_once ('class/MiClase.php');

$data1y=array();
$data2y=array();
$data3y=array();
$data4y=array();

$grafica = new MiClase();
$grafica->get_ext_categoria_cantidad();

$i=0;
while($row=$grafica->array->fetch_array()){
	$i++;
	if($i==1){ $data1y[] = $row['cantidad'];}
	if($i==2){ $data2y[] = $row['cantidad'];}
	if($i==3){ $data3y[] = $row['cantidad'];}
	if($i==4){ $data4y[] = $row['cantidad'];}
}

for($i=0;$i<11;$i++){
	$data1y[] = 0;
	$data2y[] = 0;
	$data3y[] = 0;
	$data4y[] = 0;
}

// Create the graph. These two calls are always required
$graph = new Graph(550,400,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50,52,54,56,58,60,62,64,66,68,70,72,74,76,78,80), array(1,2));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('Nov','Dic','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// // Create the bar plots
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);
$b3plot = new BarPlot($data3y);
$b4plot = new BarPlot($data4y);
// $b5plot = new BarPlot($data5y);

// // Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot,$b4plot));
// // ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#88b0d2");

$b2plot->SetColor("white");
$b2plot->SetFillColor("#dca45f");

$b3plot->SetColor("white");
$b3plot->SetFillColor("#419BC4");

$b4plot->SetColor("white");
$b4plot->SetFillColor("#73c441");

$graph->title->Set("Bar Plots");

// Display the graph
$graph->Stroke();
?>
