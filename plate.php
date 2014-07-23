<?php
/** clas representing a car
 *
 * this class represents the license plate
 * which can have non-ascii symbolson their plates
 * 
 * @author Sam Jones
 **/

class Plate
{
    /**
     * owner id of the owner of this plate
     **/
    protected $ownerId;
    /**
     *plate number, also the primary key
     */
    protected $plateNo;
    /**
     *year of the car
     */
    protected $year;
    
    /**
     *constructor method for Plate
     *
     *@param string new value of Plate NO
     *@param integer value for Owner Id
     *@param integer value of year
     *@throws RuntimeException if there are invalid inputs 
     *
     **/
    
    public function __construct($newPlateNo, $newOwnerId , $newYear)
    {
        try
        {
        $this->setPlateNo($newPlateNo);
        $this->setOwnerId($newOwnerId);
        $this->setYear($newYear); 
        }
        catch(RuntimeException $exception)
        {
            throw(new RuntimeException("Unable to build car, 0, $exception"));
        }
    }
    
    /**
    * accessor method for ownerId
    *
    * @return string value for ownerId
    **/
    
    public function getOwnerId()
    {
        return ($this->ownerId);
    }
    
    
    /**
     * mutator method for ownerId
     *
     * @param integer new value for ownerId
     * @throws RangeException if ownerId is negative
     * @throws UnexpectedValuesException if ownerId is invalid
     **/
    public function setownerId($newOwnerId)
    {
        
        //scrub for obvious trash, yo
        $newOwnerId = htmlspecialchars($newOwnerId);
        $newOwnerId = trim($newOwnerId);
        
        //second, verify it's numeric
        if(is_numeric($newOwnerId) === false)
        {
            throw(new UnexpectedValueException("Invalid ID: $newOwnerId"));
        }
        
        // third, convert it and verify it's range
        
        $newOwnerId = intval($newOwnerId);
        if($newOwnerId < 0)
        {
            throw(new RangeException("Invalid ID: $newOwnerId"));
        }
        
        // finally it's cleansed - assign the object
        
        $this->ownerId = $newOwnerId;
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
    
     /**
    * accessor method for year
    *
    * @return string value for year
    **/
    
    public function getYear()
    {
        return ($this->year);
    }
    
    
    /**
     * mutator method for year
     *
     * @param integer new value for year
     * @throws RangeException if year is < 1900
     * @throws UnexpectedValuesException if year is invalid
     **/
    public function setYear($newYear)
    {
        
        //scrub for obvious trash, yo
        $newYear = htmlspecialchars($newYear);
        $newYear = trim($newYear);
        
        //second, verify it's numeric
        if(is_numeric($newYear) === false)
        {
            throw(new UnexpectedValueException("Invalid Year: $newYear"));
        }
        
        // third, convert it and verify it's range
        
        $newYear = intval($newYear);
        if($newYear < 1900 || $newYear > 2050)
        {
            throw(new RangeException("Invalid Year: $newYear"));
        }
        
        // finally it's cleansed - assign the object
        
        $this->year = $newYear;
    }
    
}

?>