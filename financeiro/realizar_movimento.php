<?php

    //  ===== Verificar a Sessão =====
    require_once './DAO/UtilDAO.php';
    UtilDAO::VerificarLogado();
    //  ==============================

    require_once './DAO/MovimentoDAO.php';
    require_once './DAO/CategoriaDAO.php';
    require_once './DAO/EmpresaDAO.php';
    require_once './DAO/ContaDAO.php';

    $objCategoria = new CategoriaDAO();
    $objEmpresa = new EmpresaDAO();
    $objConta = new ContaDAO();

    if(isset($_POST['btnRealizar'])){
        $tipo = $_POST['tipo'];
        $data = $_POST['data'];
        $valor = trim($_POST['valor']);
        $obs = trim($_POST['msg']);
        $categoria = $_POST['categoria'];
        $empresa = $_POST['empresa'];
        $conta = $_POST['conta'];

        $objDAO = new MovimentoDAO();
        $ret = $objDAO->RealizarMovimento($tipo, $data, $valor, $obs, $categoria, $empresa, $conta);
    }

    $categorias = $objCategoria->ConsultarCategoria();
    $empresas = $objEmpresa->ConsultarEmpresa();
    $contas = $objConta->ConsultarConta();

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
                        <h2>Realizar Movimentação Financeira.</h2>
                        <h5>Aqui você pode REALIZAR todas as suas Movimentações Financeiras (Fluxo de Caixa).</h5>
                        <?php include_once '_msg.php'; ?>
                    </div>
                </div>
                <hr />
                <form action="realizar_movimento.php" method="POST">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Selecione um Tipo de Movimentação:</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Selecione</option>
                                <option value="1">Entrada</option>
                                <option value="2">Saída</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Selecione uma Data:</label>
                            <input type="date" class="form-control" name="data" id="data"/>
                        </div>
                        <div class="form-group">
                            <label>Digite o Valor (R$):</label>
                            <input type="text" class="form-control" placeholder="Digite o Valor (R$) aqui..." name="valor" id="valor"/>
                        </div>            
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Selecione uma Categoria Financeira:</label>
                            <select class="form-control" name="categoria" id="categoria">
                                <option value="">Selecione</option>
                                <?php for($i=0; $i < count($categorias); $i++){ ?>
                                    <option value="<?= $categorias[$i]['id_categoria'] ?>"><?= $categorias[$i]['nome_categoria'] ?></option>
                                <?php } ?>
                            </select>
                        </div>     
                        <div class="form-group">
                            <label>Selecione uma Empresa:</label>
                            <select class="form-control" name="empresa" id="empresa">
                                <option value="">Selecione</option>
                                <?php for($i=0; $i < count($empresas); $i++){ ?>
                                    <option value="<?= $empresas[$i]['id_empresa'] ?>"><?= $empresas[$i]['nome_empresa'] ?></option>
                                <?php } ?>
                            </select>
                        </div>     
                        <div class="form-group">
                            <label>Selecione uma Conta Bancária:</label>
                            <select class="form-control" name="conta" id="conta">
                                <option value="">Selecione</option>
                                <?php for($i=0; $i < count($contas); $i++){ ?>
                                    <option value="<?= $contas[$i]['id_conta'] ?>"><?= $contas[$i]['banco_conta'] . ' - R$ ' . number_format($contas[$i]['saldo_conta'], 2, ',', '.') ?></option>
                                <?php } ?>
                            </select>
                        </div>     
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Digite uma Observação (opcional):</label>
                            <textarea class="form-control" placeholder="Digite sua Observação aqui..." rows="6" name="msg" id="msg" maxlength="500"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" name="btnRealizar" onclick="return ValidarRealizarMovimento();">Realizar Movimento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>