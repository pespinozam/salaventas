<?php


Class DB{

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    public function connect(){
        // CONEXION LOCAL
        // $this->servername = "localhost";
        // $this->username = "uwqj4tunnbvoj";
        // $this->password = "m029ncqryseg";
        // $this->dbname = "dbr1g1gpshoxbb";
        // $this->charset = "utf8";
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "portalclientes";
        $this->charset = "utf8";
        try {
            //Data Source Name
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
            $pdo = new PDO($dsn,$this->username,$this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $pdo;
            
        } catch (PDOException $e) {
            echo "Conection failed: ".$e->getMessage();
        }
    }   
}

//$db = new DB;


    // consulta para comprobar las credenciales del usuario
//var_dump ($db->connect());
// $db = mysqli_connect("localhost", "root", "", "PortalClientes");
// mysqli_query($db, "SET NAMES 'utf8'");

// //inicia sesion

// session_start();
?>