	-- Tabela de usuários
CREATE TABLE usuario (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de perfil (1 para 1 com usuário)
CREATE TABLE perfil (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT UNIQUE NOT NULL,
    bio TEXT,
    foto VARCHAR(255),
    CONSTRAINT fk_perfil_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuario(id)
        ON DELETE CASCADE
);

-- Tabela de categorias de notícias
CREATE TABLE categoria (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela de notícias
CREATE TABLE noticia (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    conteudo TEXT NOT NULL,
    data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_noticia_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuario(id)
        ON DELETE CASCADE
);

-- Tabela associativa para muitos-para-muitos entre notícia e categoria
CREATE TABLE noticia_categoria (
    noticia_id BIGINT NOT NULL,
    categoria_id BIGINT NOT NULL,
    PRIMARY KEY (noticia_id, categoria_id),
    CONSTRAINT fk_noticia_categoria_noticia
        FOREIGN KEY (noticia_id)
        REFERENCES noticia(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_noticia_categoria_categoria
        FOREIGN KEY (categoria_id)
        REFERENCES categoria(id)
        ON DELETE CASCADE
);
