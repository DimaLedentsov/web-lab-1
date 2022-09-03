<?php
// header('Access-Control-Allow-Origin: *');

function validate($val){
	return isset($val);
}

// Проверка на попадание в область

function check_first_area($x, $y, $r){
	return ($x>=0 && $y>=0 && sqrt($x*$x+$y*$y)<=$r/2);
}

function check_second_area($x, $y, $r){
	return ($x<=0 && $y>=0 && $y<=2*$x+$r);
}

function check_third_area($x, $y, $r){
	return ($x>=0 && $y<=0 && $x<=$r/2 && $y>= -$r);
}

$Xval = @$_POST["x_coordinate"];
$Yval = @$_POST["y_coordinate"];
$Rval = @$_POST["r_coordinate"];
$timezone= @$_POST["timezone"];

if(validate($Xval) && validate($Yval) && validate($Rval) && validate($timezone)){
    $is_inside = check_first_area($Xval, $Yval, $Rval) || check_second_area($Xval, $Yval, $Rval) || check_third_area($Xval, $Yval, $Rval);
	$hit_fact = $is_inside ? "Hit": "Miss";
	$current_time = date("j M o G:i:s", time()-$timezone*60);
	$execution_time = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 7);
	
    echo "<tr class='columns'>";
	echo "<td>" . $Xval . "</td>";
	echo "<td>" . $Yval . "</td>";
	echo "<td>" . $Rval . "</td>";
	echo "<td>" . $hit_fact  . "</td>";
	echo "<td>" . $current_time  . "</td>";
	echo "<td>" . $execution_time . "</td>";
	echo "</tr>";
}

?>