<?php
include "includes/menu.php";
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];

$teste_tipo_id = $_GET['teste_tipo_id'];
$tipo = recuperaDados("teste_tipos","id",$teste_tipo_id);

if(isset($_POST['carregar'])){
    $idTeste = $_POST['idTeste'];
}

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $medida = $_POST['medida'];
    $observacao = $_POST['observacao'];
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO testes (teste_tipo_id, data, medida, observacao, cliente_id) VALUES ('$teste_tipo_id','$data','$medida', '$observacao', '$idCliente')";
    if(mysqli_query($con,$sql)){
        $idTeste = recuperaUltimo("testes");
        $mensagem = mensagem("success","Gravado com suscesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])){
    $idTeste = $_POST['idTeste'];
    $sql = "UPDATE testes SET data = '$data', medida = '$medida', observacao = '$observacao' WHERE id = '$idTeste'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

$teste = recuperaDados("testes","id",$idTeste);
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
                            <h3 class="box-title"><?= $tipo['teste_tipo'] ?></h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=testes_edit&teste_tipo_id=<?= $teste_tipo_id ?>" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control" value="<?= $teste['data'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="medida">Descrição</labeL>
                                    <input type="number" id="medida" name="medida"  class="form-control" maxlength="3" value="<?= $teste['medida'] ?>">
                                </div>
                                <div class="form-group col-md-8">
                                    <labeL for="observacao">Observação</labeL>
                                    <input type="text" id="observacao" name="observacao"  class="form-control" maxlength="100" value="<?= $teste['observacao'] ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value='<?= $cliente['id'] ?>'>
                            <input type='hidden' name='idTeste' value='<?= $teste['id'] ?>'>
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
                        <form method="POST" action="?perfil=administrador&p=testes_list&teste_tipo_id=<?= $teste_tipo_id ?>" role="form">
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