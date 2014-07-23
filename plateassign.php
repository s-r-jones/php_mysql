<?php
/**
 *class representing a plate assignmnet
 *
 *this is a week entity for the m- to -n relationship from car to plate.
 *it contains the foreign key for both.
 *
 *@see Car
 *@see Plate
 *@author sam jones <bsamjones@gmail.com>
 **/

 Class PlateAssignment
 {
    /**
     * id of the car
     **/
    
    protected $carId;
    
      /**
     * license plate number
     **/
    
    protected $plateNo;
    
    /**
     *constructor method for plateAssignmnet
     *
     *@param integer value for car id
     *@param string value of license no
     *@throws RuntimeException if there are invalid inputs 
     *
     **/
    
    public function __construct($newCardId, $newPlateNo)
    {
        try
        {
        $this->setCardId($newCardId);
        $this->setPlateNo($newPlateNo);
        }
        catch(RuntimeException $exception)
        {
            throw(new RuntimeException("Unable to build car, 0, $exception"));
        }
    }
    
    /**
    * accessor method for carId
    *
    * @return integer value for carId
    **/
    
    public function getCarId()
    {
        return ($this->carId);
    }
    
    
    /**
     * mutator method for carId
     *
     * @param integer new value for carId
     * @throws RangeException if carId is negative
     * @throws UnexpectedValuesException if carId is invalid
     **/
    public function setCarId($newCarId)
    {
        
        //scrub for obvious trash, yo
        $newCarId = htmlspecialchars($newCarId);
        $newCarId = trim($newCarId);
                
        //second, verify it's numeric
        if(is_numeric($newCarId) === false)
        {
            throw(new UnexpectedValueException("Invalid car id: $newCarId"));
        }
        
        // third, convert it and verify it's range
        
        $newCarId = intval($newCarId);
        if($newCarId < 0)
        {
            throw(new RangeException("Invalid car id: $newCarId"));
        }
        
        // finally it's cleansed - assign the object
        
        $this->carId = $newCarId;
    }
    
    /**
     * accessor method for plateNo
     *
     * @return string value for plateNo
     **/
    
    public function getPlateNo()
    {
        return ($this->plateNo);
    }
    
    /**
     *mutator method for plateNo
     *
     *@param string new value of plateNo 
     *@throws UnexpectedValueException if plateNo is empty
     **/
    
    public function setPlateNo($newPlateNo)
    {
        //scrub for obvious trash
        $newPlateNo = htmlspecialchars($newPlateNo);
        $newPlateNo = trim($newPlateNo);
        
        //second, verify the variable still has something left
        if(empty($newPlateNo) === true)
        {
            throw(new UnexpectedValueException("Invalid plate number"));
        }
        
        // third, veriyf the the plate number matches regular expresion
        $newPlateNo = strtoupper($newPlateNo);
        if(preg_match("/^[\dA-Z]({1-,7}$/", $newPlateNo) !==1)
        {
            throw(new UnexpectedValueException("Invalid plate number"));
        }
        
        // finally it's cleansed - assign the object
        $this->plateNo = $newPlateNo;
    }
    
 }
