var MobileSkin = {
	GA: {
		userName: (wgUserName === null) ? 'anon' : 'user'
	},
	userType: (wgUserName !== null) ? 'logged in' : 'anon',
	ct: {},
	c: null,
	h: null,
	b: null,

	track: function(category, action, label, intVal) {
		var paramsArray = [category, action];

		//optional parameters
		if(label)
			paramsArray.push(label);

		if(intVal)
			paramsArray.push(intVal);

		_wtq.push([null, 'main.sampled', paramsArray]);
	},

	init: function(){
		//analytics
		_wtq.push(['/1_mobile/' + MobileSkin.GA.userName + '/view', 'main.sampled']);

		if(wgPrivateTracker) {
			_wtq.push(['/1_mobile/' + wgDBname + '/' + MobileSkin.GA.userName + '/view', 'main.sampled']);
		}

		MobileSkin.track('pageview', 'view', wgPageName);

		//skin elements
		MobileSkin.c = $("#bodyContent");
		MobileSkin.h = MobileSkin.c.find(">h2");

		var cindex = -1;
		MobileSkin.c.contents().each(function(i, el) {
			if (this) {
				if (this.nodeName == 'H2') {
					$(this).append('<a class="showbutton">' + MobileSkinData["showtext"] + '</a>');
					cindex++;
					MobileSkin.ct["c"+cindex] = [];
				} else if (this.id != 'catlinks' && this.id != 'mw-data-after-content' && cindex > -1) {
					MobileSkin.ct["c"+cindex].push(this);
					$(this).remove();
				}
			}
		});

		MobileSkin.b = MobileSkin.h.find(".showbutton");

		MobileSkin.b.each(function(i, el) {
			$(el).data("c", "c" + i);
		});

		//event handling
		MobileSkin.b.click(MobileSkin.toggle);

		$('#mobile-search-btn').bind('click', function(event){
			MobileSkin.track('button', 'click', 'search');
		});

		$('a').bind('click', function(event){
			var elm = $(this);
			var href = $(this).attr('href');

			if(elm.hasClass('showbutton')) {
				if(elm.data("s")) {
					MobileSkin.track('button', 'click', 'section show');
				} else {
					MobileSkin.track('button', 'click', 'section hide');
				}
			} else if(elm.hasClass('more')) {
				MobileSkin.track('link', 'click', 'related pages');
			} else if(elm.hasClass('fullsite')){
				event.preventDefault();
				MobileSkin.track('link', 'click', 'full site');
				document.cookie = 'mobilefullsite=true';
				location.reload();
			} else if(elm.attr('data-id') === 'randompage') MobileSkin.track('button', 'click', 'random page');
			else if(href && href.indexOf(CategoryNamespaceMessage) !== -1) MobileSkin.track('link', 'click', 'category');
			else if(href && href.indexOf(SpecialNamespaceMessage) === -1) MobileSkin.track('link', 'click', 'article');
		});
	},

	toggle: function(e) {
		e.preventDefault();

		if($(this).data("s")) {
			$(MobileSkin.ct[$(this).data("c")]).remove();
			$(this).data("s", false);
			$(this).text(MobileSkinData["showtext"]);
		} else {
			$(this).closest("h2").after($(MobileSkin.ct[$(this).data("c")]));
			$(this).data("s", true);
			$(this).text(MobileSkinData["hidetext"]);
		}
	}
};

$(document).ready(MobileSkin.init);