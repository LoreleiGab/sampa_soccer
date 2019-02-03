<?php
include "includes/menu.php";
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $peso = decimalMysql($_POST['peso']);
    $altura = decimalMysql($_POST['altura']);
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO imcs (cliente_id,data,peso,altura) VALUES ('$idCliente','$data','$peso','$altura')";
    if(mysqli_query($con,$sql)){
        $idAvaliacao = recuperaUltimo("imcs");
        $mensagem = mensagem("success","Gravado com sucesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])){
    $idAvaliacao = $_POST['idAvaliacao'];
    $sql = "UPDATE imcs SET data = '$data', peso = '$peso', altura = '$altura' WHERE id = '$idAvaliacao'";
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

$avaliacao = recuperaDados("imcs","id",$idAvaliacao);
$cliente = recuperaDados("clientes","id",$avaliacao['cliente_id']);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Peso / altura
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_antropometria.php';
        ?>

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
                    <form method="POST" action="?perfil=administrador&p=peso_altura_edit" role="form">
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
                            <button type="submit" name="edita" class="btn btn-info pull-right">Gravar</button><button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="#modal-danger">Excluir</button>
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
                        <form method="POST" action="?perfil=administrador&p=peso_altura_list" role="form">
                            <input type='hidden' name='idAvaliacao' value='<?= $avaliacao['id'] ?>'>
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

<script>
    $('#peso').mask('000,000', {reverse: true});
    $('#altura').mask('000,0', {reverse: true});
</script>