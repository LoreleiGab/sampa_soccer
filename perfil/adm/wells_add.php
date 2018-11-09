<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['carregar'])){
    $idCliente = $_POST['idCliente'];
    $idAvaliacao = $_POST['idAvaliacao'];
}

$cliente = recuperaDados("clientes","id",$idCliente);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Wells</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">

                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=wells_edit" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nome:</label> <?= $cliente['nome'] ?>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-offset-4 col-md-3">
                                    <labeL for="medida">Medida</labeL>
                                    <input type="text" id="medida" name="medida" class="form-control">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idAvaliacao' value='<?= $idAvaliacao ?>'>
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