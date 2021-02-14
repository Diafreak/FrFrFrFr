<?php


abstract class Model
{
    // types for the schema
    const TYPE_STRING  = 'string';
    const TYPE_INT     = 'int';
    const TYPE_UINT    = 'uint';
    const TYPE_DECIMAL = 'dec';
    const TYPE_DATE    = 'date';



    // =====================
    // ===== VARIABLES =====
    // =====================

    protected $schema = [];
    private   $values = [];



    // =======================
    // ===== CONSTRUCTOR =====
    // =======================

    // gets an associative array $newValues and inserts the gives values in the $values-array of the class,
    // but only if the key of $newValues exist in the $schema of the created class
    public function __construct($newValues = [])
    {
        try
        {
            // loop through the schema of the created class
            foreach ($this->schema as $key => $value)
            {
                // if the key from $newValues exists in the $schema
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
        catch(\Exception $error)                                            //!!! CHANGE !!!
        {
            print_r($error);
            exit(1);
        }
    }



    // =============================
    // ===== GENERAL FUNCTIONS =====
    // =============================

    public static function tablename()
    {
        $class = get_called_class();

        if(defined($class.'::TABLENAME'))
        {
            return $class::TABLENAME;
        }

        return null;
    }



    // =========================
    // ===== SQL FUNCTIONS =====
    // =========================

    public function insert()
    {
        $db        = $GLOBALS['db'];
        $tableName = self::tablename();

        // $columnsString  generates a string from the class-schema in which the insert-collums are stored
        // $valuesString   generates a string of the values that you want to insert
        // $sqlString      combines $columnsString & $valuesString toa complete sql-insert-statement
        $valuesString  = "";
        $columnsString = "";

        foreach($this->schema as $key => $schemaOptions)
        {
            $columnsString .=       $key . ', ';
            $valuesString  .= ':' . $key . ', ';
        }

        // remove the last comma from the strings
        $columnsString = rtrim($columnsString, ', ');
        $valuesString  = rtrim($valuesString,  ', ');

        $sqlString = "INSERT INTO `{$tableName}` (" . $columnsString . ') VALUES (' . $valuesString . ');';

        try
        {
            $insertStatement = $db->prepare($sqlString);

            // bind each value from the $values-array to its related placeholder in the insertStatement
            foreach ($this->schema as $key => $value)
            {
                if ($this->values === null)
                {
                    $insertStatement->bindParam(":{$key}", null);
                }
                else
                {
                    $insertStatement->bindParam(":{$key}", $this->values[$key]);
                }
            }

            // execute the insert-statement
            $insertStatement->execute();
        }
        catch (\PDOException $e)
        {
            echo('Error inserting new ' . SELF::tablename() . ': ' . $e->GetMessage() );              //!!! CHANGE-Redirect to 404? !!!
        }

    }



    // ======================
    // ===== DESTRUCTOR =====
    // ======================

    public function __destruct()
    {
        $schema = null;
        $values = null;
    }



    // ===========================
    // ===== SETTER & GETTER =====
    // ===========================

    public function setValue($key, $value)
    {
        // check if the given key is in the schema
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
        // check if the given key is in the schema
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



    // ===========================
    // ===== SETTER & GETTER =====
    // ===========================
    public function getSchema()
    {
        return $this->schema;
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