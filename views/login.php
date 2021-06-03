	<div class="login-container">
		<div class="login-content">
			<h1 class="text-center">De Tinta Tu Arte</h1>
			<p class="text-center">
				<i class="fas fa-skull"></i>

			</p>
			<p class="text-center">
				Acceder como administrador
			</p>

			<div class="" role="alert" id="mensaje">
				<p class="text-center"></p>
			</div>


			<form action="#" autocomplete="off">
				<div class="form-group">
					<label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>

					<input type="text" class="form-control" id="nick" name="nick" pattern="[a-zA-Z0-9]{1,35}" maxlength="35" value="" required="">
				</div>


				<div class="form-group">
					<label for="password" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>

					<input type="password" class="form-control" id="password" name="password" maxlength="200" value="" required="">
				</div>
				<button type="button" class="btn-login text-center" id="buttonLogin">Acceder</button>

			</form>

		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="views/ajax/loginAjax.js"></script>