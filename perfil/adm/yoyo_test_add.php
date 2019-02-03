<?php
include "includes/menu.php";
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];

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
                            <h3 class="box-title">Yoyo Test</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=yoyo_test_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="distancia">Distância (m)</labeL>
                                    <input type="number" id="distancia" name="distancia"  class="form-control" maxlength="3">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="ml_kg_min">ml / kg / min</labeL>
                                    <input type="text" id="ml_kg_min" name="ml_kg_min"  class="form-control" maxlength="10">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="evolucao">Evolução</labeL>
                                    <input type="text" id="evolucao" name="evolucao"  class="form-control" maxlength="10">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="anotacoes">Anotações</labeL>
                                    <input type="text" id="anotacoes" name="anotacoes"  class="form-control" maxlength="60">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value='<?= $idCliente ?>'>
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