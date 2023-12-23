<?php
 
// $dataPoints = array( 
// 	array("y" => 3373.64, "label" => "Germany" ),
// 	array("y" => 2435.94, "label" => "France" ),
// 	array("y" => 1842.55, "label" => "China" ),
// 	array("y" => 1828.55, "label" => "Russia" ),
// 	array("y" => 1039.99, "label" => "Switzerland" ),
// 	array("y" => 765.215, "label" => "Japan" ),
// 	array("y" => 612.453, "label" => "Netherlands" )
// );
// $dataPoints1 = array( 
// 	array("label"=>"Chrome", "y"=>64.02),
// 	array("label"=>"Firefox", "y"=>12.55),
// 	array("label"=>"IE", "y"=>8.47),
// 	array("label"=>"Safari", "y"=>6.08),
// 	array("label"=>"Edge", "y"=>4.29),
// 	array("label"=>"Others", "y"=>4.59)
// );

$link = mysqli_connect("localhost","root","");
mysqli_select_db($link, "project1");

$arr = array();
$count = 0;

$res = mysqli_query($link, "select * from barchart");
while($row = mysqli_fetch_array($res)){
	$arr[$count]["label"] = $row["Label"];
	$arr[$count]["y"] = $row["Amount"];
	$count++;

}
$arr2 = array();
$count = 0;
$res2 = mysqli_query($link, "SELECT country, budget, time FROM piechart ORDER BY time DESC LIMIT 3");
while($row = mysqli_fetch_array($res2)){
	$arr2[$count]["label"] = $row["country"];
	$arr2[$count]["y"] = $row["budget"];
	$count++;
}

 
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Dashboard"
	},
	axisY: {
		title: "Gold Reserves"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.##",
		dataPoints: <?php echo json_encode($arr, JSON_NUMERIC_CHECK); ?>
	}]
});
var chart1 = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
	title: {
		text: "Military Budget of Respected Country"
	},
	subtitles: [{
		text: "November 2023"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"$\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($arr2, JSON_NUMERIC_CHECK); ?>
	}]
});

chart.render();
chart1.render();
 
}
</script>
</head>
<body>
	<br><br>
	<div id="chartContainer" style="height: 370px; width: 100%; margin: 10px"></div><br>
	<div id="chartContainer1" style="height: 370px; width: 100%;"></div>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>  