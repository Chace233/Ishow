var LOCAL_PLATFORM_TYPE=2
// 1-android
// 2-web

/*
ajax仅支持如下参数
url：
method：
cache：
dataType：(只支持json和text)
data：(只支持json对象)
success : function(data);
error : function(data,textStatus);
*/

var ishowAjax = function (settings) {
	if (LOCAL_PLATFORM_TYPE === 1){
		callback=function(data,err){
			if (err){
			    settings.success(data);
			}else{
                settings.error(data,err.statusCode);
			}

		}
        ajax(settings,callback);
	}else if (LOCAL_PLATFORM_TYPE === 2){
        $.ajax(settings);
	}
}
