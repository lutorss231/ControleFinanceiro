-- CRUD (Create, Read, Update, Delete)
-- Update: Atualizar.

UPDATE tb_usuario
	SET nome_usuario = 'Paulo Sergio'
WHERE id_usuario = 2;

UPDATE tb_usuario
	SET nome_usuario = 'Paulo Sergio',
		email_usuario = 'paulo_sergio@gmail.com'
WHERE id_usuario = 2;