<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $peso = decimalMysql($_POST['peso']);
    $altura = decimalMysql($_POST['altura']);
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO avaliacoes (cliente_id,data,peso,altura) VALUES ('$idCliente','$data','$peso','$altura')";
    if(mysqli_query($con,$sql)){
        $idAvaliacao = recuperaUltimo("avaliacoes");
        $mensagem = mensagem("success","Gravado com suscesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])){
    $idAvaliacao = $_POST['idAvaliacao'];
    $sql = "UPDATE avaliacoes SET data = '$data', peso = '$peso', altura = '$altura' WHERE id = '$idAvaliacao'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['carregar'])){
    $idAvaliacao = $_POST['idAvaliacao'];
}

$avaliacao = recuperaDados("avaliacoes","id",$idAvaliacao);
$cliente = recuperaDados("clientes","id",$avaliacao['cliente_id']);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Avaliação</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro</h3>
                            <input type='hidden' name='idCliente' value="<?= $cliente['id'] ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=avaliacao_edit" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nome:</label> <?= $cliente['nome'] ?>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control" value="<?= $avaliacao['data'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="peso">Peso</labeL>
                                    <input type="text" id="peso" name="peso" class="form-control" value="<?= $avaliacao['peso'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="altura">Altura</labeL>
                                    <input type="text" id="altura" name="altura" class="form-control" value="<?= $avaliacao['altura'] ?>">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value='<?= $cliente['id'] ?>'>
                            <input type='hidden' name='idAvaliacao' value='<?= $avaliacao['id'] ?>'>
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
    $('#peso').mask('000,000', {reverse: true});
    $('#altura').mask('000,00', {reverse: true});
</script>