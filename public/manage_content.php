<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>
	
<div id="main">
	<div id="navigation">
		<br>
		<a href="admin.php">Back to menu.</a>
		<?php echo navigation($current_subject,$current_page); ?>
		<a href="new_subject.php">+ Add a new subject.</a>
	</div>
	<div id="page">
		<?php echo message(); ?>
		<h2>Manage Content</h2>
		<?php if ($current_subject) { ?>
		Menu name: <?php echo $current_subject["menu_name"]; ?><br>
		<?php } elseif ($current_page) { ?>
		Menu name: <?php echo $current_page["menu_name"]; ?><br>
		<?php } else { ?>
		<?php echo "Please select a subject or a page"; ?>
		<?php } ?>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>