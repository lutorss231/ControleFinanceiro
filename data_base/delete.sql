-- CRUD (Create, Read, Update, Delete)
-- Delete: Excluir.

-- Esse comando excluir TODO o Banco de Dados!
DROP DATABASE db_exemplo;

-- Esse comando excluir uma ou várias Tabelas do Banco de Dados!
DROP TABLE tb_exemplo;

DELETE FROM tb_usuario WHERE id_usuario = 1;

DELETE FROM tb_categoria WHERE id_categoria = 1;

DELETE FROM tb_movimento WHERE id_movimento IN (1, 2, 3, 4);