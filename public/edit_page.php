<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_function.php"); ?>

<?php find_selected_page(); ?>

<?php
	if (!$current_page) {
		redirect_to("manage_content.php");
	}
?>

<?php 
if (isset($_POST["submit"])) {

	$subject_id = $current_page["id"];
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int)$_POST["position"];
	$visible = (int)$_POST["visible"];
	$content = mysql_prep($_POST["content"]);

	$required_fields = array("menu_name", "position", "visible", "content");
	validate_presences($required_fields);

	$field_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($field_with_max_lengths);

	if (empty($errors)) {
  
	$query = "UPDATE pages set ";
	$query .= "menu_name = '{$menu_name}', ";
	$query .= "position = {$position}, ";
	$query .= "visible = {$visible}, ";
	$query .= "content = '{$content}' ";
	$query .= "WHERE id = {$subject_id} ";
	$query .= "LIMIT 1";

	$result = mysqli_query($conn, $query);

	if ($result && mysqli_affected_rows($conn) == 1) {
		$_SESSION["message"] = "Page modified.";
		redirect_to("manage_content.php");
	} else {
		$message = "Page failed to modify.";
	}
}
}

?>
	<?php $layout_context = "admin"; ?>
	<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">

	</div>
	<div id="page">
		<?php if (!empty($message)) {
			echo "<div class=\"message\">" . htmlentities($message) . "</div>";
		} ?>
		<?php //$errors = errors(); ?>
		<?php echo form_errors($errors); ?>

		<h2>Edit Page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
		<form method="post" action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">
			<p>Page name:
				<input type="text" name="menu_name" value="<?php echo htmlentities($current_page['menu_name']); ?>" />
			</p>
			<p>Position:
				<select name="position">
			<?php $page_set = find_pages_for_subjects($current_page["subject_id"],false); ?>
			<?php $page_count = mysqli_num_rows($page_set);?>
			<?php for ($count=1; $count <= $page_count; $count++) { 
				echo "<option value=\"{$count}\"";
				if ($current_page["position"] == $count) {
					echo " selected";
				}
				echo ">{$count}</option>";
			} ?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) {
					echo "checked";
				} ?>/> No
				&nbsp;
				<input type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) {
					echo "checked";
				} ?>/> Yes
			</p>
			<p>Content:<br>
				<textarea cols="80" rows="20" name="content"><?php echo htmlentities($current_page["content"]); ?></textarea>
			</p>
			<input type="submit" name="submit" value="Save Changes">
		</form><br>
		<a href="manage_content.php?page=<?php echo urlencode($current_page["id"]); ?>">Cancel</a>
		&nbsp;
		&nbsp;
		<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?')">Delete</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?> 