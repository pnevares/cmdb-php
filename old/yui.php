<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>YUI Base Page</title>
		<link rel="stylesheet" href="http://yui.yahooapis.com/2.5.1/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css" />
	    <script type="text/javascript" src="jquery.js"></script>
		<link rel="stylesheet" href="livesearch.css" type="text/css" />
	    <script type="text/javascript" src="livesearch.js"></script>
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
			input[type=text], input[type=file], input[type=checkbox], select, input[type=submit] { 
				border: 1px solid #faa;
				background-color: #eee;
				font-size: 93%;
			}
			input[type=submit] { margin-bottom: 10px; }
			input[type=file] { font-size: 77%; }
			input[type=text].name, input[type=file].photo { width: 125px; }
			input[type=text].day { width: 18px; }
			input[type=text].year { width: 36px; }
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
		</style>
	</head>
	<body>
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
									<form class="names_form" action="">
									<div>
										<label for="title">Title:</label>
										<select name="title" id="title">
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
										<input type="text" class="name" name="first_name" id="first_name" />
									</div>
									<div>
										<label for="middle_name">Middle Name:</label>
										<input type="text" class="name" name="middle_name" id="middle_name" />
									</div>
									<div>
										<label for="last_name">Last Name:</label>
										<input type="text" class="name" name="last_name" id="last_name" />
									</div>
									<div>
										<label for="suffix">Suffix:</label>
										<select name="suffix" id="suffix">
											<option></option>
											<option value="Jr.">Jr.</option>
											<option value="Sr.">Sr.</option>
										</select>
									</div>
									<div>&nbsp;</div>
									<div>
										<label for="preferred_name">Preferred Name:</label>
										<input type="text" class="name" name="preferred_name" id="preferred_name" />
									</div>
									<div>&nbsp;</div>
									<div>
										<label for="preferred_name">Spouse:</label>
										<div>
											<div><input type="text" class="name" name="spouse" id="livesearch" /></div>
											<div class="livesearch"><div id="livesearch_results" class="livesearch_results"></div></div>
										</div>
									</div>
									</form>
								</div>
								<div class="personal-right">
									<form class="names_form2" action="">
									<div class="save">
										<input type="submit" name="submit" id="submit" value="Save changes" />
									</div>
									<div>
										<label for="birthmonth">Birthday:</label>
										<input type="text" class="day" name="birthmonth" id="birthmonth" /> /
										<input type="text" class="day" name="birthday" id="birthday" /> /
										<input type="text" class="year" name="birthyear" id="birthyear" />
									</div>
									<div>
										<label for="anniversarymonth">Anniversary:</label>
										<input type="text" class="day" name="anniversarymonth" id="anniversarymonth" /> /
										<input type="text" class="day" name="anniversaryday" id="anniversaryday" /> /
										<input type="text" class="year" name="anniversaryyear" id="anniversaryyear" />
									</div>
									<div>
										<label for="website">Website:</label>
										<input type="text" class="name" name="website" id="website" />
									</div>
									<div>
										<label for="photo">Photo:</label>
										<input type="file" class="photo" name="photo" id="photo" />
									</div>
									<div>&nbsp;</div>
									<div>
										<label for="first_name">Company:</label>
										<input type="text" class="name" name="company" id="company" />
									</div>
									<div>
										<label for="middle_name">Job Title:</label>
										<input type="text" class="name" name="job_title" id="job_title" />
									</div>
									<div>
										<label for="last_name">Department:</label>
										<input type="text" class="name" name="department" id="department" />
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
									Contact Methods
								</div>
							</div>
							<div class="yui-u">
								<div class="content">
									Groups
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="yui-b">
					<div class="cmdb-nav">
						<ul>
							<li><a href="">Search</a></li>
							<li><a href="">New Contact</a></li>
							<li><a href="">New Group</a></li>
							<li><a href="">Import</a></li>
							<li><a href="">Export</a></li>
							<li><a href="">Reset CMDB</a></li>
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
	</body>
</html>


