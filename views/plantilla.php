<?php
	if(!isset($usuario)){
		header("location: index.php?controller=login&action=signIn");
	}
?>
<!-- Main container -->
<main class="full-box main-container">
	<!-- Nav lateral -->
    <?php require_once "contenido/nav_lateral.php" ?>
	<!-- Page content -->
	<section class="full-box page-content">
		<!-- Nav Bar-->
        <?php require_once "contenido/navBar.php" ?>
		<!-- Page header -->
        <?php require_once "contenido/page_header.php" ?>
		
		<!-- Content -->
		</section>
</main>