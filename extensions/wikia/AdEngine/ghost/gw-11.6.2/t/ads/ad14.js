document.write('<!-- Copyright 2008 DoubleClick, a division of Google Inc. All rights reserved. -->\n<!-- Code auto-generated on Mon Jan 31 22:08:49 EST 2011 -->\n<script src=\"http://s0.2mdn.net/879366/flashwrite_1_2.js\"><\/script>');document.write('\n');

function DCFlash(id,pVM){
var swf = "http://s0.2mdn.net/2809678/3-snocat_160x600_40_0_v01d.swf";
var gif = "http://s0.2mdn.net/2809678/11-autbridge_160x600_20_v2.jpg";
var minV = 8;
var FWH = ' width="160" height="600" ';
var url = escape("http://ad.doubleclick.net/click%3Bh%3Dv8/3af7/7/9d/%2a/w%3B239770484%3B1-0%3B0%3B62596390%3B2321-160/600%3B40514977/40532764/2%3B%3B%7Esscs%3D%3fhttp://ads.specificmedia.com/click/v=5%3Bm=2%3Bl=23470%3Bc=146418%3Bb=874880%3Bp=ui%3DACXqoRFLEtwSFA%3Btr%3DDZeqTyQW0qH%3Btm%3D0-0%3Bts=20110427233838%3Bdct=http://usa.autodesk.com/adsk/servlet/oc/redir?siteID=123112&mktvar002=ban-wwm-amer-us-gcabd-SpecificMedia-----&url=http%3a%2f%2fusa%2Eautodesk%2Ecom%2fadsk%2fservlet%2findex%3fid%3d15577397%26siteID%3d123112");
var fscUrl = url;
var fscUrlClickTagFound = false;
var wmode = "opaque";
var bg = "";
var dcallowscriptaccess = "never";

var openWindow = "false";
var winW = 0;
var winH = 0;
var winL = 0;
var winT = 0;

var moviePath=swf.substring(0,swf.lastIndexOf("/"));
var sm=new Array();


var defaultCtVal = escape("http://ad.doubleclick.net/click%3Bh%3Dv8/3af7/7/9d/%2a/w%3B239770484%3B1-0%3B0%3B62596390%3B2321-160/600%3B40514977/40532764/2%3B%3B%7Esscs%3D%3fhttp://ads.specificmedia.com/click/v=5%3Bm=2%3Bl=23470%3Bc=146418%3Bb=874880%3Bp=ui%3DACXqoRFLEtwSFA%3Btr%3DDZeqTyQW0qH%3Btm%3D0-0%3Bts=20110427233838%3Bdct=http://usa.autodesk.com/adsk/servlet/oc/redir?siteID=123112&mktvar002=ban-wwm-amer-us-gcabd-SpecificMedia-----&url=http%3a%2f%2fusa%2Eautodesk%2Ecom%2fadsk%2fservlet%2findex%3fid%3d15577397%26siteID%3d123112");
var ctp=new Array();
var ctv=new Array();
ctp[0] = "clickTag";
ctv[0] = "";


var fv='"moviePath='+moviePath+'/'+'&moviepath='+moviePath+'/';
for(i=1;i<sm.length;i++){if(sm[i]!=""){fv+="&submovie"+i+"="+escape(sm[i]);}}
for(var ctIndex = 0; ctIndex < ctp.length; ctIndex++) {
  var ctParam = ctp[ctIndex];
  var ctVal = ctv[ctIndex];
  if(ctVal != null && typeof(ctVal) == 'string') {
    if(ctVal == "") {
      ctVal = defaultCtVal;
    }
    else {
      ctVal = escape("http://ad.doubleclick.net/click%3Bh%3Dv8/3af7/7/9d/%2a/w%3B239770484%3B1-0%3B0%3B62596390%3B2321-160/600%3B40514977/40532764/2%3B%3B%7Esscs%3D%3fhttp://ads.specificmedia.com/click/v=5%3Bm=2%3Bl=23470%3Bc=146418%3Bb=874880%3Bp=ui%3DACXqoRFLEtwSFA%3Btr%3DDZeqTyQW0qH%3Btm%3D0-0%3Bts=20110427233838%3Bdct=" + ctVal);
    }
    if(ctParam.toLowerCase() == "clicktag") {
      fscUrl = ctVal;
      fscUrlClickTagFound = true;
    }
    else if(!fscUrlClickTagFound) {
      fscUrl = ctVal;
    }
    fv += "&" + ctParam + "=" + ctVal;
  }
}
fv+='"';
var bgo=(bg=="")?"":'<param name="bgcolor" value="#'+bg+'">';
var bge=(bg=="")?"":' bgcolor="#'+bg+'"';
function FSWin(){if((openWindow=="false")&&(id=="DCF0"))alert('openWindow is wrong.');
var dcw = 800;
var dch = 600;
// IE
if(!window.innerWidth)
{
  // strict mode
  if(!(document.documentElement.clientWidth == 0))
  {
    dcw = document.documentElement.clientWidth;
    dch = document.documentElement.clientHeight;
  }
  // quirks mode
  else if(document.body)
  {
    dcw = document.body.clientWidth;
    dch = document.body.clientHeight;
  }
}
// w3c
else
{
  dcw = window.innerWidth;
  dch = window.innerHeight;
}
if(openWindow=="center"){winL=Math.floor((dcw-winW)/2);winT=Math.floor((dch-winH)/2);}window.open(unescape(fscUrl),id,"width="+winW+",height="+winH+",top="+winT+",left="+winL+",status=no,toolbar=no,menubar=no,location=no");}this.FSWin = FSWin;
ua=navigator.userAgent;
if(minV<=pVM&&(openWindow=="false"||(ua.indexOf("Mac")<0&&ua.indexOf("Opera")<0))){
	var adcode='<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="'+id+'"'+FWH+'>'+
		'<param name="movie" value="'+swf+'"><param name="flashvars" value='+fv+'><param name="quality" value="high"><param name="wmode" value="'+wmode+'"><param name="base" value="'+swf.substring(0,swf.lastIndexOf("/"))+'"><PARAM NAME="AllowScriptAccess" VALUE="'+dcallowscriptaccess+'">'+bgo+
		'<embed src="'+swf+'" flashvars='+fv+bge+FWH+' type="application/x-shockwave-flash" quality="high" swliveconnect="true" wmode="'+wmode+'" name="'+id+'" base="'+swf.substring(0,swf.lastIndexOf("/"))+'" AllowScriptAccess="'+dcallowscriptaccess+'"></embed></object>';
  if(('j'!="j")&&(typeof dclkFlashWrite!="undefined")){dclkFlashWrite(adcode);}else{document.write(adcode);}
}else{
	document.write('<a target="_blank" href="'+unescape(url)+'"><img src="'+gif+'"'+FWH+'border="0" alt="Advertisement" galleryimg="no"></a>');
}}
var pVM=0;var DCid=(isNaN("239770484"))?"DCF2":"DCF239770484";
if(navigator.plugins && navigator.mimeTypes.length){
  var x=navigator.plugins["Shockwave Flash"];if(x && x.description){var pVF=x.description;var y=pVF.indexOf("Flash ")+6;pVM=pVF.substring(y,pVF.indexOf(".",y));}}
