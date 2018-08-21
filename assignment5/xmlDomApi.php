<?php

include_once("Skier.php");
include_once("Club.php");
include_once("Season.php");
include_once("Representing.php");
include_once("TotalDistance.php");

class XmlDomApi {

#
#Returns the length of a element specified in the XPath ($xp), if any.
#
function findLength($docUrl, $xp) {
    $doc = new DOMDocument();
    if (!$doc->load($docUrl)) {
      echo "FAILURE - Could not load the XML- file.\n\n";
    }
    else {
      $xpath = new DOMXpath($doc);
      $elements = $xpath->query($xp);
      return $elements->length;
    }
}

#
#Returns one Skier- element (userName, firstName, lastName, yearOfBirth).
#
function processSkier($docUrl, $i) {
    $Skier = null;
    $userName = $firstName = $lastName = $yearOfBirth = "";
    #Creates and loads the DOM. If not successful, the rest of the code is not executed.
    $doc = new DOMDocument();
    if (!$doc->load($docUrl)) {
        echo "FAILURE - Could not load the XML- file.\n";
    } else {
	#        
	#Find the i-th Skier element with XPath.
        $xpath = new DOMXpath($doc);
        $skier = $xpath->query("/SkierLogs/Skiers/Skier")[$i];
	#	
	#The following code is exectued if a skier was successfully returned from the Xpath- query.
	if ($skier) {
		$userName = $skier->getAttribute('userName');
		$children = $skier->childNodes;
		#Extracts each child- node from the Skier.
		#Process every odd number in the iteration, because empty children (carriage returns)
		# are located at the even numbers.
		for ($i = 1; $i < $children->length; $i += 2) {
			$child = $children->item($i);
			switch($i) {
			  case 1: $firstName = $child->nodeValue; break;
			  case 3: $lastName = $child->nodeValue; break;
			  case 5: $yearOfBirth = $child->nodeValue; break;
			}
		}		
          }

	 return $Skier = new Skier($userName, $firstName, $lastName, $yearOfBirth);
	}	
   }

#
#Returns one Club- element (clubId, clubName, city, county).
#
function processClub($docUrl, $i) {
    $Club = null;
    $clubId = $clubName = $city = $county = "";
    #Creates and loads the DOM. If not successful, the rest of the code is not executed.
    $doc = new DOMDocument();
    if (!$doc->load($docUrl)) {
        echo "FAILURE - Could not load the XML- file.\n";
    } else {
	#        
	#Find the i-th Club element with XPath.
        $xpath = new DOMXpath($doc);
        $club = $xpath->query("/SkierLogs/Clubs/Club")[$i];
	#	
	#The following code is exectued if a club was successfully returned from the Xpath- query.
	if ($club) {
		$clubId = $club->getAttribute('id');
		$children = $club->childNodes;
		#Extracts each child- node from the Club.
		#Process every odd number in the iteration, because empty children (carriage returns)
		# are located at the even numbers.
		for ($i = 1; $i < $children->length; $i += 2) {
			$child = $children->item($i);
			switch($i) {
			  case 1: $clubName = $child->nodeValue; break;
			  case 3: $city = $child->nodeValue; break;
			  case 5: $county = $child->nodeValue; break;
			}
		}		
          }

	}
	return $Club = new Club($clubId, $clubName, $city, $county);	
   }


#
#Returns one Season- element (fallYear).
#
function processSeason($docUrl, $i) {
    $Season = null;
    $fallYear = "";
    #Creates and loads the DOM. If not successful, the rest of the code is not executed.
    $doc = new DOMDocument();
    if (!$doc->load($docUrl)) {
        echo "FAILURE - Could not load the XML- file.\n";
    } else {
	#        
	#Find the i-th Season element with XPath.
        $xpath = new DOMXpath($doc);
        $season = $xpath->query("/SkierLogs/Season")[$i];
	#	
	#The following code is exectued if a season was successfully returned from the Xpath- query.
	if ($season) {
		$fallYear = $season->getAttribute('fallYear');			
          }

	}
	return $Season = new Season($fallYear);	
   }


#
#Returns one Representing- element (userName, clubId, fallYear).
#
function processRepresenting($docUrl, $i) {
    $Representing = null;
    $userName = $clubId = $fallYear = "";
    #Creates and loads the DOM. If not successful, the rest of the code is not executed.
    $doc = new DOMDocument();
    if (!$doc->load($docUrl)) {
        echo "FAILURE - Could not load the XML- file.\n";
    } else {
	#        
	#Find the i-th element with XPath.
        $xpath = new DOMXpath($doc);
        $skierRep = $xpath->query("/SkierLogs/Season/Skiers/Skier")[$i];
	#	
	#The following code is exectued if a season was successfully returned from the Xpath- query.
	if ($skierRep) {
		$userName = $skierRep->getAttribute('userName');
		#Goes up to the parent and retrieves it's clubId- attribute.
		#NULL is applied if the skier doesn't belong to a club this season.
		if ($skierRep->parentNode->hasAttribute('clubId')) {
			$clubId = $skierRep->parentNode->getAttribute('clubId');
		} else {
			$clubId = NULL;
		}
		#Goes up to the grandparent and retrieves it's fallYear- attribute.
		$fallYear = $skierRep->parentNode->parentNode->getAttribute('fallYear');
	  }
	}
	return $Representing = new Representing($userName, $clubId, $fallYear);	
   
  }

#
#Returns one TotalDistance- element (userName, totDist, fallYear).
#
function processTotalDistance($docUrl, $i) {
    $TotalDistance = null;
    $userName = $fallYear = "";
    $totDist = 0;
    #Creates and loads the DOM. If not successful, the rest of the code is not executed.
    $doc = new DOMDocument();
    if (!$doc->load($docUrl)) {
        echo "FAILURE - Could not load the XML- file.\n";
    } else {
	#        
	#Find the i-th element with XPath.
        $xpath = new DOMXpath($doc);
        $tot = $xpath->query("/SkierLogs/Season/Skiers/Skier")[$i];
	#	
	#The following code is exectued if a season was successfully returned from the Xpath- query.
	if ($tot) {
		#Retrieves the userName and the fallYear related to the i-th element.
		$userName = $tot->getAttribute('userName');		
		$fallYear = $tot->parentNode->parentNode->getAttribute('fallYear');
		#Then uses these retrieved values to find exactly every entries of a given skier in a given season.
		$entries = $xpath->query("/SkierLogs/Season[@fallYear = $fallYear]/Skiers/Skier[@userName = '$userName']/Log/Entry/Distance");
		#The total distance are summed up together and stored in $totDist.		
		for ($i = 0; $i < $entries->length; $i++) {				
			$totDist += $entries[$i]->nodeValue;
		}
          }
	}
	return $TotalDistance = new TotalDistance($userName, $totDist, $fallYear);	
   }
}

?>
