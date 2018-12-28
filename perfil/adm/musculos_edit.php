<?php
include "includes/menu.php";
$con = bancoMysqli();

$musculo_tipo_id = $_GET['musculo_tipo_id'];
$tipo = recuperaDados("musculo_tipos","id",$musculo_tipo_id);

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO musculos (musculo_tipo_id, data, descricao, cliente_id) VALUES ('$musculo_tipo_id','$data','$descricao','$idCliente')";
    if(mysqli_query($con,$sql)){
        $idMusculo = recuperaUltimo("musculos");
        $mensagem = mensagem("success","Gravado com suscesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])){
    $idMusculo = $_POST['idMusculo'];
    $sql = "UPDATE musculos SET data = '$data', descricao = '$descricao' WHERE id = '$idMusculo'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

$musculo = recuperaDados("musculos","id",$idMusculo);
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
                    <form method="POST" action="?perfil=administrador&p=musculos_edit&musculo_tipo_id=<?= $musculo_tipo_id ?>" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= $tipo['musculo_tipo'] ?></h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
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
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control" value="<?= $musculo['data'] ?>">
                                </div>
                                <div class="form-group col-md-10">
                                    <labeL for="descricao">Descrição</labeL>
                                    <input type="text" id="descricao" name="descricao"  class="form-control" maxlength="255" value="<?= $musculo['descricao'] ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value='<?= $cliente['id'] ?>'>
                            <input type='hidden' name='idMusculo' value='<?= $musculo['id'] ?>'>
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