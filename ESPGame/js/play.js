var checkf;
$(init());
$(
		function(){
			bindgaming();
		}
);
function bindgaming(){
	$('#pass').click(function(){
		$.get("pass.php", function(data) {
			$('#gameimg').attr({
				src : data.url
			});
		}, "json");
		passes();
	});
	$('#label').click(function(){
		test();
		label($('#labelbox').val());
		$('#labelbox').val('');
	});
    $('#counter_2').countdown({
        image: 'image/digits.png',
        startTime: '00:10',
        timerEnd: function(){ 
        	finish();
        },
        format: 'mm:ss'
      });
}

function finish(){
	alert("finish");
	clearTimeout(checkf);
	$.post("leave.php",function(){
		$('#gamecenter').html(
				'<input id="restart" class="button" type="button" value="restart" /> '+
				'<div>'+
				'<p>waiting for connectting ..</p>'+
				'</div>'
		);
		$('#restart').click(function(){
			$('#labelstr').html('');
			$('#limitstr').html('');
			$('#passnum').html(0);
			$('#scorenum').html(0);
			connect();
		});
	});
}

function test(){
	var item = $('#labelbox').attr("value");
	var id = 1;
	$.get('match.php',{label:item, picid:id},function(data){
		if (data.matched == "false"){
			
			}
		else{
			alert("matched");
			score();
		}
	},"json");
};


function init() {
	close();
	check();
};

function connect() {
	$.get('connection.php', function(data) {
		if (data.status == "fail") {
			setTimeout("connect()", 1000);
		} else {
			$('#gamecenter').html('<div id="input">'+
					'<input id="labelbox" type="text" />'+ 
					'<input id="label" class="button" type="button" value="Label" />'+ 
					'<input id="pass" class="button" type="button" value="Pass" /> '+
					'</div>'+
					'<div id="notify">'+
					'<p>here put the notis</p>'+
					'</div>'+
					'<div id="image">'+
					'<img id="gameimg" src="image/test.jpg" />'+
					'</div>');
			bindgaming();
			check();
		}
	}, "json");
};

function close() {
	$(window).unload(function() {
		$.post('stopgame.php', {
			operation : '0'
		});
	});
};

function check() {
	$.get('getinfo.php', function(data) {
		if (data.parterstatus == 0) {
			alert('parter leave');
			notify('partter leave');
			location.herf = "login.php";
		} else {
			if(data.parterstatus == 3){
				notify('your parter has passed this picture');
				$('#gameimg').attr({
					src : data.url
				});
			}
			checkf = setTimeout("check()", 1000);
		}
	}, "json");
}

function label(str){
	$('#labelstr').append("<p>"+ str +"</p>");
	notify(str);
}

function score(){
	var value=new Number($('#passnum').html());
	value = value + 1;
	$('#scorenum').html(value);
	$('#labelstr').html('');
}

function passes(){
	var value=new Number($('#passnum').html());
	value = value + 1;
	$('#passnum').html(value);
	$('#labelstr').html('');
}

function notify(str){
	$('#notify').html("<p>"+str+"</p>").slideDown('slow');
	setTimeout(function(){
		$('#notify').slideUp('slow');
	},3000);
}
