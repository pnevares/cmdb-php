<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CMDB - group.php</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
			# Purpose: Create, view, modify, and delete a group record.
			# pnevares 11-5-2008

			require('_db.php');
			require('old/_table.php');

			if($_GET['id']) {
				if($_GET['mod']) {
					// Modify group record
					
				} else {
					// View group record
					$query = "select grp_label from tblGroups where grp_id = " . $_GET['id'];
					$result = mysql_query($query);
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$groupname = $row["grp_label"];

					$query = "select con_title, con_hide, con_firstname, con_middlename, con_lastname, 
									 con_preferredname, con_company, con_job_title, con_department, con_suffix, 
									 con_website, con_spouse_id, con_birthday, con_anniversary, con_photo, con_created,
									 p.pho_number, e.eml_address, addr_house_number, addr_street_direction, addr_street_name,
									 addr_street_type, addr_city, addr_state, addr_zip_code,
									 (select con_preferredname from tblContacts where con_id = c.con_spouse_id) as spouse_name
							  from tblContacts c
							  left join tblPhone p on p.con_id = c.con_id
							  left join tblEmail e on e.con_id = c.con_id
							  left join tblAddress a on a.con_id = c.con_id
							  where (p.pho_primary <> 0 or p.pho_primary is null)
							    and (e.eml_primary <> 0 or e.eml_primary is null)
								and (a.addr_primary <> 0 or a.addr_primary is null)
							    and c.con_id IN (select con_id from tblGroupMembers where grp_id = " . $_GET['id'] . ")
							  order by con_lastname, con_firstname";
					$result = mysql_query($query);

					echo '<h2>' . $groupname . '</h2>';
					contact_table_output($result);
				}
			} else {
				// New group record
			}
		?>
	</body>
</html>
