<?php

if(filesize("Venue.json")<=0){
		echo"Venue List is empty";
	}
	else{
	$f = fopen("Venue.json", 'r');
	$s = fread($f, filesize("Venue.json"));
	$data = json_decode($s);
	echo "<br>";
	echo "<fieldset>";
	echo "<legend>Venue List</legend>";
	echo "<table>";
	echo "<tr>";
	echo "<th>ID</th>";
	echo "<th>Name</th>";
	echo "<th>Location</th>";
	echo "<th>Capacity</th>";
	echo "<th>Rating</th>";
	echo "<th>Cost</th>";
	echo "<th>Status</th>";
	echo "</tr>";
	for ($x = 0; $x < count($data); $x++) {
	echo "<tr>";
  	echo "<td>" . $data[$x]->vid . "</td>";
	echo "<td>" . $data[$x]->name . "</td>";
	echo "<td>" . $data[$x]->location . "</td>";
	echo "<td>" . $data[$x]->capacity . "</td>";
	echo "<td>" . $data[$x]->rating . "</td>";
	echo "<td>" . $data[$x]->cost . "</td>";
	echo "<td>" . $data[$x]->status . "</td>";
	echo "</tr>";
	}
	echo "</table>";
	echo "</fieldset>";
	fclose($f);
}
?>