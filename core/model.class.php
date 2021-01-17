<?php


abstract class Model
{
    // types for the schema
    const TYPE_STRING  = 'string';
    const TYPE_INT     = 'int';
    const TYPE_UINT    = 'uint';
    const TYPE_DECIMAL = 'dec';
    const TYPE_DATE    = 'date';

    protected $schema = [];

    private $values = [];


    //constructor
    public function __construct($values)        //was muss hier übergeben werden???
    {
        try
        {
            foreach($this->schema as $key => $value)
            {
                if(isset($values[$key]))
                {
                    $this->$key = $values[$key];
                }
                else
                {
                    $this->$key = null;
                }
            }
            
        }
        catch(\Exception $error)
        {
            print_r($error);
            exit(1);
        }
    }


    public static function tablename()
    {
        $class = get_called_class();

        if(defined($class.'::TABLENAME'))
        {
            return $class::TABLENAME;
        }

        return null;
    }


    public function __set($key, $value)
    {
        //is the given key in the schema?
        if(isset($this->schema[$key]))
        {
            $this->values[$key] = $value;
        }
        else
        {
            $className = get_called_class();
            throw new \Exception(`${key} does not exists in this class ${className}`);
        }
    }


    public function __get($key)
    {
        //is the given key in the schema?
        if(isset($this->schema[$key]))
        {
            return $this->values[$key];
        }
        else
        {
            $className = get_called_class();
            throw new \Exception(`${key} does not exists in this class ${className}`);
        }
    }



    public function insert()
    {
        $db        = $GLOBALS['db'];
        $tableName = self::tablename();

        //$sqlString    generates a string from the class-schema in which the insert-collums are stored
        //$valuesString generates a string of the values that you want to insert
        $sqlString    = "INSERT INTO `{$tableName}` (";
        $valuesString = "";

        foreach($this->schema as $key => $values)   //??? values nötig ???          //key     = id, createdAt, updatedAt...
        {                                                                           //$values = ["type"] => ... ["max"] => ...
            //echo('key:' . $key . '<br>');
            echo('values: '); var_dump($values); echo('<br>');

            $sqlString .= $key . ',';
            $valuesString .= $key . ',';
        }

        //remove the last comma from the string
        $sqlString    = rtrim($sqlString,    ',');
        $valuesString = rtrim($valuesString, ',');


        $sqlString = $sqlString . ') VALUES (' . $valuesString . ');';
        echo($sqlString);
    }



    //destructor
    public function __destruct()
    {
        $schema = null;
        $values = null;
    }


    /*
    public static function find($whereStr = '1')
    {
        $db = $GLOBALS['db'];
        $sqlStr = 'SELECT * FROM `'.self::tablename().'` WHERE '.$whereStr.';';
        $results = [];
        try
        {
            $results = $db->query($sqlStr)->fetchAll();
            $count = count($results);
            for ($i=0; $i < $count; ++$i)
            { 
                $class = get_called_class();
                $results[$i] = new $class($results[$i]);
            }
        }
        catch(\PDOException $error)
        {
            print_r($error);
        }

        return $results;
    }


    public static function findOne($whereStr = '1')
    {
        $results = self::find($whereStr);

        if(count($results) > 0)
        {
            return $results[0];
        }

        return null;
    }


    public function insert()
    {
        $db = $GLOBALS['db'];
        $tableName = self::tablename();
        $sqlStr = "INSERT INTO `${tableName}` (";
        $valuesStr = "(";
        foreach($this->schema as $key => $value)
        {
            $sqlStr.=$key.',';
            $valuesStr.=':'.$key.',';
        }

        $sqlStr = rtrim($sqlStr, ',');
        $valuesStr = rtrim($valuesStr, ',');

        $sqlStr = $sqlStr.') VALUES '.$valuesStr.');';

        try
        {
            $stmt=$db->prepare($sqlStr);
            $stmt->execute($this->values);
            $this->id = $db->lastInsertId();
        }
        catch(\PDOException $e)
        {
            print_r($e);
        }
    }

    public function update(){}

    public function destroy(){}
    */
}


?>