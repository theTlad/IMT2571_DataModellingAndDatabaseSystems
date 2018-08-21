<?php
#CLASS - Skier: Contains the attributes of the Skier- relation in the DB w/ constructor.
class Skier {
	public $userName;
	public $firstName;
	public $lastName;
	public $yearOfBirth;

	public function __construct($userName, $firstName, $lastName, $yearOfBirth) {  
        $this->userName = $userName;
        $this->firstName = $firstName;
	$this->lastName = $lastName;
	$this->yearOfBirth = $yearOfBirth;
	}

	#Displays the object's data to the console.
	public function display() {
		echo $this->userName . ", " . $this->firstName . ", " . $this->lastName . ", " . $this->yearOfBirth . "\n";
    } 
}
?>
