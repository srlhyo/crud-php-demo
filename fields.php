<?php 

$apikeys = [
    "api"
];

// connect php to postgreSQL Database using PDO

$host='localhost';
$db = 'weathersafe';
$username = 'postgres';
$password = '';


$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";

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
        <h2 class="my-3">Your Form</h2>
        <form class="row g-3" method="POST">
            <div class="col-md-6">
                <label for="numbtrees" class="form-label">Number of trees</label>
                <input type="text" name="numberOfTrees" class="form-control" id="numbtrees">
            </div>
            <div class="col-md-6">
                <label for="agetrees" class="form-label">Age of trees</label>
                <input type="text" name="ageOfTrees" class="form-control" id="agetrees">
            </div>

            <input type="hidden" name="fieldID" id="fieldID">
            
            <div class="col-auto mt-3">
                <input type="submit" name="submit" class="btn btn-primary mb-3" value="Add Fields">
            </div>
            <div class="col-auto mt-3">
                <input type="submit" name="submit" class="btn btn-primary mb-3" value="Save Fields">
            </div>

        </form>
        <h2 class="my-3">The last 8 Fields</h2>
        <table id="mytable" class="table table-striped table-bordered" style="width:300px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NumberOfTrees</th>
                    <th>AgeOfTrees</th>
                    <th>Edit Rows</th>
                    <th>Delete Rows</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- When using pdo::fetch_assoc, the pdostatement returns an array indexed by column name  -->
                <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <td onClick="selectRow(this)"><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['NumberOfTrees']); ?></td>
                    <td><?php echo htmlspecialchars($row['AgeOfTrees']); ?>
                    <td><button onClick="populatesFormFields(this)" class="btn btn-outline-primary">Edit</button></td>
                    <td>
                        <form id="deleteBtnForm" method="post">
                            <input type="hidden" name="fieldID">
                            <input type="hidden" name="delete" value="delete">
                            <button type="submit" class="btn btn-outline-danger" style="border-color: #d5a3a8; color: #b76870;" disabled>Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    
    <?php
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

    <script type="text/javascript">

        function populatesFormFields(btn) {
            const buttonType = btn.innerText;
            const fieldsList = btn.parentElement.parentElement.getElementsByTagName("td");
            document.getElementById('fieldID').value = fieldsList[0].innerText
            document.getElementById('numbtrees').value = fieldsList[1].innerText            
            document.getElementById('agetrees').value = fieldsList[2].innerText            
        }

        function selectRow(btn) {
            console.log(btn)
            const hiddenFieldID = btn.parentElement.querySelector('input')
            const disabledBtn = btn.parentElement.querySelector('td:nth-of-type(5)').children[0].children[1]
            
            hiddenFieldID.value = btn.parentElement.querySelector('td:nth-of-type(1)').innerText
            console.log(btn.parentElement.querySelector('td:nth-of-type(1)').innerText)

            // true == exists
            if(disabledBtn.attributes.getNamedItem('disabled') !== null) {

                disabledBtn.attributes.removeNamedItem('disabled')
                disabledBtn.style.removeProperty('border-color')
                disabledBtn.style.removeProperty('color')
            } else {
                disabledBtn.setAttribute("disabled", "")
                disabledBtn.style.borderColor = "#d5a3a8"
                disabledBtn.style.color = "#b76870"
            }
        }
    </script>
</body>
</html>