<?php

    // Classe que vai controlar o acesso na aplicação!

    class UtilDAO{
        // 1º Passo: Iniciar uma Sessão do Usuário para permissão!
        private static function IniciarSessao(){
            if(!isset($_SESSION)){
                session_start();
            }
        }

        // 2º Passo: Essa function vai levantar e armazenar os dados de acesso do Usuário!
        public static function CriarSessao($cod, $nome){
            self::IniciarSessao();

            $_SESSION['cod'] = $cod;
            $_SESSION['nome'] = $nome;
        }

        // 3º Passo: Vamos receber o Nome do Usuário que esta logando.
        public static function NomeLogado(){
            self::IniciarSessao();

            return $_SESSION['nome'];
        }

        // 4º Passo: Vamos receber o ID do Usuário que esta logando.
        public static function UsuarioLogado(){
            // Simula um Usuário conectado no Sistema!
            // return 1;

            self::IniciarSessao();

            return $_SESSION['cod'];
        }

        // 5º Passo: Vamos destruir a sessão quando o sair for habilitado pelo Usuário!
        public static function Deslogar(){
            self::IniciarSessao();

            unset($_SESSION['cod']);
            unset($_SESSION['nome']);

            header('location: index.php');
            exit();
        }

        // 6º Passo: Essa function monitora se existe sessão, caso não, o Usuário será devolvido para tela de Login!
        public static function VerificarLogado(){
            self::IniciarSessao();

            if(!isset($_SESSION['cod']) || $_SESSION['cod'] == ''){
                header('location: index.php');
                exit();
            }
        }
    }