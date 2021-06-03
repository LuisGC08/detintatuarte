<!-- navBar -->
<nav class="full-box navbar-info">
	<a href="#" class="float-left show-nav-lateral">
		<i class="fas fa-exchange-alt"></i>
	</a>
	<?php
	if (isset($cliente)) {
	?>


		<a href="#" id="boton-carrito" data-toggle="modal" data-target="#carrito">

			<i class="fas fa-shopping-cart cantidad-productos">0</i>

		</a> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		<a href="#" id="cerrar-cliente" class="btn-exit-cliente">

			<i class="fas fa-user-check"> <?= $cliente->getNick() ?></i>

		</a> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	}
	?>
	<!-- <a href="#">
		<i class="fas fa-user-cog"> <?= $usuario->getNick() ?></i>
	</a> -->
	
	<a href="#" class="btn-exit-system" id="cerrar-sesion">
		
		<p>cerrar sesión</p>
	</a>
</nav>
<?php
if (isset($cliente)) {
	require_once "views/contenido/Carrito/modalCarrito.php";
}
?>