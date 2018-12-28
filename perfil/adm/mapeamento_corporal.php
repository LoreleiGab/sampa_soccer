<?php
include "includes/menu.php";

$idCliente = $_SESSION['idCliente'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Mapeamento Corporal
        <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_mapeamento_corporal.php';
        ?>
    </section>
    <!-- /.content -->
</div>