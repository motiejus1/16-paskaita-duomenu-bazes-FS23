<?php include("classes/moviesDatabase-class.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmai</title>
</head>
<body>
    <h1>Filmai pagrindinis</h1>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php $movies = new MovieDatabase(); ?>
        <?php $movies->deleteMovie(); ?>
        
    </table>
</body>
</html>