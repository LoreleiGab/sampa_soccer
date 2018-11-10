<?php
include "includes/menu.php";
$con = bancoMysqli();

$idCliente = $_POST['idCliente'];

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $data_inicio = $_POST['data_inicio'];
    $data_vencimento = $_POST['data_vencimento'];
    $plano = addslashes($_POST['plano']);
    $valor = dinheiroDeBr($_POST['valor']);
    $forma_pagamento = addslashes($_POST['forma_pagamento']);
    $outros = addslashes($_POST['outros']);
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO matricula (cliente_id, data_inicio, data_vencimento, plano, valor, forma_pagamento, outros) 
            VALUES ('$idCliente', '$data_inicio', '$data_vencimento', '$plano', '$valor','$forma_pagamento','$outros')";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success","Gravado com suscesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['edita'])){
    $sql = "UPDATE matricula SET data_inicio = '$data_inicio', data_vencimento = '$data_vencimento', plano = '$plano', valor = '$valor', forma_pagamento = '$forma_pagamento', outros = '$outros' WHERE cliente_id = '$idCliente'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

$plano = recuperaDados("matricula","cliente_id",$idCliente);
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
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de plano</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=matricula_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="data_inicio">Data início</label>
                                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= $plano['data_inicio'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_vencimento">Data vencimento</label>
                                    <input type="date" id="data_vencimento" name="data_vencimento" class="form-control" value="<?= $plano['data_vencimento'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="plano">Plano</label>
                                    <input type="text" id="plano" name="plano" class="form-control" maxlength="120" value="<?= $plano['plano'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="valor">Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control" value="<?= $plano['valor'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="forma_pagamento">Forma de Pagamento</label>
                                    <input type="text" id="forma_pagamento" name="forma_pagamento" class="form-control" maxlength="100" value="<?= $plano['forma_pagamento'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="outros">Outros</label>
                                    <input type="text" id="outros" name="outros" class="form-control" maxlength="100" value="<?= $plano['outros'] ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
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

<script>
    $('#valor').mask('000.000.000.000.000,00', {reverse: true});
</script>