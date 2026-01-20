<?php

    require_once 'Conexao.php';
    require_once 'UtilDAO.php';

    class UsuarioDAO extends Conexao{
        public function ValidarLogin($email, $senha){
            if(empty($email) || empty($senha)){
                return 0;
            }else if(strlen($senha) < 6 || strlen($senha) > 8){
                return -2;
            }else{
                // return 1;

                $conexao = parent:: retornarConexao();

                $comando_sql = 'SELECT id_usuario, nome_usuario FROM tb_usuario WHERE email_usuario = ? AND senha_usuario = ?';

                $sql = new PDOStatement();

                $sql = $conexao->prepare($comando_sql);

                $sql->bindValue(1, $email);
                $sql->bindValue(2, $senha);

                $sql->setFetchMode(PDO::FETCH_ASSOC);

                $sql->execute();

                $user = $sql->fetchAll();

                if(count($user) == 0){
                    return -6;
                }else{
                    $cod = $user[0]['id_usuario'];
                    $nome = $user[0]['nome_usuario'];

                    UtilDAO::CriarSessao($cod, $nome);

                    header('location: inicial.php');
                    exit();
                }
            }
        }

        public function CadastrarUsuario($nome, $email, $senha, $repSenha){
            if(empty($nome) || empty($email) || empty($senha) || empty($repSenha)){
                return 0;
            }else if(strlen($senha) < 6 || strlen($senha) > 8){
                return -2;
            }else if($senha != $repSenha){
                return -3;
            }else{
                if($this->ValidarEmailDuplicadoCadastrar($email) != 0){
                    return -5;
                }

                $conexao = parent::retornarConexao();

                $comando_sql = 'INSERT INTO tb_usuario(nome_usuario, email_usuario, senha_usuario, data_cadastro) VALUES(?, ?, ?, ?);';

                $sql = new PDOStatement();

                $sql = $conexao->prepare($comando_sql);

                $sql->bindValue(1, $nome);
                $sql->bindValue(2, $email);
                $sql->bindValue(3, $senha);
                $sql->bindValue(4, date('Y-m-d'));

                try{
                    $sql->execute();
                    return 1;
                }catch(Exception $ex){
                    echo $ex->getMessage();
                    return -1;
                }    
            }
        }

        public function CarregarMeusDados(){
            $conexao = parent::retornarConexao();

            $comando_sql = 'SELECT nome_usuario, email_usuario, senha_usuario FROM tb_usuario WHERE id_usuario = ?;';

            $sql = new PDOStatement();

            $sql = $conexao->prepare($comando_sql);

            $sql->bindValue(1, UtilDAO::UsuarioLogado());

            // Esse comando realiza a consulta via PDO e retorna os dados em um Array!
            $sql->setFetchMode(PDO::FETCH_ASSOC);

            $sql->execute();

            return $sql->fetchAll();
        }

        public function GravarMeusDados($nome, $email, $senha){
            if(empty($nome) || empty($email) || empty($senha)){
                return 0;
            }else{
                if($this->ValidarEmailDuplicadoAlterar($email) != 0){
                    return -5;
                }!

                $conexao = parent::retornarConexao();

                $comando_sql = 'UPDATE tb_usuario SET nome_usuario = ?, email_usuario = ?, senha_usuario = ? WHERE id_usuario = ?;';

                $sql = new PDOStatement();

                $sql = $conexao->prepare($comando_sql);

                $i=1;
                $sql->bindValue($i++, $nome);
                $sql->bindValue($i++, $email);
                $sql->bindValue($i++, $senha);
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

        // Vai impedir que um cadastro seja feito com um e-mail já utilizado!
        public function ValidarEmailDuplicadoCadastrar($email){
            if($email == ''){
                return 0;
            }else{
                $conexao = parent::retornarConexao();

                $comando_sql = 'SELECT COUNT(email_usuario) AS CONTAR FROM tb_usuario WHERE email_usuario = ?';

                $sql = $conexao->prepare($comando_sql);

                $sql->bindValue(1, $email);

                $sql->setFetchMode(PDO::FETCH_ASSOC);

                $sql->execute();

                $contar = $sql->fetchAll();

                return $contar[0]['CONTAR'];
            }
        }

        // Vai impedir que um cadastro seja alterado com um e-mail já utilizado!
        public function ValidarEmailDuplicadoAlterar($email){
            if($email == ''){
                return 0;
            }else{
                $conexao = parent::retornarConexao();

                $comando_sql = 'SELECT COUNT(email_usuario) AS CONTAR FROM tb_usuario WHERE email_usuario = ? AND id_usuario != ?';

                $sql = $conexao->prepare($comando_sql);

                $sql->bindValue(1, $email);
                $sql->bindValue(2, UtilDAO::UsuarioLogado());

                $sql->setFetchMode(PDO::FETCH_ASSOC);

                $sql->execute();

                $contar = $sql->fetchAll();

                return $contar[0]['CONTAR'];
            }
        }
    }