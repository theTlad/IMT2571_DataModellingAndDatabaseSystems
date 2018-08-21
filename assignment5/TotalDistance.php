<?php
#CLASS - TotalDistance: Contains the attributes of the TotalDistance- relation in the DB w/ constructor.
class TotalDistance {
	public $userName;
	public $totDist;
	public $fallYear;

	public function __construct($userName, $totDist, $fallYear) {  
        $this->userName = $userName;
        $this->totDist = $totDist;
	$this->fallYear = $fallYear;
    } 

	#Displays the object's data to the console.
	public function display() {
		echo $this->userName . ", " . $this->totDist . ", " . $this->fallYear . "\n";
	}
}
?>
