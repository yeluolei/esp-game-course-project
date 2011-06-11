$(
function() {
	$('#pass').click(function() {
		$.get("getimage.php", function(data) {
			$('#gameimg').attr({
				src : data.url
			});
		}, "json");
	});
	
});