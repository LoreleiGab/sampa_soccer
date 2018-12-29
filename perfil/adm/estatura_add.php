<?php
if(isset($_SESSION['idCliente'])){
    $idCliente = $_SESSION['idCliente'];
}
if(isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
}
include "includes/menu.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Estatura
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_antropometria.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de estatura familiar</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=estatura_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="estatura_pai">Estatura do pai</label> <i>(Em cm)</i>
                                    <input type="text" id="estatura_pai" name="estatura_pai" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="estatura_mae">Estatura da mãe</label> <i>(Em cm)</i>
                                    <input type="text" id="estatura_mae" name="estatura_mae" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="cadastrar" class="btn btn-info pull-right">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script>
    $('#estatura_pai').mask('000,0', {reverse: true});
    $('#estatura_mae').mask('000,0', {reverse: true});
</script>