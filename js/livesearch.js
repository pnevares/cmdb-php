$(document).ready(function() {
	$("#livesearch").keyup(function(e) {
		if(this.value != '') {
			$("#livesearch_results").addClass('show');
			$("#livesearch_results").removeClass('hide');
			// send request
			var myRandom = parseInt(Math.random() * 99999999);
			$.get("livesearch.php", {q: this.value, r: myRandom}, function(xml) {
				$("#livesearch_results").html(xml);
				$("tr").click(function() {
					$("#livesearch").attr("value",$(this).attr("id"));
					location.href = 'contact.php?id=' + $(this).find("td").attr("id");
				});
			});
		} else {
			$("#livesearch_results").addClass('hide');
			$("#livesearch_results").removeClass('show');
		}
	});
});