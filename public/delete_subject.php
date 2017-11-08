<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
$current_subject = find_subject_by_id($_GET["subject"]);
if (!$current_subject) {
	redirect_to("manage_content.php");
}

$page_set = find_pages_for_subjects($current_subject["id"],false);
if (mysqli_num_rows($page_set) > 0) {
	$_SESSION["message"] = "Can't delete a subject with pages.";
	redirect_to("manage_content.php?subject={$current_subject["id"]}");
}

$id = $current_subject["id"];
$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_affected_rows($conn) == 1) {
	$_SESSION["message"] = "Deleted successfully.";
	redirect_to("manage_content.php");
} else {
	$_SESSION["message"] = "Failed to delete.";
	redirect_to("manage_content.php?subject={$id}");
}