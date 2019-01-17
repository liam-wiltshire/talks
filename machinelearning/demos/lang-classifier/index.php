<?php
require_once("./classifier-a.php");

$classifier = new Classifier();

if (isset($_POST['data'])) {
	$classifier->train($_POST["data"], $_POST["category"]);	
}

if (isset($_GET['data'])) {
	$resp = $classifier->classify($_GET["data"]);
	header('Content-Type: application/json');
	echo json_encode($resp);
}

?>
