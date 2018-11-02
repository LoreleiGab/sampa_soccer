<?php
include "includes/menu.php";

$con = bancoMysqli();

$idUser = $_SESSION['idUser'];
$sql = "SELECT clientes.id AS idCliente, nome, telefone01, email, nome_classificacao, clientes.classificacao_id FROM clientes INNER JOIN classificacao c on clientes.classificacao_id = c.id";
$query = mysqli_query($con,$sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Clientes</h2>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Listagem</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Classificação</th>
                                <th colspan="3" width="10%">Ação</th>
                            </tr>
                            </thead>

                            <?php
                            echo "<tbody>";
                            while ($cliente = mysqli_fetch_array($query)){


                                echo "<tr>";
                                echo "<td>".$cliente['nome']."</td>";
                                echo "<td>".$cliente['telefone01']."</td>";
                                echo "<td>".$cliente['email']."</td>";
                                echo "<td>".$cliente['nome_classificacao']."</td>";
                                if($cliente['classificacao_id'] == 1){
                                    echo "<td><form method=\"POST\" action=\"?perfil=administrador&p=atleta_edit\" role=\"form\">";
                                }
                                if($cliente['classificacao_id'] == 2){
                                    echo "<td><form method=\"POST\" action=\"?perfil=administrador&p=base_edit\" role=\"form\">";
                                }
                                if($cliente['classificacao_id'] == 3){
                                    echo "<td><form method=\"POST\" action=\"?perfil=administrador&p=aluno_edit\" role=\"form\">";
                                }
                                echo "<input type='hidden' name='idCliente' value='".$cliente['idCliente']."'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                </td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=cliente_resumo\" role=\"form\">
                                    <input type='hidden' name='idCliente' value='".$cliente['idCliente']."'>
                                    <button type=\"submit\" name='resumo' class=\"btn btn-block btn-primary\">Resumo</button>
                                    </form>
                                </td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            ?>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Classificação</th>
                                <th colspan="3" width="10%">Ação</th>
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
        <!-- /.row -->
        <!-- END ACCORDION & CAROUSEL-->

    </section>
    <!-- /.content -->
</div>