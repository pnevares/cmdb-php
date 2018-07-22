<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CMDB - init.php</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
			# Purpose: drop and create all tables for CMDB application:
			# tblContacts, tblPhone, tblAddress, tblEmail, tblGroups, tblNotes
			# pnevares - updated 11-8-2008

			// options for populating tables
			$contacts = 30;
			$max_phone_address_email_per_contact = 3;
			$notes_csv_file = 'notes.txt';
			require('_db.php');

			// ================ BEGIN tblContacts ================
			// Drop tblContacts
			$query = "drop table if exists `tblContacts`";
			$result = mysql_query($query);
			// Create tblContacts
			$query = "create table `tblContacts` (
					  `con_id` INT(11) NOT NULL auto_increment,
					  `con_title` VARCHAR(10) DEFAULT NULL,
					  `con_hide` BOOLEAN NOT NULL DEFAULT '0',
					  `con_firstname` VARCHAR(20) NOT NULL,
					  `con_middlename` VARCHAR(20) DEFAULT NULL,
					  `con_lastname` VARCHAR(40) NOT NULL,
					  `con_preferredname` VARCHAR(100) DEFAULT NULL,
					  `con_company` VARCHAR(100) DEFAULT NULL,
					  `con_job_title` VARCHAR(50) DEFAULT NULL,
					  `con_department` VARCHAR(100) DEFAULT NULL,
					  `con_suffix` VARCHAR(20) DEFAULT NULL,
					  `con_website` VARCHAR(256) DEFAULT NULL,
					  `con_spouse_id` INT(11) DEFAULT NULL,
					  `con_birthday` DATE default NULL,
					  `con_anniversary` DATE DEFAULT NULL,
					  `con_photo` VARCHAR(256) DEFAULT NULL,
					  `con_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  primary key (`con_id`) )";
			$result = mysql_query($query);
			$result ? print 'tblContacts query successful...<br /><br />' : die("tblContacts query error:<br /><br />" . mysql_error());
			// Populate tblContacts
			$titles = array('Mr.','Mrs.','Miss','Ms.','Prof.','Dr.');
			$firstnames = array('Jacob','Emily','Michael','Isabella','Ethan','Emma','Joshua','Ava','Daniel','Madison',
								'Christopher','Sophia','Anthony','Olivia','William','Abigail','Matthew','Hannah','Andrew','Elizabeth');
			$lastnames  = array('Smith','Johnson','Williams','Jones','Brown','Davis','Miller','Wilson','Moore','Taylor');
			for ($ix = 1; $ix <= $contacts; $ix++) {
				$random_title  = rand() % count($titles);
				$random_first  = rand() % count($firstnames);
				$random_middle = rand() % count($firstnames);
				$random_last   = rand() % count($lastnames);
				$random_pref   = rand() % 3;
				switch($random_pref) {
					case "0":
						$midpref = ' ';
						break;
					case "1":
						$midpref = ' ' . substr($firstnames[$random_middle],0,1) . '. ';
						break;
					case "2";
						$midpref = ' ' . $firstnames[$random_middle] . ' ';
						break;
				}
				rand() % 2 ? $company = '' : $company = 'Xavier Tech';
				$query = "insert into `tblContacts`(con_title, con_firstname, con_middlename, con_lastname, con_preferredname, con_company, con_birthday)
						  values('".$titles[$random_title]."','".$firstnames[$random_first]."','".$firstnames[$random_middle]."','".$lastnames[$random_last]."','".$firstnames[$random_first].$midpref.$lastnames[$random_last]."','".$company."','".date("Y-m-d",(time() - 567648000) - rand(0,1419120000))."')";
				$result = mysql_query($query);
				if(!$result) { die("tblContacts query error:<br /><br />" . mysql_error()); }
				// set spouses and anniversaries
				for($ix2 = $contacts; $ix2 >= 4; $ix2 -= 10) {
					$anniversary = date("Y-m-d",(time() - rand(0,5 * 365 * 24 * 60 * 60)));
					$spouse1 = $ix2 - 3;
					$spouse2 = $ix2 - 2;
					$query = "update `tblContacts`
							  set con_spouse_id = " . $spouse1 . ",
								  con_anniversary = '" . $anniversary . "'
							  where con_id = " . $spouse2;
					$result = mysql_query($query);
					if(!$result) { die("tblContacts query error:<br /><br />" . mysql_error()); }
					$query = "update `tblContacts`
							  set con_spouse_id = " . $spouse2 . ",
								  con_anniversary = '" . $anniversary . "'
							  where con_id = " . $spouse1;
					$result = mysql_query($query);
					if(!$result) { die("tblContacts query error:<br /><br />" . mysql_error()); }
				}
			}

			// ================ BEGIN tblPhone ================
			// Drop tblPhone
			$query = "drop table if exists `tblPhone`";
			$result = mysql_query($query);
			// Create tblPhone
			$query = "create table `tblPhone` (
					  `pho_id` INT(11) NOT NULL auto_increment,
					  `con_id` INT(11) NOT NULL,
					  `pho_hide` BOOLEAN NOT NULL DEFAULT '0',
					  `pho_primary` BOOLEAN NOT NULL DEFAULT '0',
					  `pho_label` VARCHAR(20) NOT NULL,
					  `pho_number` VARCHAR(10) NOT NULL,
					  `pho_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  primary key (`pho_id`) )";
			$result = mysql_query($query);
			$result ? print 'tblPhone query successful...<br /><br />' : die("tblPhone query error:<br /><br />" . mysql_error());
			// Populate tblPhone
			$labels = array('Home','Office','Cell');
			for ($ix = 1; $ix <= $contacts; $ix++) {
				$phone_number_count = rand() % ($max_phone_address_email_per_contact + 1);
				while($phone_number_count > 0) {
					$phone_number_count == 1 ? $primary = 1 : $primary = 0;
					$query = "insert into `tblPhone`(con_id, pho_primary, pho_label, pho_number)
							  values(".$ix.",".$primary.",'".$labels[$phone_number_count - 1]."','".rand(211,999) . rand(2111111,9999999)."')";
					$result = mysql_query($query);
					if(!$result) { die("tblPhone query error:<br /><br />" . mysql_error()); }
					$phone_number_count--;
				}
			}

			// ================ BEGIN tblAddress ================
			// Drop tblAddress
			$query = "drop table if exists `tblAddress`";
			$result = mysql_query($query);
			// Create tblAddress
			$query = "create table `tblAddress` (
					  `addr_id` INT(11) NOT NULL auto_increment,
					  `con_id` INT(11) NOT NULL,
					  `addr_hide` BOOLEAN NOT NULL DEFAULT '0',
					  `addr_primary` BOOLEAN NOT NULL DEFAULT '0',
					  `addr_label` VARCHAR(20) NOT NULL,
					  `addr_house_number` VARCHAR(10) NOT NULL,
					  `addr_street_direction` VARCHAR(3) DEFAULT NULL,
					  `addr_street_name` VARCHAR(40) DEFAULT NULL,
					  `addr_street_type` VARCHAR(10) DEFAULT NULL,
					  `addr_street_suffix` VARCHAR(3) DEFAULT NULL,
					  `addr_additional` VARCHAR(100) DEFAULT NULL,
					  `addr_po_box` VARCHAR(40) DEFAULT NULL,
					  `addr_city` VARCHAR(100) NOT NULL,
					  `addr_state` VARCHAR(2) NOT NULL,
					  `addr_zip_code` VARCHAR(10) NOT NULL,
					  `addr_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  primary key (`addr_id`) )";
			$result = mysql_query($query);
			$result ? print 'tblAddress query successful...<br /><br />' : die("tblAddress query error:<br /><br />" . mysql_error());
			// Populate tblAddress
			$directions = array('N','S','E','W');
			$street_names = array('Third','First','Fourth','Park','Fifth','Main','Sixth','Oak','Seventh','Pine');
			$street_suffixes = array('Ave','Blvd','Ct','Ln','Pkwy','Pl','Rd','St','Ter','Way');
			$cities = array('Fairview','Midway','Oak Grove','Franklin','Riverside','Centerville','Mount Pleasant','Georgetown','Salem','Greenwood');
			$states = array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY');
			$labels = array('Home','Office','Other');
			for ($ix = 1; $ix <= $contacts; $ix++) {
				$address_count = rand() % ($max_phone_address_email_per_contact + 1);
				while($address_count > 0) {
					$direction_rand = rand() % 4;
					$name_rand = rand() % 10;
					$suffix_rand = rand() % 10;
					$cities_rand = rand() % 10;
					$states_rand = rand() % 50;
					$address_count == 1 ? $primary = 1 : $primary = 0;
					$query = "insert into `tblAddress`(con_id, addr_primary, addr_label, addr_house_number, addr_street_direction, addr_street_name, addr_street_type, addr_city, addr_state, addr_zip_code)
							  values(".$ix.",".$primary.",'".$labels[$address_count - 1]."','".rand(1000,9999)."','".$directions[$direction_rand]."','".$street_names[$name_rand]."','".$street_suffixes[$suffix_rand]."','".$cities[$cities_rand]."','".$states[$states_rand]."','".rand(10000,99999)."')";
					$result = mysql_query($query);
					if(!$result) { die("tblAddress query error:<br /><br />" . mysql_error()); }
					$address_count--;
				}
			}

			// ================ BEGIN tblEmail ================
			// Drop tblEmail
			$query = "drop table if exists `tblEmail`";
			$result = mysql_query($query);
			// Create tblEmail
			$query = "create table `tblEmail` (
					  `eml_id` INT(11) NOT NULL auto_increment,
					  `con_id` INT(11) NOT NULL,
					  `eml_hide` BOOLEAN NOT NULL DEFAULT '0',
					  `eml_primary` BOOLEAN NOT NULL DEFAULT '0',
					  `eml_label` VARCHAR(20) NOT NULL,
					  `eml_address` VARCHAR(100) NOT NULL,
					  `addr_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  primary key (`eml_id`) )";
			$result = mysql_query($query);
			$result ? print 'tblEmail query successful...<br /><br />' : die("tblEmail query error:<br /><br />" . mysql_error());
			// Populate tblEmail
			$providers = array('aol.com','msn.com','gmail.com','yahoo.com');
			$labels = array('Work','Personal');
			for ($ix = 1; $ix <= $contacts; $ix++) {
				$email_count = rand() % ($max_phone_address_email_per_contact + 1);
				$query = "select con_firstname, con_lastname from tblContacts where con_id = ".$ix;
				$result = mysql_query($query);
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
				$username = substr(strtolower($row["con_firstname"]),0,1).strtolower($row["con_lastname"]);
				while($email_count > 0) {
					$provider_rand = rand() % 4;
					$label_rand = rand() % 2;
					$email_count == 1 ? $primary = 1 : $primary = 0;
					$query = "insert into `tblEmail`(con_id, eml_primary, eml_label, eml_address)
							  values(".$ix.",".$primary.",'".$labels[$label_rand]."','".$username.'@'.$providers[$provider_rand]."')";
					$result = mysql_query($query);
					if(!$result) { die("tblAddress query error:<br /><br />" . mysql_error()); }
					$email_count--;
				}
			}

			// ================ BEGIN tblGroups ================
			// Drop tblGroups
			$query = "drop table if exists `tblGroups`";
			$result = mysql_query($query);
			// Create tblGroups
			$query = "create table `tblGroups` (
					  `grp_id` INT(11) NOT NULL auto_increment,
					  `grp_hide` BOOLEAN NOT NULL DEFAULT '0',
					  `grp_label` VARCHAR(20) NOT NULL,
					  `grp_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  primary key (`grp_id`) )";
			$result = mysql_query($query);
			$result ? print 'tblGroups query successful...<br /><br />' : die("tblGroups query error:<br /><br />" . mysql_error());
			// Populate tblGroups
			$query = "insert into `tblGroups`(grp_label) values('Smith-Brown'),('Xavier')";
			$result = mysql_query($query);
			if(!$result) { die("tblGroups query error:<br /><br />" . mysql_error()); }

			// ================ BEGIN tblGroupMembers ================
			// Drop tblGroups
			$query = "drop table if exists `tblGroupMembers`";
			$result = mysql_query($query);
			// Create tblGroups
			$query = "create table `tblGroupMembers` (
					  `mem_id` INT(11) NOT NULL auto_increment,
					  `con_id` INT(11) NOT NULL,
					  `mem_hide` BOOLEAN NOT NULL DEFAULT '0',
					  `grp_id` INT(11) NOT NULL,
					  `mem_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  primary key (`mem_id`) )";
			$result = mysql_query($query);
			$result ? print 'tblGroupMembers query successful...<br /><br />' : die("tblGroupMembers query error:<br /><br />" . mysql_error());
			// Populate tblGroupMembers
			$query = "select con_id from tblContacts where con_lastname = 'Smith' or con_lastname = 'Brown'";
			$result = mysql_query($query);
			if(!$result) { die("tblGroupMembers query error:<br /><br />" . mysql_error()); }
			$family = array();
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) { $family[] = $row["con_id"]; }
			foreach($family as $key => $value) {
				$query = "insert into `tblGroupMembers`(con_id, grp_id) values (" . $value . ",1)";
				$result = mysql_query($query);
				if(!$result) { die("tblGroupMembers query error:<br /><br />" . mysql_error()); }
			}
			$query = "select con_id from tblContacts where con_company = 'Xavier Tech'";
			$result = mysql_query($query);
			if(!$result) { die("tblGroupMembers query error:<br /><br />" . mysql_error()); }
			$xavier = array();
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) { $xavier[] = $row["con_id"]; }
			foreach($xavier as $key => $value) {
				$query = "insert into `tblGroupMembers`(con_id, grp_id) values (" . $value . ",2)";
				$result = mysql_query($query);
				if(!$result) { die("tblGroupMembers query error:<br /><br />" . mysql_error()); }
			}

			// ================ BEGIN tblNotes ================
			// Drop tblNotes
			$query = "drop table if exists `tblNotes`";
			$result = mysql_query($query);
			// Create tblNotes
			$query = "create table `tblNotes` (
					  `note_id` INT(11) NOT NULL auto_increment,
					  `con_id` INT(11) NOT NULL,
					  `note_hide` BOOLEAN NOT NULL DEFAULT '0',
					  `note_primary` BOOLEAN NOT NULL DEFAULT '0',
					  `note_body` TEXT NOT NULL,
					  `note_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  primary key (`note_id`) )";
			$result = mysql_query($query);
			$result ? print 'tblNotes query successful...<br /><br />' : die("tblNotes query error:<br /><br />" . mysql_error());
			// Populate tblNotes
			// insert into `tblNotes`(con_id, note_primary, note_body)
			// values(1, 1, 'This is the song that never ends, yes it goes on and on my friends.');

			mysql_close($connection);
		?>
	</body>
</html>
