<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_function.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>

<?php
	if (!$current_subject) {
		redirect_to("manage_content.php");
	}
?>

<?php 
if (isset($_POST["submit"])) {

	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);

	$field_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($field_with_max_lengths);

	if (empty($errors)) {

	$subject_id = $current_subject["id"];
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int)$_POST["position"];
	$visible = (int)$_POST["visible"];

	$query = "UPDATE subjects set";
	$query .= " menu_name = '{$menu_name}',";
	$query .= " position = {$position},";
	$query .= " visible = {$visible}";
	$query .= " WHERE id = {$subject_id}";
	$query .= " LIMIT 1";

	$result = mysqli_query($conn, $query);

	if ($result && mysqli_affected_rows($conn) >= 0) {
		$_SESSION["message"] = "Subject modified.";
		redirect_to("manage_content.php");
	} else {
		$message = "Subject failed to modify.";
	}
}
}

?>
	
<div id="main">
	<div id="navigation">

	</div>
	<div id="page">
		<?php if (!empty($message)) {
			echo "<div class=\"message\">" . htmlentities($message) . "</div>";
		} ?>
		<?php //$errors = errors(); ?>
		<?php echo form_errors($errors); ?>

		<h2>Edit Subject: <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
		<form method="post" action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">
			<p>Subject name:
				<input type="text" name="menu_name" value="<?php echo htmlentities($current_subject['menu_name']); ?>" />
			</p>
			<p>Position:
				<select name="position">
			<?php $subject_set = find_all_subjects(); ?>
			<?php $subject_count = mysqli_num_rows($subject_set);?>
			<?php for ($count=1; $count <= $subject_count; $count++) { 
				echo "<option value=\"{$count}\"";
				if ($current_subject["position"] == $count) {
					echo " selected";
				}
				echo ">{$count}</option>";
			} ?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) {
					echo "checked";
				} ?>/> No
				&nbsp;
				<input type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) {
					echo "checked";
				} ?>/> Yes
			</p>
			<input type="submit" name="submit" value="Save Changes">
		</form><br>
		<a href="manage_content.php?>">Cancel</a>
		&nbsp;
		&nbsp;
		<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?')">Delete</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?> 