<?php
// models which Fields can be instantiated from
require_once "Database.php";

class Model extends Database {
    protected static $tableName = null;
    protected static $limit = null;
    protected static $orderByColumn = null;
    protected static $selectAllRawSql = null;
    protected static $fieldID = null;

    public static function selectAll()
    {    
        $sql = static::generateRawSql_selectAll();
        return static::exec($sql);
    }

    private static function generateRawSql_selectAll() {
        $tableName = static::getTableName();
        $orderByColumn = static::getorderByColumn();
        $limit = static::getLimit();
        return static::$selectAllRawSql ?? "select * from \"$tableName\" order by \"$orderByColumn\" limit $limit";
    }

    public static function delete($toBeSearchedBy)
    {
        $sql = static::generateRawSql_deleteWhere();
        static::execute($sql,[$toBeSearchedBy]);
        return null;
    }

    private static function generateRawSql_deleteWhere()
    {
        $column = static::getColumn();
        $tableName = static::getTableName();
        return "DELETE FROM \"$tableName\" where \"$column\" = ? ";
    }

    private static function getColumn()
    {
        return "id";
    }

    private static function getTableName() {
        return static::$tableName ?? static::class; 
    }

    private static function getLimit() {
        return static::$limit ?? 8;
    }

    private static function getorderByColumn() {
        return static::$orderByColumn ?? "id";
    }
}

