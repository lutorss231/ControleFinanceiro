<?php 

    //  ===== Verificar a Sessão =====
    require_once './DAO/UtilDAO.php';
    UtilDAO::VerificarLogado();
    //  ==============================

    require_once './DAO/ContaDAO.php';

    $objDAO = new ContaDAO();
    $contas = $objDAO->ConsultarConta();

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
                        <h2>Consultar Contas Bancárias cadastradas.</h2>
                        <h5>Aqui você pode CONSULTAR todas as suas Contas Bancárias cadastradas.</h5>
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
                                        <th>Nome do Banco</th>
                                        <th>Num. Agência</th>
                                        <th>Num. Conta</th>
                                        <th>Saldo (R$)</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($contas as $itens){ ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $itens['banco_conta'] ?></td>
                                            <td><?= $itens['agencia_conta'] ?></td>
                                            <td><?= $itens['numero_conta'] ?></td>
                                            <td>R$ <?= number_format($itens['saldo_conta'], 2, ',', '.') ?></td>
                                            <td><a href="alterar_conta.php?cod=<?= $itens['id_conta'] ?>" class="btn btn-warning">Altrerar</a></td>
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