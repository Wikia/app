function loadKrux(){
	var k=document.createElement('script');k.type='text/javascript';k.async=true;var m,src=(m=location.href.match(/\bkxsrc=([^&]+)\b/))&&decodeURIComponent(m[1]);
	k.src=src||(location.protocol==='https:'?'https:':'http:')+'//cdn.krxd.net/controltag?confid=HfAnTWny';
	var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(k,s);
}