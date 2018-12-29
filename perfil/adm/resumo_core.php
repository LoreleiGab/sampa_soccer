<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Core</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <form method="POST" action="?perfil=administrador&p=core_add" role="form">
                    <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                    <button type="submit" name="core" class="btn btn-info pull-right">Adicionar</button>
                </form>
            </div>
            <?php
            $sql_core = "SELECT * FROM core WHERE cliente_id = '$idCliente'";
            $query_core = mysqli_query($con,$sql_core);
            if($query_core != NULL) {
                ?>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th width="10%">Ação</th>
                        </tr>
                        </thead>
                        <?php
                        echo "<tbody>";
                        while ($core = mysqli_fetch_array($query_core)) {
                            echo "<tr>";
                            echo "<td>" . dataBR($core['data']) . "</td>";
                            echo "<td>" . $core['descricao']. "</td>";
                            echo "<td>
                            <form method=\"POST\" action=\"?perfil=administrador&p=core_edit\" role=\"form\">
                            <input type='hidden' name='idCore' value='" . $core['id'] . "'>
                            <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                            </form>
                            </td>";
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
    <!-- /.col -->
    </div>
<!-- /.row -->
</div>