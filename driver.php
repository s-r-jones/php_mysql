<?php
/** class representing a driver
 *
 * this class represents the the driver of the car
 * 
 * @author Sam Jones
 **/

class Driver
{
    /**
     * birthday of driver
     **/
    protected $birthday;
    /**
     *license number, also the primary key
     */
    protected $licenseNo;
    /**
     *name of the driver
     */
    protected $name;
    
    /**
     *constructor method for Driver
     *
     *@param string new value of birthday
     *@param string value for License Number
     *@param stribng value of name
     *@throws RuntimeException if there are invalid inputs 
     *
     **/
    
    public function __construct($newLicenseNo, $newBirthday , $newName)
    {
        try
        {
        $this->setLicenseNo($newLicenseNo);
        $this->setBirthday($newBirthday);
        $this->setName($newName); 
        }
        catch(RuntimeException $exception)
        {
            throw(new RuntimeException("Unable to build car, 0, $exception"));
        }
    }
    
    /**
    * accessor method for birthday
    *
    * @return string value for birthday
    **/
    
    public function getBirthday()
    {
        return ($this->birthday);
    }
        
    /**
     * mutator method for birthday
     *
     * @param mixed DateTime object, mySQL date string, or null
     * @throws InvalidArgumentExcpetion if the input is none of those
     **/
    public function setBirthday($newBirthday)
    {
        // if the input is a DateTime object, just assign it
        if(gettype($newBirthday) === "object")
        {
            // ensure this is a DateTime first!
            if(get_class($newBirthday) === "DateTime")
            {
                $this->dateRigged = $newBirthday;
                return;
            }
            else
            {
                throw(new InvalidArgumentException("Invalid object, expected type DateTime but got " . get_class()));
            }
        }

        // if the input is string, parse the date
        $newBirthday = htmlspecialchars($newBirthday);
        $newBirthday = trim($newBirthday);
        $dateTime = DateTime::createFromFormat("Y-m-d H:i:s", $newBirthday);

        if($dateTime === false)
        {
            throw(new InvalidArgumentException("Invalid date detected: $newBirthday"));
        }

        // date sanitized; assign it
        $this->birthday = $dateTime;
    }
    
    /**
     * accessor method for licenseNo
     *
     * @return string value for licenseNo
     **/
    
    public function getLicenseNo()
    {
        return ($this->licenseNo);
    }
    
    /**
     *mutator method for licenseNo
     *
     *@param string new value of licenseNo 
     *@throws UnexpectedValueException if licenseNo is empty
     **/
    
    public function setLicenseNo($newLicenseNo)
    {
        //scrub for obvious trash
        $newLicenseNo = htmlspecialchars($newLicenseNo);
        $newLicenseNo = trim($newLicenseNo);
        
        //second, verify the variable still has something left
        if(empty($newLicenseNo) === true)
        {
            throw(new UnexpectedValueException("Invalid license number"));
        }
        
        // third, veriyf the the plate number matches regular expresion
        $newLicenseNo = strtoupper($newLicenseNo);
        if(preg_match("/^\d({9}$/", $newLicenseNo) !==1)
        {
            throw(new UnexpectedValueException("Invalid license number"));
        }
        
        // finally it's cleansed - assign the object
        $this->licenseNo = $newLicenseNo;
    }
    
    /**
    * accessor method for name
    *
    * @return string value for name
    **/
    
    public function getName()
    {
        return ($this->name);
    }
    
    /**
     *mutator method for name
     *
     *@param string new value of name 
     *@throws UnexpectedValueException if name is empty
     **/
    
    public function setName($newName)
    {
        //scrub for obvious trash
        $newName = htmlspecialchars($newName);
        $newName = trim($newName);
        
        //second, verify the variable still has something left
        if(empty($newName) === true)
        {
            throw(new UnexpectedValueException("Invalid name"));
        }
        
        // finally it's cleansed - assign the object
        $this->name = $newName;
    }
    
}

?>