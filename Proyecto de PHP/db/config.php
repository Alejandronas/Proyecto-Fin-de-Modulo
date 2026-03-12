<?php

class Database {

    private $db = null;
    
 
    public static function conectar()
    {
        $host = 'db';
        $db   = 'tiempo_db'; 
        $user = 'weather_user';
        $pass = 'weather_pass';

        try {
            
            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            
            
            $dbh = new PDO($dsn, $user, $pass);
            
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $dbh;

        } catch (PDOException $e){
            
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

?>