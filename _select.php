<?php
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
				 and c.con_id = " . $_GET['id'];
	$result = mysql_query($query);
	
	// select group info
	$query2 = "select m.grp_id, g.grp_label
				 from tblGroupMembers m
			left join tblGroups g on g.grp_id = m.grp_id
				where m.con_id = " . $_GET['id'];
	$result2 = mysql_query($query2);
	
	// contact methods block - address, e-mail, phone
	// select address info
	$query3 = "select a.addr_primary, a.addr_label, a.addr_house_number, a.addr_street_direction, a.addr_street_name, a.addr_street_type,
					  a.addr_street_suffix, a.addr_additional, a.addr_po_box, a.addr_city, a.addr_state, a.addr_zip_code, a.addr_hide,
					  a.addr_id
				 from tblAddress a
				where a.con_id = " . $_GET['id'] . "
			 order by a.addr_primary desc";
	$result3 = mysql_query($query3);
	// select e-mail info
	$query4 = "select e.eml_primary, e.eml_label, e.eml_address, e.eml_hide, e.eml_id
				 from tblEmail e
				where e.con_id = " . $_GET['id'] . "
			 order by e.eml_primary desc";
	$result4 = mysql_query($query4);
	// select phone info
	$query5 = "select p.pho_primary, p.pho_label, p.pho_number, p.pho_hide, p.pho_id
				 from tblPhone p
				where p.con_id = " . $_GET['id'] . "
			 order by p.pho_primary desc";
	$result5 = mysql_query($query5);
?>