<?php
$con = bancoMysqli();

if(isset($_POST['resumo'])){
    $idCliente = $_POST['idCliente'];
    $_SESSION['idCliente'] = $idCliente;
}

if(isset($_SESSION['idCliente'])){
    $idCliente = $_SESSION['idCliente'];
}

include "includes/menu.php";

$cliente = recuperaDados("clientes","id",$idCliente);
$classificacao = recuperaDados("classificacao","id",$cliente['classificacao_id']);
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
                    <div class="box-header with-border">
                        <h3 class="box-title">Dados pessoais</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label>Classificação do cliente:</label> <?= $classificacao['nome_classificacao'] ?>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-9">
                                <label>Nome completo:</label> <?= $cliente['nome'] ?>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Idade:</label> <?= idade($cliente['data_nascimento']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <labeL>Data de Nascimento:</labeL> <?= dataBR($cliente['data_nascimento']) ?>
                            </div>
                            <div class="form-group col-md-2">
                                <labeL>CPF:</labeL> <?= $cliente['cpf'] ?>
                            </div>
                            <div class="form-group col-md-4">
                                <labeL>Telefone:</labeL> <?= $cliente['telefone01'] ?><?= $cliente['telefone02'] ? " / ".$cliente['telefone02'] : NULL ?>
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Email:</labeL> <?= $cliente['email'] ?>
                            </div>
                        </div>
                        <?php
                        if($cliente['classificacao_id'] == 3) {
                            $aluno = recuperaDados("alunos", "cliente_id", $idCliente);
                            ?>
                            <div class="form-group">
                                <labeL>Atividades de interesse:</labeL> <?= $aluno['atividade_interesse'] ?>
                            </div>
                            <div class="form-group">
                                <labeL>Restrição:</labeL> <?= $aluno['restricao'] ?>
                            </div>
                            <?php
                        }
                        else {
                            $atleta = recuperaDados("atletas", "cliente_id", $idCliente);
                            $pe = recuperaDados("pe_dominantes","id",$atleta['pe_dominante_id']);
                            $categoria = recuperaDados("categoria_atletas","id",$atleta['categoria_id']);
                            $posicao = recuperaDados("posicoes","id", $atleta['posicao_id']);
                            ?>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL>Apelido:</labeL> <?= $atleta['apelido'] ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Posição:</labeL> <?= $posicao['posicao'] ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Pé dominante:</labeL> <?= $pe['pe_dominante'] ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Clube:</labeL> <?= $atleta['clube'] ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Categoria:</labeL> <?= $categoria['categoria'] ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <labeL>Restrição:</labeL> <?= $atleta['restricao'] ?>
                            </div>
                            <div class="form-group">
                                <labeL>Últimos clubes:</labeL> <?= $atleta['ultimos_clubes'] ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label>Diagnóstico:</label> <?= $cliente['diagnostico'] ?>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <?php
                    if($cliente['classificacao_id'] == 1){
                        echo "<form method=\"POST\" action=\"?perfil=administrador&p=atleta_edit&classificacao_id=1\" role=\"form\">";
                    }
                    if($cliente['classificacao_id'] == 2){
                        echo "<form method=\"POST\" action=\"?perfil=administrador&p=atleta_edit&classificacao_id=2\" role=\"form\">";
                    }
                    if($cliente['classificacao_id'] == 3){
                        echo "<form method=\"POST\" action=\"?perfil=administrador&p=aluno_edit\" role=\"form\">";
                    }
                    ?>
                        <div class="box-footer">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="carregar" class="btn btn-info pull-right">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.box -->
        <?php
        // PLANO
        include "resumo_plano.php";
        // ESTATURA PREVISTA
        include "resumo_estatura.php";
        // PESO E ALTURA
        include "resumo_peso_altura.php";
        // PERIMETRIA
        include "resumo_perimetria.php";
        // DOBRAS
        include "resumo_dobras.php";
        // JACKSON POLLOCK
        include "resumo_jackson_pollock.php";
        // MAPEAMENTO CORPORAL - MÚSCULOS
        include "resumo_musculos.php";
        // MOBILIDADE ARTICULAR
        include "resumo_mobilidade.php";
        // CORE
        include "resumo_core.php";
        // TESTE BANCO DE WELLS
        include "resumo_wells.php";
        // TESTE SALTO HORIZONTAL
        include "resumo_salto_horizontal.php";
        ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(function () {
        "use strict";

        //PESO CHART
        var bar = new Morris.Bar({
            element: 'peso-chart',
            resize: true,
            data: [<?= $avaliacao_charts ?>],
            barColors: ['#3c8dbc'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Peso'],
            hideHover: 'auto'
        });

        //WELLS CHART
        var bar = new Morris.Bar({
            element: 'wells-chart',
            resize: true,
            data: [<?= $wells_charts ?>],
            barColors: ['#3c8dbc'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Medida'],
            hideHover: 'auto'
        });

        //HORIZONTAL CHART
        var bar = new Morris.Bar({
            element: 'horizontal-chart',
            resize: true,
            data: [<?= $horizontal_charts ?>],
            barColors: ['#3c8dbc'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Medida'],
            hideHover: 'auto'
        });
    });
</script>
