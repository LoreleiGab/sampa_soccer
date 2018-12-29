<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 29/12/2018
 * Time: 18:03
 */
?>
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
