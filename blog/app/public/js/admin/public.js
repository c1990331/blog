
function layermsg(code,message)
{
	switch (code){
		case 0:
			var layer = '<div id="layermsg" style="background: rgb(0, 0, 0); position: fixed; z-index: 10; width: auto; height: 40px; left: 45%; top: 55%; opacity: 0.9; color: rgb(255, 255, 255); border: 1px solid rgb(0, 0, 0); border-radius: 6px; text-align: center; line-height: 40px; font-size: 14px;padding:0 5px;">'+message+'</div>';
			break;
		case 1:
//			var layer = '<div id="layermsg" style="display:inline-block;zoom:1; float:left;width:auto;height:35px;margin:0 auto;z-index:1000;background-color:#fff;line-height:35px;text-align: center;color:red;padding:2px 5px;">'+message+'</div>';
			var layer = '<div id="layermsg" style="background: rgb(0, 0, 0); position: fixed; z-index: 10; width: auto; height: 40px; left: 45%; top: 55%; opacity: 0.9; color: red; border: 1px solid rgb(0, 0, 0); border-radius: 6px; text-align: center; line-height: 40px; font-size: 14px;padding:0 5px;">'+message+'</div>';
			break;
	}
	if($('#layermsg').length > 0){
		
	}else{		
		$('body').append(layer);
		$('#layermsg').delay (100).fadeIn().delay(1000).fadeOut();
		setTimeout(function(){$('#layermsg').remove();},1000);
	}
}