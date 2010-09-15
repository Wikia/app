var CreatePage = {};
var CreatePageEnabled = false;

CreatePage.pageLayout = null;

CreatePage.checkTitle = function( title, enterWasHit ) {
	$.getJSON(wgScript,
			{
				'action':'ajax',
				'rs':'wfCreatePageAjaxCheckTitle',
				'title':title
			},
			function(response) {
				if(response.result == 'ok') {
					if( enterWasHit ) {
						CreatePage.track('enter/' + ( CreatePage.pageLayout == 'format' ? 'standardlayout' : 'blankpage'));
					}
					else {
						CreatePage.track('create/' + ( CreatePage.pageLayout == 'format' ? 'standardlayout' : 'blankpage'));
					}
					location.href = wgScript + '?title=' + encodeURIComponent( title ) + '&action=edit' + ( CreatePage.pageLayout == 'format' ? '&useFormat=1' : '');
				}
				else {
					CreatePage.displayError(response.msg);
				}
			}
		);
};

CreatePage.openDialog = function(e, titleText) {
	e.preventDefault();
	if( false == CreatePageEnabled ) {
		CreatePageEnabled = true;
		$().getModal(
			wgScript + '?action=ajax&rs=wfCreatePageAjaxGetDialog',
			'#CreatePageDialog', {
					width: 400,
					callback: function() {
						CreatePageEnabled = false;
						CreatePage.track( 'open' );
						if(titleText != null) {
							$('#wpCreatePageDialogTitle').val( decodeURIComponent( titleText ) );
						}
						$('#wpCreatePageDialogTitle').focus();
					},
				onClose: function() {
					CreatePage.track( 'close' );
				}
			}
		);
	}
};

CreatePage.submitDialog = function( enterWasHit ) {
	CreatePage.checkTitle( $('#wpCreatePageDialogTitle').val(), enterWasHit );
};

CreatePage.displayError = function( errorMsg ) {
	var box = $( '#CreatePageDialogTitleErrorMsg' );
	box.html( '<span id="createPageErrorMsg">' + errorMsg + '</span>' );
	box.removeClass('hiddenStructure');
};

CreatePage.setPageLayout = function( layout ) {
	CreatePage.pageLayout = layout;
	switch( layout ) {
		case 'format':
			$('#CreatePageDialogFormat').attr( 'checked', 'checked' );
			$('#CreatePageDialogBlankContainer').removeClass( 'accent' );
			$('#CreatePageDialogFormatContainer').addClass( 'accent' );
			CreatePage.track('standardlayout');
			break;
		case 'blank':
		default:
			$('#CreatePageDialogBlank').attr( 'checked', 'checked' );
			$('#CreatePageDialogBlankContainer').addClass( 'accent' );
			$('#CreatePageDialogFormatContainer').removeClass( 'accent' );
			CreatePage.track('blankpage');
			break;
	}
};

CreatePage.track = function( str ) {
	WET.byStr('CreatePage/' + str);
};

CreatePage.getTitleFromUrl = function( url ) {
	var vars = [], hash;
	var hashes = url.slice(url.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++)
	{
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars['title'].replace(/_/g, ' ');
};

CreatePage.redLinkClick = function(e, titleText) {
	title = titleText.split(':');
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
};

$(function() {
	if( window.WikiaEnableNewCreatepage ) {
		$().log('init', 'CreatePage');

		if( !window.WikiaDisableDynamicLinkCreatePagePopup ) {
			if( $( '#dynamic-links-write-article-icon' ).exists() ) {
				// open dialog on clicking
				$( '#dynamic-links-write-article-icon' ).click( function(e) { CreatePage.openDialog(e, null); });
			}
			if( $( '#dynamic-links-write-article-link' ).exists() ) {
				// open dialog on clicking
				$( '#dynamic-links-write-article-link' ).click( function(e) { CreatePage.openDialog(e, null); });
			}
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

		$("a.new").bind('click', function(e) { CreatePage.redLinkClick(e, CreatePage.getTitleFromUrl(this.href)) } );
		$(".createboxButton").bind('click', function(e) {
			var form = $(e.target).parent();

			// make sure we're inside createbox and not inputbox (RT #40959)
			if(form.attr('class') == 'createboxForm') {
				var field = form.children('.createboxInput');
				var preloadField = form.children("input[name='preload']");

				if((typeof preloadField.val() == undefined) || (preloadField.val() == '')) {
					CreatePage.openDialog(e, field.val());
				}
				else {
					return true;
				}
			}
		});
	}
});
