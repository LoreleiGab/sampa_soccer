<?php

$con = bancoMysqli();

if(isset($_SESSION['idEvento']))
{
	unset($_SESSION['idEvento']);	
}

$sql_avisos = "SELECT * FROM weblogs WHERE publicado = '1' ORDER BY id DESC LIMIT 0,5";
$query_avisos = mysqli_query($con,$sql_avisos);

?>
<section id="avisos" class="home-section bg-white">
	<div class="container">
        <?php include 'includes/menu_geral.php'; ?>
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
					<h2>Mural de Atualizações</h2>
					<br/>
		<?php  
			while($avisos = mysqli_fetch_array($query_avisos))
			{
		?>	
			<h5><?php echo $avisos['titulo'];  ?></h5>
			<p class="left"><?php echo exibirDataBr($avisos['data']); ?>
			<div class="left"><?php echo $avisos['mensagem']; ?></div>
			<br />
			<br />
		<?php
			}
		?>
				</div>
			</div>
		</div>  
	</div>
</section>


