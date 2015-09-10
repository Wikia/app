var displayToggleSkin = function(){
	var ToggleSkin = {
		settings: {
			background: "2e0002",
			buttonBorder: "",
			buttonBorderSelectedColor: "",
			buttonHeight: 85,
			buttonWidth: 85,
			buttonsX: 560,
			buttonsY: 45,
			buttonSpace: 5,
			creativeButtons: "",
			creativeSkins: [],
			orientation: ""
		},

		getCreative: function() {
			var html = '<style type="text/css">\
				#ad-skin {\
					cursor: pointer;\
					height: 100%;\
					left: 0;\
					position: fixed;\
					text-align: center;\
					top: 0;\
					width: 100%;\
					z-index: 1;\
				}';
			for (var i=0; i<ToggleSkin.settings.creativeSkins.length; i++) {
				html += '\
				.ad-skin' + i + ' {\
					background: url(' + ToggleSkin.settings.creativeSkins[i] + ') no-repeat top center #' + ToggleSkin.settings.background + ';\
				}';
			}
			html += '\
				#skin_switcher ul {\
					left: 50%;\
					list-style: none;\
					margin-left: ' + ToggleSkin.settings.buttonsX + 'px;\
					padding: 0;\
					position: absolute;\
					top: ' + ToggleSkin.settings.buttonsY + 'px;\
					width: ' + (ToggleSkin.settings.buttonWidth+ToggleSkin.settings.buttonSpace)*ToggleSkin.settings.creativeSkins.length + 'px;\
				}\
				#skin_switcher li {\
					background-image: url(' + ToggleSkin.settings.creativeButtons + ');';
			if (ToggleSkin.settings.buttonBorder) {
				html += '\
					border: ' + ToggleSkin.settings.buttonBorder + ';';
			}
			html += '\
					cursor: pointer;';
			if (ToggleSkin.settings.orientation == 'horizontal') {
				html += '\
					float: left;';
			}
			html += '\
					height: ' + ToggleSkin.settings.buttonHeight + 'px;\
					margin-bottom: ' + ToggleSkin.settings.buttonSpace + 'px;\
					margin-right: ' + ToggleSkin.settings.buttonSpace + 'px;\
					width: ' + ToggleSkin.settings.buttonWidth + 'px;\
				}\
				#skin_switcher li.switcher_selected {';
			if (ToggleSkin.settings.buttonBorderSelectedColor) {
				html += '\
					border-color: #' + ToggleSkin.settings.buttonBorderSelectedColor + ';';
			}
			html += '\
				}';
			for (var i=0; i<ToggleSkin.settings.creativeSkins.length; i++) {
				html += '\
				#skin_thumb' + i + ' {';
				if (ToggleSkin.settings.orientation == 'horizontal') {
					html += '\
					background-position: -' + i*ToggleSkin.settings.buttonWidth + 'px 0;';
				}
				else {
					html += '\
					background-position: 0 -' + i*ToggleSkin.settings.buttonHeight + 'px;';
				}
				html += '\
				}';
			}
			html += '\
			</style>\
			<div id="skin_switcher">\
				<ul>';
			for (var i=0; i<ToggleSkin.settings.creativeSkins.length; i++) {
				html += '\
					<li id="skin_thumb' + i + '"></li>';
			}
			html += '\
				</ul>\
			</div>';

			return html;
		},

		initCreatives: function() {
			// for DFP impression counting, put interstitial macro only on default skin
			if (ToggleSkin.settings.creativeSkin0) ToggleSkin.settings.creativeSkins.push(ToggleSkin.settings.interstitial+ToggleSkin.settings.creativeSkin0);
			if (ToggleSkin.settings.creativeSkin1) ToggleSkin.settings.creativeSkins.push(ToggleSkin.settings.creativeSkin1);
			if (ToggleSkin.settings.creativeSkin2) ToggleSkin.settings.creativeSkins.push(ToggleSkin.settings.creativeSkin2);
			if (ToggleSkin.settings.creativeSkin3) ToggleSkin.settings.creativeSkins.push(ToggleSkin.settings.creativeSkin3);
		},

		switchSkin: function (num) {
			var adSkin = $("#ad-skin");
			var className = adSkin.attr('class');
			className = $.trim(className.replace(/\bad-skin\d+\b/g, "")) + " ad-skin" + num;
			adSkin.attr('class', className);
			var thumbs = $("#skin_switcher li");
			for (var i=0; i<thumbs.length; i++) {
				if (i == num) {
					$(thumbs[i]).attr('class', "switcher_selected");
				}
				else {
					$(thumbs[i]).attr('class', "");
				}
			}
		},

		init: function() {
			if (window.ToggleSkin_settings) {
				$.extend(true, ToggleSkin.settings, ToggleSkin_settings);
			}

			if (!ToggleSkin.settings.creativeButtons || !ToggleSkin.settings.creativeSkin0 || !ToggleSkin.settings.creativeSkin1 || !ToggleSkin.settings.url) {
				return;
			}

			ToggleSkin.initCreatives();

			$("#ad-skin").append(this.getCreative());

			$("#ad-skin").click(function(e) {
				var curTarget = $(e.currentTarget);
				if (curTarget.closest("ul").length == 0) {
					window.open(ToggleSkin.settings.url, "blank");
				}


			});

			$("#ad-skin ul li").click(function(e) {
				e.stopPropagation();

				var num = $(this).index("#ad-skin ul li");
				ToggleSkin.switchSkin(num);
			});

			ToggleSkin.switchSkin(0);
		}
	}

	ToggleSkin.init();
}

displayToggleSkin(); // assume jQuery is already loaded (AdDriver is handling ads)
