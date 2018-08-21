<?php
#CLASS - Season: Contains the attributes of the Season- relation in the DB w/ constructor.
class Season {
	public $fallYear;

	public function __construct($fallYear) {  
        $this->fallYear = $fallYear;
    }

	#Displays the object's data to the console.
	public function display() {
		echo $this->fallYear . "\n";
    } 
}
?>
