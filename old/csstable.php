<?php
	require('_db.php');
					// select address info
					$query3 = "select a.addr_primary, a.addr_label, a.addr_house_number, a.addr_street_direction, a.addr_street_name, a.addr_street_type,
									  a.addr_street_suffix, a.addr_additional, a.addr_po_box, a.addr_city, a.addr_state, a.addr_zip_code, a.addr_hide
								 from tblAddress a
								where a.con_id = " . $_GET['id'];
					$result3 = mysql_query($query3);

					// select e-mail info
					$query4 = "select e.eml_primary, e.eml_label, e.eml_address, e.eml_hide
								 from tblEmail e
								where e.con_id = " . $_GET['id'];
					$result4 = mysql_query($query4);

					// select phone info
					$query5 = "select p.pho_primary, p.pho_label, p.pho_number, p.pho_hide
								 from tblPhone p
								where p.con_id = " . $_GET['id'];
					$result5 = mysql_query($query5);

					$contact_methods = array(
											'primary' => array(),
											'label'   => array(),
											'address' => array(),
											'hide'    => array()
											);
					while($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {
						$contact_methods["primary"][] = $row["addr_primary"];
						$contact_methods["label"][]   = $row["addr_label"];
						$contact_methods["address"][] = $row["addr_street_name"];
						$contact_methods["hide"][]    = $row["addr_hide"];
					}
					while($row = mysql_fetch_array($result4, MYSQL_ASSOC)) {
						$contact_methods["primary"][] = $row["eml_primary"];
						$contact_methods["label"][]   = $row["eml_label"];
						$contact_methods["address"][] = $row["eml_address"];
						$contact_methods["hide"][]    = $row["eml_hide"];
					}
					while($row = mysql_fetch_array($result5, MYSQL_ASSOC)) {
						$contact_methods["primary"][] = $row["pho_primary"];
						$contact_methods["label"][]   = $row["pho_label"];
						$contact_methods["address"][] = $row["pho_number"];
						$contact_methods["hide"][]    = $row["pho_hide"];
					}

					echo '<div style="display: table;">';
					for( $ix=0; $ix<count($contact_methods["primary"]); $ix++ ) {
						echo '<div style="display: table-row-group">';
						echo '<div style="display: table-cell; width: 30px;">' . $contact_methods["primary"][$ix] . '</div>';
						echo '<div style="display: table-cell; width: 100px;">' . $contact_methods["label"][$ix] . '</div>';
						echo '<div style="display: table-cell; width: 150px;">' . $contact_methods["address"][$ix] . '</div>';
						echo '<div style="display: table-cell; width: 30px;">' . $contact_methods["hide"][$ix] . '</div>';
						echo '</div>';
					}
					echo '</div>';

					echo 'done';
?>