<?php
function redirect_to($new_location) {
	header("Location:" . $new_location);
	exit;
}

function mysql_prep($string) {
	global $conn;
	$escaped_string = mysqli_escape_string($conn, $string);
	return $escaped_string;
}

function confirm_query($result_set) {
	global $conn;
	if (!$result_set) {
		die("Database query failed." . mysqli_error($conn));
	}
}

 function form_errors($errors=array()) {
 	$output = "";
 	if (!empty($errors)) {
 		$output .= "<div class\"error\">";
 		$output .= "Please fix the following errors:";
 		$output .= "<ul>";
 		foreach ($errors as $key => $error) {
 			$output .= "<li>{$error}</li>";
 		}
 		$output .= "</ul></div>";
 	}
 	return $output;
 }

function find_all_subjects() {
	global $conn;
	$query = "SELECT * FROM subjects ";
	//$query .= "WHERE visible = 1 ";
	$query .= "ORDER BY position ASC";
	$subject_set = mysqli_query($conn, $query);
	confirm_query($subject_set);
	return $subject_set;
}

function find_pages_for_subjects($subject_id) {
	global $conn;
	$safe_subject_id = mysqli_escape_string($conn, $subject_id);
	$query = "SELECT * FROM pages ";
	$query .= "WHERE subject_id = {$safe_subject_id}";
	$query .= " AND visible = 1 ";
	$query .= "ORDER BY position ASC";
	$page_set = mysqli_query($conn, $query);
	confirm_query($page_set);
	return $page_set;
}

function find_subject_by_id($subject_id) {
	global $conn;

	$safe_subject_id = mysqli_escape_string($conn, $subject_id);

	$query = "SELECT * FROM subjects ";
	$query .= "WHERE id = {$safe_subject_id} ";
	$query .= "LIMIT 1";
	$subject_set = mysqli_query($conn, $query);
	confirm_query($subject_set);
	if ($subject = mysqli_fetch_assoc($subject_set)) {
		return $subject;
	} else {
		return null;
	}
}

function find_page_by_id($page_id) {
	global $conn;

	$safe_page_id = mysqli_escape_string($conn, $page_id);

	$query = "SELECT * FROM pages ";
	$query .= "WHERE id = {$safe_page_id} ";
	$query .= "LIMIT 1";
	$page_set = mysqli_query($conn, $query);
	confirm_query($page_set);
	if ($page = mysqli_fetch_assoc($page_set)) {
		return $page;
	} else {
		return null;
	}
	
}

function find_selected_page() {
	global $current_subject;
	global $current_page;
	if (isset($_GET["subject"])) {
		$current_subject = find_subject_by_id($_GET["subject"]);
		$current_page =  null;
	} elseif (isset($_GET["page"])) {
		$current_subject = null;
		$current_page = find_page_by_id($_GET["page"]);
	} else {
		$current_page = null;
		$current_subject = null;
	}
}

function navigation($subject_array,$page_array) {
	$output = "<ul class=\"subjects\">";
	$subject_set = find_all_subjects();
	while($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if ($subject_array && $subject["id"] == $subject_array["id"]) {
			$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?subject=";
			$output .= urlencode($subject["id"]) . "\">";
			$output .= $subject["menu_name"];
			$output .= "</a>";

			$page_set = find_pages_for_subjects($subject["id"]);
			$output .= "<ul class=\"pages\">";
			while($page = mysqli_fetch_assoc($page_set)) {
			$output .= "<li";
			if ($page_array && $page["id"] == $page_array["id"]) {
			$output .= " class=\"selected\"";
			}
			$output .= ">";

			$output .= "<a href=\"manage_content.php?page=";
			$output .= urlencode($page["id"]) . "\">";
			$output .= $page["menu_name"];
			$output .= "</a></li>";
			}
			mysqli_free_result($page_set);
			$output .= "</ul>";
			$output .= "</li>";
			}
			mysqli_free_result($subject_set);
			$output .= "</ul>";

			return $output;
}