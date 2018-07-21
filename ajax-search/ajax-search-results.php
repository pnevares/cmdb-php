<?php
	require('../_db.php');

	$query = "select con_preferredname from tblContacts
			  where con_hide = 0
			    and con_preferredname like '%".$_GET['q']."%'
			  order by con_lastname
			  limit 11";
	$result = mysql_query($query);

	$ix = 0;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$ix++;
		$matched_name = preg_replace('/'.$_GET['q'].'/i','<span class="matched">\\0</span>',$row["con_preferredname"]);
		echo '<a href="#" name="' . $row["con_preferredname"] . '">' . $matched_name . '</a><br />';
		if($ix == 10) { echo "More than 10 results."; break; }
	}
	if($ix == 0) { echo "No results."; }
?>