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
                        if($cliente['classificacao_id'] == 1) {
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
                        if($cliente['classificacao_id'] == 2) {
                            $base = recuperaDados("bases", "cliente_id", $idCliente);
                            $pe = recuperaDados("pe_dominantes","id",$base['pe_dominante_id']);
                            $posicao = recuperaDados("posicoes","id", $base['posicao_id']);
                            ?>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL>Apelido:</labeL> <?= $base['apelido'] ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Posição:</labeL> <?= $posicao['posicao'] ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Pé dominante:</labeL> <?= $pe['pe_dominante'] ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Restrição:</labeL> <?= $base['restricao'] ?>
                                </div>
                            </div>
                            <?php
                        }
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
                        ?>

                        <div class="form-group">
                            <label>Diagnóstico:</label> <?= $cliente['diagnostico'] ?>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <?php
                    if($cliente['classificacao_id'] == 1){
                        echo "<form method=\"POST\" action=\"?perfil=administrador&p=atleta_edit\" role=\"form\">";
                    }
                    if($cliente['classificacao_id'] == 2){
                        echo "<form method=\"POST\" action=\"?perfil=administrador&p=base_edit\" role=\"form\">";
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
        <!-- PLANO - Início -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Plano</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <?php
                    $sql_matricula = "SELECT * FROM planos WHERE cliente_id = '$idCliente'";
                    $query_matricula = mysqli_query($con,$sql_matricula);
                    $matricula = mysqli_fetch_array($query_matricula);
                    if($matricula != NULL) {
                        ?>
                        <!-- form start -->
                        <form method="POST" action="?perfil=administrador&p=plano_edit" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <labeL>Data início:</labeL> <?= dataBR($matricula['data_inicio']) ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <labeL>Data vencimento:</labeL> <?= $matricula['data_vencimento'] ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <labeL>Plano:</labeL> <?= $matricula['plano'] ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Valor:</labeL> R$ <?= decimalBr($matricula['valor'],2) ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Valor total:</labeL> R$ <?= decimalBr($matricula['valor_total'],2) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <labeL>Forma de pagamento:</labeL> <?= $matricula['forma_pagamento'] ?>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <labeL>Outros:</labeL> <?= $matricula['outros'] ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                                <button type="submit" name="carregar" class="btn btn-info pull-right">Editar</button>
                            </div>
                        </form>
                        <!-- /.box -->
                        <?php
                    }
                    else{
                        ?>
                        <!-- form start -->
                        <form method="POST" action="?perfil=administrador&p=plano_add" role="form">
                            <div class="box-body">
                                <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                                <button type="submit" name="matricula" class="btn btn-info pull-right">Adicionar</button>
                            </div>
                        </form>
                        <!-- /.box -->
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- PLANO - Fim -->
        <!-- ESTATURA - Início -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Estatura prevista</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <?php
                    $sql_estatura = "SELECT * FROM estaturas WHERE cliente_id = '$idCliente'";
                    $query_estatura = mysqli_query($con,$sql_estatura);
                    $estatura = mysqli_fetch_array($query_estatura);
                    if($estatura != NULL) {
                        ?>
                        <!-- form start -->
                        <form method="POST" action="?perfil=administrador&p=estatura_edit" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <labeL>Estatura Pai:</labeL> <?= decimalBr($estatura['estatura_pai'],1) ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Estatura Mãe:</labeL> <?= decimalBr($estatura['estatura_mae'],1) ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Estatura Prevista:</labeL> <?= decimalBr($estatura['estatura_prevista'],1) ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Estimativa:</labeL> <?= decimalBr($estatura['estimativa'],1) ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Margem de erro 01:</labeL> <?= decimalBr($estatura['margem_erro01'],1) ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Margem de erro 02:</labeL> <?= decimalBr($estatura['margem_erro02'],1) ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                                <button type="submit" name="carregar" class="btn btn-info pull-right">Editar</button>
                            </div>
                        </form>
                    <!-- /.box -->
                    <?php
                    }
                    else{
                        ?>
                        <!-- form start -->
                        <form method="POST" action="?perfil=administrador&p=estatura_add" role="form">
                            <div class="box-body">
                                <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                                <button type="submit" name="estatura" class="btn btn-info pull-right">Adicionar</button>
                            </div>
                        </form>
                        <!-- /.box -->
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- ESTATURA - Fim -->
        <!-- AVALIAÇÕES general form elements -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Peso / Altura</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=peso_altura_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="avaliacao" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <?php
                    $sql_avaliacao = "SELECT * FROM imcs WHERE cliente_id = '$idCliente' ORDER BY data";
                    $query_avaliacao = mysqli_query($con,$sql_avaliacao);
                    if($query_avaliacao != NULL) {
                        ?>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Peso</th>
                                    <th>Altura</th>
                                    <th>IMC</th>
                                    <th width="10%">Ação</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                $avaliacao_charts = '';
                                while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                    echo "<tr>";
                                    echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                    echo "<td>" . decimalBr($avaliacao['peso'],3) . "</td>";
                                    echo "<td>" . decimalBr($avaliacao['altura'],1) . "</td>";
                                    echo "<td>" . imc($avaliacao['peso'],$avaliacao['altura']) ."</td>";
                                    echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=peso_altura_edit\" role=\"form\">
                                    <input type='hidden' name='idAvaliacao' value='" . $avaliacao['id'] . "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                                    echo "</tr>";
                                    $avaliacao_charts .= "{y: '".dataBR($avaliacao['data'])."', a: ".$avaliacao['peso']."}, ";
                                }
                                $avaliacao_charts = substr($avaliacao_charts,0,-2);
                                echo "</tbody>";
                                ?>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- PESO CHART -->
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Peso corporal total</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="peso-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <!-- ./PESO CHART -->
        </div>
        <!-- AVALIAÇÕES - Fim -->
        <!-- PERIMETRIA - Início -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <?php
                    $sql_perimetria = "SELECT per.id AS idPerimetria, `imc_id`, `torax`, `cintura`, `abdome`, `quadril`, `coxa_direita`, `coxa_esquerda`, `perna_direita`, `perna_esquerda`, `biceps_direito`, `biceps_esquerdo`, `punho`, i.id, `data`, `peso`, `altura`, `resultado`, `cliente_id` FROM perimetrias AS per INNER JOIN imcs i on per.imc_id = i.id WHERE i.cliente_id = '$idCliente' ORDER BY i.data";
                    $query_perimetria = mysqli_query($con,$sql_perimetria);
                    ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">Perimetria</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=perimetria_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="perimetria" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Torax</th>
                                <th>Cintura</th>
                                <th>Abdome</th>
                                <th>Quadril</th>
                                <th>Coxa D.</th>
                                <th>Coxa E.</th>
                                <th>Perna D.</th>
                                <th>Perna E.</th>
                                <th>Bíceps D.</th>
                                <th>Bíceps E.</th>
                                <th>Punho</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <?php
                            while($perim = mysqli_fetch_array($query_perimetria)){
                                echo "<tbody>";
                                echo "<tr>";
                                echo "<td>".dataBR($perim['data'])."</td>";
                                echo "<td>".decimalBr($perim['torax'],1)."</td>";
                                echo "<td>".decimalBr($perim['cintura'],1)."</td>";
                                echo "<td>".decimalBr($perim['abdome'],1)."</td>";
                                echo "<td>".decimalBr($perim['quadril'],1)."</td>";
                                echo "<td>".decimalBr($perim['coxa_direita'],1)."</td>";
                                echo "<td>".decimalBr($perim['coxa_esquerda'],1)."</td>";
                                echo "<td>".decimalBr($perim['perna_direita'],1)."</td>";
                                echo "<td>".decimalBr($perim['perna_esquerda'],1)."</td>";
                                echo "<td>".decimalBr($perim['biceps_direito'],1)."</td>";
                                echo "<td>".decimalBr($perim['biceps_esquerdo'],1)."</td>";
                                echo "<td>".decimalBr($perim['punho'],1)."</td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=perimetria_edit\" role=\"form\">
                                    <input type='hidden' name='idPerimetria' value='" . $perim['idPerimetria'] . "'>
                                    <input type='hidden' name='idCliente' value='" . $idCliente. "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                                echo "</tr>";
                                echo "</tbody>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- PERIMETRIA - Fim -->
        <!-- DOBRAS - Início -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <?php
                    $sql_dobra = "SELECT do.id AS idDobra, `imc_id`, `peitoral`, `s_escapular`, `tricipital`, `a_media`, `s_iliaca`, `abdominal`, `coxa`, `perna`, i.id, `data`, `peso`, `altura`, `resultado`, `cliente_id` FROM dobras AS do INNER JOIN imcs i on do.imc_id = i.id WHERE i.cliente_id = '$idCliente' ORDER BY i.data";
                    $query_dobra = mysqli_query($con,$sql_dobra);
                    ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">Dobras</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <?php
                        if($cliente['classificacao_id'] == 1) {
                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_add\" role=\"form\">";
                        }
                        if($cliente['classificacao_id'] == 2) {
                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras8_add\" role=\"form\">";
                        }
                        if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 1) {
                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras3m_add\" role=\"form\">";
                        }
                        if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 2) {
                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras3f_add\" role=\"form\">";
                        }
                        ?>
                        <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                        <button type="submit" name="perimetria" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Peitoral</th>
                                <th>Sub Escapular</th>
                                <th>Tricipital</th>
                                <th>Axilar Média</th>
                                <th>Supra Ilíaca</th>
                                <th>Abdominal</th>
                                <th>Coxa</th>
                                <th>Perna</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <?php
                            while($dob = mysqli_fetch_array($query_dobra)){
                                echo "<tbody>";
                                echo "<tr>";
                                echo "<td>".dataBR($dob['data'])."</td>";
                                echo "<td>".decimalBr($dob['peitoral'],1)."</td>";
                                echo "<td>".decimalBr($dob['s_escapular'],1)."</td>";
                                echo "<td>".decimalBr($dob['tricipital'],1)."</td>";
                                echo "<td>".decimalBr($dob['a_media'],1)."</td>";
                                echo "<td>".decimalBr($dob['s_iliaca'],1)."</td>";
                                echo "<td>".decimalBr($dob['abdominal'],1)."</td>";
                                echo "<td>".decimalBr($dob['coxa'],1)."</td>";
                                echo "<td>".decimalBr($dob['perna'],1)."</td>";
                                echo "<td>";
                                if($cliente['classificacao_id'] == 1) {
                                    echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_edit\" role=\"form\">";
                                }
                                if($cliente['classificacao_id'] == 2) {
                                    echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras8_edit\" role=\"form\">";
                                }
                                if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 1) {
                                    echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras3m_edit\" role=\"form\">";
                                }
                                if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 2) {
                                    echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras3f_edit\" role=\"form\">";
                                }
                                echo"<input type='hidden' name='idDobras' value='" . $dob['idDobra'] . "'>
                                        <input type='hidden' name='idCliente' value='" . $idCliente . "'>
                                        <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                        </form>
                                        </td>";
                                echo "</tr>";
                                echo "</tbody>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- DOBRAS - Fim -->
        <div class="row">
        <!-- JACKSON POLLOCK 7 -->
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jackson Pollock 7 dobras</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <?php
                    $sql_avaliacao = "SELECT * FROM imcs WHERE cliente_id = '$idCliente' ORDER BY data";
                    $query_avaliacao = mysqli_query($con,$sql_avaliacao);
                    if($query_avaliacao != NULL) {
                        ?>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>% Gordura</th>
                                    <th>Massa Magra</th>
                                    <th>Massa Gorda</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                    $jp = jackson($avaliacao['id']);
                                    echo "<tr>";
                                    echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                    echo "<td>" . $jp['gordura7'] . "</td>";
                                    echo "<td>" . $jp['mg7'] ."</td>";
                                    echo "<td>" . $jp['mm7'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                ?>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- ./JACKSON POLLOCK 7 -->
            <!-- JACKSON POLLOCK 3 -->
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jackson Pollock 3 dobras</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <?php
                    $sql_avaliacao = "SELECT * FROM imcs WHERE cliente_id = '$idCliente' ORDER BY data";
                    $query_avaliacao = mysqli_query($con,$sql_avaliacao);
                    if($query_avaliacao != NULL) {
                        ?>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>% Gordura</th>
                                    <th>Massa Magra</th>
                                    <th>Massa Gorda</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                if($cliente['classificacao_id'] == 3) {
                                    $aluno = recuperaDados("alunos", "cliente_id", $idCliente);
                                    if($aluno['sexo_id'] == 2){
                                        while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                            $jp = jackson($avaliacao['id']);
                                            echo "<tr>";
                                            echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                            echo "<td>" . $jp['gordura3'] . "</td>";
                                            echo "<td>" . $jp['mg3'] . "</td>";
                                            echo "<td>" . $jp['mm3'] . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    else{
                                        while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                            $jp = jackson($avaliacao['id']);
                                            echo "<tr>";
                                            echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                            echo "<td>" . $jp['gordura3'] . "</td>";
                                            echo "<td>" . $jp['mg3'] . "</td>";
                                            echo "<td>" . $jp['mm3'] . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                                else{
                                    while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                        $jp = jackson($avaliacao['id']);
                                        echo "<tr>";
                                        echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                        echo "<td>" . $jp['gordura3'] . "</td>";
                                        echo "<td>" . $jp['mg3'] . "</td>";
                                        echo "<td>" . $jp['mm3'] . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                echo "</tbody>";
                                ?>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- ./JACKSON POLLOCK 3 -->
        </div>
        <div class="row">
            <!-- WELLS - Início -->
            <div class="col-md-6">
                <div class="box box-default">
                    <?php
                    $sql_wells = "SELECT * FROM wells WHERE cliente_id = '$idCliente' ORDER BY data";
                    $query_wells = mysqli_query($con,$sql_wells);
                    ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">Banco de Wells</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=wells_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="carregar" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Medida</th>
                                <th width="20%">Ação</th>
                            </tr>
                            </thead>
                            <?php
                            echo "<tbody>";
                            $wells_charts = '';
                            while($wel = mysqli_fetch_array($query_wells)){
                                echo "<tr>";
                                echo "<td>".dataBR($wel['data'])."</td>";
                                echo "<td>".$wel['medida']."</td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=wells_edit\" role=\"form\">
                                    <input type='hidden' name='idWells' value='" . $wel['id'] . "'>
                                    <input type='hidden' name='idCliente' value='" . $idCliente. "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                                echo "</tr>";
                                $wells_charts .= "{y: '".dataBR($wel['data'])."', a: ".$wel['medida']."}, ";
                            }
                            $wells_charts = substr($wells_charts,0,-2);
                            echo "</tbody>";
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- PESO CHART -->
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Banco de Wells</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="wells-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <!-- ./PESO CHART -->
            <!-- WELLS - Fim -->
        </div>

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
    });
</script>
