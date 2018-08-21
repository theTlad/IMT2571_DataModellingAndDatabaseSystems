<?php

include_once("Skier.php");
include_once("Club.php");
include_once("Season.php");
include_once("Representing.php");
include_once("TotalDistance.php");



class RelDB {

	protected $db = null;
	protected $skierlist = array();
	protected $clublist = array();
	protected $seasonlist = array();
	protected $replist = array();
	protected $totlist = array();

	#
	#CONSTRUCTOR: Connects to the database with PDO.
	#
	public function __construct() {

		if ($this->db) {
			$this->db = $db;
		} else {

		#Connects a new PHP Document Object to the DB hosted at the localhost (on a Ubuntu 16.04 operating system).
		try {
	  	$this->db = new PDO('mysql:host=localhost; dbname=assignment5; unix_socket=/opt/lampp/var/mysql/mysql.sock; charset=utf8', 'root', '', 
	        	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		} catch(PDOException $e) {
	    		echo "Something went wrong: " . $e->getMessage() . "\n";
			}
		}
	}

#
#FUNCTION: Inserts the Skier- elements into the database.
#
public function insertSkier($skier) {
  try {
	$stmt = $this->db->prepare('INSERT INTO Skier (userName, firstName, lastName, yearOfBirth)'
				    . 'VALUES(:userName, :firstName, :lastName, :yearOfBirth)');
	$stmt->bindValue(':userName', $skier->userName);
	$stmt->bindValue(':firstName', $skier->firstName);
	$stmt->bindValue(':lastName', $skier->lastName);
        $stmt->bindValue(':yearOfBirth', $skier->yearOfBirth);
	$stmt->execute();
      } catch(PDOException $e) {
	  throw $e;
   }
}	

#
#FUNCTION: Inserts the Club- elements into the database.
#
public function insertClub($club) {
  try {
	$stmt = $this->db->prepare('INSERT INTO Club (clubId, clubName, city, county)'
				    . 'VALUES(:clubId, :clubName, :city, :county)');
	$stmt->bindValue(':clubId', $club->clubId);
	$stmt->bindValue(':clubName', $club->clubName);
	$stmt->bindValue(':city', $club->city);
        $stmt->bindValue(':county', $club->county);
	$stmt->execute();
      } catch(PDOException $e) {
	  throw $e;
   }
}


#
#FUNCTION: Inserts the Season- elements into the database.
#
public function insertSeason($season) {
  try {
	$stmt = $this->db->prepare('INSERT INTO Season(fallYear) VALUES(:fallYear)');
	$stmt->bindValue(':fallYear', $season->fallYear);
	$stmt->execute();
      } catch(PDOException $e) {
	  throw $e;
   }
}


#
#FUNCTION: Inserts the Season- elements into the database.
#
public function insertRepresenting($rep) {
  try {
	$stmt = $this->db->prepare('INSERT INTO Representing(userName, clubId, fallYear)' 
				   . 'VALUES(:userName, :clubId, :fallYear)');
	$stmt->bindValue(':userName', $rep->userName);
	$stmt->bindValue(':clubId', $rep->clubId);
	$stmt->bindValue(':fallYear', $rep->fallYear);
	$stmt->execute();
      } catch(PDOException $e) {
	  throw $e;
   }
}


#
#FUNCTION: Inserts the TotalDistance- elements into the database.
#
public function insertTotalDistance($tot) {
  try {
	$stmt = $this->db->prepare('INSERT INTO TotalDistance(userName, totDist, fallYear)' 
				   . 'VALUES(:userName, :totDist, :fallYear)');
	$stmt->bindValue(':userName', $tot->userName);
	$stmt->bindValue(':totDist', $tot->totDist);
	$stmt->bindValue(':fallYear', $tot->fallYear);
	$stmt->execute();
      } catch(PDOException $e) {
	  throw $e;
   }
}

#
#FUNCTION: Retrieves all the information stored in the database.
#
public function query() {

	#Retrieves all the tuples in the Skier- relation from the DB.
	try {
		foreach ($this->db->query('SELECT * FROM Skier') as $row) {
			array_push($this->skierlist, new Skier($row['userName'], $row['firstName'], $row['lastName'], $row['yearOfBirth']));
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage() . "\n";
		}

	#Retrieves all the tuples in the Club- relation from the DB.
	try {
		foreach ($this->db->query('SELECT * FROM Club') as $row) {
			array_push($this->clublist, new Club($row['clubId'], $row['clubName'], $row['city'], $row['county']));
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage() . "\n";
		}

	#Retrieves all the tuples in the Season- relation from the DB.
	try {
		foreach ($this->db->query('SELECT * FROM Season') as $row) {
			array_push($this->seasonlist, new Season($row['fallYear']));
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage() . "\n";
		}

	#Retrieves all the tuples in the Representing- relation from the DB.
	try {
		foreach ($this->db->query('SELECT * FROM Representing') as $row) {
			array_push($this->replist, new Representing($row['userName'], $row['clubId'], $row['fallYear']));
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage() . "\n";
		}

	#Retrieves all the tuples in the TotalDistance- relation from the DB.
	try {
		foreach ($this->db->query('SELECT * FROM TotalDistance') as $row) {
			array_push($this->totlist, new TotalDistance($row['userName'], $row['totDist'], $row['fallYear']));
		}
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage() . "\n";
		}
	}


#
#FUNCTION: Displays all the information to the console.
#
public function display() {
	#Displays all the tuples in the Skier- relation to the console.
	if ($this->skierlist) {
        	echo "\n\n\t< SKIER >\n";
        	echo "userName     firstName lastName    yearOfBirth\n";
		echo "---------------------------------------------\n";
		foreach ($this->skierlist as $skier) {
			$skier->display();
			}
		}

	#Displays all the tuples in the Club- relation to the console.
	if ($this->clublist) {
        	echo "\n\n\t< CLUB >\n";
        	echo "clubId\tclubName\tcity\tcounty\n";
		echo "---------------------------------------------\n";
		foreach ($this->clublist as $club) {
			$club->display();
			}
		}

	#Displays all the tuples in the Season- relation to the console.
	if ($this->seasonlist) {
        	echo "\n\n\t< SEASON >\n";
        	echo "fallYear\n";
		echo "---------------------------------------------\n";
		foreach ($this->seasonlist as $season) {
			$season->display();
			}
		}

	#Displays all the tuples in the Representing- relation to the console.
	if ($this->replist) {
        	echo "\n\n\t< REPRESENTING >\n";
        	echo "userName\tclubId\tfallYear\n";
		echo "---------------------------------------------\n";
		foreach ($this->replist as $rep) {
			$rep->display();
			}
		}

	#Displays all the tuples in the TotalDistance- relation to the console.
	if ($this->totlist) {
        	echo "\n\n\t< TOTAL_DISTANCE >\n";
        	echo "userName\ttotDist\tfallYear\n";
		echo "---------------------------------------------\n";
		foreach ($this->totlist as $tot) {
			$tot->display();
			}
		}
	}
}

?>
