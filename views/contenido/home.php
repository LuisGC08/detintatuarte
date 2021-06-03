<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="../dist/css/adminlte.min.css">

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<title>Document</title>

<div class="full-box tile-container">

	<a href="index.php?controller=clientes&action=listar" class="tile">

		<div class="tile-tittle">Clientes</div>
		<div class="tile-icon">
			<i class="fas fa-user-ninja"></i>
			<p><?= $clientes ?> Identificados</p>
		</div>

	</a>

	<a href="index.php?controller=articulos&action=listar" class="tile">

		<div class="tile-tittle">Artículos</div>
		<div class="tile-icon">
			<i class="fas fa-drumstick-bite"></i>
			<p><?= $articulos ?> Identificados</p>
		</div>

	</a>


	<a href="index.php?controller=pedidos&action=listar" class="tile">

		<div class="tile-tittle">Pedidos</div>
		<div class="tile-icon">
			<i class="fas fa-shopping-basket"></i>
			<p><?= $pedidos ?> Identificados</p>
		</div>
	</a>



	<a href="index.php?controller=albaranes&action=listar" class="tile">

		<div class="tile-tittle">Albaranes</div>
		<div class="tile-icon">
			<i class="fas fa-copy"></i>
			<p><?= $albaranes ?> Identificados</p>
		</div>

	</a>



	<a href="index.php?controller=facturas&action=listar" class="tile">
		<div class="tile-tittle">Facturas</div>
		<div class="tile-icon">
			<i class="fas fa-file-pdf"></i>
			<p><?= $facturas ?> Identificada</p>
		</div>
	</a>

</div>

<div class="info-box-content">

	<span class="info-box-text">©LUIS GARCÍA CLAVEL</span>

</div>