/*@cc_on@*/
function adxsethtml(o, t) {
	o.innerHTML = t
}
function adxinserthtml(o, w, t) {
	o.insertAdjacentHTML(w, t)
}
var adx_base_110096, adx_data_110096 = 'centro,XPRGM082_MiamiHerald_Homepage_Auguat_13_SBB,C=XPRGM082,P=MiamiHerald,K=383372',
adx_U_110096, adx_I_110096, adx_D_110096, adx_click, adx_dart, adx_P_110096 = (adx_D_110096 ? adx_D_110096: '') + (adx_click ? adx_click: '') + (adx_dart ? adx_dart: ''),
adx_id_110096 = Math.random(),
adl_i0_110096 = new Image,
adl_i1_110096 = new Image,
adl_b = 0,
adx_tp_110096 = ((document.location.protocol.indexOf("https") >= 0) ? 'https://str.adinterax.com': 'http://tr.adinterax.com');
if (!adx_base_110096) adx_base_110096 = "http://mi.adinterax.com/customer/centro/";
if (typeof YAHOOads != "undefined") {
	YAHOOads.vendor.ExpIframe.register(972, 24)
}
function adxv() {}
function adl_CO_110096() {
	adl_i0_110096.onload = adxv;
	adl_i0_110096.src = adx_tp_110096 + '/tr/' + adx_data_110096 + '/' + adx_id_110096 + '/0/co/b.gif'
}
adl_i0_110096.onload = adl_CO_110096;
adl_i0_110096.src = adx_tp_110096 + '/re/' + adx_data_110096 + '/' + adx_id_110096 + '/0/in,ti/ti.gif';
if (adx_I_110096) adl_i1_110096.src = adx_I_110096;
function adxL() {
	var t = '',
	u = adx_base_110096 + "XPRGM082_MiamiHerald_Homepage_Auguat_13_SBB",
	g, n = navigator,
	d = document,
	e;
	/*@if(@_win32&&@_jscript_version>=5)u+='.js';try{new ActiveXObject('ShockwaveFlash.ShockwaveFlash.10');g=1}catch(e){}@else@*/
	if (n.userAgent.indexOf("Gecko") > 0) {
		u += '.ns.js';
		g = (n.vendor.indexOf("Ap") == 0 || n.vendor.indexOf("Goog") == 0) ? 3: (n.productSub > 20030623) ? 2: 0;
		var a, b, c, f;
		if (g && ! ((a = n.mimeTypes) && (b = a['application/x-shockwave-flash']) && (c = b.enabledPlugin) && (f = c.description) && parseInt(f.substr(16)) > 9)) g = 0
	}
	/*@end@*/
	u += "?adxq=1281714383";
	if (g && d.getElementById('adx_img_110096')) g = 0;
	t += '<DIV' + (g ? ' ID="adx_script_110096" STYLE="position:relative"': '') + '><A ' + (g ? 'ID="adx_a_110096"': '') + ' HREF="' + adx_P_110096 + adx_tp_110096 + '/re/' + adx_data_110096 + '/' + adx_id_110096 + '/0/tc' + (g ? ',ac': '') + ',c:_undefined_/http://www.cadillacdealer.com/" TARGET="_blank"><IMG ' + (g ? 'ID="adx_img_110096" ': '') + 'SRC="' + adx_base_110096 + '452/972x24.gif?adxq=1279228836" WIDTH=972 HEIGHT=24 BORDER=0 ></A></DIV>';
	d.write(t);
	if (g) {
		d.write('<SCR' + 'IPT LANGUAGE="JavaScript" ' + ((g > 2) ? 'SRC="' + u + '">': 'ID="adl_S_110096"></SCR' + 'IPT><SCRIPT>setTimeout(\'document.getElementById("adl_S_110096").src="' + u + '"\',1)') + '</SCR' + 'IPT>')
	}
}
adxL();
var adl_i2_110096 = new Image;
adl_i2_110096.src = 'http://ad.doubleclick.net/ad/N3880.miamihearld.com/B4235886.19;dcove=o;sz=1x1;ord=' + adx_id_110096 + '?';

