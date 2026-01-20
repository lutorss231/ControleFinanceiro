<?php

    //  ===== Verificar a Sessão =====
    require_once './DAO/UtilDAO.php';
    UtilDAO::VerificarLogado();
    //  ==============================

    require_once './DAO/MovimentoDAO.php';

    $tipoMov = '';

    if(isset($_POST['btnPesquisar'])){
        $tipoMov = $_POST['tipoMov'];
        $dtInicio = $_POST['dtInicio'];
        $dtFinal = $_POST['dtFinal'];

        $objDAO = new MovimentoDAO();
        $movs = $objDAO->ConsultarMovimento($tipoMov, $dtInicio, $dtFinal);
    }else if(isset($_POST['btnExcluir'])){
        $idMov = $_POST['idMov'];
        $idConta = $_POST['idConta'];
        $tipo = $_POST['tipo'];
        $valor = $_POST['valor'];

        $objDAO = new MovimentoDAO();
        $ret = $objDAO->ExcluirMovimento($idMov, $idConta, $tipo, $valor);
    }

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
                        <h2>Consultar Movimentações Financeiras realizadas.</h2>
                        <h5>Aqui você pode CONSULTAR todas as suas Movimentações Financeiras realizadas.</h5>
                        <?php include_once '_msg.php'; ?>
                    </div>
                </div>
                <hr />
                
                <form action="consultar_movimento.php" method="POST">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Selecione um Tipo de Movimentação:</label>
                            <select class="form-control" name="tipoMov" id="tipoMov">
                                <option value="">Selecione</option>
                                <option value="0" <?= $tipoMov == 0 ? 'selected' : '' ?>>Todos</option>
                                <option value="1" <?= $tipoMov == 1 ? 'selected' : '' ?>>Entrada</option>
                                <option value="2" <?= $tipoMov == 2 ? 'selected' : '' ?>>Saída</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Selecione uma Data de Início:</label>
                            <input type="date" class="form-control" name="dtInicio" id="dtInicio" value="<?= isset($dtInicio) ? $dtInicio : '' ?>"/>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Selecione uma Data Final:</label>
                            <input type="date" class="form-control" name="dtFinal" id="dtFinal" value="<?= isset($dtFinal) ? $dtFinal : '' ?>"/>
                        </div>
                    </div>
                        
                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-primary" name="btnPesquisar" onclick="return ValidarConsultarMovimento();">Pesquisar</button>
                    </div>
                </form>

                <?php if(isset($movs)){ ?>
                    <hr>
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
                                            <th>Tipo do Movimento</th>
                                            <th>Data</th>
                                            <th>Valor (R$)</th>
                                            <th>Categoria Financeira</th>
                                            <th>Empresa</th>
                                            <th>Conta Bancária</th>
                                            <th>Observação (Opcional)</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                            $total = 0;

                                            for($i=0; $i < count($movs); $i++){
                                                if($movs[$i]['tipo_movimento'] == 1){
                                                    $total = $total + $movs[$i]['valor_movimento'];
                                                }else{
                                                    $total = $total - $movs[$i]['valor_movimento'];
                                                }
                                            
                                        
                                        ?>
                                            <tr>
                                                <td><?= $i+1 ?></td>
                                                <td><?= $movs[$i]['tipo_movimento'] == 1 ? '<strong style="color: #006400;">Entrada</strong>' : '<strong style="color: #f40000;">Saída</strong>' ?></td>
                                                <td><?= $movs[$i]['data_movimento'] ?></td>
                                                <td>R$ <?= number_format($movs[$i]['valor_movimento'], 2, ',', '.') ?></td>
                                                <td><?= $movs[$i]['obs_movimento'] ?></td>
                                                <td><?= $movs[$i]['nome_categoria'] ?></td>
                                                <td><?= $movs[$i]['nome_empresa'] ?></td>
                                                <td><?= $movs[$i]['banco_conta'] . ' - R$ ' . number_format($movs[$i]['saldo_conta'], 2, ',', '.') ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?= $i ?>">Excluir</a>

                                                    <form action="consultar_movimento.php" method="POST">
                                                        <input type="hidden" name="idMov" value="<?= $movs[$i]['id_movimento'] ?>">
                                                        <input type="hidden" name="idConta" value="<?= $movs[$i]['id_conta'] ?>">
                                                        <input type="hidden" name="tipo" value="<?= $movs[$i]['tipo_movimento'] ?>">
                                                        <input type="hidden" name="valor" value="<?= $movs[$i]['valor_movimento'] ?>">

                                                        <div class="panel-body">
                                                            <div class="modal fade" id="myModal<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Você quer realmente EXCLUIR esse Movimento Financeiro?</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <strong>Tipo do Movimento: </strong><span><?= $movs[$i]['tipo_movimento'] == 1 ? '<strong style="color: #006400;">Entrada</strong>' : '<strong style="color: #f40000;">Saída</strong>' ?></span>
                                                                            <br>
                                                                            <strong>Data do Movimento: </strong><span><?= $movs[$i]['data_movimento'] ?></span>
                                                                            <br>
                                                                            <strong>Valor do Movimento: </strong>R$ <span><?= number_format($movs[$i]['valor_movimento'], 2, ',', '.') ?></span>
                                                                            <br>
                                                                            <strong>Observação: </strong><span><?= $movs[$i]['obs_movimento'] ?></span>
                                                                            <br>
                                                                            <strong>Nome da Categoria: </strong><span><?= $movs[$i]['nome_categoria'] ?></span>
                                                                            <br>
                                                                            <strong>Nome Empresa: </strong><span><?= $movs[$i]['nome_empresa'] ?></span>
                                                                            <br>
                                                                            <strong>Banco: </strong><span><?= $movs[$i]['banco_conta'] . ' - R$ ' . number_format($movs[$i]['saldo_conta'], 2, ',', '.') ?></span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-danger" name="btnExcluir">Excluir</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div style="text-align: center;">
                                    <strong>Total: </strong>
                                    <span style="color: <?= $total < 0 ? '#f40000;' : '#006400' ?>;">
                                        <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>