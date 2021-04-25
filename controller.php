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

$showError = false;
$errorMessage = "";

try {
    $conn = new PDO($dsn);

} catch (PDOException $e) {
    $showError = true;
    $errorMessage = $e->getMessage();
}

$isApiCorrect = isset($_GET["apikey"]) && in_array($_GET["apikey"], $apikeys);

$showStatus = isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "Get Fields";

if($isApiCorrect && !$showError) {
    $close = function($st) {
        $st->closeCursor();
    };

    $execute = function ($sql) use(&$conn, &$showError, &$errorMessage) {
        
        try{
            $statement = $conn->query($sql);

            if(!$statement) {
                $showError = true;
                $errorMessage = "Dabase couldn't be reached";
                return null;
            } else {
                return $statement;
            }

        }catch (PDOException $e){
            $showError = true;
            // report error message
            $errorMessage = $e->getMessage();
            return null;
        }
    };

    if(isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "Add Fields") {
        
        $numberOfTrees = $_POST['numberOfTrees'];
        $ageOfTrees = $_POST['ageOfTrees'];
        
        $sql = "insert into \"Fields\" (\"NumberOfTrees\", \"AgeOfTrees\")
        values ('$numberOfTrees', '$ageOfTrees')"; 

        $close($execute($sql));        
    }

    if(isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "Save Fields") {

        $numberOfTrees = $_POST['numberOfTrees'];
        $ageOfTrees = $_POST['ageOfTrees'];
        $fieldID = $_POST['fieldID'];

        $sql = "update \"Fields\" 
        set \"NumberOfTrees\" = $numberOfTrees,
        \"AgeOfTrees\" = $ageOfTrees
        where id = $fieldID"; 

        $close($execute($sql));  
    }

    if(isset($_POST["delete"])) {
        $fieldID = $_POST['fieldID'];

        $sql = "delete from \"Fields\" 
        where id = $fieldID";

        $close($execute($sql)); 
    }

    // get all fields
    $sql = "select * 
    from (select * from \"Fiel\" f order by \"id\" desc limit 8) as foo
    order by \"id\" asc;";


    // returns an object containing the result set or false if failing to execute the query
    $statement = $execute($sql);
    if($statement != null) {
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $close($statement);
    }
}