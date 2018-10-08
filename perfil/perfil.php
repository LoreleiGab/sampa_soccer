<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
					<h2>Módulos</h2>
					<p>Selecione o módulo que deseja utilizar.</p>
				</div>
			</div>
		</div>
		<div class="table-responsive list_info">
			<table class="table table-condensed">
				<thead>
					<tr class="list_menu">
						<td>Módulo</td>
						<td>Descrição</td>
						<td width="20%"></td>
					</tr>
				</thead>
				<tbody>
                    <?php listaModulosAlfa($_SESSION['perfil']); ?>	
				</tbody>
			</table>
		</div>
	</div>
</section>