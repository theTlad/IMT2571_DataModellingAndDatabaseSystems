<?php
#CLASS - Club: Contains the attributes of the Club- relation in the DB w/ constructor.
class Club {
	public $clubId;
	public $clubName;
	public $city;
	public $county;

	public function __construct($clubId, $clubName, $city, $county) {  
        $this->clubId = $clubId;
        $this->clubName = $clubName;
	$this->city = $city;
	$this->county = $county;
    }

	#Displays the object's data to the console.
	public function display() {
		echo $this->clubId . ", " . $this->clubName . ", " . $this->city . ", " . $this->county . "\n";
    } 
}
?>
