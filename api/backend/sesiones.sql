-- Tabla para guardar las sesiones de PHP en la base de datos.
-- Necesaria porque en Vercel (serverless) los archivos locales no se
-- comparten entre invocaciones de las funciones.
--
-- Ejecutar este script UNA sola vez en tu base de datos MySQL de Clever Cloud
-- (por ejemplo desde phpMyAdmin, Adminer, o el cliente mysql).

CREATE TABLE IF NOT EXISTS sesiones (
    id VARCHAR(128) NOT NULL PRIMARY KEY,
    datos MEDIUMTEXT NOT NULL,
    actualizado_en DATETIME NOT NULL,
    INDEX idx_sesiones_actualizado_en (actualizado_en)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
