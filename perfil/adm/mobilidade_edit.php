<?php
include "includes/menu.php";
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $data = $_POST['data'];
    $quadril = $_POST['quadril'];
    $isquiotibiais = $_POST['isquiotibiais'];
    $quadriceps = $_POST['quadriceps'];
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO mobilidade (data, quadril, isquiotibiais, quadriceps, cliente_id) VALUES ('$data', '$quadril', '$isquiotibiais', '$quadriceps','$idCliente')";
    if(mysqli_query($con,$sql)){
        $idMobilidade = recuperaUltimo("mobilidade");
        $mensagem = mensagem("success","Gravado com suscesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])){
    $idMobilidade = $_POST['idMobilidade'];
    $sql = "UPDATE mobilidade SET data = '$data',  quadril = '$quadril', isquiotibiais = '$isquiotibiais', quadriceps = '$quadriceps' WHERE id = '$idMobilidade'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['carregar'])){
    $idMobilidade = $_POST['idMobilidade'];
}

$mobilidade = recuperaDados("mobilidade","id",$idMobilidade);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Cliente
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_mapeamento_corporal.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Mobilidade articular</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=mobilidade_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control" value="<?= $mobilidade['data'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="quadril">Quadril</labeL>
                                    <input type="text" id="quadril" name="quadril"  class="form-control" maxlength="255" value="<?= $mobilidade['quadril'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="isquiotibiais">Isquiotibiais</labeL>
                                    <input type="text" id="isquiotibiais" name="isquiotibiais"  class="form-control" maxlength="255" value="<?= $mobilidade['isquiotibiais'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="quadriceps">Quadríceps</labeL>
                                    <input type="text" id="quadriceps" name="quadriceps"  class="form-control" maxlength="255" value="<?= $mobilidade['quadriceps'] ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value='<?= $cliente['id'] ?>'>
                            <input type='hidden' name='idMobilidade' value='<?= $mobilidade['id'] ?>'>
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
                        <form method="POST" action="?perfil=administrador&p=mobilidade_list" role="form">
                            <input type='hidden' name='idMobilidade' value='<?= $mobilidade['id'] ?>'>
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