<?php
include "includes/menu.php";
$classificacao_id = $_GET['classificacao_id'];
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
                        <h3 class="box-title">Cadastro de Atleta</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=atleta_edit&classificacao_id=<?= $classificacao_id ?>" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nome">Nome completo</label>
                                <input type="text" id="nome" name="nome" class="form-control" maxlength="180" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="datepicker01">Data de Nascimento</labeL>
                                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="cpf">CPF</labeL>
                                    <input type="text" id="cpf" name="cpf" class="form-control" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="telefone01">Telefone 01</labeL>
                                    <input type="text" id="telefone01" name="telefone01" onkeyup="mascara( this, mtel );" class="form-control" maxlength="15" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="telefone02">Telefone 02</labeL>
                                    <input type="text" id="telefone02" name="telefone02" onkeyup="mascara( this, mtel );" class="form-control" maxlength="15">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="email">Email</labeL>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="apelido">Apelido</labeL>
                                    <input type="text" id="apelido" name="apelido" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="posicao_id">Posição</labeL>
                                    <select id="posicao_id" name="posicao_id" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <?php geraOpcao("posicoes","") ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="pe_dominante">Pé dominante</labeL>
                                    <select id="pe_dominante" name="pe_dominante" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <?php geraOpcao("pe_dominantes","") ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="clube">Clube</labeL>
                                    <input type="text" id="clube" name="clube" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="categoria_id">Categoria</labeL>
                                    <select id="categoria_id" name="categoria_id" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <?php geraOpcao("categoria_atletas","") ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <labeL for="restricao">Restrição</labeL>
                                <input id="restricao" type="text" name="restricao" class="form-control" maxlength="255">
                            </div>
                            <div class="form-group">
                                <labeL for="ultimos_clubes">Últimos clubes</labeL>
                                <input type="text" id="ultimos_clubes" name="ultimos_clubes" class="form-control" maxlength="255">
                            </div>
                            <div class="form-group">
                                <label for="diagnostico">Diagnóstico</label>
                                <textarea class="form-control" rows="5" id="diagnostico" name="diagnostico"></textarea>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="cadastrar" class="btn btn-info pull-right">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script>
    $("input[name='cpf']").mask('000.000.000-00', {reverse: true});
</script>