else if (window.ActiveXObject && window.execScript){
  window.execScript('on error resume next\npVM=2\ndo\npVM=pVM+1\nset swControl = CreateObject("ShockwaveFlash.ShockwaveFlash."&pVM)\nloop while Err = 0\nOn Error Resume Next\npVM=pVM-1\nSub '+DCid+'_FSCommand(ByVal command, ByVal args)\nCall '+DCid+'_DoFSCommand(command, args)\nEnd Sub\n',"VBScript");}
eval("function "+DCid+"_DoFSCommand(c,a){if(c=='openWindow')o"+DCid+".FSWin();}o"+DCid+"=new DCFlash('"+DCid+"',pVM);");
//-->

document.write('\n<noscript><a target=\"_blank\" href=\"http://ad.doubleclick.net/click%3Bh%3Dv8/3af7/7/9d/%2a/w%3B239770484%3B1-0%3B0%3B62596390%3B2321-160/600%3B40514977/40532764/2%3B%3B%7Esscs%3D%3fhttp://ads.specificmedia.com/click/v=5%3Bm=2%3Bl=23470%3Bc=146418%3Bb=874880%3Bp=ui%3DACXqoRFLEtwSFA%3Btr%3DDZeqTyQW0qH%3Btm%3D0-0%3Bts=20110427233838%3Bdct=http://usa.autodesk.com/adsk/servlet/oc/redir?siteID=123112&mktvar002=ban-wwm-amer-us-gcabd-SpecificMedia-----&url=http%3a%2f%2fusa%2Eautodesk%2Ecom%2fadsk%2fservlet%2findex%3fid%3d15577397%26siteID%3d123112\"><img src=\"http://s0.2mdn.net/2809678/11-autbridge_160x600_20_v2.jpg\" width=\"160\" height=\"600\" border=\"0\" alt=\"Advertisement\" galleryimg=\"no\"></a></noscript>\n\n<\/SCRIPT>');document.write('\n<!-- Begin AKQA AUTODESK US BANNER LEAD Tag -->\n<img src=\'http://s0.srtk.net/www/delivery/ti.php?bannerid=490&trackerid=1228&cb=1134511041&sr=Display_Nature\' width=\'1\' height=\'1\' border=\'0\'/>\n<!-- End AKQA Tag -->');
