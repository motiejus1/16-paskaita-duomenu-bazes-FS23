<?php include("classes/moviesDatabase-class.php"); ?>
<?php 
$moviesDatabase = new MovieDatabase();  
$movie=$moviesDatabase->selectOneMovie();
$moviesDatabase->editMovie();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redaguoti filmą</title>
</head>
<body>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input class="form-control" name="title" value="<?php echo $movie[0]["title"]; ?>" placeholder="Pavadinimas">
        <input class="form-control" name="description" value="<?php echo $movie[0]["description"]; ?>" placeholder="Aprašymas">
        <input class="form-control" name="image" value="<?php echo $movie[0]["image"]; ?>"  placeholder="Paveikslėlis">
        <!-- <input class="form-control" name="kategorijosID" value="<?php echo $movie[0]["kategorijosID"]; ?>"  placeholder="Kategorija"> -->
        <select class="form-select" name="kategorijosID">
            <!-- <option value="1">Siaubo </option> -->
            <?php foreach($moviesDatabase->getCategories() as $category) { ?>
                <?php if($movie[0]["kategorijosID"] == $category["id"]) { ?>
                    <option value="<?php echo $category['id']; ?>" selected><?php echo $category['title']; ?></option>
                <?php }  else {?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                <?php } ?>
            
                <?php } ?>
        </select>
        <button class="btn btn-primary" type="submit" name="redaguoti">Redaguoti</button>
    </form>
</body>
</html>