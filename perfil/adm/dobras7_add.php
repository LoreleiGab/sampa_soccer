<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['idCliente'])){
    $idCliente = $_POST['idCliente'];
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
                    <form method="POST" action="?perfil=administrador&p=dobras7_edit" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="imc_id">Data</labeL>
                                    <select id="imc_id" name="imc_id" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <?php geraOpcaoData("dobras",$idCliente,"") ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="peitoral">Peitoral</labeL>
                                    <input type="text" id="peitoral" name="peitoral" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="s_escapular">Escapular</labeL>
                                    <input type="text" id="s_escapular" name="s_escapular" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="tricipital">Tricipital</labeL>
                                    <input type="text" id="tricipital" name="tricipital" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="a_media">A Media</labeL>
                                    <input type="text" id="a_media" name="a_media" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="s_iliaca">S Ilíaca</labeL>
                                    <input type="text" id="s_iliaca" name="s_iliaca" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="abdominal">Abdominal</labeL>
                                    <input type="text" id="abdominal" name="abdominal" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="coxa">Coxa</labeL>
                                    <input type="text" id="coxa" name="coxa" class="form-control">
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
    $('#peitoral').mask('000,0', {reverse: true});
    $('#s_escapular').mask('000,0', {reverse: true});
    $('#tricipital').mask('000,0', {reverse: true});
    $('#a_media').mask('000,0', {reverse: true});
    $('#s_iliaca').mask('000,0', {reverse: true});
    $('#abdominal').mask('000,0', {reverse: true});
    $('#coxa').mask('000,0', {reverse: true});
</script>