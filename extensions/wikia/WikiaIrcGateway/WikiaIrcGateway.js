function setrefercookie() {
   document.cookie = "referer="+document.referrer;
}
function setjs() {
 if(navigator.product == 'Gecko') {
   document.loginform["interface"].value = 'mozilla';
 }else if(window.opera && document.childNodes) {
   document.loginform["interface"].value = 'opera7';
 }else if(navigator.appName == 'Microsoft Internet Explorer' &&
    navigator.userAgent.indexOf("Mac_PowerPC") > 0) {
    document.loginform["interface"].value = 'konqueror';
 }else if(navigator.appName == 'Microsoft Internet Explorer' &&
 document.getElementById && document.getElementById('ietest').innerHTML) {
   document.loginform["interface"].value = 'ie';
 }else if(navigator.appName == 'Konqueror') {
    document.loginform["interface"].value = 'konqueror';
 }else if(window.opera) {
   document.loginform["interface"].value = 'opera';
 }
}
function nickvalid() {
	var nick = document.loginform.Nickname.value;
	if(nick.match(/^[A-Za-z0-9\[\]\{\}\^\\\|\_\-`]{1,32}$/)) {
		return true;
	}
	alert('Please enter a valid nickname');
	document.loginform.Nickname.value = nick.replace(/[^A-Za-z0-9\[\]\{\}\^\\\|\_\-`]/g, '');
	return false;
}
function setcharset() {
	if(document.charset && document.loginform["Character set"]) {
		document.loginform['Character set'].value = document.charset;
	}
}

// credit: http://www.netlobo.com/url_query_string_javascript.html
function gup( name )
{
	name = name.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)",
		regex = new RegExp( regexS ),
		results = regex.exec( window.location.href );
	return results ? results[1] : '';
}

function set_chan()
{
	var wanted = gup('select');
	if (wanted == '') {
		return;
	}
	
	var selector = document.getElementsByName('Channel')[0];
	
	for(var i = 0; i < selector.length; i++)
	{
		if( ('#' + wanted) == selector.options[i].value )
		{
			selector.selectedIndex = i;
			return true;
		}
	}
	
	return false;
}
