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
        $this->username = "surmonte";
        $this->password = "Sm2022$!";
        $this->dbname = "surmonteprod";
        $this->charset = "utf8";

        // DATOS DE DOMINIO
        // $this->servername = "192.168.1.17";
        // $this->username = "admin";
        // $this->password = "CITelum7602825102019";
        // $this->dbname = "flota";
        // $this->charset = "utf8";
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
//$db = new DB_SM;
// consulta para comprobar las credenciales del usuario
//var_dump ($db->connect());
// $db = mysqli_connect("localhost", "root", "", "PortalClientes");
// mysqli_query($db, "SET NAMES 'utf8'");

// //inicia sesion

// session_start();
?>