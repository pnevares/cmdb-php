$(document).ready(function() {
	$("#spousesearch").keyup(function(e) {
		if(this.value != '') {
			$("#spousesearch_results").addClass('show');
			$("#spousesearch_results").removeClass('hide');
			// send request
			var myRandom = parseInt(Math.random() * 99999999);
			$.get("spousesearch.php", {q: this.value, r: myRandom}, function(xml) {
				$("#spousesearch_results").html(xml);
				$("#spousesearch_results > a").click(function() {
					$("#spousesearch").attr("value",$(this).attr("name"));
					$("#spousesearch_results").addClass('hide');
					$("#spousesearch_results").removeClass('show');
					return false;
				});
			});
		} else {
			$("#spousesearch_results").addClass('hide');
			$("#spousesearch_results").removeClass('show');
		}
	});
});