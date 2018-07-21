<?php
	# Purpose: Create, view, modify, and delete a contact record.
	# pnevares - updated 11-10-2008

	require('_db.php');

	if($_GET['id']) {
		$con_id = $_GET['id'];
		if($_GET['mod']) {
			// update tblContacts
			$query = "update tblContacts
						 set con_title             = '" . $_POST['title'] . "',
						     con_firstname     = '" . $_POST['first_name'] . "',
							 con_middlename    = '" . $_POST['middle_name'] . "',
							 con_lastname      = '" . $_POST['last_name'] . "',
							 con_suffix        = '" . $_POST['suffix'] . "',
							 con_preferredname = '" . $_POST['preferred_name'] . "',
							 con_birthday      = '" . $_POST['birthyear'] . "-" . $_POST['birthmonth'] . "-" . $_POST['birthday'] . "',
							 con_anniversary   = '" . $_POST['anniversaryyear'] . "-" . $_POST['anniversarymonth'] . "-" . $_POST['anniversaryday'] . "',
							 con_website       = '" . $_POST['website'] . "',
							 con_company       = '" . $_POST['company'] . "',
							 con_job_title     = '" . $_POST['job_title'] . "',
							 con_department    = '" . $_POST['department'] . "'
					   where con_id = " . $_GET['id'];
			$result = mysql_query($query);
			if (!$result) { die("Contacts table query error: " . odbc_error()); }

			echo 'Changes have been saved!';
			sleep(1);
			exit();
		} else {
			// View contact record

			// select contact info
			$query = "select con_title, con_hide, con_firstname, con_middlename, con_lastname, 
							 con_preferredname, con_company, con_job_title, con_department, con_suffix, 
							 con_website, con_spouse_id, con_birthday, con_anniversary, con_photo, con_created,
							 (select con_preferredname from tblContacts where con_id = c.con_spouse_id) as spouse_name
						from tblContacts c
					   where c.con_id = " . $_GET['id'];
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

			$contact_methods = array( 'primary' => array(), 'label'   => array(), 'address' => array(), 'hide'    => array() );
			while($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {
				$contact_methods["primary"][] = $row["addr_primary"] ? '<input type="radio" checked="checked" name="addr_primary" value="' . $row["addr_id"] . '" />' : '<input type="radio" name="addr_primary" value="' . $row["addr_id"] . '" />';
				$contact_methods["label"][]   = $row["addr_label"];
				$contact_methods["address"][] = $row["addr_house_number"] . ' ' . $row["addr_street_direction"] . ' ' . $row["addr_street_name"] . ' ' . $row["addr_street_type"] . ' ' . $row["addr_street_suffix"] . '<br />' . $row["addr_city"] . ', ' . $row["addr_state"] . ' ' . $row["addr_zip_code"];
				$contact_methods["hide"][]    = $row["addr_hide"] ? '<input type="checkbox" checked="checked" />' : '<input type="checkbox" />';
			}
			while($row = mysql_fetch_array($result4, MYSQL_ASSOC)) {
				$contact_methods["primary"][] = $row["eml_primary"] ? '<input type="radio" checked="checked" name="eml_primary" value="' . $row["eml_id"] . '" />' : '<input type="radio" name="eml_primary" value="' . $row["eml_id"] . '" />';
				$contact_methods["label"][]   = $row["eml_label"];
				$contact_methods["address"][] = $row["eml_address"] ? '<a href="mailto:' . $row["eml_address"] . '">' . $row["eml_address"] . '</a>' : '';
				$contact_methods["hide"][]    = $row["eml_hide"] ? '<input type="checkbox" checked="checked" />' : '<input type="checkbox" />';
			}
			while($row = mysql_fetch_array($result5, MYSQL_ASSOC)) {
				$contact_methods["primary"][] = $row["pho_primary"] ? '<input type="radio" checked="checked" name="pho_primary" value="' . $row["pho_id"] . '" />' : '<input type="radio" name="pho_primary" value="' . $row["pho_id"] . '" />';
				$contact_methods["label"][]   = $row["pho_label"];
				$contact_methods["address"][] = $row["pho_number"] ? '(' . substr($row["pho_number"],0,3) . ') ' . substr($row["pho_number"],3,3) . '-' . substr($row["pho_number"],6,4) : '';
				$contact_methods["hide"][]    = $row["pho_hide"] ? '<input type="checkbox" checked="checked" />' : '<input type="checkbox" />';
			}

			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				// set variables for the contact form
				$title = $row["con_title"] ? '<option value="'.$row["con_title"].'">'.$row["con_title"].'</option>' : '';
				$firstname = $row["con_firstname"];
				$middlename = $row["con_middlename"];
				$lastname = $row["con_lastname"];
				$suffix = $row["con_suffix"] ? '<option value="'.$row["con_suffix"].'">'.$row["con_suffix"].'</option>' : '';
				$preferredname = $row["con_preferredname"];
				$spousename = $row["spouse_name"];
				$birthmonth = date('m',strtotime($row["con_birthday"]));
				$birthday = date('d',strtotime($row["con_birthday"]));
				$birthyear = date('Y',strtotime($row["con_birthday"]));
				$anniversarymonth = date('m',strtotime($row["con_anniversary"]));
				$anniversaryday = date('d',strtotime($row["con_anniversary"]));
				$anniversaryyear = date('Y',strtotime($row["con_anniversary"]));
				$website = $row["con_website"];
				$company = $row["con_company"];
				$job_title = $row["con_job_title"];
				$department = $row["con_department"];
			}
			while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)) { $groups .= '<div class="group" id="grp_'.$row2["grp_id"].'">'.$row2["grp_label"].'</div>'; }
			$submit = 'Save changes';
			$contact_table = '<table id="hor-zebra">';
			$contact_table .= '<thead><tr><th scope="col" class="primary">Primary</th><th scope="col" class="type">Type</th><th scope="col" class="address">Address</th><th scope="col" class="hidden">Hide</th></tr></thead>';
			$contact_table .= '
				<tr id="newcontact">
					<td class="primary"><input type="checkbox" /></td>
					<td class="type">
						<select id="newmethodtypes">
							<option></option>
							<option>Home</option>
							<option>Work</option>
							<option>Cell</option>
						</select>
					</td>
					<td class="address">
						<select id="newmethodoptions">
							<option></option>
							<option>Address</option>
							<option>E-mail</option>
							<option>Phone</option>
						</select>
						<input type="text" class="hide" name="newphone" id="newphone" />
						<input type="text" class="hide" name="newemail" id="newemail" />
						<textarea rows="2" cols="15" class="hide" name="newaddress" id="newaddress"></textarea>
					</td>
					<td class="hidden"><input type="button" id="contactcancel" value="cancel" /></td>
				</tr>
			';
			for( $ix=0; $ix<count($contact_methods["primary"]); $ix++ ) {
				if($ix % 2 == 0) {
					$contact_table .= '<tr class="odd">';
				} else {
					$contact_table .= '<tr>';
				}
				$contact_table .= '<td class="primary">' . $contact_methods["primary"][$ix] . '</td>';
				$contact_table .= '<td class="type">' . $contact_methods["label"][$ix] . '</td>';
				$contact_table .= '<td class="address">' . $contact_methods["address"][$ix] . '</td>';
				$contact_table .= '<td class="hidden">' . $contact_methods["hide"][$ix] . '</td>';
				$contact_table .= '</tr>';
			}
			$contact_table .= '</table>';
		}
	} else {
		if($_GET['mod']) {
			echo $_SERVER["REQUEST_URI"];
			exit();
		} else {
			// set empty fields for a new contact
			// this isn't necessary - wow, php
			// $title = $firstname = $middlename =  $lastname = $preferredname = $spousename = $birthmonth = $birthday = $birthyear = $anniversarymonth = $anniversaryday = $anniversaryyear = $company = $groups = $contact_table = '';
			$submit = 'Save new contact';
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>YUI Base Page</title>
	    <script type="text/javascript" src="js/jquery.js"></script>
	    <script type="text/javascript" src="js/livesearch.js"></script>
		<link rel="stylesheet" href="http://yui.yahooapis.com/2.5.1/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css" />
		<link rel="stylesheet" href="css/livesearch.css" type="text/css" />
		<style type="text/css">
			.content, .cmdb-nav {
				border: 1px solid #faa;
				background-color: #ffc;
				padding: 5px;
				margin: 5px 0px;
			}
			.cmdb-nav {
				text-align: right;
			}
			.cmdb-nav a {
				background-color: #eee;
				line-height: 189%;
				padding: 2px;
				border: 1px dashed orange;
				color: black;
				text-decoration: none;
			}
			.cmdb-nav a:hover { color: red; background-color: white; border-style: solid; }
			.header { text-align: center; margin: 10px 0px 5px 0px; font-size: 146.5%; }
			.footer { font-size: 77%; text-align: right; }
			h2 { text-align: center; text-decoration: underline; }
			input[type=text], input[type=file], input[type=checkbox], select, textarea { border: 1px solid #faa; background-color: #eee; }
			input[type=text], input[type=file], input[type=checkbox], select, input[type=submit] { font-size: 85%; }
			input[type=submit] { margin-bottom: 10px; padding: 2px; cursor: pointer; }
			input[type=file] { font-size: 77%; }
			input[type=text].name, input[type=file].photo { width: 150px; }
			input[type=text].day { width: 16px; }
			input[type=text].year { width: 30px; }
			#submit_hidden { display: none; }
			label {
				float: left;
				display: block;
				width: 100px;
			}
			.names_form div, .names_form2 div { margin: 3px; }
			.personal-left {
				float: left;
				display: block;
				width: 50%;
			}
			.personal-right {
				float: right;
				display: block;
				width: 50%;
			}
			div.livesearch { position: relative; top: -7px; left: 92px; }
			div.save { text-align: right; }
			div.group {
				border: 1px solid black;
				background-color: #ddd;
				padding: 3px;
				display: inline-block;
				white-space: nowrap;
				margin-right: 5px;
				margin-bottom: 5px;
				cursor: pointer;
			}
			div.group:hover { outline: 1px solid green; border: 1px solid green; background-color: #eee; }
			.loading { border: 0px; display: none; width: 16px; height: 16px; }
			#newcontact { display: none; }

			#hor-zebra	{
				text-align: left;
				border-collapse: collapse;
				width: 100%;
			}
			#hor-zebra th{
				font-weight: normal;
				color: #039;
				padding: 10px 8px;
			}
			#hor-zebra td { color: #444; padding: 8px; }
			#hor-zebra .primary { text-align: left; }
			#hor-zebra .type { text-align: center; }
			#hor-zebra .address { text-align: center; }
			#hor-zebra .hidden { text-align: right; }
			#hor-zebra .odd { background: #e8edff; }
		</style>
		<script type="text/javascript">
			// stupid xhtml validator...
			var amp = '&amp;';
			var amp = amp.substr(0,1);

			$(document).ready(function() {
				$("form").submit(function() {
					$("#submit").attr("disabled","disabled").attr("value","Saving...").blur();
					$("#loading").css("display","inline");
					$.post(
						"contact.php?mod=1"<?php echo $_GET['id'] ? ' + amp + "id=' . $_GET['id'] : '' ; ?>", {
							title: $("#title").attr("value"),
							first_name: $("#first_name").attr("value"),
							middle_name: $("#middle_name").attr("value"),
							last_name: $("#last_name").attr("value"),
							suffix: $("#suffix").attr("value"),
							preferred_name: $("#preferred_name").attr("value"),
							spouse: $("#spouse").attr("value"),
							birthmonth: $("#birthmonth").attr("value"),
							birthday: $("#birthday").attr("value"),
							birthyear: $("#birthyear").attr("value"),
							anniversarymonth: $("#anniversarymonth").attr("value"),
							anniversaryday: $("#anniversaryday").attr("value"),
							anniversaryyear: $("#anniversaryyear").attr("value"),
							website: $("#website").attr("value"),
							company: $("#company").attr("value"),
							job_title: $("#job_title").attr("value"),
							department: $("#department").attr("value"),
							hide: $("#hide").attr("value")
						},
						function(returned_data) {
							$("#submit").attr("disabled",false).attr("value","Save changes");
							$("#loading").css("display","none");
							alert(returned_data);
						}
					);
					return false;
				});
				$("div.group").click(function() {
					location.href = 'group.php?id=' + $(this).attr("id").replace('grp_','');
				});
				$("#addnew").click(function() {
					$("#newcontact").show();
					return false;
				});
				$("#contactcancel").click(function() {
					$("#newmethodoptions").show();
					$("#newmethodoptions option:first").attr("selected","selected");
					$("#newmethodtypes option:first").attr("selected","selected");
					$("#newcontact").hide();
					$("#newaddress").attr("value","").hide();
					$("#newemail").attr("value","").hide();
					$("#newphone").attr("value","").hide();
					return false;
				});
				$("#newmethodoptions").change(function() {
					switch($(this).attr("value")) {
						case 'Address':
							$("#newmethodoptions").hide();
							$("#newaddress").show();
							break;
						case 'E-mail':
							$("#newmethodoptions").hide();
							$("#newemail").show();
							break;
						case 'Phone':
							$("#newmethodoptions").hide();
							$("#newphone").show();
							break;
					}
				});
			});
		</script>
	</head>
	<body>
		<?php
			echo <<<END_OUTPUT
				<div id="doc" class="yui-t2">
					<div id="hd">
						<div class="header">
							<h1>Contact Management Database</h1>
						</div>
					</div>
					<div id="bd">
						<div id="yui-main">
							<div class="yui-b">
								<div class="yui-g content">
									<div>
										<div class="personal-left">
											<form method="post" name="contact" id="names_form" class="names_form" action="">
											<input type="submit" name="submit" id="submit_hidden" value="$submit" />
											<div>
												<label for="title">Title:</label>
												<select name="title" id="title">
													$title
													<option></option>
													<option value="Mr.">Mr.</option>
													<option value="Mrs.">Mrs.</option>
													<option value="Miss">Miss</option>
													<option value="Ms.">Ms.</option>
													<option value="Prof.">Prof.</option>
													<option value="Dr.">Dr.</option>
												</select>
											</div>
											<div>
												<label for="first_name">First Name:</label>
												<input type="text" class="name" name="first_name" id="first_name" value="$firstname" />
											</div>
											<div>
												<label for="middle_name">Middle Name:</label>
												<input type="text" class="name" name="middle_name" id="middle_name" value="$middlename" />
											</div>
											<div>
												<label for="last_name">Last Name:</label>
												<input type="text" class="name" name="last_name" id="last_name" value="$lastname" />
											</div>
											<div>
												<label for="suffix">Suffix:</label>
												<select name="suffix" id="suffix">
													$suffix
													<option></option>
													<option value="Jr.">Jr.</option>
													<option value="Sr.">Sr.</option>
													<option value="II">II</option>
													<option value="III">III</option>
													<option value="IV">IV</option>
												</select>
											</div>
											<div>&nbsp;</div>
											<div>
												<label for="preferred_name">Preferred Name:</label>
												<input type="text" class="name" name="preferred_name" id="preferred_name" value="$preferredname" />
											</div>
											<div>&nbsp;</div>
											<div>
												<label for="livesearch">Spouse:</label>
												<div>
													<div><input type="text" class="name" name="spouse" id="livesearch" value="$spousename" /></div>
													<div class="livesearch"><div id="livesearch_results" class="livesearch_results"></div></div>
												</div>
											</div>
											</form>
										</div>
										<div class="personal-right">
											<form method="post" name="contact" id="names_form2" class="names_form" action="">
											<div class="save">
												<img src="images/loading.gif" id="loading" class="loading" alt="loading..." />
												<input type="submit" name="submit" id="submit" value="$submit" />
											</div>
											<div>
												<label for="birthmonth">Birthday:</label>
												<input type="text" class="day" name="birthmonth" id="birthmonth" value="$birthmonth" /> /
												<input type="text" class="day" name="birthday" id="birthday" value="$birthday" /> /
												<input type="text" class="year" name="birthyear" id="birthyear" value="$birthyear" />
											</div>
											<div>
												<label for="anniversarymonth">Anniversary:</label>
												<input type="text" class="day" name="anniversarymonth" id="anniversarymonth" value="$anniversarymonth" /> /
												<input type="text" class="day" name="anniversaryday" id="anniversaryday" value="$anniversaryday" /> /
												<input type="text" class="year" name="anniversaryyear" id="anniversaryyear" value="$anniversaryyear" />
											</div>
											<div>
												<label for="website">Website:</label>
												<input type="text" class="name" name="website" id="website" value="$website" />
											</div>
											<div>
												<label for="photo">Photo:</label>
												<input type="file" class="photo" name="photo" id="photo" />
											</div>
											<div>&nbsp;</div>
											<div>
												<label for="first_name">Company:</label>
												<input type="text" class="name" name="company" id="company" value="$company" />
											</div>
											<div>
												<label for="job_title">Job Title:</label>
												<input type="text" class="name" name="job_title" id="job_title" value="$job_title" />
											</div>
											<div>
												<label for="department">Department:</label>
												<input type="text" class="name" name="department" id="department" value="$department" />
											</div>
											<div>&nbsp;</div>
											<div>
												<label for="hide">Hide Contact:</label>
												<input type="checkbox" class="name" name="hide" id="hide" />
											</div>
											</form>
										</div>
									</div>
								</div>
								<div class="yui-gc">
									<div class="yui-u first">
										<div class="content">
											<h2>Contact Methods</h2>
											<a href="#" id="addnew">add new</a>
											$contact_table
										</div>
									</div>
									<div class="yui-u">
										<div class="content">
											<h2>Groups</h2>
											<div class="groups">
												$groups
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="yui-b">
							<div class="cmdb-nav">
								<ul>
									<li><a href="">Search</a></li>
									<li><a href="contact.php">New Contact</a></li>
									<li><a href="">New Group</a></li>
									<li><a href="">Import</a></li>
									<li><a href="export.php?id=$con_id">Export</a></li>
									<li><a href="init.php">Reset CMDB</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div id="ft">
						<div class="footer">
							Copyright &copy; 2008 Pablo Nevares <a href="http://validator.w3.org/check/referer">xhtml</a><br />
							<a href="http://pablo.nevares.com">http://pablo.nevares.com</a>
						</div>
					</div>
				</div>
END_OUTPUT;
		?>
	</body>
</html>
