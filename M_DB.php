<?php

class M_DB
{
    private static $instance = null;

    public static function instance() //установили соединение с базой
    {
        if (self::$instance === null) {
            self::$instance = new PDO('sqlite:' .  __DIR__ . '/test');

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            if(filesize( __DIR__ .'/test') <= 0) {

                try {

                    self::$instance->beginTransaction();

                    $sql = "CREATE TABLE users(
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    surname TEXT NOT NULL,
                    age INTEGER NOT NULL
                    )";
                    self::$instance->exec($sql);

                    self::$instance->commit();
                } catch (PDOException $e) {

                    self::$instance->rollBack();
                    echo $e->getMessage();
                    exit;
                }
            }
        }

        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::instance(), $method], $args);
    }

    public static function run($sql, $args = [])
    {
        try {
            $stmt = self::instance()->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        } catch (PDOException $e) {
            file_put_contents('log.txt', date('Y-m-d h:i:s', time()) . "/ " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }

    }
}