<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">
	<?= $headlinks ?>

	<title><?= $pagetitle ?></title>
	<!-- SASS-generated CSS file -->
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/oasis.scss') ?>">
	<!-- CSS injected by extensions -->
	<?= $csslinks ?>
	<?php
		global $wgUser;
		$srcs = AssetsManager::getInstance()->getGroupLocalURL($wgUser->isLoggedIn() ? 'site_user_css' : 'site_anon_css');
		foreach($srcs as $src) {
			echo '<link rel="stylesheet" href="'.$src.'">';
		}

		// RT #68514: load global user CSS (and other page specific CSS added via "SkinTemplateSetupPageCss" hook)
		if ($pagecss != '') {
	?>


	<!-- page CSS -->
	<style type="text/css"><?= $pagecss ?></style>
	<?php
		}
	?>

	<?= $globalVariablesScript ?>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- Used for page load time tracking -->
	<script>/*<![CDATA[*/
		var wgNow = new Date();
	/*]]>*/</script><?php
		if(!$jsAtBottom) {
			print $wikiaScriptLoader; // needed for jsLoader and for the async loading of CSS files.
			print "\n\n\t<!-- Combined JS files (StaticChute) and head scripts -->\n";
			print $jsFiles . "\n";
		}
	?>
	<?php
	global $wgUser;
	if($wgUser->isLoggedIn()) {
		$gomez = ($wgUser->getID() % 100) === 0;
	} else {
		$gomez = rand(0,99) === 0;
	}
	if($gomez) {
	?>
<script>
<!--
var gomez={
  gs: new Date().getTime(),
  acctId:'B10B2F',
  pgId:'wikia',
  grpId:''
};
//-->
</script>
<script>
<!--
/*Gomez tag version: 6.0*/var gomez=gomez?gomez:{};gomez.h3=function(d, s){for(var p in s){d[p]=s[p];}return d;};gomez.h3(gomez,{b3:function(r){if(r<=0)return false;return Math.random()<=r&&r;},b0:function(n){var c=document.cookie;var v=c.match(new RegExp(';[ ]*'+n+'=([^;]*)'));if(!v)v=c.match(new RegExp('^'+n+'=([^;]*)'));if(v)return unescape(v[1]);return '';},c2:function(n,v,e,p,d,s){try{var t=this,a=t.domain?t.domain:location.hostname;var c=n+'='+escape(v)+(e?';expires='+e.toGMTString():'')+(p?';path='+p:';path=/')+(d?';domain='+d:';domain='+a)+(s?';secure':'');document.cookie=c;}catch(e){}},z0:function(n){var t=this;if(n){var s =t.b0("__g_c");if(!s)return '';var v=s.match(new RegExp(n+':([^\|]*)'));if(v)return unescape(v[1]);return '';}else return '';},z1:function(n,m){var t=this;if(n){var s=t.b0("__g_c");if(s){if(s.indexOf(n+':')!=-1)s=s.replace(new RegExp('('+n+':[^\|]*)'),n+':'+m);else s=s==' '?n+':'+m:s+'|'+n+':'+m;t.c2("__g_c",s);}else t.c2("__g_c",n+':'+m);};},b2:function(v,s){var t=this,f=new Date(t.gt()+946080000000),g=''+v+'_'+s;t.c2('__g_u',g,f);t.gc.c=v;t.gc.d=s;t.z1('c',v);t.z1('d',s);},gt:function(){return new Date().getTime()},b5:function(){return new Date().getTime()-gomez.gs},j1:function(h){if(h){if(h.indexOf('<')!=-1||h.indexOf('%3C')!=-1||h.indexOf('%3c')!=-1)return null;if(window.decodeURIComponent)return decodeURIComponent(h);else return unescape(h);}return null;},f1:function(u,t){try{if(u){if(!/(^http|^https)/.test(u)){if(t==1)return gomez.j1(location.hostname);else return u;}var p=new RegExp('(^http|^https|):\/{2}([^\?#;]*)');if(t==1)p=new RegExp('(^http|^https|):\/{2}([^\/\?]*)');var r=u.match(p);if(r&&t==1)return gomez.j1(r[2]);else if(r)return r[0];}return null;}catch(e){return null;}},j2:function(){try{var m,t =this,key=escape((document.referrer+window.location).replace(new RegExp("([:\/\.])","gm"),""));if(window.localStorage){m=window.localStorage.getItem(key);}if(!m){var c=t.z0("r");if(c){var r=c.split('___');if(r &&r[0]==key){m=r[1];}};};t.j4();return m;}catch(e){return ;}},j3:function(n){try{var t =this,key=escape((window.location+n).replace(new RegExp("([:\/\.])","gm"),""));if(window.localStorage){window.localStorage.setItem(key, t.gt());}t.z1('r',key+'___'+t.gt());}catch(e){return ;}},j4:function(){try{var t =this;if(window.localStorage){window.localStorage.removeItem(escape((document.referrer+window.location).replace(new RegExp("([:\/\.])","gm"),"")));}t.z1('r', '');}catch(e){return ;}},j5:function(){var ret='';for(var i=0;i<3;i++){ret =ret +(((1+Math.random())*0x10000)|0).toString(16).substring(1);}ret =parseInt(ret, 16);return ret;},j6:function(){var t =this;var g=t.b0("__g_u");if(g&&g!='1'&&g.indexOf('NaN')==-1&&g.indexOf('undefined')==-1){var r =g.split("_");if(r.length>5){if(parseInt(r[5])<new Date().getTime()){return undefined;}else{return parseFloat(r[2]);}}}return undefined;},nameEvent:function(){},startInterval:function(){},endInterval:function(){},customValue:function(){}});gomez.P=function(){};gomez.P.prototype={hash:function(o){if(!o)return '';var t=this,s='{n:'+t.f9(o['n'])+'|';for(var i in o){if(i=='n')continue;if(typeof(o[i])=='string'||typeof(o[i])=='number')s +=i+':'+t.f9(o[i])+'|';};s=s.substring(0,s.length-1);return s+'}';},f9:function(s){s=''+s;s=s.replace('|','#$#').replace(':','$*$').replace('{','@#@').replace('}','*@*').replace('&','!*!');return s;},g0:function(){var t=this,z=gomez;if(z.grpIds)z.h3(z.gc,z.grpIds);if(z.wrate)z.gc.r=z.wrate;z.gc.e=z.grpId;for(var i=1;i<5;i++){if(z["grpId"+i]!=undefined){z.gc["e"+i]=z["grpId"+i];}}z.gc.b=z.pgId;z.gc.l=z.f1(z.m,2);if(self.screen){z.gc.m=screen.width;z.gc.o=screen.height;}else if(self.java){var j=java.awt.Toolkit.getDefaultToolkit();var s=j.getScreenSize();z.gc.m=s.width;z.gc.o=s.height;};z.gc.p=navigator.platform;if(navigator.cpuClass)z.gc.q=navigator.cpuClass;if(!z.gc.f&&!z.gc.g){try{var a=new Array("MSIE","Firefox","Opera","Safari","Chrome"),b=document.createElement('div');if(b.addBehavior&&document.body){b.addBehavior('#default#clientCaps');z.gc.k=b.connectionType;}}catch(e){};for(var i=0;i<a.length;i++){if(navigator.userAgent.indexOf(a[i])!=-1){z.gc.g=a[i];z.gc.f=(new String(navigator.userAgent.substring(navigator.userAgent.indexOf(a[i])).match(/[\d.]+/))).substring(0);}}if(!z.gc.f&&!z.gc.g){z.gc.g=navigator.vendor||navigator.appName;z.gc.f=(new String(navigator.appVersion.match(/[\d.]+/))).substring(0);}}return t.hash(z.gc);}};try{gomez.gc={'n':'c'};var iU=gomez.b0('__g_u');if(iU==undefined||iU==''){gomez.b2(gomez.j5(), 0);}var sR=gomez.j6();if(sR==undefined){sR=1;gomez.isFirstVi=true;}else{gomez.isFirstVi=false;}var wR=gomez.wrate?parseFloat(gomez.wrate):(gomez.wrate==0?0:1);wR=wR<0?0:(wR>1?1:wR);gomez.inSample=gomez.z0('a');if(!gomez.inSample||gomez.inSample==''){if(gomez.b3(wR*sR)){gomez.inSample=1;}else{gomez.inSample=0;}gomez.z1('a', gomez.inSample);}else{gomez.inSample=parseInt(gomez.inSample);}gomez.runFlg=gomez.inSample>0;if(gomez.runFlg){gomez.clickT=gomez.j2();gomez.h1=function(v,d){return v?v:d};gomez.gs=gomez.h1(gomez.gs,new Date().getTime());gomez.acctId=gomez.h1(gomez.acctId,'');gomez.pgId=gomez.h1(gomez.pgId,'');gomez.grpId=gomez.h1(gomez.grpId, '');gomez.E=function(c){this.s=c;};gomez.E.prototype={g1:function(e){var t=gomez,i=t.g6(e);if(i)i.e=t.b5();}};gomez.L=function(m){this.a=m;};gomez.L.prototype={g2:function(m){var t=gomez,n=t.b5();var s=document.getElementsByTagName(m);var e=t.k;if(m=='script')e=t.j;if(m=='iframe')e=t.l;if(s){var l=s.length;for(var i=0;i<l;i++){var u=s[i].src||s[i].href;if(u &&!e[u]){var r =new gomez.E(e);t.grm[u]=r;e[u]=new t.c7(u, n);if(t.gIE&&m=='script')t.e2(s[i],'readystatechange',t.d2,false);else t.e2(s[i],'load',r.g1,false);}}}}};gomez.L.m=new Object;gomez.L.m['link']=new gomez.L();gomez.L.m['iframe']=new gomez.L();gomez.S=function(){var t=this,h=gomez.acctId+".r.axf8.net";t.x=('https:'==location.protocol?'https:':'http:')+'//'+h+'/mr/b.gif?';t.pvHttpUrl=('https:'==location.protocol?'https:':'http:')+'//'+h+'/mr/e.gif?';t.abHttpUrl=('https:'==location.protocol?'https:':'http:')+'//'+h+'/mr/f.gif?';};gomez.h2=function(){var t=this;t.gIE=false;t.f=new Object;t._h=0;t.j=new Object;t.k=new Object;t.l=new Object;t.m=location.href;t.p=-1;t.q=-1;t.t=new Array;t.u=new Array;t._w=false;t.gSfr=/KHTML|WebKit/i.test(navigator.userAgent);t.grm=new Object;t.b;t.d=false;t.x=false;t.s=new gomez.S;t._a=false;t.h6=false;t.n1=0;t.c=false;};gomez.h3(gomez,{h5:function(u){try{var s=document.createElement('script');s.src=u;s.type='text/javascript';if(document.body)document.body.appendChild(s);else if(document.documentElement.getElementsByTagName('head')[0])document.documentElement.getElementsByTagName('head')[0].appendChild(s);}catch(e){var t=gomez;if(t.gSfr)document.write("<scr"+"ipt src='"+u+"'"+"><\/scr"+"ipt>");}},a9:function(){var t=gomez,i=t.z0('a'),g=t.b0('__g_u'),h=t.z0('h'), b=t.z0('b');t.gc.h=b;if(h)t.n1=parseInt(h);if(!t.gc.h)t.gc.h=1;t.z1('b',parseInt(t.gc.h)+1);if(i){t.a=parseInt(i);if(t.a==1){t._w=true;}else if(t.a==3){t.x=true;t._w=true;};t.d=true;}if(b){t.gc.c=t.z0('c');t.gc.i=t.z0('e');t.gc.j=t.z0('f');t.iFS=false;}else {if(!t.gc.a)return;var s='v=1';t.c2('__g_u','1',new Date(t.gt()+1000));t.iFS=true;if(t.b0('__g_u')&&g&&g!='1'&&g.indexOf('NaN')==-1&&g.indexOf('undefined')==-1){s='v=0';var r=g.split('_');t.b2(parseInt(r[0]),parseInt(r[1])+1);if(r[4]&&r[4]!='0'&&t.gt()<parseInt(r[5])&&r[2]&&r[2]!='0'){t.b1(parseFloat(r[2]),parseFloat(r[3]),parseFloat(r[4]),parseInt(r[5]));if(r[6])t.n0(parseInt(r[6]));};};t.h6=true;};t.gc.d=t.z0('d');if(!t.gc.d||(t.gc.d&&t.gc.d==0)){t.z1('d',1);t.gc.d=1;}t.b=t.z0('g');t.j8();if(i &&!t.isFirstVi&&t._w&&!t._a){t.h7();t._a=true;};},h7:function(){var t=gomez,u=t.tloc?t.tloc:('https:'==location.protocol?'https:':'http:')+'//'+t.acctId+'.t.axf8.net/js/gtag6.0.js';t.h5(u);},n0:function(h){var t=gomez,f=new Date(t.gt()+946080000000),g=t.b0('__g_u');t.n1=h;t.z1('h',h);if(g&&g!='1'&&g.indexOf('NaN')==-1&&g.indexOf('undefined')==-1){var r=g.split('_');g=''+r[0]+'_'+r[1]+'_'+r[2]+'_'+r[3]+'_'+r[4]+'_'+r[5]+'_'+h;t.c2('__g_u',g,f);};},b1:function(v,s,q,f){var t=this;if(s ==undefined)s =1;t.d=true;t.z1('e',v);t.z1('f',s);t.gc.i=v;t.gc.j=s;t.h4(v,s,q,f);},b3:function(i, v, s){var t =this;t.d=true;if(s ==undefined)s =1;if(i==0||i==1){t.a=i;if(i==1){t._w=true;if(!t._a){t.h7();t._a=true;};}t.z1('a',t.a);if(v !=undefined){t.b1(v, s);}}else if(i==2){t.h4(v, s);}},h4:function(o,p,q,d){var t=this,f=new Date(t.gt()+946080000000),g=t.b0('__g_u');if(g&&g!='1'&&g.indexOf('NaN')==-1&&g.indexOf('undefined')==-1){var r=g.split('_'),s;if(d)s=d;else if(q&&q>=0)s=new Date(t.gt()+parseInt(q*86400000)).getTime();else{q=5;s=new Date(t.gt()+432000000).getTime();};g=''+r[0]+'_'+r[1]+'_'+o+'_'+p+'_'+q+'_'+s;t.c2('__g_u',g,f);};},b6:function(){var t=gomez;t.p=t.b5();},f8:function(){var t=this;if(t.pollId1)clearInterval(t.pollId1);if(t.pollId2)clearInterval(t.pollId2);if(t.pollId3)clearInterval(t.pollId3);if(t.pollId4)clearInterval(t.pollId4);},b7:function(){var t =gomez;t.f8();t.q=t.b5();},c7:function(u, s){var t=this;t.m=u;t.s=s;},c8:function(){var t=gomez,n=t.b5(),l=document.images.length;if(l>t._h){for(var i=t._h;i<l;++i){var u=document.images[i].src;if(u){var r =new gomez.E(t.f);t.grm[u]=r;t.f[u]=new t.c7(u, n);t.e2(document.images[i],'load',t.c4,false);t.e2(document.images[i],'error',t.c5,false);t.e2(document.images[i],'abort',t.c6,false);}}}t._h=l;},c4:function(e){var t=gomez,i=t.g6(e);if(i)i.e=t.b5();},c5:function(e){var t=gomez,i=t.g6(e);if(i){i.e=t.b5();i.b=1;}},c6:function(e){var t=gomez,i=t.g6(e);if(i)i.a=t.b5();},g6:function(e){var t=gomez,e=window.event?window.event:e,a=t.d8(e),i;if(t.grm[a.src||a.href]&&t.grm[a.src||a.href].s)i=t.grm[a.src||a.href].s[a.src||a.href];return i;},d2:function(){var t=gomez;var e=window.event?window.event:e,s=t.d8(e);if(s.readyState=='loaded'||s.readyState=='complete'){var o=t.j[s.src];if(o)o.e=t.b5();}},setPair:function(name,value){var t=this;t.t[t.t.length]={'n':'p','a':name,'b':value};},nameEvent:function(n){var t=this;t.f6(n,1);},startInterval:function(n){var t=this;t.f6(n,2,1);},endInterval:function(n){var t=this;t.f6(n,2,2);},f6:function(n,p,b){if(n&&n.length>20)n=n.substring(0,20);var t=this,f=t.u;if(p==3){f[f.length]={'n':'a','a':n,'b':b,'e':p,'f':undefined};}else{f[f.length]={'n':'a','a':n,'b':t.b5(),'e':p,'f':b};}},customValue:function(n,v){var t=this;if(typeof(v)!='number'){return;}t.f6(n,3,v);},d8:function(e){if(gomez.gIE)return e.srcElement||{};else return e.currentTarget||e.target||{};},e2:function(e,p,f,c){var n='on'+p;if(e.addEventListener)e.addEventListener(p,f,c);else if(e.attachEvent)e.attachEvent(n, f);else{var x=e[n];if(typeof e[n]!='function')e[n]=f;else e[n]=function(a){x(a);f(a);};}},i1:function(){var d =window.document, done=false,i2=function (){if(!done){done=true;gomez.b6();gomez.a9();}};(function (){try{d.documentElement.doScroll('left');}catch(e){setTimeout(arguments.callee, 50);return;}i2();})();d.onreadystatechange=function(){if(d.readyState=='complete'){d.onreadystatechange=null;i2();}};},j7:function(s, toUrl){try{var t=this,z=gomez;if(!s)return;s+="{n:u|e:1}";var p ='';if(t.isFirstVi){p='&a='+z.acctId+'&r=1&s=1';}else if(t.iFS){p='&a='+z.acctId+'&r='+t.j6();}if(window.encodeURIComponent)s=encodeURIComponent(s);else s=escape(s);z.h5(z.e(toUrl)+'info='+s+p);}catch(err){}return;},e:function(u){if(!/\?|&/.test(u))if(!/\?/.test(u))u +='?';else u +='&';return u;},j8:function(){var t=gomez, p=new gomez.P();var s=p.g0();t.j7(s, t.s.pvHttpUrl);},g7:function(){try{var t=gomez;t.gc.a=t.acctId;/*@cc_on t.gIE=true;@*/if(t.gIE){t.i1();window.attachEvent('onload', t.b7);}else if(window.addEventListener){window.addEventListener('DOMContentLoaded', t.b6, false);window.addEventListener('load', t.b7, false);}else if(t.gSfr){var m=setInterval(function(){if(/loaded|complete/.test(document.readyState)){clearInterval(m);delete m;t.b6();t.b7();}}, 10);}else return;if(!t.jbo){t.c8();t.pollId1=setInterval(t.c8, 10);gomez.L.m['link'].g2('link');t.pollId3=setInterval("gomez.L.m['link'].g2('link')", 10);gomez.L.m['iframe'].g2('iframe');t.pollId4=setInterval("gomez.L.m['iframe'].g2('iframe')", 10);}if(!t.gIE)t.a9();}catch(e){return;}}});gomez.h2();gomez.g7();}}catch(e){};
//-->
</script>
	<?php } ?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
<?= $body ?>

<!-- comScore -->
<?= $comScore ?>

<!-- googleAnalytics -->
<?= $googleAnalytics ?>

<?php
	if($jsAtBottom) {
		print $wikiaScriptLoader; // needed for jsLoader and for the async loading of CSS files.
		print "\n\n\t<!-- Combined JS files (StaticChute) and head scripts -->\n";
		print $jsFiles . "\n";
	}
?>

<?php
	if (empty($wgSuppressAds)) {
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_1'));
		if (!$wgEnableCorporatePageExt) {
			echo wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_2'));
		}
	}
?>
<?= AdEngine::getInstance()->getDelayedIframeLoadingCode() ?>

<!-- quantServe -->
<?= $quantServe ?>

<?php
	print '<script type="text/javascript">/*<![CDATA[*/for(var i=0;i<wgAfterContentAndJS.length;i++){wgAfterContentAndJS[i]();}/*]]>*/</script>' . "\n";

	print "<!-- BottomScripts -->\n";
	print $bottomscripts;
	print "<!-- end Bottomscripts -->\n";
?>

<!-- printable CSS -->
<?= $printableCss ?>

<?= wfReportTime()."\n" ?>
</body>
<?= wfRenderModule('Ad', 'Config') ?>
</html>
