<?php

if(filesize("Food.json")<=0){
		echo"Food List is empty";
	}
	else{
	$f = fopen("Food.json", 'r');
	$s = fread($f, filesize("Food.json"));
	$data = json_decode($s);
	echo "<br>";
	echo "<fieldset>";
	echo "<legend>Food List</legend>";
	echo "<table>";
	echo "<tr>";
	echo "<th>ID</th>";
	echo "<th>Rice Items</th>";
	echo "<th>Salad Items</th>";
	echo "<th>Kabab Items</th>";
	echo "<th>Curry items</th>";
	echo "<th>Deserts</th>";
	echo "<th>Cost</th>";
	echo "</tr>";
	for ($x = 0; $x < count($data); $x++) {
	echo "<tr>";
  	echo "<td>" . $data[$x]->fid . "</td>";
	echo "<td>" . $data[$x]->rice . "</td>";
	echo "<td>" . $data[$x]->salad . "</td>";
	echo "<td>" . $data[$x]->kabab . "</td>";
	echo "<td>" . $data[$x]->curry . "</td>";
	echo "<td>" . $data[$x]->desert . "</td>";
	echo "<td>" . $data[$x]->cost . "</td>";
	echo "</tr>";
	}
	echo "</table>";
	echo "</fieldset>";
	fclose($f);
}
?>