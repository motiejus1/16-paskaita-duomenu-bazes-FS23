<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Pagrindinis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=create">Kurti filmą</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=update">Redaguoti filmą</a>
            </li>

            
        </ul>
        <?php 
            //pagal GET kintamaji mes busime nukreipiami į tam tikrus puslapius
        
            if(isset($_GET["page"])) {
                if(($_GET["page"]) == "create") {
                    include("movies/create.php");
                } else if(($_GET["page"]) == "update") {
                    include("movies/update.php");
                } else if(($_GET["page"]) == "categories") {
                    include("categories/index.php");
                } 
            } else {
                include("movies/index.php");
            }

        ?>
    </div>
</body>
</html>