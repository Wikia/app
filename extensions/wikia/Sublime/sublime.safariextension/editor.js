if (window.top === window) {

	//create iframe
	$(function() {
		$('<iframe src="http://sean.wikia-dev.com/extensions/wikia/Sublime/sublime_iframe.php" id="sublimeFrame" style="display: none;"></iframe>').appendTo("body");
	});

	// maps domain name to the appropriate selector for finding the content area
	var contentMap = {
		"techcrunch.com": ".snap_preview:first"
	};

	// variables for mediawiki title, content, and category
	var settings = {
		title			:	$("title").text(),
		content		: contentMap[document.location.host],
		category	: document.location.host
	};

	// makes the current content editable
	function makeEditable() {		
		$(settings.content)
			.attr("contenteditable", "true")
			.css("background-color", "#FFC");
	}

	// makes the current content uneditable		
	function makeUnEditable() {
		$(settings.content)
			.attr("contenteditable", "false")
			.css("background-color", "transparent");
	}
	
	
	//handle commands from the toolbar like "save"
	function command(data) {
	
		if (data == "save") {
		
			//send message to global.html
			safari.self.tab.dispatchMessage("toggleToolbar");
			
			//get MediaWiki Title (document title)
			var title = $("title").text();
			
			//get MediaWiki Category (domain name)
			var category = document.location.host;
	
			//get MediaWiki Content (.snap_preview:first.html())
			var content = $(".snap_preview:first").html();
	
			//TODO: Send edit to server
			phonehome({
				"title": title,
				"category": category,
				"content": content
			});

		}
	
	}
	
	function phonehome(data) {
		var iframe = document.getElementById("sublimeFrame").contentWindow;
		
		data.action = "login";
		data.username = "Fbconnect_test21";
		data.password = "test123";
		
		console.log("phonehome: passing data object:");
		console.log(data);
		console.log("phonehome: postMessage to iframe, NOW!");
		iframe.postMessage(JSON.stringify(data), "*");		
	}

		
	function handleMessage(msgEvent) {
		var messageName = msgEvent.name;
		var messageData = msgEvent.message;
	
		if (messageName === "makeEditable") {
			makeEditable();
		}
		
		if (messageName === "makeUnEditable") {
			makeUnEditable();
		}
		
		//commands sent from the toolbar like "save"
		if (messageName == "command") {
			command(messageData);
		}
		
		//formatting sent from the toolbar like "bold"
		if (messageName === "format") {
			alert(messageData);
		}	
	}

	safari.self.addEventListener("message", handleMessage, false);

}