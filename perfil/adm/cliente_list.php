<?php
include "includes/menu.php";

$con = bancoMysqli();

$idUser = $_SESSION['idUser'];
$sql = "SELECT clientes.id AS idCliente, nome, telefone01, emal, nome_classificacao FROM clientes INNER JOIN classificacao c on clientes.classificacao_id = c.id";
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
                                <th width="10%">Ação</th>
                            </tr>
                            </thead>

                            <?php
                            echo "<tbody>";
                            while ($cliente = mysqli_fetch_array($query)){
                                echo "<tr>";
                                echo "<td>".$cliente['nome']."</td>";
                                echo "<td>".$cliente['telefone01']."</td>";
                                echo "<td>".$cliente['emal']."</td>";
                                echo "<td>".$cliente['nome_classificacao']."</td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=cliente_edit\" role=\"form\">
                                    <input type='hidden' name='idCliente' value='".$cliente['idCliente']."'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Carregar</button>
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
                                <th width="10%">Ação</th>
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