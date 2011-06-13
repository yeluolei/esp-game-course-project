		$(function(){
				init();
				$('tr td:first-child').css("border-left","1px solid #5C9446");
			});
		
		function init()
		{
			bindlogin();
			ctoreg();
		};

		function bindlogin()
		{
			$('#login').click(function(){
				$.post("validate.php",
						{userid:$('#userid').val(),passwd:$('#passwd').val()},
						function(data){
							if (data.succ==true)
							{
								$('#loginreg').html("<label id='welcome'>Welcome!</label>" +
										"<label id='name'>"+
										data.userid+
										"</label>" +
										"<input id='startgame' class='button' type='button' value='Start Game'>");
								bindstart();
							}else{
								$('#noti').html(data.msg);
							}
						},"json");
				});
		};
		
		function bindreg()
		{
			$('#reg').click(function(){
				$.post("reg.php",
						{userid:$('#userid').val(),passwd:$('#passwd').val()},
						function(data){
							if (data.succ==true)
							{
								$('#loginreg').html("<label id='welcome'>Welcome!</label>" +
										"<label id='name'>"+
										data.userid+
										"</label>" +
										"<input id='startgame' class='button' type='button' value='Start Game'>");
								bindstart();
							}else{
								$('#noti').html(data.msg);
							}
						},"json");
				});
		}
			
		function ctoreg()
		{
			$('#changereg').click(function(){
				$('#loginreg').html(registstr);
				ctologin();
				bindreg();
				});
			};
		function ctologin(){
			$('#changelogin').click(function(){
				$('#loginreg').html(loginstr);
				ctoreg();
				bindlogin();
				});
			};
		
		function bindstart(){
			$('#startgame').click(
					function(){
						 connect();
						 $('#startgame').prop("disabled",true);
						 $('#startgame').prop("value","Waiting...");
					}
			);
		}
		
		function connect(){
			$.get('connection.php',function(data){
					if (data.status == "fail"){
						setTimeout("connect()", 1000);
						}
					else{
						window.location.href="play.php?url="+data.url;
					}
				},"json");
		};
			
		var registstr="<label class='t'>Register</label>"+
				"<div class='block'>"+
				"<label class='field'>User Name:</label>" +
				"<input id='userid' class='labelbox' type='text' name='userid'/>" +
				"</div>" +
				"<div class='block'>" +
				"<label class='field'>Password:</label>" +
				"<input id='passwd' class='labelbox' type='text' name='passwd'/>" +
				"</div>" +
				"<p id='noti'></p>" +
				"<div class='buttonarea'>" +
				"<a id='changelogin' href='#' >Login</a>" +
				"<input id='reg' class='button'  type='button' value='Register'/>" +
				"</div>";
		var loginstr='<label class="t">Login</label>'+
			'<div class="block">'+
			'<label class="field">User Name:</label>'+
			'<input id="userid" class="labelbox" type="text" name="userid"/>'+
			'</div>'+
			'<div class="block">'+
			'<label class="field">Password:</label>'+
			'<input id="passwd" class="labelbox" type="text" name="passwd"/>'+
			'</div>'+
			'<p id="noti"></p>'+
			'<div class="buttonarea">'+
			'<a id="changereg" href="#" >Register</a>'+
			'<input id="login" class="button"  type="button" value="Login"/>'+
			'</div>';