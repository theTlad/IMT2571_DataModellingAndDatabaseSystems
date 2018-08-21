<?php
#CLASS - Representing: Contains the attributes of the Representing- relation in the DB w/ constructor.
class Representing {
	public $userName;
	public $clubId;
	public $fallYear;

	public function __construct($userName, $clubId, $fallYear) {  
        $this->userName = $userName;
        $this->clubId = $clubId;
	$this->fallYear = $fallYear;
    } 

	#Displays the object's data to the console.
	public function display() {
		echo $this->userName . ", " . $this->clubId . ", " . $this->fallYear . "\n";
	}
}
?>
