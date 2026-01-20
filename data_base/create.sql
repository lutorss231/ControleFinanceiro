-- CRUD (Create, Read, Update, Delete)
-- Create: Cadastrar.

INSERT INTO tb_usuario
(nome_usuario, email_usuario, senha_usuario, data_cadastro)
VALUES
('Ana Maria', 'ana_maria@outlook.com', 'ana369', '2025-10-14');

INSERT INTO tb_categoria
(nome_categoria, id_usuario)
VALUES
('Faculdade', 1);