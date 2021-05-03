<?php
    try {
        $env = require "../env.php";
        require "../database/Database.php";
        Database::initialize($env["dbconnection"]);
        require "../database/Field.php";
        include "../controllers/controller.php";
        include "layout.php";
    } catch(\Exception $e) {
        if($env["environment"] == "dev") {
            echo $e->getMessage();
        } else {
            echo "There was a problem. Please contact support!";
        }
    }
?>