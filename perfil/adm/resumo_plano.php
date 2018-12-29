<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 29/12/2018
 * Time: 18:01
 */
?>
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

