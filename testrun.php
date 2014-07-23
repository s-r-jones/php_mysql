<?php
// require the class we are testing
require_once("mvd.php");

try
{
    // enalbe exception handling
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    //connect to mySQL
    $mysqli = new mysqli("localhost", "sports_samj", "abcd-1234", "sports_samj");
    
    // create a new car and insert it
    $car = new Car(null, "Volvo", "760");
    $car->insert($mysqli);
    echo "Inserted car id = " .$car->getId() . "<br/>";
    
    // clean up the mySQLi connection
    $mysqli->close();
    
}
catch(mysqli_sql_exception $exception)
{
    echo "Exception: " . $exception->getMessage();
}


?>