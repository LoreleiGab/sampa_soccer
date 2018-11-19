<?php
$con = bancoMysqli();

if(isset($_SESSION['idCliente'])){
    $idCliente = $_SESSION['idCliente'];
}
if(isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
}

if(isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $idCliente = $_POST['idCliente'];
    $estatura_pai = decimalMysql($_POST['estatura_pai']);
    $estatura_mae = decimalMysql($_POST['estatura_mae']);
    $estatura_prevista = ($estatura_pai + $estatura_mae)/2;
    $estimativa = ($estatura_pai + $estatura_mae)/2+6.5;
    $margem_erro01 = ($estatura_pai + $estatura_mae)/2+12.5;
    $margem_erro02 = ($estatura_pai + $estatura_mae)/2+0.5;
}

if(isset($_POST['cadastrar'])){
    $sql = "INSERT INTO estaturas (cliente_id, estatura_pai, estatura_mae, estatura_prevista, estimativa, margem_erro01, margem_erro02) VALUES ('$idCliente','$estatura_pai','$estatura_mae', '$estatura_prevista', '$estimativa', '$margem_erro01', '$margem_erro02')";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Cadastrado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['editar'])){
    $sql = "UPDATE estaturas SET cliente_id = '$idCliente', estatura_pai = '$estatura_pai', estatura_mae = '$estatura_mae', estatura_prevista = '$estatura_prevista', estimativa = '$estimativa', margem_erro01 = '$margem_erro01', margem_erro02 = '$margem_erro02' WHERE cliente_id = '$idCliente'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['carregar'])){
    $idCliente = $_POST['idCliente'];
}

include "includes/menu.php";

$estatura = recuperaDados("estaturas","cliente_id",$idCliente);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Estatura
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>

        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de estatura familiar</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=estatura_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="estatura_pai">Estatura do pai</label> <i>(Em cm)</i>
                                    <input type="text" id="estatura_pai" name="estatura_pai" class="form-control" value="<?= $estatura['estatura_pai'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="estatura_mae">Estatura da mãe</label> <i>(Em cm)</i>
                                    <input type="text" id="estatura_mae" name="estatura_mae" class="form-control" value="<?= $estatura['estatura_mae'] ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value="<?= $cliente['id'] ?>">
                            <button type="submit" name="editar" class="btn btn-info pull-right">Gravar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Estatura prevista</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <labeL>Estatura Prevista:</labeL>
                                <?= decimalBr($estatura['estatura_prevista'],1) ?> cm.
                                <br>
                                <labeL>Estimativa:</labeL>
                                <?= decimalBr($estatura['estimativa'],1) ?> cm.
                                <br>
                                <labeL>Margem de erro #1:</labeL>
                                <?= decimalBr($estatura['margem_erro01'],1) ?> cm.
                                <br>
                                <labeL>Margem de erro #2:</labeL>
                                <?= decimalBr($estatura['margem_erro02'],1) ?> cm.
                            </div>
                        </div>
                    </div>
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
    $('#estatura_pai').mask('000,0', {reverse: true});
    $('#estatura_mae').mask('000,0', {reverse: true});
</script>