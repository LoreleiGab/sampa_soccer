<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['idAvaliacao'])){
    $idAvaliacao = $_POST['idAvaliacao'];
    $avaliacao = recuperaDados("avaliacoes","id",$idAvaliacao);
    $idCliente = $avaliacao['cliente_id'];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Dobras
        <small><?= recuperaNomeCliente($idCliente) ?></small></h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de dobras</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrador&p=dobras3f_edit" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="tricipital">Tricipital</labeL>
                                    <input type="text" id="tricipital" name="tricipital" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="s_iliaca">S Ilíaca</labeL>
                                    <input type="text" id="s_iliaca" name="s_iliaca" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="coxa">Coxa</labeL>
                                    <input type="text" id="coxa" name="coxa" class="form-control">
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

<script>
    $('#tricipital').mask('000,0', {reverse: true});
    $('#s_iliaca').mask('000,0', {reverse: true});
    $('#coxa').mask('000,0', {reverse: true});
</script>