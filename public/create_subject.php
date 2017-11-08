<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_function.php"); ?>
<?php
if (isset($_POST["submit"])) {
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int)$_POST["position"];
	$visible = (int)$_POST["visible"];

	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);

	$field_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($field_with_max_lengths);

	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_subject.php");
	}

	$query = "INSERT INTO subjects";
	$query .= " (menu_name, position, visible)";
	$query .= " VALUES";
	$query .= " ('{$menu_name}', {$position}, {$visible})";

	$result = mysqli_query($conn, $query);

	if ($result) {
		$_SESSION["message"] = "Subject created.";
		redirect_to("manage_content.php");
	} else {
		$_SESSION["message"] = "Subject creation failed.";
		redirect_to("new_subject.php");
	}
} else {
	redirect_to("new_subject.php");
}

if (isset($conn)) { mysqli_close($conn); }