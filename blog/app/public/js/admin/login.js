$('#login').on('click',function(){
	pwdLogin();
});
$("input[name='name'],input[name='password']").on('keyup', function(event) {
	　if (event.keyCode == "13") {
		pwdLogin();
	　}

});
function pwdLogin(){
	var name = $("form input[name='name']").val();
	var password = $("form input[name='password']").val();
	if(!!!name){
		layermsg(1,'用户名为空！');
		return false;
	}
	if(!!!password){
		layermsg(1,'密码为空！');
		return false;
	}
	$.post(
			'/admin/login/pwdlogin',
			{'name':name,'password':password},
			function(e){
				if(e.code == 0){
					layermsg(e.code,e.msg);
					setTimeout(function(){window.location.href = e.data.url},2000);
				}else{
					layermsg(e.code,e.msg);
				}
			},
			'json'
	);
}
