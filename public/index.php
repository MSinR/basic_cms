<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "public"; ?> 
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>
	
<div id="main">
	<div id="navigation">
		<br>
		<?php echo public_navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">
		<h2>Manage Content</h2>
		<?php if ($current_subject) { ?>
		Menu name: <?php echo htmlentities($current_subject["menu_name"]); ?><br>

		<?php } elseif ($current_page) { ?>
			<?php echo htmlentities($current_page["content"]); ?>

		<?php } else { ?>
		<?php echo "Please select a subject or a page"; ?>
		<?php } ?>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>