<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 29/12/2018
 * Time: 18:05
 */
?>
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
