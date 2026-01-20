<?php 

    //  ===== Verificar a Sessão =====
    require_once './DAO/UtilDAO.php';
    UtilDAO::VerificarLogado();
    //  ==============================

    require_once './DAO/EmpresaDAO.php';

    $objDAO = new EmpresaDAO();
    $empresas = $objDAO->ConsultarEmpresa();

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once '_head.php'; ?>

<body>
    <div id="wrapper">
        <?php
            include_once '_topo.php';
            include_once '_menu.php';
        ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Consultar Empresas cadastradas.</h2>
                        <h5>Aqui você pode CONSULTAR todas as suas Empresas cadastradas.</h5>
                        <?php include_once '_msg.php'; ?>
                    </div>
                </div>
                <hr />
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span>Veja o resultado da consulta:</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Qtds.</th>
                                        <th>Nome da Empresa</th>
                                        <th>Telefone (WhatsApp)</th>
                                        <th>Endereço Completo</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($empresas as $itens) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $itens['nome_empresa'] ?></td>
                                            <td><?= $itens['telefone_empresa'] ?></td>
                                            <td><?= $itens['endereco_empresa'] ?></td>
                                            <td><a href="alterar_empresa.php?cod=<?= $itens['id_empresa'] ?>" class="btn btn-warning">Altrerar</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>