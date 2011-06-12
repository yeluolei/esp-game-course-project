$(
function() {
	$('#pass').click(function() {
		$.get("pass.php", function(data) {
			$('#gameimg').attr({
				src : data.url
			});
		}, "json");
	});
	
	$('#begingame').click(function(){
		$('#begingame').attr("disabled","disabled");
		
	});
});