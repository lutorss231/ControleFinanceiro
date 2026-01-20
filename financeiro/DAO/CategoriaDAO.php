<?php

    require_once 'Conexao.php';
    require_once 'UtilDAO.php';

    class CategoriaDAO extends Conexao{
        public function CadastrarCategoria($nomeCtg){
            if(empty($nomeCtg)){
                return 0;
            }else{
                // 1º Passo: Realiza a herança com a classe Conexao conectando com o Banco de Dados!
                $conexao = parent::retornarConexao();

                // 2º Passo: Script SQL que sera executado na Tabela Categoria.
                $comando_sql = 'INSERT INTO tb_categoria(nome_categoria, id_usuario) VALUES(?, ?);';

                // 3º Passo: Monta os recursos do PDO para gerir o Banco de Dados pelo PHP!
                $sql = new PDOStatement();

                // 4º Passo: Prepara a execução do Script SQL!
                $sql = $conexao->prepare($comando_sql);

                // 5º Passo: Valida e identifica os itens que vão ser cadastrados!
                $sql->bindValue(1, $nomeCtg);
                $sql->bindValue(2, UtilDAO::UsuarioLogado());

                // 6º Passo: Tenta executar e trata o erro caso não funcione!
                try{
                    $sql->execute();
                    return 1;
                }catch(Exception $ex){
                    echo $ex->getMessage();
                    return -1;
                }
            }
        }

        public function ConsultarCategoria(){
            $conexao = parent::retornarConexao();

            $comando_sql = 'SELECT id_categoria, nome_categoria FROM tb_categoria WHERE id_usuario = ? ORDER BY nome_categoria ASC;';

            $sql = new PDOStatement();

            $sql = $conexao->prepare($comando_sql);

            $sql->bindValue(1, UtilDAO::UsuarioLogado());

            $sql->setFetchMode(PDO::FETCH_ASSOC);

            $sql->execute();

            return $sql->fetchAll();
        }

        public function DetalharCategoria($idCategoria){
            if($idCategoria == ''){
                return 0;
            }else{
                $conexao = parent::retornarConexao();

                $comando_sql = 'SELECT id_categoria, nome_categoria FROM tb_categoria WHERE id_categoria = ? AND id_usuario = ?;';

                $sql = new PDOStatement();

                $sql = $conexao->prepare($comando_sql);

                $sql->bindValue(1, $idCategoria);
                $sql->bindValue(2, UtilDAO::UsuarioLogado());

                $sql->setFetchMode(PDO::FETCH_ASSOC);

                $sql->execute();

                return $sql->fetchAll();
            }
        }

        public function AlterarCategoria($nomeCtg, $idCategoria){
            if(empty($nomeCtg) || empty($idCategoria)){
                return 0;
            }else{
                $conexao = parent::retornarConexao();

                $comando_sql = 'UPDATE tb_categoria SET nome_categoria = ? WHERE id_categoria = ? AND id_usuario = ?;';

                $sql = new PDOStatement();

                $sql = $conexao->prepare($comando_sql);

                $i=1;
                $sql->bindValue($i++, $nomeCtg);
                $sql->bindValue($i++, $idCategoria);
                $sql->bindValue($i++, UtilDAO::UsuarioLogado());

                try{
                    $sql->execute();
                    return 1;
                }catch(Exception $ex){
                    echo $ex->getMessage();
                    return -1;
                }
            }
        }

        public function ExcluirCategoria($idCategoria){
            if($idCategoria == ''){
                return 0;
            }else{
                $conexao = parent::retornarConexao();

                $comando_sql = 'DELETE FROM tb_categoria 
                                WHERE id_categoria = ? 
                                AND id_usuario = ?;';

                $sql = new PDOStatement();

                $sql = $conexao->prepare($comando_sql);

                $sql->bindValue(1, $idCategoria);
                $sql->bindValue(2, UtilDAO::UsuarioLogado());

                try{
                    $sql->execute();
                    return 1;
                }catch(Exception $ex){
                    echo $ex->getMessage();
                    return -4;
                }
            }
        }        
    }