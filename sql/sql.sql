	-- Tabela de usuários
	CREATE TABLE usuario (
	    id SERIAL PRIMARY KEY,
	    email VARCHAR(255) NOT NULL UNIQUE,
	    senha VARCHAR(255) NOT NULL
	);
	
	-- Tabela de perfis (relacionada com usuário)
	CREATE TABLE perfil (
	    id SERIAL PRIMARY KEY,
	    nome VARCHAR(100) NOT NULL,
	    periodo VARCHAR(50),
	    idade INTEGER,
	    bio TEXT,
	    imagem VARCHAR(255),
	    id_usuario INTEGER NOT NULL,
	    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
	);
	
	-- Tabela de notícias (relacionada com usuário como autor)
	CREATE TABLE noticia (
	    id SERIAL PRIMARY KEY,
	    titulo VARCHAR(255) NOT NULL,
	    texto TEXT NOT NULL,
	    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	    imagem VARCHAR(255),
	    id_autor INTEGER NOT NULL,
	    FOREIGN KEY (id_autor) REFERENCES usuario(id) ON DELETE CASCADE
	);

-- Inserindo um usuário
INSERT INTO usuario (email, senha)
VALUES ('joao@example.com', 'senha123'); -- Lembre-se de criptografar senhas no sistema real

-- Vamos supor que o ID gerado foi 1 (você pode verificar com SELECT ou RETURNING id)
-- Inserindo perfil para o usuário
INSERT INTO perfil (nome, periodo, idade, bio, imagem, id_usuario)
VALUES ('João Silva', 'Noturno', 21, 'Estudante de Ciência da Computação.', 'joao.jpg', 1);

-- Inserindo notícia escrita por esse usuário
INSERT INTO noticia (titulo, texto, imagem, id_autor)
VALUES (
    'Lançamento do novo sistema acadêmico',
    'O sistema acadêmico foi atualizado com novas funcionalidades.',
    'sistema.jpg',
    1
);

