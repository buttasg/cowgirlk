window.onload=function(){var nAgt=navigator.userAgent;var osName=navigator.platform.toLowerCase();osName=osName.substr(0,3);var browserName=navigator.appName;var nameOffset,verOffset;if((verOffset=nAgt.indexOf("MSIE"))!=-1){browserName="msie-"+getInternetExplorerVersion();}else if((verOffset=nAgt.indexOf("Chrome"))!=-1){browserName="chrome";}else if((verOffset=nAgt.indexOf("Safari"))!=-1){browserName="safari";}else if((verOffset=nAgt.indexOf("Firefox"))!=-1){browserName="firefox";}else if((nameOffset=nAgt.lastIndexOf(' ')+1)<(verOffset=nAgt.lastIndexOf('/'))){browserName=nAgt.substring(nameOffset,verOffset);if(browserName.toLowerCase()==browserName.toUpperCase())
browserName=navigator.appName;}
document.body.className=document.body.className+" "+osName+"-"+browserName;}
function getInternetExplorerVersion()
{var rv=-1;if(navigator.appName=='Microsoft Internet Explorer'){var ua=navigator.userAgent;var re=new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");if(re.exec(ua)!=null)
rv=parseFloat(RegExp.$1);}
return rv;}
if(/*@cc_on!@*/false){}
