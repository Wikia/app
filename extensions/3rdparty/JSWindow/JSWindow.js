function sendEmail(){
	err = ""
	if(document.emailform.emailto.value=="")err+= "Please enter the email to send to \n";
	if(document.emailform.yourname.value=="")err+= "Please enter your name \n";
	if(document.emailform.emailfrom.value=="")err+= "Please enter your email \n";
	if(!err){
		getContent("index.php?title=Special:EmailThis","pageid=" + document.emailform.pageid.value + "&emailto=" + document.emailform.emailto.value + "&yourname=" + document.emailform.yourname.value + "&emailfrom=" + document.emailform.emailfrom.value + "&message=" + document.emailform.message.value,"pageToolsContent")
	}else{
		alert(err)
	}
}

var jsWindow = Class.create();

jsWindow.prototype = {
   initialize: function(content,options) {
   		this.options = options
		this.editWindow = document.createElement('div');
		if($("ad"))$("ad").hide();
		$(this.editWindow).addClassName(this.options.className);
		document.body.appendChild(this.editWindow); 
		this.editWindow.hide();
		Element.setOpacity(this.editWindow, 1.00);
		 
		Element.setStyle(this.editWindow,{'top':  (this.getYpos() + 120) + 'px' });
		Element.setStyle(this.editWindow,{'display':  'block' }); //Safari Fix
		WindowWidth = Element.getStyle(this.editWindow,"width").replace("px","")
		BrowserWidth = ((window.innerWidth)?window.innerWidth:document.body.clientWidth);
		if(WindowWidth){
			Element.setStyle(this.editWindow,{'left':  (BrowserWidth/2) - (WindowWidth/2) + 'px' });
		}
		closeBox = "<div id=close style='float:right;'><span style='cursor:hand;cursor:pointer'><img src=images/closeWindow.gif id=close ></span></div>"
		$(this.editWindow).innerHTML = closeBox + '<div id=jsWindow style="display:none" >'+ content + '</div>';
		this.editWindow.show();
		
		new Effect[ 'BlindDown']($("jsWindow"));
		Event.observe("close", 'click',  function(){
			Element.remove(this.editWindow)
			if($("ad"))$("ad").show();
		}.bind(this) )
   },
   
   	getYpos: function(){
		if (self.pageYOffset) {
			this.yPos = self.pageYOffset;
		} else if (document.documentElement && document.documentElement.scrollTop){
			this.yPos = document.documentElement.scrollTop; 
		} else if (document.body) {
			this.yPos = document.body.scrollTop;
		}
		return this.yPos
	}
}
	
