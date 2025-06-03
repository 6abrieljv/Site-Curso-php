-- Tabela de usuários
CREATE TABLE
    usuario (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(150) UNIQUE NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        is_admin BOOL DEFAULT FALSE
    );

-- Tabela de perfil (1 para 1 com usuário)
CREATE TABLE
    perfil (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        id_usuario BIGINT UNIQUE NOT NULL,
        nome VARCHAR(100) NOT NULL,
        sobrenome VARCHAR(100) NOT NULL,
        data_nascimento DATE,
        bio TEXT,
        -- Redes sociais
        instagram VARCHAR(100),
        facebook VARCHAR(100),
        twitter VARCHAR(100),
        linkedin VARCHAR(100),
        youtube VARCHAR(100),
        github VARCHAR(100),
        tiktok VARCHAR(100),
        foto VARCHAR(255),

        CONSTRAINT fk_perfil_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON DELETE CASCADE
    );
CREATE TABLE
    categoria (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) UNIQUE NOT NULL,
        cor VARCHAR(20) NOT NULL DEFAULT '#001A35', -- Cor para identificação visual
        slug VARCHAR(150) UNIQUE NOT NULL -- Para URLs amigáveis de categorias
    );

-- Tabela de notícias
CREATE TABLE
    noticia (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        usuario_id BIGINT NOT NULL,
        categoria_id BIGINT,
        titulo VARCHAR(200) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL, -- Coluna para URL amigável
        conteudo TEXT NOT NULL,
        imagem VARCHAR(255), -- Caminho para a imagem
        data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_noticia_usuario FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE,
        CONSTRAINT fk_noticia_categoria FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE
    );

-- Tabela de Categorias


