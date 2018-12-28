<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['testes'])){
    $idCliente = $_POST['idCliente'];
}

$teste_tipo_id = $_GET['teste_tipo_id'];
$tipo = recuperaDados("teste_tipos","id",$teste_tipo_id);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Cliente
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_testes.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= $tipo['teste_tipo'] ?></h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=testes_edit&teste_tipo_id=<?= $teste_tipo_id ?>" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="medida">Medida</labeL>
                                    <input type="number" id="medida" name="medida"  class="form-control" maxlength="3">
                                </div>
                                <div class="form-group col-md-8">
                                    <labeL for="observacao">Observação</labeL>
                                    <input type="text" id="observacao" name="observacao"  class="form-control" maxlength="100">
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