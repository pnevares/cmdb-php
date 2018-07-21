<?php
	function contact_table_output($query) {
		echo '<table border="1">';
		echo '<tr>';
		echo '<th>Title</th>';
		echo '<th>Hide</th>';
		echo '<th>First Name</th>';
		echo '<th>Middle Name</th>';
		echo '<th>Last Name</th>';
		echo '<th>Pref. Name</th>';
		echo '<th>Company</th>';
		echo '<th>Spouse</th>';
		echo '<th>Birthday</th>';
		echo '<th>Anniversary</th>';
		echo '<th>E-mail</th>';
		echo '<th>Phone</th>';
		echo '<th>Address</th>';
		echo '<th>CSZ</th>';
		echo '<th>Photo</th>';
		echo '<th>Created</th>';
		echo '</tr>';
		while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
			echo '<tr>';
			echo '<td>' . $row["con_title"] . '</td>';
			echo '<td>' . $row["con_hide"] . '</td>';
			echo '<td>' . $row["con_firstname"] . '</td>';
			echo '<td>' . $row["con_middlename"] . '</td>';
			echo '<td>' . $row["con_lastname"] . '</td>';
			echo '<td>' . $row["con_preferredname"] . '</td>';
			echo '<td>' . $row["con_company"] . '</td>';
			echo '<td>' . $row["spouse_name"] . '</td>';
			echo '<td>' . $row["con_birthday"] . '</td>';
			echo '<td>' . $row["con_anniversary"] . '</td>';
			echo '<td>' . $row["eml_address"] . '</td>';
			$row["pho_number"] ? print '<td>(' . substr($row["pho_number"],0,3) . ') ' . substr($row["pho_number"],3,3) . '-' . substr($row["pho_number"],6,4) . '</td>' : print '<td></td>';
			echo '<td>' . $row["addr_house_number"] . ' ' . $row["addr_street_direction"] . ' ' . $row["addr_street_name"] . ' ' . $row["addr_street_type"] . '</td>';
			$row["addr_city"] ? print '<td>' . $row["addr_city"] . ', ' . $row["addr_state"] . ' ' . $row["addr_zip_code"] . '</td>' : print '<td></td>';
			echo '<td>' . $row["con_photo"] . '</td>';
			echo '<td>' . $row["con_created"] . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
?>