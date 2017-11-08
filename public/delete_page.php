<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
$current_page = find_page_by_id($_GET["page"]);
if (!$current_page["id"]) {
	redirect_to("manage_content.php");
}


$page_id = $current_page["id"];
$query = "DELETE FROM pages WHERE id = {$page_id} LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_affected_rows($conn) == 1) {
	$_SESSION["message"] = "Page deleted";
	redirect_to("manage_content.php");
} else {
	$_SESSION["message"] = "Page deletion failed";
	redirect_to("manage_content.php?page={$page_id}");
}