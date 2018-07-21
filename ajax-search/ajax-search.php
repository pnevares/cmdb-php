<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CMDB - contact.php</title>
		<script src="../jquery.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#livesearch").keyup(function(e) {
					if(this.value != '') {
						$("#livesearch_results").addClass('show');
						$("#livesearch_results").removeClass('hide');
						// send request
						var myRandom = parseInt(Math.random() * 99999999);
						$.get("ajax-search-results.php", {q: this.value, r: myRandom}, function(xml) {
							$("#livesearch_results").html(xml);
							$("#livesearch_results > a").click(function() {
								$("#livesearch").attr("value",$(this).attr("name"));
								$("#livesearch_results").addClass('hide');
								$("#livesearch_results").removeClass('show');
								return false;
							});
						} );
					} else {
						$("#livesearch_results").addClass('hide');
						$("#livesearch_results").removeClass('show');
					}
				});
			});
		</script>
		<style type="text/css">
			.livesearch_results {
				font-size: 8pt;
				font-family: Arial;
				width: 144px;
				background-color: #dde;
				border: 1px dashed black;
				position: absolute;
				opacity: 0.9;
				display: inline;
				display: none;
			}
			.livesearch_results a:hover {
				background-color: #f99;
			}
			.hide { display: none; }
			.show { display: inline; }
			.red { color: red; }
			.matched { font-weight: bold; background-color: white; }
		</style>
	</head>
	<body>
		<div>
			<div><input type="text" name="livesearch" id="livesearch" class="livesearch"></div>
			<div id="livesearch_results" class="livesearch_results"></div>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
		</div>
	</body>
</html>
