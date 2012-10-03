rubicon_cb = Math.random();
rubicon_rurl = document.referrer;
if(top.location==document.location){rubicon_rurl = document.location;}
rubicon_rurl = escape(rubicon_rurl);
window.rubicon_zone = "http://optimized-by.rubiconproject.com/a/4275/4806/6725-15" + "." + "js";
window.rubicon_ad = "174512" + "." + "js";
if (window.rubicon_olds && (window.rubicon_dk_zone != window.rubicon_zone))
window.rubicon_olds = null;
url = "<SCRIPT TYPE=\'text/javascript\'>\nvar ACE_AR = {Site: \'754519\', Size: \'300250\'};\n<\/script>\n<SCRIPT TYPE=\'text/javascript\' SRC=\'http://uac.advertising.com/wrapper/aceUAC.js\'><\/script>\n\n<!-- ---------- Copyright 2007, Advertising.com ---------- -->\n<script type=\"text/javascript\" src=\"http://tap-cdn.rubiconproject.com/partner/scripts/rubicon/alice.js\"><\/script>\n<img src=\"http://pixel.quantserve.com/pixel/p-e4m3Yko6bFYVc.gif?labels=NewsAndReference,CultureAndSociety\" style=\"display: none;\" border=\"0\" height=\"1\" width=\"1\" alt=\"Quantcast\"/>";
url = url.replace(/##RUBICON_CB##/g,rubicon_cb); 
document.write(url);
