<?php
include "includes/menu.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Avaliação</h2>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro</h3>
                </div>
                <form method="POST" action="?perfil=administrador&p=avaliacao_edit" role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Nome:</label>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <labeL>Data</labeL>
                                <input type="text" name="data" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <labeL>Peso</labeL>
                                <input type="text" name="altura" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <labeL>Altura</labeL>
                                <input type="text" name="peso" class="form-control">
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-default">Cancela</button>
                        <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
