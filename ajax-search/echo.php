<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=windows-1250">
		<meta name="generator" content="PSPad editor, www.pspad.com">
		<title>echo test</title>
	</head>
	<body>
		<?php
			$one = 1;
			$two = 2;
			$total = $one + $two;

			echo <<<END_OUTPUT
				The total of $one plus $two is $total<br /><br />
END_OUTPUT;

			$three = 3;
			$four = 4;
			$total = $four - $three;

			echo <<<END_OUTPUT
				The total of $four - $three is $total<br />
				The total of $four / $three is $total
END_OUTPUT;
				
		?>
	</body>
</html>
