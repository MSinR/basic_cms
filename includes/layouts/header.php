<?php if (!isset($layout_context)) {
	$layout_context = "public";
}//$layout_context = "admin"; ?> 
<!DOCTYPE html>
<html>
<head>
	<title>Widget Corp <?php if ($layout_context == "admin") {
			echo "Admin";
		} ?></title>
	<link rel="stylesheet" media="all" type="text/css" href="stylesheets/public.css">
</head>
<body>
	<div id="header">
		<h1>Widget Corp <?php if ($layout_context == "admin") {
			echo "Admin";
		} ?>
			
		</h1>
	</div>