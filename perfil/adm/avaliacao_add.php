<?php
include "includes/menu.php";

if(isset($_POST['avaliacao'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $sql = "INSERT INTO avaliacoes ('cliente_id','data','altura','peso') VALUES ('$idCliente','$data','$peso','$altura')";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success","Gravado com suscesso!");
        if($cliente['classificacao_id'] == 1){
            header('Location: ?perfil=administrador&p=sete_dobras');
        }
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['avaliacao'])){
    $idCliente = $_POST['idCliente'];
}

$cliente = recuperaDados("clientes","id",$idCliente);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Avaliação</h2>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro</h3>
                </div>
                <form method="POST" action="?perfil=administrador&p=avaliacao_edit" role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Nome:</label> <?= $cliente['nome'] ?>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <labeL for="data">Data</labeL>
                                <input type="date" id="data" name="data" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <labeL for="peso">Peso</labeL>
                                <input type="text" id="peso" name="peso" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <labeL for="altura">Altura</labeL>
                                <input type="text" id="altura" name="altura" class="form-control">
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-default">Cancelar</button>
                        <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
