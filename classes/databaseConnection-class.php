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

    protected $conn; //connection kad sita savybe galetu naudotis kitos klases

    //Konstruktoriaus funkcija - pasileidzia automatiskai objektui susikurus/ivykdzius objekto metoda
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
           // echo "Prisijungta prie duomenu bazes sekmingai";
        } catch(PDOException $e) {
           // echo "Prisijungti prie duomenu bazes nepavyko: " . $e->getMessage();
        }

    }
    //SELECT - jinai grazina rezultatu masyva

    //INSERT - negrazina jokiu irasu
    //DELETE- negrazina jokiu irasu
    //UPDATE - negrazina jokiu irasu

    //SELECT * FROM `kategorijos` WHERE 1

    // $col - rikiavimo stulpelis, id ....
    //$sortDir - rikiavimo kryptis. ASC arba DESC
    public function selectAction($table, $col ="id", $sortDir ="ASC") {
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM `$table` WHERE 1 ORDER BY $col $sortDir";
            //pasiruosimas vykdyti
            $stmt = $this->conn->prepare($sql);
            //vykdyti
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            return $result;

        } catch(PDOException $e) {
            return "Nepavyko vykdyti uzklausos: " . $e->getMessage();
        }
    }
    //$cols - iterpiami stulpeliai, masyvas
    //$values - stulpeliu reiksmes, masyvas

    //kategorijos
    // $cols = ["title", "description"];
    // $values = ["'test'", "'test'"];['"test"', '"test"']

    //filmai
    // $cols = ["title", "description","image", "kategorijosID];
    // $values = ["test", "test", "test", "test"];
    public function insertAction($table, $cols, $values) {


        $cols = implode(",", $cols);
        //masyva pavercia i teksta per skirtuka ["title", "description"] => "title,description"
        $values = implode(",", $values);//  ["test", "test"] => "test,test"

        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql= "INSERT INTO `$table` ($cols) VALUES ($values)";
            //var_dump($sql);
            $this->conn->exec($sql);
            echo "Pavyko sukurti nauja irasa";

        } catch (PDOException $e) {
            echo "Nepavyko sukurti naujo iraso: " . $e->getMessage();
        }

    }

    public function deleteAction($table, $id) {
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM `$table` WHERE id = $id";
            $this->conn->exec($sql);
            echo "Pavyko istrinti irasa";
        }
        catch(PDOException $e) {
            echo "Nepavyko istrinti iraso: " . $e->getMessage();
        }
    }

    public function updateAction($table, $id, $data) {
        $cols = array_keys($data);
        //var_dump($cols);
        $values = array_values($data);
        //var_dump($values);

        $dataString = [];
        for ($i=0; $i<count($cols); $i++) {
           $dataString[] = $cols[$i] . " = '" . $values[$i]. "'";
        }
        $dataString = implode(",", $dataString);
       // var_dump($dataString);


       try{
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $sql = "UPDATE `$table` SET $dataString WHERE id = $id";
              $stmt = $this->conn->prepare($sql);
              $stmt->execute();
              echo "Pavyko atnaujinti irasa";
         } 
       catch(PDOException $e) {
              echo "Nepavyko atnaujinti iraso: " . $e->getMessage();
       }
    }

    public function selectOneAction($table, $id) {
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM `$table` WHERE id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        } catch(PDOException $e) {
            return "Nepavyko vykdyti uzklausos: " . $e->getMessage();
        }
    }

    public function selectWithJoin($table1, $table2, $table1RelationCol, $table2RelationCol, $join, $cols) {
        //table1 - filmai
        //table2 - kategorijos

        //sujungimo stulpeliai

        //daznu atveju reikia pasirinkti konkrecius stulpelius
        // tenka pervadinti stulpelius

        //$table1 = "filmai";
        //$table2 = "kategorijos";

        //$table1RelationCol = "kategorijosID";
        //$table2RelationCol = "id";

        //$join = "LEFT JOIN";

        //$cols = ["filmai.id", "filmai.title", "filmai.description", "filmai.image", "kategorijos.title as categoryTitle"];

        $cols = implode(",", $cols); // "filmai.id, filmai.title, filmai.description, filmai.image, kategorijos.title as categoryTitle"

        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT $cols FROM $table1 
            $join $table2
            ON $table1.$table1RelationCol = $table2.$table2RelationCol";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        }
        catch(PDOException $e) {
            return "Nepavyko vykdyti uzklausos: " . $e->getMessage();
        }
    }

    //Destruktoriaus funkcija - pasileidzia automatiskai po objekto sunaikinimo/ ir po objekto metodo ivykdymo
    public function __destruct() {
        $this->conn = null;
       // echo "Atjungta is duomenu bazes sekmingai";
    }


}

?>