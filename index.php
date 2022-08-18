<?php 

//1.Prie duomenu bazes reikia prisijungti x
//2. Kodas turi atlikti SQL uzklausa  
//3.Kodas turi atsijungti nuo duomenu bazes

//proceduriniu budu 
//objektiniu budu

//proceduriniu budu labai lengva pamirst uzdaryti prisijungima prie duombazes
class DatabaseConnection {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "filmai";

    protected $conn; //connection

    //Konstruktoriaus funkcija - pasileidzia automatiskai objektui susikurus/ivykdzius objekto metoda
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
            echo "Prisijungta prie duomenu bazes sekmingai";
        } catch(PDOException $e) {
            echo "Prisijungti prie duomenu bazes nepavyko: " . $e->getMessage();
        }

    }


    //SELECT * FROM `kategorijos` WHERE 1

    public function selectAction($table, $collumns = "*", $where = "WHERE 1", $orderCollumn = "id", $orderBy = "ASC") {

        if(is_array($collumns)) {
            $collumns = implode(", ", $collumns);
        }

        if(is_null($where)) {
            $where = "WHERE 1";
        }

        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT $collumns FROM `$table` $where ORDER BY $orderCollumn $orderBy";
            var_dump($sql);
            //pasiruosimas vykdyti
            $stmt = $this->conn->prepare($sql);
            //vykdyti
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            var_dump($result);

        } catch(PDOException $e) {
            echo "Nepavyko vykdyti uzklausos: " . $e->getMessage();
        }
    }

    //Destruktoriaus funkcija - pasileidzia automatiskai po objekto sunaikinimo/ ir po objekto metodo ivykdymo
    public function __destruct() {
        $this->conn = null;
        echo "Atjungta is duomenu bazes sekmingai";
    }


}

$conn = new DatabaseConnection();
$conn->selectAction("kategorijos",["id","title"], null, "id", "DESC");