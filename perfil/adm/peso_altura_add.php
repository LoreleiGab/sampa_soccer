<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['avaliacao'])){
    $idCliente = $_POST['idCliente'];
}

$cliente = recuperaDados("clientes","id",$idCliente);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Peso / altura
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
                    <form method="POST" action="?perfil=administrador&p=peso_altura_edit" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nome:</label> <?= $cliente['nome'] ?>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="peso">Peso</labeL>
                                    <input type="text" id="peso" name="peso"  class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="altura">Altura</labeL>
                                    <input type="text" id="altura" name="altura" class="form-control">
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

<script>
    $('#peso').mask('000,000', {reverse: true});
    $('#altura').mask('000,0', {reverse: true});
</script>