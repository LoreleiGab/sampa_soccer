<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $peitoral = $_POST['peitoral'] ?? NULL;
    $s_escapular = $_POST['s_escapular'] ?? NULL;
    $tricipital = $_POST['tricipital'] ?? NULL;
    $a_media = $_POST['a_media'] ?? NULL;
    $s_iliaca = $_POST['s_iliaca'] ?? NULL;
    $abdominal = $_POST['abdominal'] ?? NULL;
    $coxa = $_POST['coxa'] ?? NULL;
}

if(isset($_POST['cadastra'])) {
    $idAvaliacao = $_POST['idAvaliacao'];
    $sql = "INSERT INTO dobras (avaliacao_id, peitoral, s_escapular, tricipital, a_media, s_iliaca, abdominal, coxa) VALUES ('$idAvaliacao', '$peitoral', '$s_escapular', '$tricipital', '$a_media', '$s_iliaca', '$abdominal', '$coxa')";
    if(mysqli_query($con,$sql)){
        $idDobras = recuperaUltimo("dobras");
        $mensagem = mensagem("success", "Cadastrado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])) {
    $idDobras = $_POST['idDobras'];
    $sql = "UPDATE dobras SET peitoral = '$peitoral', s_escapular = '$s_escapular', tricipital = '$tricipital', a_media = '$a_media', s_iliaca = '$s_iliaca', abdominal = '$abdominal', coxa = '$coxa' WHERE id = '$idDobras'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['idAvaliacao'])){
    $idAvaliacao = $_POST['idAvaliacao'];
    $avaliacao = recuperaDados("avaliacoes","id",$idAvaliacao);
    $idCliente = $avaliacao['cliente_id'];
}

if(isset($_POST['carregar'])){
    $idDobras = $_POST['idDobras'];
}

$dobras = recuperaDados("dobras","id",$idDobras);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Dobras</h2>

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
                                <div class="form-group col-md-1">
                                    <labeL for="peitoral">Peitoral</labeL>
                                    <input type="text" id="peitoral" name="peitoral" class="form-control" value="<?= $dobras['peitoral'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="s_escapular">Escapular</labeL>
                                    <input type="text" id="s_escapular" name="s_escapular" class="form-control" value="<?= $dobras['s_escapular'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="tricipital">Trcipital</labeL>
                                    <input type="text" id="tricipital" name="tricipital" class="form-control" value="<?= $dobras['tricipital'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="a_media">A Media</labeL>
                                    <input type="text" id="a_media" name="a_media" class="form-control" value="<?= $dobras['a_media'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="s_iliaca">S Ilíaca</labeL>
                                    <input type="text" id="s_iliaca" name="s_iliaca" class="form-control" value="<?= $dobras['s_iliaca'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="abdominal">Abdominal</labeL>
                                    <input type="text" id="abdominal" name="abdominal" class="form-control" value="<?= $dobras['abdominal'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="coxa">Coxa</labeL>
                                    <input type="text" id="coxa" name="coxa" class="form-control" value="<?= $dobras['coxa'] ?>">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idDobras' value="<?= $dobras['id'] ?>">
                            <button type="submit" name="edita" class="btn btn-info pull-right">Gravar</button>
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