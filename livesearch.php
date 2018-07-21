<?php
	require('_db.php');

	$query = "select con_id, con_firstname, con_middlename, con_lastname, con_preferredname, con_company
				from tblContacts
			   where con_hide = 0
			     and (
				 	con_firstname like '%".$_GET['q']."%' OR
				 	con_middlename like '%".$_GET['q']."%' OR
				 	con_lastname like '%".$_GET['q']."%' OR
				 	con_preferredname like '%".$_GET['q']."%' OR
				 	con_company like '%".$_GET['q']."%'
				 )
			   order by con_lastname
			   limit 21";
	$result = mysql_query($query);

	$ix = 0;
	echo '<table border="0" width="100%">';
	echo '<thead><tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Preferred Name</th><th>Company</th></tr></thead>';
	echo '<tr><td colspan="5">&nbsp;</td></tr>';
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		echo '<tr class="livesearch_row" id="'.$row["con_preferredname"].'">';
		$ix++;
		$matched_name = preg_replace('/'.$_GET['q'].'/i','<span class="matched">\\0</span>',$row["con_firstname"]);
		echo '<td id="'.$row["con_id"].'">' . $matched_name . '</td>';
		$matched_name = preg_replace('/'.$_GET['q'].'/i','<span class="matched">\\0</span>',$row["con_middlename"]);
		echo '<td>' . $matched_name . '</td>';
		$matched_name = preg_replace('/'.$_GET['q'].'/i','<span class="matched">\\0</span>',$row["con_lastname"]);
		echo '<td>' . $matched_name . '</td>';
		$matched_name = preg_replace('/'.$_GET['q'].'/i','<span class="matched">\\0</span>',$row["con_preferredname"]);
		echo '<td>' . $matched_name . '</td>';
		$matched_name = preg_replace('/'.$_GET['q'].'/i','<span class="matched">\\0</span>',$row["con_company"]);
		echo '<td>' . $matched_name . '</td>';
		if($ix == 20) {
			echo '<tr><td colspan="5">&nbsp;</td></tr>';
			echo '<tr><td colspan="5" align="center">More than 20 results.</td></tr>';
			break;
		}
	}
	echo '</table>';
	if($ix == 0) { echo "No results."; }
?>