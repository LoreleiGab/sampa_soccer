<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $idCliente = $_POST['idCliente'];
    $estatura_pai = $_POST['estatura_pai'];
    $estatura_mae = $_POST['estatura_mae'];
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
        $mensagem = mensagem("success", "Cadastrado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['carregar'])){
    $idCliente = $_POST['idCliente'];
}

$cliente = recuperaDados("clientes","id",$idCliente);
$estatura = recuperaDados("estaturas","cliente_id",$idCliente);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cliente</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastro de estatura</h3>
                        <small><strong>Cliente:</strong> <?= $cliente['nome'] ?></small>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=estatura_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="estatura_pai">Estatura do pai</label>
                                    <input type="text" id="estatura_pai" name="estatura_pai" class="form-control" value="<?= $estatura['estatura_pai'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="estatura_mae">Estatura da mãe</label>
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>