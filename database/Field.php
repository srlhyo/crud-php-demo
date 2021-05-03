<?php
require_once "Model.php";

class Field extends Model {
     protected static $tableName = "Fields";
     // protected static $orderByColumn = "id";
     protected static $column = "fieldID";
     protected static $limit = "3";
     // protected static $selectAllRawSql = "select * from (select * from \"Fields\" f order by \"id\" desc limit 8) as foo order by \"id\" asc;";
}