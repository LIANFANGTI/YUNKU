
/**
 * Created by Administrator on 2016/4/5 0005.
 */
function  creatCookie(name,value,days,path,domain,secure){
    if(days){
        var date=new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires=date.toGMTString();
    }
    else var expires="";
    cookieString=name+"="+escape(value);
    if(expires) cookieString+=";expires="+expires;
    if(path) cookieString+=";path="+escape(path);
    if(domain) cookieString+=";domain="+escape(domain);
    if(secure) cookieString+=";secure="+secure;
    document.cookie=cookieString;

}
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}//读取cookie

function  deleteCookie(name){
    creatCookie(name,"",-1);
}

