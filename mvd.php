<?php
/** class representing a car
 *
 * this class represents a car and it's components for a car
 *
 * @author Sam Jones <bsamjones@gmail.com>
 **/

class Car
{
    /**
     * mySQL primary key for the car
     **/
    protected $id;
    /**
     *make of the car
     */
    protected $make;
    /**
     *model of the car
     */
    protected $model;
    
    /**
     *constructor method for car
     **/
    
    public function __construct($newId, $newMake, $newModel)
    {
        try
        {
         $this->setId($newId);
         $this->setMake($newMake);
         $this->setModel($newModel); 
        }
        catch(RuntimeException $exception)
        {
            throw(new RuntimeException("Unable to build car, 0, $exception"));
        }
    }
    
    /**
    * accessor method for id
    *
    * @return integer value for id
    **/
    
    public function getId()
    {
        return ($this->id);
    }
    
    
    /**
     * mutator method for id
     *
     * @param integer new value for id
     * @throws RangeException if id is negative
     * @throws UnexpectedValuesException if id is invalid
     **/
    public function setId($newId)
    {
        // allow id to be null (for new rows)
        if($newId === null)
        {
            $this->id = null;
            return;
        }
        
        //scrub for obvious trash, yo
        $newId = htmlspecialchars($newId);
        $newId = trim($newId);
        
        //second, verify it's numeric
        if(is_numeric($newId) === false)
        {
            throw(new UnexpectedValueException("Invalid ID: $newId"));
        }
        
        // third, convert it and verify it's range
        
        $newId = intval($newId);
        if($newId < 0)
        {
            throw(new RangeException("Invalid ID: $newId"));
        }
        
        // finally it's cleansed - assign the object
        
        $this->id = $newId;
    }
    
    /**
     * accessor method for make
     *
     * @return string value for make
     **/
    
    public function getMake()
    {
        return ($this->make);
    }
    
    /**
     *mutator method for make
     *
     *@param string new value of make 
     *@throws UnexpectedValueException if make is empty
     **/
    
    public function setMake($newMake)
    {
        //scrub for obvious trash
        $newMake = htmlspecialchars($newMake);
        $newMake = trim($newMake);
        
        //second, verify the variable still has something left
        if(empty($newMake) === true)
        {
            throw(new UnexpectedValueException("Invalid make"));
        }
        
        // finally it's cleansed - assign the object
        $this->make = $newMake;
    }
    
    /**
    * accessor method for 
    *
    * @return string value for model
    **/
    
    public function getModel()
    {
        return ($this->model);
    }
    
    /**
     *mutator method for model
     *
     *@param string new value of model 
     *@throws UnexpectedValueException if model is empty
     **/
    
    public function setModel($newModel)
    {
        //scrub for obvious trash
        $newModel = htmlspecialchars($newModel);
        $newModel = trim($newModel);
        
        //second, verify the variable still has something left
        if(empty($newModel) === true)
        {
            throw(new UnexpectedValueException("Invalid model"));
        }
        
        // finally it's cleansed - assign the object
        $this->model = $newModel;
    }
    
    
    /**
     *delete this car from mySQL
     *
     *@param resrouces pointer to mySQL connection by reference
     *@throws mysqli_sql_exception when mySQL errors occur
     **/
    
    public function delete(&$mysqli)
    {
        //handle degenerate cases
        if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
        {
           throw(new mysqli_sql_exception("not a mySQL object"));
        }
        
        // verify this a new object (where id !== null)
        if($this->getId() === null)
        {
           throw(new mysqli_sql_exception("Non new id detected"));
        }
        
        // create a query template
        $query = "DELETE FROM car WHERE id =?";
        
         // prepare the query statement
         $statement = $mysqli->prepare($query);
         if($statement === false)
         {
            throw(new mysqli_sql_exception("Unable to preapre statement"));
         }
         
         // bind parameters to the query template
         $wasClean = $statement->bind_param("i", $this->id);
         if($wasClean === false)
         {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
         }
         
         //execute the statement
         if($statement->execute() === false)
         {
            throw(new mysqli_sql_exception("Unable to execute statement"));
         }
         
     
    }
    
    /**
     *
     *inserts car into mySQL
     *
     *@param resources pointer to mySQLi connection, by reference
     *@throws mysqli_sql_exception when mySQL errors occur
     **/
    
    public function insert(&$mysqli)
    {
        //handle degenerate cases
        if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
        {
           throw(new mysqli_sql_exception("not a mySQL object"));
        }
        
        // verify this a new object (where id === null)
        if($this->getId() !== null)
        {
           throw(new mysqli_sql_exception("Non new id detected"));
        }
        
        // create a query template
        $query = "INSERT INTO car(make, model) VALUES (?, ?)";
        
        // prepare the query statement
        $statement = $mysqli->prepare($query);
        if($statement === false)
        {
           throw(new mysqli_sql_exception("Unable to preapre statement"));
        }
        
        // bind parameters to the query template
        $wasClean = $statement->bind_param("ss", $this->make, $this->model);
        if($wasClean === false)
        {
           throw(new mysqli_sql_exception("Unable to bind parameters"));
        }
        
        //execute the statement
        if($statement->execute() === false)
        {
           throw(new mysqli_sql_exception("Unable to execute statement"));
        }
        
        // update the id
        $this->setId($mysqli->insert_id);
        
        //free the statement
        $statement->close();
     
    }
    
