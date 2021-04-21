<?php 

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
            <?php if(in_array($_GET["apikey"], $apikeys)) : ?>
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
            die("Error executing the query: $get_fields");
            }

            }catch (PDOException $e){
            // report error message
            echo $e->getMessage();
            }
            require "main_fields.php"; 
        }
        if(isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "Add Fields") {

            $numberOfTrees = $_POST['numberOfTrees'];
            $ageOfTrees = $_POST['ageOfTrees'];

            $statement->closeCursor();

            $add_field = "insert into \"Fields\" (\"NumberOfTrees\", \"AgeOfTrees\")
            values ('$numberOfTrees', '$ageOfTrees')"; 

            $statement = $conn->query($add_field);

            if($statement == false) {
                die("Error executing query: $add_field");
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
                die("Error executing query: $edit_field");
            }
        }

        if(isset($_POST["delete"])) {

            $fieldID = $_POST['fieldID'];

            $statement->closeCursor();

            $delete_field = "delete from \"Fields\" 
            where id = $fieldID"; 

            $statement = $conn->query($delete_field);

            if($statement == false) {
                die("Error executing query: $edit_field");
            }
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">

        removeApiForm();

        function removeApiForm() {
            const apiForm = document.getElementById('apiForm');
            const note = document.getElementById('note');
            const successMessage = document.getElementById('success');

            if(successMessage) {
                note.style.display = "none";
                apiForm.style.display = "none";
            }


        }

        function populatesFormFields(btn) {
            const buttonType = btn.innerText;
            const fieldsList = btn.parentElement.parentElement.getElementsByTagName("td");

            document.getElementById('fieldID').value = fieldsList[0].innerText
            document.getElementById('numbtrees').value = fieldsList[1].innerText            
            document.getElementById('agetrees').value = fieldsList[2].innerText            
        }


        

        function onIdClicked(idEl) {
            const deleteBtn = idEl.parentElement.querySelector('td:nth-of-type(5)').children[0].children[2]
            const hiddenFieldID = idEl.parentElement.querySelector('input')
       
            setFieldID(idEl);
            toggleBtn(deleteBtn);
        }

        function toggleBtn(btn) {
            if( btn.attributes.getNamedItem('disabled') !== null) {
                btn.attributes.removeNamedItem('disabled')
                btn.style.removeProperty('border-color')
                btn.style.removeProperty('color')
            } else {
                btn.setAttribute("disabled", "")
                btn.style.borderColor = "#d5a3a8"
                btn.style.color = "#b76870"
            }
        }

        function setFieldID(id) {
            const hiddenFieldID = id.parentElement.querySelector('input')
            hiddenFieldID.value = id.parentElement.querySelector('td:nth-of-type(1)').innerText
        }


        // function deleteRow() {

        //     axios.post('.', {
        //         fieldID: '',
        //         delete: 'Flintstone'
        //     })
        //     .then(function (response) {
        //         console.log(response);
        //     })
        //     .catch(function (error) {
        //         console.log(error);
        //     });
        // }
        // document.getElementById('test').parentElement.childNodes[8].children[0].children[2]
        
    </script>
</body>
</html>