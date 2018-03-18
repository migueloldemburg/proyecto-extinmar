<?php // content="text/plain; charset=utf-8"

require_once ('libs/jpgraph-4.1.0/src/jpgraph.php');
require_once ('libs/jpgraph-4.1.0/src/jpgraph_bar.php');
require_once ('class/MiClase.php');
//Cada arreglo es cada tipo de extintor, y cada valor es lo que representa por mes

$tipoExtintor = new MiClase();
$tipoExtintor->obtener_categorias();

$obj = new MiClase();

//Cada arreglo $data0y, $data1y, $dataNy... es cada tipo de extintor, y cada valor en el arreglo $cant_x_mes, es lo que representa la cantidad de extintores para dicho mes
$contador=0;
$tipos = array();
while( $row=$tipoExtintor->array->fetch_array() ){
	$variable = "data".$contador."y";

	$cant_x_mes = array();
	$cant_x_mes[] = $obj->get_categorias_cantidad('01', date('Y'), $row['id']) + $obj->get_categorias_cantidad('02', date('Y'), $row['id']) + $obj->get_categorias_cantidad('03', date('Y'), $row['id']);
	$cant_x_mes[] = $obj->get_categorias_cantidad('04', date('Y'), $row['id']) + $obj->get_categorias_cantidad('05', date('Y'), $row['id']) + $obj->get_categorias_cantidad('06', date('Y'), $row['id']);
	$cant_x_mes[] = $obj->get_categorias_cantidad('07', date('Y'), $row['id']) + $obj->get_categorias_cantidad('08', date('Y'), $row['id']) + $obj->get_categorias_cantidad('09', date('Y'), $row['id']);
	$cant_x_mes[] = $obj->get_categorias_cantidad('10', date('Y'), $row['id']) + $obj->get_categorias_cantidad('11', date('Y'), $row['id']) + $obj->get_categorias_cantidad('12', date('Y'), $row['id']);

	$$variable = $cant_x_mes;
	$tipos[$contador] = $row['nombre'];
	$contador++;
}

// Create the graph. These two calls are always required
$graph = new Graph(750,400,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,10,20,30,60,90,120,150, 200), array(5,15,25,45,75,105,135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);

//Se le pasa un arreglo con los meses
$graph->xaxis->SetTickLabels(array('Ene-Feb-Mar','Abr-May-Jun','Jul-Ago-Sep','Oct-Nov-Dic'));

$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

// Create the bar $b0plot, $b1plot, $bNplot... / CADA TIPO de extintor
$groupBar = array();
for($i=0; $i<$contador;$i++){
	${"b".$i."plot"} = new BarPlot(${"data".$i."y"});
	$groupBar[] = ${"b".$i."plot"};
}

// Create the grouped bar plot
$gbplot = new GroupBarPlot($groupBar);
// ...and add it to the graPH
$graph->Add($gbplot);
$graph->legend->Hide(false);


$color0 = "#6c5ce7";
$color1 = "#bdc3c7";
$color2 = "#2ecc71";
$color3 = "#3498db";
$color4 = "#9b59b6";
$color5 = "#34495e";
$color6 = "#16a085";
$color7 = "#27ae60";
$color8 = "#2980b9";
$color9 = "#e67e22";
$color10 = "#e74c3c";
$color11 = "#f1c40f";
$color12 = "#d35400";
$color13 = "#1abc9c";
$color14 = "#7f8c8d";

for($i=0; $i<$contador;$i++){
	${"b".$i."plot"}->SetColor(${"color".$i});
	${"b".$i."plot"}->SetFillColor(${"color".$i});

	// add legend
	${"b".$i."plot"}->SetLegend($tipos[$i]);
}

$graph->title->Set("GRAFICAS TRIMESTRALES  AÑO(".date('Y').")");

// Display the graph
$graph->Stroke();
?>