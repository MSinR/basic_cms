<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/dbconnect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>
	
<div id="main">
	<div id="navigation">
		<br>
		<a href="admin.php">&laquo; Back to menu.</a>
		<?php echo navigation($current_subject,$current_page); ?>
		<a href="new_subject.php">+ Add a new subject.</a>
	</div>
	<div id="page">
		<?php echo message(); ?>
		<h2>Manage Content</h2>
		<?php if ($current_subject) { ?>
		Menu name: <?php echo htmlentities($current_subject["menu_name"]); ?><br>
		Position: <?php echo $current_subject["position"]; ?><br>
		Visible: <?php echo $current_subject["visible"] == 0 ? 'no' : 'yes'; ?><br><br>
		<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Edit Subject</a>
		<hr />
		<h3>Pages in this subject:</h3>
		<ul>
			<?php $page_set = find_pages_for_subjects($current_subject["id"],false); ?>
			<?php while ($pages = mysqli_fetch_assoc($page_set)) { ?>
				<li><a href="manage_content.php?page=<?php echo $pages["id"];?>"><?php echo $pages["menu_name"];?></a></li>
			<?php } ?>
		</ul>
			<a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>">+ Add new page</a>
		<?php } elseif ($current_page) { ?>
		Menu name: <?php echo htmlentities($current_page["menu_name"]); ?><br>
		Position: <?php echo $current_page["position"]; ?><br>
		Visible: <?php echo $current_page["visible"] == 0 ? 'no' : 'yes'; ?><br>
		Content:<br><div class="view-content">
			<?php echo htmlentities($current_page["content"]); ?>
		</div><br>
		<a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Edit Page</a>
		<?php } else { ?>
		<?php echo "Please select a subject or a page"; ?>
		<?php } ?>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>