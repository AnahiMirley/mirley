<?php
declare(strict_types=1);

/**
 * Inicializador de sesiones para entornos serverless (Vercel).
 *
 * Las funciones serverless no comparten disco entre invocaciones, así que
 * las sesiones nativas de PHP (basadas en archivos) se pierden entre una
 * petición y otra. Este archivo guarda las sesiones en la base de datos
 * MySQL (que sí es compartida) en vez de en archivos locales.
 *
 * Uso: en cada página que antes llamaba a session_start(), reemplazar esa
 * llamada por: require_once __DIR__ . '/backend/session_init.php';
 * (o la ruta relativa correspondiente si el archivo está dentro de backend/).
 */

require_once __DIR__ . '/conexion.php';

if (!class_exists('DbSessionHandler')) {
    class DbSessionHandler implements SessionHandlerInterface
    {
        private PDO $pdo;
        private int $maxLifetime;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
            $configurado = (int) ini_get('session.gc_maxlifetime');
            $this->maxLifetime = $configurado > 0 ? $configurado : 1440; // 24 min por defecto
        }

        public function open(string $path, string $name): bool
        {
            return true;
        }

        public function close(): bool
        {
            return true;
        }

        public function read(string $id): string|false
        {
            $stmt = $this->pdo->prepare('SELECT datos FROM sesiones WHERE id = ? LIMIT 1');
            $stmt->execute([$id]);
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fila ? (string) $fila['datos'] : '';
        }

        public function write(string $id, string $data): bool
        {
            $stmt = $this->pdo->prepare(
                'INSERT INTO sesiones (id, datos, actualizado_en) VALUES (?, ?, NOW())
                 ON DUPLICATE KEY UPDATE datos = VALUES(datos), actualizado_en = NOW()'
            );
            return $stmt->execute([$id, $data]);
        }

        public function destroy(string $id): bool
        {
            $stmt = $this->pdo->prepare('DELETE FROM sesiones WHERE id = ?');
            return $stmt->execute([$id]);
        }

        public function gc(int $max_lifetime): int|false
        {
            $limite = date('Y-m-d H:i:s', time() - $this->maxLifetime);
            $stmt = $this->pdo->prepare('DELETE FROM sesiones WHERE actualizado_en < ?');
            $stmt->execute([$limite]);
            return $stmt->rowCount();
        }
    }
}

session_set_save_handler(new DbSessionHandler($pdo), true);
session_start();
