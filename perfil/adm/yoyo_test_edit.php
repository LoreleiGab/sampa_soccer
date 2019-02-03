<?php
include "includes/menu.php";
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];

if(isset($_POST['idTeste'])){
    $idTeste = $_POST['idTeste'];
}

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $distancia = $_POST['distancia'];
    $ml_kg_min = $_POST['ml_kg_min'];
    $evolucao = $_POST['evolucao'];
    $anotacoes = $_POST['anotacoes'];
    $resultado = ($distancia * 0.0084) + 36.4;
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO yoyo_tests (cliente_id, data, distancia, ml_kg_min, evolucao, anotacoes, resultado) VALUES ('$idCliente', '$data', '$distancia', '$ml_kg_min', '$evolucao', '$anotacoes', '$resultado')";
    if(mysqli_query($con,$sql)){
        $idTeste = recuperaUltimo("yoyo_tests");
        $mensagem = mensagem("success","Gravado com sucesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['edita'])){
    $idTeste = $_POST['idTeste'];
    $sql = "UPDATE yoyo_tests SET data = '$data', distancia = '$distancia', ml_kg_min = '$ml_kg_min', evolucao = '$evolucao',anotacoes = '$anotacoes', resultado = '$resultado' WHERE id = '$idTeste'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

$teste = recuperaDados("yoyo_tests","id",$idTeste);

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Cliente
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_testes.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Yoyo Test</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=yoyo_test_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control" value="<?= $teste['data'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="distancia">Distância (m)</labeL>
                                    <input type="number" id="distancia" name="distancia"  class="form-control" maxlength="3" value="<?= $teste['distancia'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="ml_kg_min">ml / kg / min</labeL>
                                    <input type="text" id="ml_kg_min" name="ml_kg_min"  class="form-control" maxlength="10" value="<?= $teste['ml_kg_min'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="evolucao">Evolução</labeL>
                                    <input type="text" id="evolucao" name="evolucao"  class="form-control" maxlength="10" value="<?= $teste['evolucao'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="anotacoes">Anotações</labeL>
                                    <input type="text" id="anotacoes" name="anotacoes"  class="form-control" maxlength="60" value="<?= $teste['anotacoes'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="anotacoes">Resultado</labeL><br/>
                                    <?= $teste['resultado'] ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value='<?= $idCliente ?>'>
                            <input type='hidden' name='idTeste' value='<?= $idTeste ?>'>
                            <button type="submit" name="edita" class="btn btn-info pull-right">Gravar</button>
                            <button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="#modal-danger">Excluir</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- Confirmação de Exclusão -->
        <div class="modal modal-danger fade" id="modal-danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmação de exclusão</h4>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir?<br/> Todos os dados relacionados serão excluídos e essa ação não poderá ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="?perfil=administrador&p=yoyo_test_list" role="form">
                            <input type='hidden' name='idTeste' value='<?= $teste['id'] ?>'>
                            <button type="submit" name="apagar" class="btn btn-outline">Sim</button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fim Confirmação de Exclusão -->
    </section>
    <!-- /.content -->
</div>