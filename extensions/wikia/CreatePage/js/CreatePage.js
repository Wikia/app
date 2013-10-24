var CreatePage = {
	pageLayout: null,
	options: {},
	loading: false,

	checkTitle: function(title, enterWasHit) {
		$.getJSON(wgScript, {
			action: 'ajax',
			rs: 'wfCreatePageAjaxCheckTitle',
			title: title
		},
		function(response) {
			if(response.result == 'ok') {
				location.href = CreatePage.options[CreatePage.pageLayout]['submitUrl'].replace('$1', encodeURIComponent( title ));
			}
			else {
				CreatePage.displayError(response.msg);
			}
		});
	},

	openDialog: function(e, titleText) {
		// BugId:4941
		if ((!!window.WikiaEnableNewCreatepage) === false) {
			// create page popouts are disabled - follow the link
			return;
		}

		// Ignore middle-click. BugId:12544
		if (e && e.which == 2) {
			return;
		}

		// don't follow the link
		if (e && e.preventDefault) {
			e.preventDefault();
		}

		if( false === CreatePage.loading ) {
			CreatePage.loading = true;

			$.getJSON(wgScript, {
				action: 'ajax',
				rs: 'wfCreatePageAjaxGetDialog'
			},
			function(data) {
				$.showModal(data.title, data.html, {
					width: data.width,
					id: 'CreatePageDialog',
					callback: function() {
						CreatePage.loading = false;

						for(var name in CreatePage.options){
							var idToken = name.charAt(0).toUpperCase() + name.substring(1);
							var elm = $( '#CreatePageDialog' + idToken + 'Container' );

							elm.data('optionName', name);
							elm.click( function() {CreatePage.setPageLayout($(this).data('optionName'));});
						}

						if(titleText != null) {
							$('#wpCreatePageDialogTitle').val( decodeURIComponent( titleText ) );
						}

						CreatePage.setPageLayout( data.defaultOption );

						$('#wpCreatePageDialogTitle').focus();

						$('#CreatePageDialogButton .createpage').click(function(e) {
							e.preventDefault();
							CreatePage.submitDialog(false);
						});
					}
				});
			});
		}
	},

	submitDialog: function( enterWasHit ) {
		CreatePage.checkTitle( $('#wpCreatePageDialogTitle').val(), enterWasHit );
	},

	displayError: function( errorMsg ) {
		var box = $( '#CreatePageDialogTitleErrorMsg' );
		box.html( '<span id="createPageErrorMsg">' + errorMsg + '</span>' );
		box.removeClass('hiddenStructure');
	},

	setPageLayout: function( layout ) {
		CreatePage.pageLayout = layout;
		var idToken = layout.charAt(0).toUpperCase() + layout.substring(1);

		$('#CreatePageDialog' + idToken).attr( 'checked', 'checked' );
		$('#CreatePageDialogChoices').children('li').removeClass( 'accent' );
		$('#CreatePageDialog' + idToken + 'Container').addClass( 'accent' );
	},

	getTitleFromUrl: function( url ) {
		var vars = [],
			i,
			hash,
			hashes = url.slice(url.indexOf('?') + 1).split('&');

		for(i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}

		return vars['title'].replace(/_/g, ' ');
	},

	redLinkClick: function(e, titleText) {
		var title = titleText.split(':'),
			isContentNamespace = false;

		if( window.ContentNamespacesText && (title.length > 1) ) {
			for(var i in window.ContentNamespacesText) {
				if(title[0] == window.ContentNamespacesText[i]) {
					isContentNamespace = true;
				}
			}
		}
		else {
			isContentNamespace = true;
		}

		if( isContentNamespace ) {
			CreatePage.openDialog(e, titleText );
		}
		else {
			return false;
		}
	},

	init: function() {
		if( window.WikiaEnableNewCreatepage ) {
			$().log('init', 'CreatePage');

			if( !window.WikiaDisableDynamicLinkCreatePagePopup ) {
				$( '#dynamic-links-write-article-link, #dynamic-links-write-article-icon' ).click( function(e) {CreatePage.openDialog(e, null);});
				    $('.noarticletext a[href*="redlink=1"]').click( function(e) {CreatePage.openDialog(e, wgPageName); return false; });
                        }

			// CreatePage chicklet (Oasis)
			$('.createpage').click(CreatePage.openDialog);

			// macbre: RT #38478
			var addRecipeTab = $('#add_recipe_tab');
			if (addRecipeTab.exists()) {
				var addRecipeLink = addRecipeTab.find('a');

				// only show popup if this tab really points to CreatePage
				if (addRecipeLink.attr('href').match(/CreatePage$/)) {
					addRecipeLink.click(CreatePage.openDialog);
				}
			}

			$("a.new").bind('click', function(e) {
				CreatePage.redLinkClick(e, CreatePage.getTitleFromUrl(this.href));
			});

			$(".createboxButton").bind('click', function(e) {
				var form = $(e.target).parent();

				// make sure we're inside createbox and not inputbox (RT #40959)
				if(form.attr('class') == 'createboxForm') {
					var prefix = form.children("input[name|='prefix']").val();
					if (typeof prefix == undefined) {
						prefix = '';
					}
					var field = form.children('.createboxInput');
					var preloadField = form.children("input[name='preload']");

					if((typeof preloadField.val() == undefined) || (preloadField.val() == '')) {
						CreatePage.openDialog(e, prefix + field.val());
					}
					else {
						return true;
					}
				}
			});
		}
	}
};

jQuery(function($) {
	CreatePage.init()
});
