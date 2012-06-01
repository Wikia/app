var MeeboBar = {
	network: '',
	
	init: function () {
		switch (window.cscoreCat) {
			case 'Entertainment':
				MeeboBar.network = 'wikia_entertainment';
				break;
			case 'Gaming':
				MeeboBar.network = 'wikia_gaming';
				break;
			default:
				MeeboBar.network = 'wikia_lifestyles';
		}
window.Meebo||function(c){function p(){return["<",i,' onload="var d=',g,";d.getElementsByTagName('head')[0].",
j,"(d.",h,"('script')).",k,"='//cim.meebo.com/cim?iv=",a.v,"&",q,"=",c[q],c[l]?
"&"+l+"="+c[l]:"",c[e]?"&"+e+"="+c[e]:"","'\"></",i,">"].join("")}var f=window,
a=f.Meebo=f.Meebo||function(){(a._=a._||[]).push(arguments)},d=document,i="body",
m=d[i],r;if(!m){r=arguments.callee;return setTimeout(function(){r(c)},100)}a.$=
{0:+new Date};a.T=function(u){a.$[u]=new Date-a.$[0]};a.v=5;var j="appendChild",
h="createElement",k="src",l="lang",q="network",e="domain",n=d[h]("div"),v=n[j](d[h]("m")),
b=d[h]("iframe"),g="document",o,s=function(){a.T("load");a("load")};f.addEventListener?
f.addEventListener("load",s,false):f.attachEvent("onload",s);n.style.display="none";
m.insertBefore(n,m.firstChild).id="meebo";b.frameBorder="0";b.name=b.id="meebo-iframe";
b.allowTransparency="true";v[j](b);try{b.contentWindow[g].open()}catch(w){c[e]=
d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{var t=
b.contentWindow[g];t.write(p());t.close()}catch(x){b[k]=o+'d.write("'+p().replace(/"/g,
'\\"')+'");d.close();'}a.T(1)}({network:MeeboBar.network});
Meebo.disableSharePageButton=true;
Meebo('domReady');

		Meebo(function() {
			$('body').trigger('meebo-load').on('click', $('#meebo'), function() {
				$(this).trigger('meebo-click');
				setTimeout(MeeboBar.checkVisibility, 1000);
			});
			MeeboBar.checkVisibility();
		});	
	},

	checkVisibility: function() {
		if ($('#meebo').children().eq(0).css('overflow') == 'visible') {
			$('body').trigger('meebo-visible');
		} else {
			$('body').trigger('meebo-hidden');
		}
	}
};

if (window.wgEnableMeeboExt) {
	MeeboBar.init();
}
