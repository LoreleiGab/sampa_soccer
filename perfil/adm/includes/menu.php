<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-plus"></i> <span>Novo Cliente</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="?perfil=administrador&p=atleta_add"><i class="fa fa-futbol-o"></i> Atleta</a></li>
                    <li><a href="?perfil=administrador&p=base_add"><i class="fa fa-child"></i> Base</a></li>
                    <li><a href="?perfil=administrador&p=aluno_add"><i class="fa fa-male"></i> Aluno</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Cadastros</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="?perfil=administrador&p=atleta_list"><i class="fa fa-futbol-o"></i> Atleta</a></li>
                    <li><a href="?perfil=administrador&p=base_list"><i class="fa fa-child"></i> Base</a></li>
                    <li><a href="?perfil=administrador&p=aluno_list"><i class="fa fa-male"></i> Aluno</a></li>
                </ul>
            </li>
            <li><a href="?perfil=administrador&p=cliente_list"><i class="fa fa-list"></i> Listar todos</a></li>
            <?php
            /*
             * Se existir cliente
             */
            if(isset($_SESSION['idCliente'])){
                $cliente = recuperaDados("clientes","id",$_SESSION['idCliente']);
            ?>
                <li class="header">CLIENTE</li>
                <li><a href="?perfil=administrador&p=cliente_resumo"><i class="fa fa-circle-o text-aqua"></i> Resumo</a></li>
                <?php
                if($cliente['classificacao_id'] == 1) {
                    echo "<li><a href=\"?perfil=administrador&p=atleta_edit\"><i class=\"fa fa-futbol-o\"></i> Cadastro</a></li>";
                }
                if($cliente['classificacao_id'] == 2) {
                    echo "<li><a href=\"?perfil=administrador&p=base_edit\"><i class=\"fa fa-child\"></i> Cadastro</a></li>";
                }
                if($cliente['classificacao_id'] == 3) {
                    echo "<li><a href=\"?perfil=administrador&p=aluno_edit\"><i class=\"fa fa-male\"></i> Cadastro</a></li>";
                }
                /* plano */
                $matricula = recuperaDados("matricula","cliente_id",$_SESSION['idCliente']);
                if($matricula == NULL){
                    echo "<li><a href=\"?perfil=administrador&p=plano_add\"><i class=\"fa fa-circle-o text-aqua\"></i> Plano</a></li>";
                }
                else{
                    echo "<li><a href=\"?perfil=administrador&p=plano_edit\"><i class=\"fa fa-circle-o text-aqua\"></i> Plano</a></li>";
                }
                /* estatura */
                $estatura = recuperaDados("estaturas","cliente_id",$_SESSION['idCliente']);
                if($estatura == NULL){
                    echo "<li><a href=\"?perfil=administrador&p=estatura_add\"><i class=\"fa fa-circle-o text-aqua\"></i> Estatura</a></li>";
                }
                else{
                    echo "<li><a href=\"?perfil=administrador&p=estatura_edit\"><i class=\"fa fa-circle-o text-aqua\"></i> Estatura</a></li>";
                }
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-circle-o text-aqua"></i> <span>Antropometria</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="?perfil=administrador&p=avaliacao_list"><i class="fa fa-circle-o"></i> Avaliação</a></li>
                        <li><a href="?perfil=administrador&p=perimetria_list"><i class="fa fa-circle-o"></i> Perimetria</a></li>
                        <li><a href="?perfil=administrador&p=dobras_list"><i class="fa fa-circle-o"></i> Dobras</a></li>
                    </ul>
                </li>
                <li><a href="?perfil=administrador&p=wells_list"><i class="fa fa-circle-o text-aqua"></i> Wells</a></li>
            <?php
            }
            /*
             * ./Se existir cliente
             */
            ?>
            <li class="header">OUTROS</li>
            <li><a href="?perfil=administrador"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="../include/logoff.php"><i class="fa fa-sign-out"></i><span>Sair</span></a></li>
            <!--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Avaliações</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="?perfil=administrador&p=avaliacao_add"><i class="fa fa-circle-o"></i> Cadastro</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Boxed</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Level One
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>