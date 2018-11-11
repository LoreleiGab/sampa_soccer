<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $idCliente = $_POST['idCliente'];
    $torax = decimalMysql($_POST['torax']);
    $cintura = decimalMysql($_POST['cintura']);
    $abdome = decimalMysql($_POST['abdome']);
    $quadril = decimalMysql($_POST['quadril']);
    $coxa_direita = decimalMysql($_POST['coxa_direita']);
    $coxa_esquerda = decimalMysql($_POST['coxa_esquerda']);
    $perna_direita = decimalMysql($_POST['perna_direita']);
    $perna_esquerda = decimalMysql($_POST['perna_esquerda']);
    $biceps_direito = decimalMysql($_POST['biceps_direito']);
    $biceps_esquerdo = decimalMysql($_POST['biceps_esquerdo']);
    $punho = decimalMysql($_POST['punho']);
}

if(isset($_POST['cadastra'])){
    $idAvaliacao = $_POST['idAvaliacao'];
    $sql = "INSERT INTO perimetrias (avaliacao_id, torax, cintura, abdome, quadril, coxa_direita, coxa_esquerda, perna_direita, perna_esquerda, biceps_direito, biceps_esquerdo, punho) VALUES ('$idAvaliacao', '$torax', '$cintura', '$abdome', '$quadril', '$coxa_direita', '$coxa_esquerda', '$perna_direita', '$perna_esquerda', '$biceps_direito', '$biceps_esquerdo', '$punho')";
    if(mysqli_query($con,$sql)){
        $idPerimetria = recuperaUltimo("perimetrias");
        $mensagem = mensagem("success", "Cadastrado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['edita'])){
    $idPerimetria = $_POST['idPerimetria'];
    $sql = "UPDATE perimetrias SET torax = '$torax', cintura = '$cintura', abdome = '$abdome', quadril = '$quadril', coxa_direita = '$coxa_direita', coxa_esquerda = '$coxa_esquerda', perna_direita = '$perna_direita', perna_esquerda = '$perna_esquerda', biceps_direito = '$biceps_direito', biceps_esquerdo = '$biceps_esquerdo', punho = '$punho' WHERE id = '$idPerimetria'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['carregar'])){
    $idPerimetria = $_POST['idPerimetria'];
}

if(isset($_POST['idCliente'])){
    $idCliente = $_POST['idCliente'];
}
$cliente = recuperaDados("clientes","id",$idCliente);
$perimetria = recuperaDados("perimetrias","id",$idPerimetria);
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
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de perimetria</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
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
                                    <input type="text" id="torax" name="torax" class="form-control" value="<?= $perimetria['torax'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="cintura">Cintura</labeL>
                                    <input type="text" id="cintura" name="cintura" class="form-control" value="<?= $perimetria['cintura'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="abdome">Abdome</labeL>
                                    <input type="text" id="abdome" name="abdome" class="form-control" value="<?= $perimetria['abdome'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="quadril">Quadril</labeL>
                                    <input type="text" id="quadril" name="quadril" class="form-control" value="<?= $perimetria['quadril'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="coxa_direita">Coxa D.</labeL>
                                    <input type="text" id="coxa_direita" name="coxa_direita" class="form-control" value="<?= $perimetria['coxa_direita'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="coxa_esquerda">Coxa E.</labeL>
                                    <input type="text" id="coxa_esquerda" name="coxa_esquerda" class="form-control" value="<?= $perimetria['coxa_esquerda'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="perna_direita">Perna D.</labeL>
                                    <input type="text" id="perna_direita" name="perna_direita" class="form-control" value="<?= $perimetria['perna_direita'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="perna_esquerda">Perna E.</labeL>
                                    <input type="text" id="perna_esquerda" name="perna_esquerda" class="form-control" value="<?= $perimetria['perna_esquerda'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="biceps_direito">Bíceps D.</labeL>
                                    <input type="text" id="biceps_direito" name="biceps_direito" class="form-control" value="<?= $perimetria['biceps_direito'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="biceps_esquerdo">Bíceps E.</labeL>
                                    <input type="text" id="biceps_esquerdo" name="biceps_esquerdo" class="form-control" value="<?= $perimetria['biceps_esquerdo'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="punho">Punho</labeL>
                                    <input type="text" id="punho" name="punho" class="form-control" value="<?= $perimetria['punho'] ?>">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idPerimetria' value='<?= $perimetria['id'] ?>'>
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