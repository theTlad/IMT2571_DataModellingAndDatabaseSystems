<?php

include_once("xmlDomApi.php");
include_once("relDB.php");
//include_once("Skier.php");

#Create a new PHP Document Object.
$db = new RelDB();

#Create a new DOM Object.
$xml = new XmlDomApi();


#- - - WORKING WITH SKIER: - - -
#Finds the number of Skier- elements.
$skierLength = $xml->findLength("SkierLogs.xml", "/SkierLogs/Skiers/Skier");
#For each Skier- elements: Extract a Skier- object and insert it into the database.
for ($i = 0; $i < $skierLength; $i++) {
  $skier = $xml->processSkier("SkierLogs.xml", $i);
  $db->insertSkier($skier); 
}



#- - - WORKING WITH CLUB: - - -
#Finds the number of Club- elements.
$clubLength = $xml->findLength("SkierLogs.xml", "/SkierLogs/Clubs/Club");
#For each Club- elements: Extract a Club- object and insert it into the database.
for ($i = 0; $i < $clubLength; $i++) {
  $club = $xml->processClub("SkierLogs.xml", $i);
  $db->insertClub($club);
}



#- - - WORKING WITH SEASON: - - -
#Finds the number of Season- elements.
$seasonLength = $xml->findLength("SkierLogs.xml", "/SkierLogs/Season");
#For each Club- elements: Extract a Club- object and insert it into the database.
for ($i = 0; $i < $seasonLength; $i++) {
  $season = $xml->processSeason("SkierLogs.xml", $i);
  $db->insertSeason($season);
}



#- - - WORKING WITH REPRESENTING: - - -
#Finds the number of skiers who skied during one or more seasons.

$repLength = $xml->findLength("SkierLogs.xml", "/SkierLogs/Season/Skiers/Skier");
#For each element: Extract a Representing- object and insert it into the database.
for ($i = 0; $i < $repLength; $i++) {
  $rep = $xml->processRepresenting("SkierLogs.xml", $i);
  $db->insertRepresenting($rep);
}



#- - - WORKING WITH TOTAL_DISTANCE: - - -
#Finds the total distance of each skiers for each season the skier skied.

$totLength = $xml->findLength("SkierLogs.xml", "/SkierLogs/Season/Skiers/Skier");
#For each element: Extract a Representing- object and insert it into the database.
for ($i = 0; $i < $totLength; $i++) {
  $tot = $xml->processTotalDistance("SkierLogs.xml", $i);
  $db->insertTotalDistance($tot);
}


#Retrieve all the information stored in the database,
$db->query();

#Displays all the data to the console.
$db->display();

?>
