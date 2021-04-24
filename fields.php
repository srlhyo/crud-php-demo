<?php 
// api ==== api endpoints /// noface
$apikeys = [
    "api", 
    "api2"
];


// connect php to postgreSQL Database using PDO

$host='localhost';
$db = 'weathersafe';
$username = 'postgres';
$password = '';


$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";

$access = false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeatherSafe APP</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="display-4  text-center my-5">Very simple WeatherSafe Database CRUD APP</h1>
        <small id="note">**provide your ApiKey to use the services</small>
        
        <form id="apiForm" class="row g-3 mt-1" method="GET">
            <div class="col-md-6">
                <label for="apiKey" class="form-label">Api Key</label>
                <input type="text" name="apikey" class="form-control" id="apiKey">
            </div>
            <div class="col-auto align-self-end">
                <input type="submit" name="submit" class="btn btn-primary" id="getFields" value="Get Fields">
            </div>
            <?php if(isset($_GET["apikey"]) && in_array($_GET["apikey"], $apikeys)) : ?>
                <small class="text-success" id="success"><?php echo "{'success': 'Key provided'}" ?></small>
            <?php $access= true;?>
            <?php else : ?>
                <?php if($_GET["submit"] == "Get Fields") : ?>
                    <small class="text-danger" id="error"><?php echo "{'error': 'Invalid Key!'}" ?></small>
                <?php endif; ?>
            <?php endif; ?>
        </form>

        <!-- Loading the rest of the body content -->
    <?php
        if($access) {
            $isError = false;
            $errorMessage = "";

            if(isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "Add Fields") {
                
                $numberOfTrees = $_POST['numberOfTrees'];
                $ageOfTrees = $_POST['ageOfTrees'];

                $statement->closeCursor();

                $add_field = "insert into \"Fields\" (\"NumberOfTrees\", \"AgeOfTrees\")
                values ('$numberOfTrees', '$ageOfTrees')"; 

                $statement = $conn->query($add_field);

                if($statement == false) {
                    $isError = true;
                    $errorMessage = "Dabase couldn't be reached";
                }
            }

            if(isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "Save Fields") {

                $numberOfTrees = $_POST['numberOfTrees'];
                $ageOfTrees = $_POST['ageOfTrees'];
                $fieldID = $_POST['fieldID'];

                $statement->closeCursor();

                $edit_field = "update \"Fields\" 
                set \"NumberOfTrees\" = $numberOfTrees,
                \"AgeOfTrees\" = $ageOfTrees
                where id = $fieldID"; 

                $statement = $conn->query($edit_field);

                if($statement == false) {
                    $isError = true;
                    $errorMessage = "Dabase couldn't be reached";
                }
            }

            if(isset($_POST["delete"])) {
                // create a PostgreSQL database connection
                $fieldID = $_POST['fieldID'];

                $delete_field = "delete from \"Fields\" 
                where id = $fieldID";

                $conn = new PDO($dsn);
                $statement = $conn->query($delete_field);

                if($statement == false) {
                    $isError = true;
                    $errorMessage = "Dabase couldn't be reached";
                }
                $statement->closeCursor();
            }

            // get all fields
            $get_fields = "select * 
            from (select * from \"Fields\" f order by \"id\" desc limit 8) as foo
            order by \"id\" asc;";

            try{
            // create a PostgreSQL database connection
            $conn = new PDO($dsn);

            // returns an object containing the result set or false if failing to execute the query
            $statement = $conn->query($get_fields);

            if($statement == false) {
                $isError = true;
                $errorMessage = "Dabase couldn't be reached";
            }
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();

            }catch (PDOException $e){
            // report error message
            echo $e->getMessage();
            }
            require "main_fields.php"; 
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>