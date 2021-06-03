<?php
 if(!isset($_SESSION["usuario"])){
	 header("Location: index.php?controller=login&action=signIn");
 }
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
    <i class="fas fa-home"></i> &nbsp; HOME
    </h3>
    <p class="text-justify text-center">
        BIENVENIDO <?=$usuario->getNombre()?>
    </p>
</div>