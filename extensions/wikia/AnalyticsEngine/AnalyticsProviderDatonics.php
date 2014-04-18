<?php

class AnalyticsProviderDatonics implements iAnalyticsProvider
{

	function getSetupHtml( $params = array() )
	{
		return null;
	}

	function trackEvent( $event, $eventDetails = array() )
	{

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				$script = <<<SCRIPT
<!-- Begin Datonics Tag -->
<script type="text/javascript">
var a=0;function b(f){for(var j="",o=null,f=f.toLowerCase(),g=0;g<f.length;++g)o="0123456789abcdefghijklmnopqrstuvwxyz".indexOf(f.charAt(g)),j=0>o?j+f.charAt(g):j+"0123456789abcdefghijklmnopqrstuvwxyz".charAt((o+Math.pow(g+1,3))%36);return j}var c=window.location.href,d="",e="",h="";
try{var i=document.title,k=/^(?:https?:\/\/)?(?:www\.)?(.*?)\.(?:com|org|net)(?:\/(.*?)(?:\?(.*?))?(?:\#(.*))?)?$/.exec(c);if(k){if(-1<c.indexOf("www."))d=-1<c.indexOf("search=")?"wikia - search":k[1];else{var l=k[1].split(".");if(1<l.length)for(var d=l[l.length-1],m=0;m<l.length-1;m++)d=d+"-"+l[m];else d=k[1]}var n=c,p="search";n||(n=window.location.href);var p=p.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]"),q=RegExp("[\\?&]"+p+"=([^&#]*)").exec(n);null==q?e=null:(a=1,e=decodeURIComponent(q[1].replace(/\+/g,
" ")));null==e&&(void 0!=i&&""!=i?(e=i.replace(/\s*[|:-]*?(from)?\s*Wikia(.com)?(\/WAM)?\s*(Community\s*Central)?[|:-]*?\s*/ig," "),e=e.replace(/[|:-]*?\s*(join)?\s*(the)?\s*(best)?\s*wiki\s*communities\s*(for)?\s*(everyone)?[!]?\s*(-*)?/ig," "),e=e.replace(/^\s+|\s+$/g,"")):e="wikis");if(!e||-1<e.indexOf("http://"))e="wikis"}else e=i||"wikis",d=c+"- unknown domain";var r=/[^\u0000-\u0080]+/g.test(e),e=!/[a-zA-Z]/g.test(e)&&r?"wikis":e.replace(/[^a-zA-Z0-9 ,:|-]/g," ").replace(/^\s+|\s+$/g,""),d=
d.replace(/[^a-zA-Z0-9 ,:|-]&/g," ").replace(/^\s+|\s+$/g,"");e||(e="wikis")}catch(s){e="tdjsh exception catched: "+s.message,d=c}finally{try{var d=b(d.substring(0,400)),e=b(e.substring(0,400)),t=/%[0-9A-Fa-f][0-9A-Fa-f]/;t.test(d)||(d=escape(d));t.test(e)||(e=escape(e));var u=window.location.hostname.replace(/(https?:\/\/)?((www\d*)\.)?([^\/\s]+).*/,"$4"),v=u.split(/\./);if(2<v.length){u=v[1];for(m=2;m<v.length;m++)u=u+"."+v[m]}""!=document.referrer&&-1==document.referrer.indexOf(u)&&(h=";siteref="+
escape(b(document.referrer.substring(0,1E3))));var w=document.createElement("iframe");w.name="d_ifrm";w.width=1;w.height=1;w.scrolling="no";w.marginWidth=0;w.marginHeight=0;w.frameBorder=0;void 0!=document.body&&void 0!=document.body.appendChild&&document.body.appendChild(w);void 0!=c&&""!=c&&(w.src=c.replace(/^(.*?):\/\/.*$/,"$1")+"://pbid.pro-market.net/engine?site=131911;size=1x1;e=0;dt="+a+";category="+d+";kw="+e+h+";rnd=("+(new Date).getTime()+")")}catch(x){}};
</script>
<!-- End Datonics Tag -->
SCRIPT;

				return $script;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

}
