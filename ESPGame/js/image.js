$(
function() {
	$('#pass').click(function() {
		$.get("getimage.php", function(data) {
			$('#gameimg').attr({
				src : data.url
			});
		}, "json");
	});
	
	$('#begingame').click(function(){
		$('#begingame').attr("disabled","disabled");
		
	});
});