<?php
/**
 * SKD Admission System — PDO Database Connection
 * Singleton pattern. Use db() helper anywhere in the project.
 */

require_once __DIR__ . '/config.php';

class Database
{
    private static ?PDO $instance = null;

    /**
     * Returns the singleton PDO connection.
     * Throws on failure — never silently fails.
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_NAME,
                DB_CHARSET
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Log to file in production; show friendly error
                error_log('[SKD DB ERROR] ' . $e->getMessage());
                http_response_code(500);
                die('<div style="font-family:sans-serif;padding:2rem;color:#dc2626;">
                    <strong>Database connection failed.</strong><br>
                    Please contact the system administrator.
                </div>');
            }
        }

        return self::$instance;
    }
}

/**
 * Global shorthand for the PDO connection.
 * Usage:  $stmt = db()->prepare("SELECT ...");
 */
function db(): PDO
{
    return Database::getConnection();
}
