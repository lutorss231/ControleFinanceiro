<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', ''); // ✅ string vazia
define('DB', 'db_financeiro_ead');
define('PORT', '33068');

class Conexao {

    /** @var PDO */
    private static $Connect;

    private static function Conectar() {

        if (self::$Connect === null) {
            try {
                $dsn = "mysql:host=" . HOST .
                       ";port=" . PORT .
                       ";dbname=" . DB .
                       ";charset=utf8";

                self::$Connect = new PDO($dsn, USER, PASS);

                self::$Connect->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            } catch (PDOException $e) {
                die("Erro de conexão com o banco: " . $e->getMessage());
            }
        }

        return self::$Connect;
    }

    public static function retornarConexao() {
        return self::Conectar();
    }
}
