<?php

    //  ===== Verificar a Sessão =====
    require_once './DAO/UtilDAO.php';
    UtilDAO::VerificarLogado();
    //  ==============================

    require_once './DAO/CategoriaDAO.php';

    // Objeto Global!
    $objDAO = new CategoriaDAO();

    if(isset($_GET['cod']) && is_numeric($_GET['cod'])){
        $idCategoria = $_GET['cod'];

        $dados = $objDAO->DetalharCategoria($idCategoria);

        if(count($dados) == 0){
            header('location: consultar_categoria.php');
            exit();
        }
    }else if(isset($_POST['btnSalvar'])){
        $nomeCtg = trim($_POST['nomeCtg']);
        $idCategoria = $_POST['cod'];

        $ret = $objDAO->AlterarCategoria($nomeCtg, $idCategoria);

        header('location: consultar_categoria.php?ret=' . $ret);
        exit();
    }else if(isset($_POST['btnExcluir'])){
        $idCategoria = $_POST['cod'];

        $ret = $objDAO->ExcluirCategoria($idCategoria);

        header('location: consultar_categoria.php?ret=' . $ret);
        exit();
    }else{
        header('location: consultar_categoria.php');
        exit();
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
                        <h2>Alterar/Excluir uma Categoria Financeira.</h2>
                        <h5>Aqui você pode ALTERAR/EXCLUIR sua Categoria Financeira.</h5>
                        <?php include_once '_msg.php'; ?>
                    </div>
                </div>
                <hr />
                <form action="alterar_categoria.php" method="POST">
                    <input type="hidden" name="cod" value="<?= $dados[0]['id_categoria'] ?>">
                    <div class="form-group">
                        <label>Digite o Nome da Categoria Financeira:</label>
                        <input type="text" class="form-control" placeholder="Digite o Nome da Categoria Financeira aqui..." name="nomeCtg" id="nomeCtg" value="<?= $dados[0]['nome_categoria'] ?>"/>
                    </div>
                    <button type="submit" class="btn btn-success" name="btnSalvar" onclick="return ValidarCategoria();">Salvar</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Excluir</button>

                    <div class="panel-body">
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Você quer realmente EXCLUIR essa Categoria Financeira?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <strong>Nome da Categoria Financeira: </strong><span><?= $dados[0]['nome_categoria'] ?></span>
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
            </div>
        </div>
    </div>
</body>
</html>