	<!-- Modal -->
	<div class="modal fade bd-example-modal-lg" id="carrito" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Carrito</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body lista-compra">
					<table class="table">
						<thead>
							<tr>
								<th class="text-dark">Imagen</th>
								<th class="text-dark">Nombre</th>
								<th class="text-dark">Cantidad</th>
								<th class="text-dark">Precio</th>
								<th class="text-dark"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="total mx-auto">
						<p>Total: 0.00</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-raised btn-danger" id="vaciar-carrito">Vaciar compra</button>
					&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-raised btn-info" id="procesar-pedido">Procesar pedido</button>
				</div>
			</div>
		</div>
	</div>