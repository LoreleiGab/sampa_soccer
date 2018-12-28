<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['musculos'])){
    $idCliente = $_POST['idCliente'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Cliente
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_mapeamento_corporal.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Mobilidade articular</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=mobilidade_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="quadril">Quadril</labeL>
                                    <input type="text" id="quadril" name="quadril"  class="form-control" maxlength="255">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="isquiotibiais">Isquiotibiais</labeL>
                                    <input type="text" id="isquiotibiais" name="isquiotibiais"  class="form-control" maxlength="255">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="quadriceps">Quadríceps</labeL>
                                    <input type="text" id="quadriceps" name="quadriceps"  class="form-control" maxlength="255">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value='<?= $cliente['id'] ?>'>
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