    /**
     *update this Car in mySQL
     *
     *@param resources pointer to mySQLi connection by reference
     *@throws mysqli_sql_exception when mySQL errors occur
     **/
    public function update (&$mysqli)
    {
            //handle degenerate cases
         if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
         {
            throw(new mysqli_sql_exception("not a mySQL object"));
         }
         
         // verify this an existing object (where id !== null)
         if($this->getId() === null)
         {
            throw(new mysqli_sql_exception("Non new id detected"));
         }
              
        // create a query template
         $query = "UPDATE car SET id = ?, make = ? WHERE id =?";
            
         // prepare the query statement
         $statement = $mysqli->prepare($query);
         if($statement === false)
         {
            throw(new mysqli_sql_exception("Unable to preapre statement"));
         }
         
         // bind parameters to the query template
         $wasClean = $statement->bind_param("issi", $this->id, $this->make, $this->model, $this->id);
         if($wasClean === false)
         {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
         }
         
         //execute the statement
         if($statement->execute() === false)
         {
            throw(new mysqli_sql_exception("Unable to execute statement"));
         }
         
         //free the statement
         $statement->close();
     
    }
    
    /**
     *retreives a Car from mySQL based on id
     *
     *@param resources pointer to mySQLi connection by reference
     *@param integer id to search for
     *@throws mysqli_sql_exception when mySQL errors occur
     **/
    
    public static function getCarById(&$mysqli, $id)
    {
        //handle degenerate cases
         if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
         {
            throw(new mysqli_sql_exception("not a mySQL object"));
         }
         
        // handle degenerate cases: bad id
        if(is_numeric($id) === false)
        {
            throw(new mysqli_sql_exception("Non numeric id detected"));
        }
        
        
        // finalize the sanitation on the id
        $id = trim($id);
        $id = intval($id);
        
        // create a query template
         $query = "SELECT id, make, model FROM car WHERE id = ?";
            
         // prepare the query statement
         $statement = $mysqli->prepare($query);
         if($statement === false)
         {
            throw(new mysqli_sql_exception("Unable to preapre statement"));
         }
         
         // bind parameters to the query template
         $wasClean = $statement->bind_param();
         if($wasClean === false)
         {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
         }
         
         //execute the statement
         if($statement->execute() === false)
         {
            throw(new mysqli_sql_exception("Unable to execute statement"));
         }
         
         // get the result and make and make sure we only get 1 row
         $result = $statement->get_result();
         if($result === false || $result->num_rows !==1)
         {
            throw(new mysqli_sql_exception("No result found for $id"));
         }
         
         // fetch the row we got from mySQL
         $row = $result->fetch_assoc();
         
         // create an object out of it
         $car = new Car($row["id"], $row["make"], $row["model"]);
         
         // free the result
         $result->free();
         
         //close the statement
         $statement->close;
         
         //return the object
         return($car);
    }
    
    /**
     *retreives Cars based on make
     *@param resources pointer to mySQLi connections by reference
     *@param strong make to search for
     *@return mixed array of results or single results
     *@throws mysql_SQL_exception when errors occur
     **/
    
    public static function getCarByMake(&$mysqli, $make)
    {
        //handle degenerate cases: bad mySQL pointer
         if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
         {
            throw(new mysqli_sql_exception("not a mySQL object"));
         }
         
        // handle degenerate cases: nonsensical make
        $make = htmlspecialchars($make);
        $make = trim($make);
        if(empty($make) === true)
        {
            throw(new mysqli_sql_exception("Invalid make exception detected"));
        }
        
        // create a query template
         $query = "SELECT id, make, model FROM car WHERE make = ?";
            
         // prepare the query statement
         $statement = $mysqli->prepare($query);
         if($statement === false)
         {
            throw(new mysqli_sql_exception("Unable to preapre statement"));
         }
         
         // bind parameters to the query template
         $wasClean = $statement->bind_param("s", $make);
         if($wasClean === false)
         {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
         }
         
         //execute the statement
         if($statement->execute() === false)
         {
            throw(new mysqli_sql_exception("Unable to execute statement"));
         }
         
         // validate the result set
         $result = $statement->get_result();
         if($result === flase || $result->num_rows === 0)
         {
            throw(new mysqli_sql_exception("Empty results set"));
         }
         
         // loop through the results set
         $resultSet = array();
         while(($row = $result->fetch_assoc()) !== null)
         {
            $nextCar = new Car($row["id"], $row["make"], $row["model"]);
            $result[] = $nextCar;
         }
         
        // free the result
        $result->free();
        
        // close the statement
        $statement->close();
        
        //if we get only one result return the single iten
        if(count($resultSet) === 1)
        {
            return($resultSet[0]);
        }
        
        //if we get mutliple results just return the array
        if(count($resultSet) > 1)
        {
            return($resultSet);
        }
    }
  
}

?>