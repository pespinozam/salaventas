<?php


// DB_CONNECTION=mysql
// DB_HOST=sistema.surmonte.cl
// DB_PORT=3306
// DB_DATABASE=surmontedev
// DB_USERNAME=surmonte_extra
// DB_PASSWORD=Sm2022$!


Class DB_SM{

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    public function connect(){
        // CONEXION LOCAL
        $this->servername = "sistema.surmonte.cl";
        $this->port = "3306";
        $this->username = "root";
        $this->password = "password";
        $this->dbname = "surmonteprod";
        $this->charset = "utf8";

        try {
            //Data Source Name
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
            $pdo = new PDO($dsn,$this->username,$this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $comunicado = "conectado";
            
            return $pdo;
            
        } catch (PDOException $e) {
            echo "Conection failed: ".$e->getMessage();
        }
    }   
}

?>
