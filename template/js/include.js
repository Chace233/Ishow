$(".include").each(function() {
    var file = $(this).attr('file');
    if (!!file) {
        var thisObj = $(this);
        $.get(file, function(html){
            thisObj.after(html).remove();
        });
    }
});


$(document).ready(function(){
    $.get("../controller/GetUserInfos.php", function(result, status){
        var json = JSON.parse(result);
        if (0 != json.code) {
            document.getElementById("islogin").setAttribute("href", "login.html");
            document.getElementById("islogin").innerHTML = "登陆";
        } else {
            if (json.data == null) {
                document.getElementById("islogin").setAttribute("href", "login.html");
                document.getElementById("islogin").innerHTML = "登陆";
            } else {
                document.getElementById("islogin").setAttribute("href", "user.html?uname=" + json.data[0].uname);
                document.getElementById("islogin").innerHTML = json.data[0].uname;
            }
        }
    });
});


function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}


