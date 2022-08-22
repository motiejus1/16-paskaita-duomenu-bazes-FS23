<?php include("classes/moviesDatabase-class.php"); ?>
<?php $moviesDatabase = new MovieDatabase();  
      $moviesDatabase->createMovie();  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurti filmą</title>
</head>
<body>
    <form method="POST">
        <input class="form-control" name="title" placeholder="Pavadinimas">
        <input class="form-control" name="description" placeholder="Aprašymas">
        <input class="form-control" name="image" placeholder="Paveikslėlis">
        <!-- <input class="form-control" name="kategorijosID" placeholder="Kategorija"> -->
        <?php 
        //var_dump($moviesDatabase->getCategories());
        ?>
        <select class="form-select" name="kategorijosID">
            <!-- <option value="1">Siaubo </option> -->
            <?php foreach($moviesDatabase->getCategories() as $category) { ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
            <?php } ?>
        </select>
        <button class="btn btn-primary" type="submit" name="patvirtinti">Kurti</button>
    </form>
</body>
</html>