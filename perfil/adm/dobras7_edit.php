<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $peitoral = isset($_POST['peitoral']) ? decimalMysql($_POST['peitoral']) : NULL;
    $s_escapular = isset($_POST['s_escapular']) ? decimalMysql($_POST['s_escapular']) : NULL;
    $tricipital =  isset($_POST['tricipital']) ? decimalMysql($_POST['tricipital']) : NULL;
    $a_media = isset($_POST['a_media']) ? decimalMysql($_POST['a_media']) : NULL;
    $s_iliaca = isset($_POST['s_iliaca']) ? decimalMysql($_POST['s_iliaca']) : NULL;
    $abdominal = isset($_POST['abdominal']) ? decimalMysql($_POST['abdominal']) : NULL;
    $coxa =  isset($_POST['coxa']) ? decimalMysql($_POST['coxa']) : NULL;
    $perna =  isset($_POST['perna']) ? decimalMysql($_POST['perna']) : NULL;
}

if(isset($_POST['cadastra'])) {
    $idAvaliacao = $_POST['idAvaliacao'];
    $sql = "INSERT INTO dobras (avaliacao_id, peitoral, s_escapular, tricipital, a_media, s_iliaca, abdominal, coxa, perna) VALUES ('$idAvaliacao', '$peitoral', '$s_escapular', '$tricipital', '$a_media', '$s_iliaca', '$abdominal', '$coxa', '$perna')";
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
    $sql = "UPDATE dobras SET peitoral = '$peitoral', s_escapular = '$s_escapular', tricipital = '$tricipital', a_media = '$a_media', s_iliaca = '$s_iliaca', abdominal = '$abdominal', coxa = '$coxa', perna = '$perna' WHERE id = '$idDobras'";
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

if(isset($_POST['idCliente'])){
    $idCliente = $_POST['idCliente'];
}

$dobras = recuperaDados("dobras","id",$idDobras);
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
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
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
                                    <labeL for="tricipital">Tricipital</labeL>
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
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
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

<script>
    $('#peitoral').mask('000,0', {reverse: true});
    $('#s_escapular').mask('000,0', {reverse: true});
    $('#tricipital').mask('000,0', {reverse: true});
    $('#a_media').mask('000,0', {reverse: true});
    $('#s_iliaca').mask('000,0', {reverse: true});
    $('#abdominal').mask('000,0', {reverse: true});
    $('#coxa').mask('000,0', {reverse: true});
</script>