(function ($) {
            $.imageFileVisible = function (options) {
                // 默认选项
                var defaults = {
                    //包裹图片的元素
                    wrapSelector: null,
                    //<input type=file />元素
                    fileSelector: null,
                    width: '100%',
                    height: 'auto',
                    errorMessage: "不是图片"
                };
                // Extend our default options with those provided.    
                var opts = $.extend(defaults, options);
                $(opts.fileSelector).on("change", function () {
                    var file = this.files[0];
                    var imageType = /image.*/;
                    if (file.type.match(imageType)) {
                        var reader = new FileReader();
                        reader.onload = function () {
                            var img = new Image();
//                            img.src = reader.result;
//                            $(img).width(opts.width);
//                            $(img).height(opts.height);
//                            $(opts.wrapSelector).append(img);
                            $(opts.wrapSelector).attr('src',reader.result);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        alert(opts.errorMessage);
                    }
                });
            };
        })(jQuery);
        $(document).ready(function () {
            //图片显示插件
            $.imageFileVisible({ wrapSelector: "#img",
                fileSelector: "#uplode_file",
                width: 100,
                height: 100
            });
            $('#save').click(function(){
            	var title = $("input[name='title']").val();
            	var desc = $("textarea[name='desc']").val();
            	var img = $("#img").attr('src');
            	var article = $('#article').val();
            	if(!type){
            		layermsg(1,'文章类型错误！');return false;
            	}
            	if(!title){
            		layermsg(1,'标题为空！');return false;
            	}
            	if(!desc){
            		layermsg(1,'描述为空！');return false;
            	}
            	if(!article){
            		layermsg(1,'文章为空！');return false;
            	}
            	$.post(
            		'/admin/article/addFile',
            		{'title':title,'desc':desc,'article':article,'type':type},
            		function(e){
            			if(e.code == 0){
            				layermsg(e.code,e.msg);
            				setTimeout(function(){            						
        						window.location.href = e.data.url;
            				},2000);
            			}else{
            				layermsg(e.code,e.msg);            				
            			}
            		},'json'
            	);
            })
            $('#edit').click(function(){
            	var title = $("input[name='title']").val();
            	var desc = $("textarea[name='desc']").val();
            	var img = $("#img").attr('src');
            	var article = $('#article').val();
            	var status = $("select[name='status']").val();
            	if(!type){
            		layermsg(1,'文章类型错误！');return false;
            	}
            	if(!id){
            		layermsg(1,'文章ID错误！');return false;
            	}
            	if(!title){
            		layermsg(1,'标题为空！');return false;
            	}
            	if(!desc){
            		layermsg(1,'描述为空！');return false;
            	}
            	if(!article){
            		layermsg(1,'文章为空！');return false;
            	}
            	if(!status){
            		layermsg(1,'状态未选择！');return false;
            	}
            	$.post(
            			'/admin/article/editFile',
            			{'title':title,'desc':desc,'article':article,'type':type,'id':id,'status':status},
            			function(e){
            				if(e.code == 0){
            					layermsg(e.code,e.msg);
            					setTimeout(function(){            						
	            						window.location.href = e.data.url;
            					},2000);
            				}else{
            					layermsg(e.code,e.msg);            				
            				}
            			},'json'
            	);
            })
        });