CREATE DATABASE IF NOT EXISTS projeto_monitor_moedas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE projeto_monitor_moedas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE historico_consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    moeda_origem VARCHAR(10) NOT NULL,
    moeda_destino VARCHAR(10) NOT NULL,
    valor_consulta DECIMAL(15,2) NOT NULL,
    valor_convertido DECIMAL(15,2) NOT NULL,
    taxa_cambio DECIMAL(18,8) NOT NULL,
    data_consulta DATETIME NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
);

INSERT INTO usuarios (nome, email, senha, created_at, updated_at)
VALUES
    ('Administrador', 'admin@monitor.com', '$2y$12$.7W72MgnYeO3Y/FMi8Xa4OdIgoknNdU.ODddiFitnDNeaeye69yZG', NOW(), NOW());

INSERT INTO historico_consultas (usuario_id, moeda_origem, moeda_destino, valor_consulta, valor_convertido, taxa_cambio, data_consulta, created_at)
VALUES
    (1, 'USD', 'BRL', 1000.00, 5142.50, 5.14250000, '2026-06-10 10:30:00', NOW()),
    (1, 'EUR', 'USD', 250.00, 270.75, 1.08300000, '2026-06-08 14:20:00', NOW()),
    (1, 'GBP', 'EUR', 500.00, 578.50, 1.15700000, '2026-06-09 09:15:00', NOW());
