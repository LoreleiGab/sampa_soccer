<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastra'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $sql = "INSERT INTO avaliacoes (cliente_id,data,peso,altura) VALUES ('$idCliente','$data','$peso','$altura')";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success","Gravado com suscesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['avaliacao'])){
    $idCliente = $_POST['idCliente'];
}

$sql_lista = "SELECT * FROM avaliacoes WHERE cliente_id = '$idCliente'";
$query_lista = mysqli_query($con,$sql_lista);

$cliente = recuperaDados("clientes","id",$idCliente);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Avaliação</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastro</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=avaliacao_add" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nome:</label> <?= $cliente['nome'] ?>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <labeL for="data">Data</labeL>
                                    <input type="date" id="data" name="data" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="peso">Peso</labeL>
                                    <input type="text" id="peso" name="peso" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="altura">Altura</labeL>
                                    <input type="text" id="altura" name="altura" class="form-control">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-default">Cancelar</button>
                            <input type='hidden' name='idCliente' value='<?= $cliente['id'] ?>'>
                            <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Avaliações anteriores</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Peso</th>
                                <th>Altura</th>
                                <th>IMC</th>
                                <th colspan="2" width="10%">Ação</th>
                            </tr>
                            </thead>

                            <?php
                            echo "<tbody>";
                            while ($avaliacao = mysqli_fetch_array($query_lista)){
                                $imc = number_format($avaliacao['peso'] / ($avaliacao['altura'] * $avaliacao['altura']),2);
                                echo "<tr>";
                                echo "<td>".exibirDataBr($avaliacao['data'])."</td>";
                                echo "<td>".$avaliacao['peso']."</td>";
                                echo "<td>".$avaliacao['altura']."</td>";
                                echo "<td>".$imc."</td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=cliente_edit\" role=\"form\">
                                    <input type='hidden' name='idAvaliacao' value='".$avaliacao['id']."'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Perimetria</button>
                                    </form>
                                </td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=cliente_edit\" role=\"form\">
                                    <input type='hidden' name='idAvaliacao' value='".$avaliacao['id']."'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Perimetria</button>
                                    </form>
                                </td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=cliente_edit\" role=\"form\">
                                    <input type='hidden' name='idAvaliacao' value='".$avaliacao['id']."'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Perimetria</button>
                                    </form>
                                </td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=avaliacao_add\" role=\"form\">
                                    <input type='hidden' name='idAvaliacao' value='".$avaliacao['id']."'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Dobras</button>
                                    </form>
                                </td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            ?>
                            <tfoot>
                            <tr>
                                <th>Data</th>
                                <th>Peso</th>
                                <th>Altura</th>
                                <th colspan="2" width="10%">Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
</div>