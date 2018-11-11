<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['idAvaliacao'])){
    $idAvaliacao = $_POST['idAvaliacao'];
    $idCliente = $_POST['idCliente'];
}
$cliente = recuperaDados("clientes","id",$idCliente);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Perimetria
        <small><?= $cliente['nome'] ?></small></h2>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastro</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=perimetria_edit" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="form-group col-md-1">
                                    <labeL for="torax">Torax</labeL>
                                    <input type="text" id="torax" name="torax" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="cintura">Cintura</labeL>
                                    <input type="text" id="cintura" name="cintura" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="abdome">Abdome</labeL>
                                    <input type="text" id="abdome" name="abdome" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="quadril">Quadril</labeL>
                                    <input type="text" id="quadril" name="quadril" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="coxa_direita">Coxa D.</labeL>
                                    <input type="text" id="coxa_direita" name="coxa_direita" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="coxa_esquerda">Coxa E.</labeL>
                                    <input type="text" id="coxa_esquerda" name="coxa_esquerda" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="perna_direita">Perna D.</labeL>
                                    <input type="text" id="perna_direita" name="perna_direita" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="perna_esquerda">Perna E.</labeL>
                                    <input type="text" id="perna_esquerda" name="perna_esquerda" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="biceps_direito">Bíceps D.</labeL>
                                    <input type="text" id="biceps_direito" name="biceps_direito" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="biceps_esquerdo">Bíceps E.</labeL>
                                    <input type="text" id="biceps_esquerdo" name="biceps_esquerdo" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="punho">Punho</labeL>
                                    <input type="text" id="punho" name="punho" class="form-control">
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
    $('#torax').mask('000,0', {reverse: true});
    $('#cintura').mask('000,0', {reverse: true});
    $('#abdome').mask('000,0', {reverse: true});
    $('#quadril').mask('000,0', {reverse: true});
    $('#coxa_direita').mask('000,0', {reverse: true});
    $('#coxa_esquerda').mask('000,0', {reverse: true});
    $('#perna_direita').mask('000,0', {reverse: true});
    $('#perna_esquerda').mask('000,0', {reverse: true});
    $('#biceps_direito').mask('000,0', {reverse: true});
    $('#biceps_esquerdo').mask('000,0', {reverse: true});
    $('#punho').mask('000,0', {reverse: true});
</script>