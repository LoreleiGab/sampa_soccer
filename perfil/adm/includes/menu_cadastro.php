<?php
$cliente = recuperaDados("clientes","id",$_SESSION['idCliente']);
if($cliente['classificacao_id'] == 3) {
    $link_cadastro = "?perfil=administrador&p=aluno_edit&classificacao_id=3";
}
else{
    $link_cadastro = "?perfil=administrador&p=atleta_edit&classificacao_id=".$cliente['classificacao_id'];
}
$matricula = recuperaDados("planos","cliente_id",$_SESSION['idCliente']);
if($matricula == NULL){
    $link_plano = "?perfil=administrador&p=plano_add";
}
else{
    $link_plano = "?perfil=administrador&p=plano_edit";
}
?>
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="<?= $link_cadastro ?>">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-male"></i></span>
                <div class="info-box-content">
                    <h3>Dados pessoais</h3>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="<?= $link_plano ?>">
            <div class="info-box bg-lime">
                <span class="info-box-icon"><i class="fa fa-plus"></i></span>
                <div class="info-box-content">
                    <h3>Plano</h3>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- /.col -->
</div>