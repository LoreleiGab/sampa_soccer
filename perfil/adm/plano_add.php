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
        <h2 class="page-header">Cliente
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_cadastro.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de plano</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=plano_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="data_inicio">Data início</label>
                                    <input type="date" id="data_inicio" name="data_inicio" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_vencimento">Vencimento</label>
                                    <input type="text" id="data_vencimento" name="data_vencimento" class="form-control" maxlength="100">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="plano">Plano</label>
                                    <input type="text" id="plano" name="plano" class="form-control" maxlength="120">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="valor">Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="valor_total">Valor total</label>
                                    <input type="text" id="valor_total" name="valor_total" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="forma_pagamento">Forma de Pagamento</label>
                                    <input type="text" id="forma_pagamento" name="forma_pagamento" class="form-control" maxlength="100">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="outros">Outros</label>
                                    <input type="text" id="outros" name="outros" class="form-control" maxlength="100">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
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
    $('#valor').mask('000.000.000.000.000,00', {reverse: true});
    $('#valor_total').mask('000.000.000.000.000,00', {reverse: true});
</script>