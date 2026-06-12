CREATE DATABASE IF NOT EXISTS projeto_monitor_moedas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE projeto_monitor_moedas;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS historico_consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    moeda_origem VARCHAR(10) NOT NULL,
    moeda_destino VARCHAR(10) NOT NULL,
    valor_origem DECIMAL(15,2) NOT NULL,
    valor_convertido DECIMAL(15,2) NOT NULL,
    taxa_cambio DECIMAL(18,8) NOT NULL,
    data_consulta DATETIME NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_data_consulta (data_consulta),
    INDEX idx_moeda_origem (moeda_origem),
    INDEX idx_moeda_destino (moeda_destino),
    CONSTRAINT fk_historico_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (nome, email, password, remember_token, created_at, updated_at)
VALUES
    ('Administrador', 'admin@monitor.com', '$2y$12$.7W72MgnYeO3Y/FMi8Xa4OdIgoknNdU.ODddiFitnDNeaeye69yZG', NULL, NOW(), NOW());

INSERT INTO historico_consultas (usuario_id, moeda_origem, moeda_destino, valor_origem, valor_convertido, taxa_cambio, data_consulta, created_at, updated_at)
VALUES
    (1, 'USD', 'BRL', 1000.00, 5142.50, 5.14250000, '2026-06-10 10:30:00', NOW(), NOW()),
    (1, 'EUR', 'USD', 250.00, 270.75, 1.08300000, '2026-06-08 14:20:00', NOW(), NOW()),
    (1, 'GBP', 'EUR', 500.00, 578.50, 1.15700000, '2026-06-09 09:15:00', NOW(), NOW());
