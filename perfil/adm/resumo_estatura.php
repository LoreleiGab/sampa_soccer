<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 29/12/2018
 * Time: 18:36
 */
?>
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
