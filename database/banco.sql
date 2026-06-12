CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE historico_consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    moeda_origem VARCHAR(10) NOT NULL,
    moeda_destino VARCHAR(10) NOT NULL,
    valor_consulta DECIMAL(16,6) NOT NULL,
    valor_convertido DECIMAL(16,6) NOT NULL,
    taxa_cambio DECIMAL(18,10) NOT NULL,
    data_consulta DATETIME NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nome, email, senha, created_at, updated_at)
VALUES
    ('Administrador', 'admin@local', '$2y$10$KxSb7Q6XxZGBhgk8J2rVnOTTkV38Fh9fkz4Ie2QQsV/Eo8EwDJTgG', NOW(), NOW());

-- Senha de acesso: admin123
