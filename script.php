<?php
// header('Access-Control-Allow-Origin: *');

function validate($val){
	return isset($val);
}

// Проверка на попадание в область



function check_left_up_area($x, $y, $r){
    return ($x<=0 && $y>=0 && ($x*$x+$y*$y)<=$r);
}

function check_right_up_area($x, $y, $r){
    return ($x>=0 && $y>=0 && sqrt($x*$x+$y*$y)<=$r);
}

function check_right_down_area($x, $y, $r){
    return ($x>=0 && $y<=0 && -$y*2-$x*2<=$r);
}

$Xval = @$_POST["x_coordinate"];
$Yval = @$_POST["y_coordinate"];
$Rval = @$_POST["r_coordinate"];
$timezone= @$_POST["timezone"];

if(validate($Xval) && validate($Yval) && validate($Rval) && validate($timezone)){
    $INSIDE = check_left_up_area($Xval, $Yval, $Rval) || check_right_up_area($Xval, $Yval, $Rval) || check_right_down_area($Xval, $Yval, $Rval);
	$CONVERTED_INSIDE = $INSIDE ? "Hit": "Miss";
	$current_time = date("j M o G:i:s", time()-$timezone*60);
	$executionTime = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 7);
	
    echo "<tr class='columns'>";
	echo "<td>" . $Xval . "</td>";
	echo "<td>" . $Yval . "</td>";
	echo "<td>" . $Rval . "</td>";
	echo "<td>" . $CONVERTED_INSIDE  . "</td>";
	echo "<td>" . $current_time  . "</td>";
	echo "<td>" . $executionTime . "</td>";
	echo "</tr>";


}
?>