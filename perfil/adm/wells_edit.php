<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $idAvaliacao = $_POST['idAvaliacao'];
    $idCliente = $_POST['idCliente'];
    $medida = $_POST['medida'];
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO wells (avaliacao_id, medida) VALUES ('$idAvaliacao','$medida')";
    if(mysqli_query($con,$sql)){
        $idWells = recuperaUltimo("wells");
        $mensagem = mensagem("success", "Cadastrado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])){
    $sql = "UPDATE wells SET medida = '$medida' WHERE avaliacao_id = '$idAvaliacao'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['carregar'])){
    $idCliente = $_POST['idCliente'];
    $idAvaliacao = $_POST['idAvaliacao'];
}

$cliente = recuperaDados("clientes","id",$idCliente);
$wells = recuperaDados("wells","avaliacao_id",$idAvaliacao);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Wells</h2>

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
                    <form method="POST" action="?perfil=administrador&p=wells_edit" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nome:</label> <?= $cliente['nome'] ?>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-offset-4 col-md-3">
                                    <labeL for="medida">Medida</labeL>
                                    <input type="text" id="medida" name="medida" class="form-control" value="<?= $wells['medida'] ?>">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idAvaliacao' value='<?= $idAvaliacao ?>'>
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