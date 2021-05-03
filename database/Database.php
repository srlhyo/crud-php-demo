<?php
// connect php to postgreSQL Database using PDO

class Database {
    private static $host;
    private static $db;
    private static $username;
    private static $password;
    private static $conn;

    public static function close($st) 
    {
        $st->closeCursor();
    }

    public static function execute($sql, $params)
    {
        $statement = self::$conn->prepare($sql);
        $statement->execute($params); 

        // returns an object containing the result set or false if failing to execute the query
        if($statement != null && $params == []) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            static::close($statement);
        }
        return $data;
    }

    private static function dsn()
    {
        return sprintf(
            "pgsql:host=%s;port=5432;dbname=%s;user=%s;password=%s",
            self::$host,
            self::$db,
            self::$username,
            self::$password
        );
    }

    public static function initialize($env)
    {
        self::$host = $env["host"];
        self::$db = $env["db"];
        self::$username = $env["username"];
        self::$password = $env["password"];
        $dsn = self::dsn();

        self::$conn = new PDO($dsn);
    }

    // proxy function {handing over to the other function}
    public static function exec($sql) {
        return static::execute($sql, []);
    }
}