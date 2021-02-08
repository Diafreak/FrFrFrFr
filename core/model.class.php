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


    // Constructor
    public function __construct($newValues)
    {
        try
        {
            foreach ($this->schema as $key => $value)
            {
                if (isset($newValues[$key]))
                {
                    $this->setValue($key, $newValues[$key]);
                }
                else
                {
                    $this->setValue($key, null);
                }
            }
        }
        catch(\Exception $error)        //!!! CHANGE !!!
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


    public function setValue($key, $value)
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


    public function getValue($key)
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

        // $columnsString generates a string from the class-schema in which the insert-collums are stored
        // $valuesString  generates a string of the values that you want to insert
        // $sqlString combines $columnsString & $valuesString toa complete sql-insert-statement
        $valuesString  = "";
        $columnsString = "";

        foreach($this->schema as $key => $schemaOptions)   //??? values nötig ???          //$key           = id, createdAt, updatedAt...
        {                                                                                  //$schemaOptions = ["type"] => ... ["max"] => ...
            $columnsString .=       $key . ', ';
            $valuesString  .= ':' . $key . ', ';
        }

        //remove the last comma from the string
        $columnsString = rtrim($columnsString, ', ');
        $valuesString  = rtrim($valuesString,  ', ');


        $sqlString = "INSERT INTO `{$tableName}` (" . $columnsString . ') VALUES (' . $valuesString . ');';


        try
        {
            $insertStatement = $db->prepare($sqlString);

            foreach ($this->values as $key => $value)
            {
                //$insertStatement->bindParam(':'.$key, $value);        //"SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'email' cannot be null"
                //echo(':'.$key . " -> " . $value . "<br>");
                $insertStatement->bindParam(':id',           $this->values['id']);
                $insertStatement->bindParam(':createdAt',    $this->values['createdAt']);
                $insertStatement->bindParam(':updatedAt',    $this->values['updatedAt']);
                $insertStatement->bindParam(':email',        $this->values['email']);
                $insertStatement->bindParam(':passwordHash', $this->values['passwordHash']);
                $insertStatement->bindParam(':firstName',    $this->values['firstName']);
                $insertStatement->bindParam(':lastName',     $this->values['lastName']);
                $insertStatement->bindParam(':address_id',   $this->values['address_id']);
            }

            $insertStatement->execute();
        }
        catch (\PDOException $e)
        {
            die( 'Error inserting new User: ' . $e->GetMessage() );              //!!! CHANGE !!!
        }

    }



    // Destructor
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
    */
}


?>