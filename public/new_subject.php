<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>
	
<div id="main">
	<div id="navigation">
		<br><a href="admin.php">&laquo; Bact to menu</a>
		<?php echo navigation($current_subject,$current_page); ?>
		<br>

	</div>
	<div id="page">
		<?php echo message(); ?>
		<?php $errors = errors(); ?>
		<?php echo form_errors($errors); ?>

		<h2>Create Subject</h2>
		<form method="post" action="create_subject.php">
			<p>Subject name:
				<input type="text" name="menu_name" value="" />
			</p>
			<p>Position:
				<select name="position">
			<?php $subject_set = find_all_subjects(); ?>
			<?php $subject_count = mysqli_num_rows($subject_set);?>
			<?php for ($count=1; $count <= ($subject_count + 1); $count++) { 
				echo "<option value=\"{$count}\">{$count}</option>";
			} ?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" /> No
				&nbsp;
				<input type="radio" name="visible" value="1" /> Yes
			</p>
			<input type="submit" name="submit" value="Create Subject">
		</form><br>
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>