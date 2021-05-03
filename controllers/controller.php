<?php

// api ==== api endpoints /// noface
$apikeys = [
    "api", 
    "api2"
];

$showError = false;
$errorMessage = "";


$isApiCorrect = isset($_GET["apikey"]) && in_array($_GET["apikey"], $apikeys);

$showStatus = isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "Get Fields";

if($isApiCorrect && !$showError) {

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

    $theSubmitedFormIsToDeleteAnObject = isset($_POST["delete"]);

    if($theSubmitedFormIsToDeleteAnObject) {
        $fieldID = $_POST['fieldID'];
        Field::delete($fieldID);
    }
    
    
    $data = Field::selectAll();
}