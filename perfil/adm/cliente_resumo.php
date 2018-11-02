<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['resumo'])){
    $idCliente = $_POST['idCliente'];
}

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
                        <h3 class="box-title">Cadastro</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label>Classificação do cliente:</label> <?= $classificacao['nome_classificacao'] ?>
                        </div>
                        <div class="form-group">
                            <label>Nome completo:</label> <?= $cliente['nome'] ?>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <labeL>Data de Nascimento:</labeL> <?= dataBR($cliente['data_nascimento']) ?>
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Telefone #1:</labeL> <?= $cliente['telefone01'] ?>
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Telefone #2:</labeL> <?= $cliente['telefone02'] ?>
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Email:</labeL> <?= $cliente['email'] ?>
                            </div>
                        </div>
                        <?php
                        if($cliente['classificacao_id'] == 1) {
                            $atleta = recuperaDados("atleta", "cliente_id", $idCliente);
                            $pe = recuperaDados("pe_dominantes","id",$atleta['pe_dominante_id']);
                            ?>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL>Apelido:</labeL> <?= $atleta['apelido'] ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Posição:</labeL> <?= $atleta['posicao'] ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Pé dominante:</labeL> <?= $pe['pe_dominante'] ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Clube:</labeL> <?= $atleta['clube'] ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Categoria:</labeL> <?= $atleta['categoria'] ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <labeL>Contatos:</labeL> <?= $atleta['contatos'] ?>
                            </div>
                            <div class="form-group">
                                <labeL>Últimos clubes:</labeL> <?= $atleta['ultimos_clubes'] ?>
                            </div>
                            <?php
                        }
                        if($cliente['classificacao_id'] == 2) {
                            $base = recuperaDados("base", "cliente_id", $idCliente);
                            $pe = recuperaDados("pe_dominantes","id",$base['pe_dominante_id']);
                            ?>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL>Apelido:</labeL> <?= $base['apelido'] ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Posição:</labeL> <?= $base['posicao'] ?>
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
                            $aluno = recuperaDados("aluno", "cliente_id", $idCliente);
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
                <!-- /.box -->
                <!-- ESTATURA - Início -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Estatura</h3>
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
                                        <labeL>Estatura Pai:</labeL> <?= $estatura['estatura_pai'] ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Estatura Mãe:</labeL> <?= $estatura['estatura_mae'] ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Estatura Prevista:</labeL> <?= $estatura['estatura_prevista'] ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Estimativa:</labeL> <?= $estatura['estimativa'] ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Margem de erro #1:</labeL> <?= $estatura['margem_erro01'] ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <labeL>Margem de erro #2:</labeL> <?= $estatura['margem_erro02'] ?>
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
                <!-- ESTATURA - Fim -->
                <!-- AVALIAÇÕES general form elements -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Avaliações</h3>
                        <form method="POST" action="?perfil=administrador&p=avaliacao_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="avaliacao" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <?php
                    $sql_avaliacao = "SELECT * FROM avaliacoes WHERE cliente_id = '$idCliente'";
                    $query_avaliacao = mysqli_query($con,$sql_avaliacao);
                    if($query_avaliacao != NULL) {
                        ?>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Peso</th>
                                    <th>Altura</th>
                                    <th>IMC</th>
                                    <th colspan="3" width="10%">Ação</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                    $imc = number_format($avaliacao['peso'] / (($avaliacao['altura']/100) * ($avaliacao['altura']/100)), 2);
                                    echo "<tr>";
                                    echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                    echo "<td>" . $avaliacao['peso'] . "</td>";
                                    echo "<td>" . $avaliacao['altura'] . "</td>";
                                    echo "<td>" . $imc . "</td>";
                                    echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=avaliacao_edit\" role=\"form\">
                                    <input type='hidden' name='idAvaliacao' value='" . $avaliacao['id'] . "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                                    $perimetria = recuperaDados("perimetrias","avaliacao_id",$avaliacao['id']);
                                    if($perimetria != NULL){
                                        echo "<td>
                                        <form method=\"POST\" action=\"?perfil=administrador&p=perimetria_edit\" role=\"form\">
                                        <input type='hidden' name='idPerimetria' value='" . $perimetria['id'] . "'>
                                        <input type='hidden' name='idCliente' value='" . $idCliente . "'>
                                        <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\"><i class=\"fa fa-edit\"></i> Perimetria</button>
                                        </form>
                                        </td>";
                                    }
                                    else{
                                        echo "<td>
                                        <form method=\"POST\" action=\"?perfil=administrador&p=perimetria_add\" role=\"form\">
                                        <input type='hidden' name='idAvaliacao' value='" . $avaliacao['id'] . "'>
                                        <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\"><i class=\"fa fa-plus\"></i> Perimetria</button>
                                        </form>
                                        </td>";
                                    }
                                    $dobras = recuperaDados("dobras","avaliacao_id",$avaliacao['id']);
                                    if($dobras != NULL){
                                        echo "<td>";
                                        if($cliente['classificacao_id'] == 1) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_edit\" role=\"form\">";
                                        }
                                        if($cliente['classificacao_id'] == 2) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_edit\" role=\"form\">";
                                        }
                                        if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 1) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_edit\" role=\"form\">";
                                        }
                                        if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 2) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_edit\" role=\"form\">";
                                        }
                                        echo"<input type='hidden' name='idDobras' value='" . $dobras['id'] . "'>
                                        <input type='hidden' name='idCliente' value='" . $idCliente . "'>
                                        <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\"><i class=\"fa fa-edit\"></i> Dobras</button>
                                        </form>
                                        </td>";
                                    }
                                    else{
                                        echo "<td>";
                                        if($cliente['classificacao_id'] == 1) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_add\" role=\"form\">";
                                        }
                                        if($cliente['classificacao_id'] == 2) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_add\" role=\"form\">";
                                        }
                                        if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 1) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_add\" role=\"form\">";
                                        }
                                        if($cliente['classificacao_id'] == 3 && $aluno['sexo_id'] == 2) {
                                            echo"<form method=\"POST\" action=\"?perfil=administrador&p=dobras7_add\" role=\"form\">";
                                        }
                                        echo"<input type='hidden' name='idAvaliacao' value='" . $avaliacao['id'] . "'>
                                            <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\"><i class=\"fa fa-plus\"></i> Dobras</button>
                                            </form>
                                        </td>";
                                    }
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                ?>
                                <tfoot>
                                <tr>
                                    <th>Data</th>
                                    <th>Peso</th>
                                    <th>Altura</th>
                                    <th>IMC</th>
                                    <th colspan="3" width="10%">Ação</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <?php
                    }
                    ?>
                </div>
                <!-- AVALIAÇÕES - Fim -->
                <!-- PERIMETRIA - Início -->
                <div class="box box-default">
                <?php
                    $sql_avaliacao = "SELECT * FROM avaliacoes WHERE cliente_id = '$idCliente'";
                    $query_avaliacao = mysqli_query($con,$sql_avaliacao);
                    if($query_avaliacao != NULL) {
                        while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                            $idAvaliacao = $avaliacao['id'];
                            $sql_perimetria = "SELECT * FROM perimetrias WHERE avaliacao_id = '$idAvaliacao'";
                            $query_perimetria = mysqli_query($con,$sql_perimetria);
                            $num_perimetria = mysqli_num_rows($query_perimetria);
                            if($num_perimetria > 0){
                            ?>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Perimetria</h3>
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
                                        </tr>
                                        </thead>
                                        <?php
                                        while($perim = mysqli_fetch_array($query_perimetria)){
                                            echo "<tbody>";
                                            echo "<tr>";
                                            echo "<td>".dataBR($avaliacao['data'])."</td>";
                                            echo "<td>".$perim['torax']."</td>";
                                            echo "<td>".$perim['cintura']."</td>";
                                            echo "<td>".$perim['abdome']."</td>";
                                            echo "<td>".$perim['quadril']."</td>";
                                            echo "<td>".$perim['coxa_direita']."</td>";
                                            echo "<td>".$perim['coxa_esquerda']."</td>";
                                            echo "<td>".$perim['perna_direita']."</td>";
                                            echo "<td>".$perim['perna_esquerda']."</td>";
                                            echo "<td>".$perim['biceps_direito']."</td>";
                                            echo "<td>".$perim['biceps_esquerdo']."</td>";
                                            echo "<td>".$perim['punho']."</td>";
                                            echo "</tr>";
                                            echo "</tbody>";
                                        }
                                        ?>
                                        <tfoot>
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
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php
                            }
                        }
                    }
                ?>
                </div>
                <!-- PERIMETRIA - Fim -->
                <!-- DOBRAS - Início -->
                <div class="box box-default">
                    <?php
                    $sql_avaliacao = "SELECT * FROM avaliacoes WHERE cliente_id = '$idCliente'";
                    $query_avaliacao = mysqli_query($con,$sql_avaliacao);
                    if($query_avaliacao != NULL) {
                        while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                            $idAvaliacao = $avaliacao['id'];
                            $sql_dobra = "SELECT * FROM dobras WHERE avaliacao_id = '$idAvaliacao'";
                            $query_dobra = mysqli_query($con,$sql_dobra);
                            $num_dobra = mysqli_num_rows($query_dobra);
                            if($num_dobra > 0){
                                ?>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Perimetria</h3>
                                </div>
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Peitoral</th>
                                            <th>S. Escapular</th>
                                            <th>Tricipital</th>
                                            <th>A Media</th>
                                            <th>S Ilíaca</th>
                                            <th>Abdominal</th>
                                            <th>Coxa</th>
                                        </tr>
                                        </thead>
                                        <?php
                                        while($dob = mysqli_fetch_array($query_dobra)){
                                            echo "<tbody>";
                                            echo "<tr>";
                                            echo "<td>".dataBR($avaliacao['data'])."</td>";
                                            echo "<td>".$dob['peitoral']."</td>";
                                            echo "<td>".$dob['s_escapular']."</td>";
                                            echo "<td>".$dob['tricipital']."</td>";
                                            echo "<td>".$dob['a_media']."</td>";
                                            echo "<td>".$dob['s_iliaca']."</td>";
                                            echo "<td>".$dob['abdominal']."</td>";
                                            echo "<td>".$dob['coxa']."</td>";
                                            echo "</tr>";
                                            echo "</tbody>";
                                        }
                                        ?>
                                        <tfoot>
                                        <tr>
                                            <th>Data</th>
                                            <th>Peitoral</th>
                                            <th>S. Escapular</th>
                                            <th>Tricipital</th>
                                            <th>A Media</th>
                                            <th>S Ilíaca</th>
                                            <th>Abdominal</th>
                                            <th>Coxa</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <!-- DOBRAS - Fim -->
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
