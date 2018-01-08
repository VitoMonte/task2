<?php

require_once  __DIR__ . '/M_DB.php';

class M_Post
{
    private static $instance;

    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new M_Post();

        return self::$instance;
    }

    /**
     * Внесение нового пользователя в базу
     */
    public function saveUsers($name, $surname, $age)
    {
        $sql= "INSERT INTO users (name, surname, age) VALUES (?,?,?)";
        $stmt = M_DB::run($sql, [$name, $surname, $age]);
        if(!$stmt)
            return false;
        return true;
    }

    /**
     * Получаем всех пользователей старше 18
    */
    public function getUsers() {
        $sql= "SELECT name, surname, age FROM users WHERE age > 18";
        $users = M_DB::run($sql)->fetchAll();
        return $users;
    }

    /**
     * Подготавливаем данные к отправке
    */
    public function sendUsers() {

        $users =  self::getUsers();
        $values =[];

        foreach ($users as $user) {
            $values[] = array($user['name'], $user['surname'], $user['age']);
        }

        return $values;
    }

    /**
     * Очистка строки (нужно подумать, как еще можно очистить)
     */
    public function clearStr($str) {
        return htmlspecialchars($str);
    }


}