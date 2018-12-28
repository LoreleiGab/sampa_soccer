<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $tricipital =  decimalMysql($_POST['tricipital']) ?? NULL;
    $perna =  decimalMysql($_POST['perna']) ?? NULL;
}

if(isset($_POST['cadastra'])) {
    $idImc = $_POST['imc_id'];
    $sql = "INSERT INTO dobras (imc_id, tricipital, perna) VALUES ('$idImc', '$tricipital', '$perna')";
    if(mysqli_query($con,$sql)){
        $idDobras = recuperaUltimo("dobras");
        $mensagem = mensagem("success", "Cadastrado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['edita'])) {
    $idDobras = $_POST['idDobras'];
    $sql = "UPDATE dobras SET tricipital = '$tricipital', perna = '$perna' WHERE id = '$idDobras'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['carregar'])){
    $idDobras = $_POST['idDobras'];
}

if(isset($_POST['idCliente'])){
    $idCliente = $_POST['idCliente'];
}

$dobras = recuperaDados("dobras","id",$idDobras);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Dobras
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
                            <h3 class="box-title">Cadastro de dobras</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=dobras8_edit" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="imc_id">Data</labeL><br/>
                                    <?php
                                    $imc = recuperaDados("imcs","id",$dobras['imc_id']);
                                    echo $data = dataBR($imc['data']);
                                    ?>
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="tricipital">TR</labeL>
                                    <input type="text" id="tricipital" name="tricipital" class="form-control" value="<?= $dobras['tricipital'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <labeL for="perna">PE</labeL>
                                    <input type="text" id="perna" name="perna" class="form-control" value="<?= $dobras['perna'] ?>">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idDobras' value="<?= $dobras['id'] ?>">
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
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
                        <form method="POST" action="?perfil=administrador&p=dobras_list" role="form">
                            <input type='hidden' name='idDobras' value='<?= $dobras['id'] ?>'>
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
    $('#peitoral').mask('000,0', {reverse: true});
    $('#s_escapular').mask('000,0', {reverse: true});
    $('#tricipital').mask('000,0', {reverse: true});
    $('#a_media').mask('000,0', {reverse: true});
    $('#s_iliaca').mask('000,0', {reverse: true});
    $('#abdominal').mask('000,0', {reverse: true});
    $('#coxa').mask('000,0', {reverse: true});
    $('#perna').mask('000,0', {reverse: true});
</script>