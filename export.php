<?php
	# Purpose: Export a contact record or group to vCard, CSV, or plain text.
	# pnevares - updated 11-10-2008

	// select contact info
	require('_db.php');

	$query = "select con_title, con_firstname, con_middlename, con_lastname, 
					 con_preferredname, con_company, con_job_title, con_department, con_suffix, 
					 con_website, con_birthday, con_photo
				from tblContacts c
			   where c.con_id = " . $_GET['id'];
	$result = mysql_query($query);

	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$title = $row["con_title"];
		$firstname = $row["con_firstname"];
		$middlename = $row["con_middlename"];
		$lastname = $row["con_lastname"];
		$suffix = $row["con_suffix"];
		$preferredname = $row["con_preferredname"];
		$birthday = $row["con_birthday"];
		$website = $row["con_website"];
		$company = $row["con_company"];
		$job_title = $row["con_job_title"];
		$department = $row["con_department"];
	}

	$query2 = "select eml_address
				from tblEmail e
			   where e.con_id = " . $_GET['id'] . "
			     and e.eml_primary";
	$result2 = mysql_query($query2);

	while($row = mysql_fetch_array($result2, MYSQL_ASSOC)) {
		$email = $row["eml_address"];
	}

	$query3 = "select a.addr_label, a.addr_house_number, a.addr_street_direction, a.addr_street_name, a.addr_street_type,
					  a.addr_street_suffix, a.addr_additional, a.addr_po_box, a.addr_city, a.addr_state, a.addr_zip_code
				from tblAddress a
			   where a.con_id = " . $_GET['id'] . "
			   	 and a.addr_primary";
	$result3 = mysql_query($query3);

	while($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {
		$address .= $row["addr_house_number"] ? $row["addr_house_number"] : '';
		$address .= $row["addr_street_direction"] ? ' ' . $row["addr_street_direction"] : '';
		$address .= $row["addr_street_name"] ? ' ' . $row["addr_street_name"] : '';
		$address .= $row["addr_street_type"] ? ' ' . $row["addr_street_type"] : '';
		$address .= $row["addr_street_suffix"] ? ' ' . $row["addr_street_suffix"] : '';
		$city = $row["addr_city"];
		$state = $row["addr_state"];
		$zip = $row["addr_zip_code"];
		switch ($row["addr_label"]) {
			case "Home":
				$addresstype = 'HOME';
				break;
			case "Work":
				$addresstype = 'WORK';
				break;
			default:
				$addresstype = '';
		}
	}

	$query4 = "select p.pho_label, p.pho_number
				from tblPhone p
			   where p.con_id = " . $_GET['id'] . "
			     and p.pho_primary";
	$result4 = mysql_query($query4);

	while($row = mysql_fetch_array($result4, MYSQL_ASSOC)) {
		$phone = $row["pho_number"] ? '(' . substr($row["pho_number"],0,3) . ') ' . substr($row["pho_number"],3,3) . '-' . substr($row["pho_number"],6,4) : '';
		switch ($row["pho_label"]) {
			case "Home":
				$phonetype = 'HOME';
				break;
			case "Office":
				$phonetype = 'WORK';
				break;
			case "Cell":
				$phonetype = 'CELL';
				break;
			default:
				$phonetype = '';
		}
	}

	$uid = str_replace('-','',mysql_result(mysql_query('Select UUID()'),0));

	// We'll be outputting a VCF
	header('Content-type: text/x-vcard');
	
	// It will be called Firstname-Lastname.vcf
	header('Content-Disposition: attachment; filename="'.$firstname.'-'.$lastname.'.vcf"');

	echo <<<END_OUTPUT
<pre>
BEGIN:VCARD
VERSION:2.1
FN:$preferredname
N:$lastname;$firstname;$middlename;$title;$suffix
PHOTO;VALUE=URL:$photo
BDAY:$birthday
ADR;PREF;$addresstype:;;$address;$city;$state;$zip
TEL;PREF;$phonetype:$phone
EMAIL;INTERNET:$email
TITLE:$job_title
ORG:$company;$department
NOTE;ENCODING=QUOTED-PRINTABLE:Comments go here.
URL:$website
UID:$uid
REV:2008-11-10T14\:15\:25Z
X-GENERATOR:CMDB (http://www.forgottencorner.com/pabnev/cmdb/)
END:VCARD
</pre>
END_OUTPUT;
	/*
		Example vCard:
		
		BEGIN:VCARD
		VERSION:2.1
		FN:Mr. Pablo Javier Nevares IV
		N:Nevares;Pablo;Javier;Mr.;IV
		PHOTO;VALUE=URL:http://pablo.nevares.com/webcam/webcam.jpg
		BDAY:2008-06-26
		ADR;HOME:PO Box 11111;Building D;1600 Pennsylvania Ave;Chandler;AZ;85224-2260;UNITED STATES
		LABEL;DOM;WORK;ENCODING=QUOTED-PRINTABLE:Another PO Box=0D=0A=Another Building=0D=0A=Another Street=0D=0A=Another City=0D=0A=Another State=0D=0A=Another Postal=0D=0A=UNITED STATES
		TEL;PREF;WORK:6025225222
		TEL;HOME:6025205200
		EMAIL;INTERNET:1@1.us
		TITLE:Developer
		ROLE:Job Role
		ORG:HP;IT
		NOTE;ENCODING=QUOTED-PRINTABLE:Comments go here.
		
		On a new line.
		URL:http://www.mywebsite.com
		UID:3a1a588f547de4a4d151b87d42e446e9
		REV:2008-11-10T14\:15\:25Z
		X-GENERATOR:CMDB (http://www.forgottencorner.com/pabnev/cmdb/)
		END:VCARD
	*/
?>
