<!-- Nav lateral -->
<section class="full-box nav-lateral">
	<div class="full-box nav-lateral-bg show-nav-lateral"></div>
	<div class="full-box nav-lateral-content">
		<figure class="full-box nav-lateral-avatar">
			<i class="far fa-times-circle show-nav-lateral"></i>
			<img src="./assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
			<figcaption class="roboto-medium text-center">
				<?= $usuario->getNombre() ?> <br><small class="roboto-condensed-light"><?= $usuario->getNick() ?></small>
			</figcaption>
		</figure>
		<div class="full-box nav-lateral-bar"></div>
		<nav class="full-box nav-lateral-menu">
			<ul>
				<li>
					<a href="index.php?controller=login&action=home"><i class="fas fa-home"></i> &nbsp; Home</a>
				</li>

				<li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-users fa-fw"></i> &nbsp; Clientes <i class="fas fa-chevron-down"></i></a>
					<ul>

						<li>
							<a href="index.php?controller=clientes&action=listar"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes</a>
						</li>
						<li>
							<a href="index.php?controller=clientes&action=filtrar"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-drumstick-bite"></i> &nbsp; Artículos <i class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="index.php?controller=articulos&action=alta"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar articulo</a>
						</li>
						<li>
							<a href="index.php?controller=articulos&action=listar"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de articulos</a>
						</li>
						<li>
							<a href="index.php?controller=articulos&action=filtrar"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar articulo</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-shopping-basket"></i> &nbsp; Pedidos <i class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="index.php?controller=carrito&action=alta"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo pedido</a>
						</li>
						<li>
							<a href="index.php?controller=pedidos&action=listar"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de pedidos</a>
						</li>
						<li>
							<a href="index.php?controller=pedidos&action=filtrar"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar pedido</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-copy"></i> &nbsp; Albaranes <i class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="index.php?controller=albaranes&action=alta"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo albaran</a>
						</li>
						<li>
							<a href="index.php?controller=albaranes&action=listar"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de albaranes</a>
						</li>
						<li>
							<a href="index.php?controller=albaranes&action=filtrar"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar albaran</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-file-pdf"></i> &nbsp; Facturas <i class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="index.php?controller=facturas&action=alta"><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva factura</a>
						</li>
						<li>
							<a href="index.php?controller=facturas&action=listar"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de facturas</a>
						</li>
						<li>
							<a href="index.php?controller=facturas&action=filtrar"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar factura</a>
						</li>
					</ul>
				</li>


			</ul>
		</nav>
	</div>
</section>