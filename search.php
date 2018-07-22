<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>CMDB - search.php</title>
	    <script type="text/javascript" src="js/jquery.js"></script>
	    <script type="text/javascript" src="js/livesearch.js"></script>
		<link rel="stylesheet" href="http://yui.yahooapis.com/2.5.1/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css" />
		<link rel="stylesheet" href="css/livesearch.css" type="text/css" />
		<link rel="stylesheet" href="css/cmdb-style.css" type="text/css" />
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
									<div id="search">
										<form action="search.php" method="post" id="searchform">
											<input type="text" class="livesearch" name="livesearch" id="livesearch" value="" /> <input type="submit" class="" name="" value="Search" />
										</form>
									</div>
									<div class="livesearch"><div id="livesearch_results" class="livesearch_results"></div></div>
								</div>
							</div>
						</div>
						<div class="yui-b">
							<div class="cmdb-nav">
								<ul>
									<li><a href="search.php">Search</a></li>
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
