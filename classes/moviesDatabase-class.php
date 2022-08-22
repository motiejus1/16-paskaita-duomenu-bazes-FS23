<?php
include("classes/databaseConnection-class.php");

class MovieDatabase extends DatabaseConnection{
    public $movies;
    public $categories;

    public function __construct(){
        parent::__construct();

        // $this->movies = $this->selectAction("filmai");
        $this->movies = $this->selectWithJoin("filmai", "kategorijos","kategorijosID", "id", "LEFT JOIN",["filmai.id", "filmai.title", "filmai.description", "filmai.image", "kategorijos.title as categoryTitle"]);
        
        if(!isset($_GET["page"])) {
            foreach ($this->movies as $movie) {
                echo "<tr>";
                echo "<td>".$movie["id"]."</td>";
                echo "<td>".$movie["title"]."</td>";
                echo "<td>".$movie["description"]."</td>";
                echo "<td>".$movie["image"]."</td>";
                if(empty($movie["categoryTitle"])) {
                    echo "<td>Nėra kategorijos</td>";
                } else {
                    echo "<td>".$movie["categoryTitle"]."</td>";
                }
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='id' value='".$movie["id"]."'>";
                echo "<button class='btn btn-danger' type='submit' name='delete'>DELETE</button>";
                echo "</form>";
                // echo "<a href='index.php?page=update&id='. $movie["id"]. "' class='btn btn-success'>EDIT</a>";
                echo "<a href='index.php?page=update&id=".$movie["id"]."' class='btn btn-success'>EDIT</a>";
                echo "</td>";
                echo "</tr>";

            }
        }
    }

    public function getCategories() {
        $this->categories =  $this->selectAction("kategorijos");
        if(isset($_GET["page"]) && ($_GET["page"] == "categories")) {
            foreach ($this->categories as $category) {
                echo "<tr>";
                echo "<td>".$category["id"]."</td>";
                echo "<td>".$category["title"]."</td>";
                echo "<td>".$category["description"]."</td>";
                echo "</tr>";

            }
        }

        return $this->categories;
    }

    public function createMovie() {
        if(isset($_POST["patvirtinti"])) {
            $movie = array(
                "title" => $_POST["title"],
                "description" => $_POST["description"],
                "image" => $_POST["image"],
                "kategorijosID" => $_POST["kategorijosID"]
            );
            $movie["title"] = '"' . $movie["title"] . '"';
            $movie["description"] = '"' . $movie["description"] . '"';
            $movie["image"] = '"' . $movie["image"] . '"';
            $movie["kategorijosID"] = '"' . $movie["kategorijosID"] . '"';
            $this->insertAction("filmai", ["title", "description", "image", "kategorijosID"],[$movie["title"], $movie["description"], $movie["image"], $movie["kategorijosID"]]);
          //  header("Location: index.php");
        }
    }

    public function deleteMovie() {
        if(isset($_POST["delete"])) {
            $this->deleteAction("filmai", $_POST["id"]);
            header("Location: index.php");
        }
    }

    public function selectOneMovie() {
        if(isset($_GET["page"]) && ($_GET["page"] == "update" && isset($_GET["id"]))) {
            $movie = $this->selectOneAction("filmai", $_GET["id"]);
            return $movie;
            
        }
    }

    public function editMovie() {
        if(isset($_POST["redaguoti"])) {
            $movie = array(
                "title" => $_POST["title"],
                "description" => $_POST["description"],
                "image" => $_POST["image"],
                "kategorijosID" => $_POST["kategorijosID"]
            );
            $this->updateAction("filmai", $_POST["id"] , $movie);
           header("Location: index.php");
        }
    }
} 


?>