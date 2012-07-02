/**
 * JavaScript for AjaxLogin extension
 * @file
 * @author Chamindu Munasinghe <chamindu@calcey.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
(function( $ ) {
mediawiki = new Object;

mediawiki.AjaxLogin = function() {
	this._loginPanel = null;
	this._loginForm = null;
};

mediawiki.AjaxLogin.prototype.initialize = function() {
	this._loginPanel = $('#userloginRound');
	this._loginForm = $('#userajaxloginform');
	if( this._loginPanel.length > 0 ) {
		this._loginPanel.jqm({modal : true, toTop : true});
		var that = this;
		$('#pt-anonlogin, #pt-login').click( function( event ) {
			event.preventDefault();
			that.showLoginPanel();
		});
		$('#wpLoginattempt').click(function( event ) {
			event.preventDefault();
			that.postAjax( 'wpLoginattempt' );
		});
		$('#wpMailmypassword').click(function( event ) {
			event.preventDefault();
			that.postAjax( 'wpMailmypassword' );
		});
		$('#wpAjaxRegister').click(function( event ) {
			that.doRegister( event );
		});
		$('#wpClose').click(function( event ) {
			that.doClose( event );
		});
	}
};

mediawiki.AjaxLogin.prototype.showLoginPanel = function() {
	this.refreshForm();
	this._loginPanel.jqmShow();
};

mediawiki.AjaxLogin.prototype.postAjax = function( action ) {
	var actionURL = wgServer + wgScriptPath + '/api.php?action=ajaxlogin&format=json';
	var dataString = this._loginForm.serialize();
	this.disableForm();
	dataString += '&' + action + '=' + action;
	var that = this;
	$.ajax({
		type : 'POST',
		url : actionURL,
		dataType : 'json',
		data : dataString,
		success : function( data ) {
			that.requestSuccess( data, dataString, actionURL );
		},
		error : function( XMLHttpRequest, textStatus, errorThrown ) {
			// TODO : add error handling here
			if( typeof console != 'undefined' ) {
				console.log( 'Error in AjaxLogin.js!' );
			}
		}
	});
};

mediawiki.AjaxLogin.prototype.enableForm = function() {
	$('#wpName1').removeAttr('disabled');
	$('#wpPassword1').removeAttr('disabled');
	$('#wpLoginattempt').removeAttr('disabled');
	$('#wpRemember').removeAttr('disabled');
	$('#wpMailmypassword').removeAttr('disabled');
	$('#wpPassword1').removeAttr('disabled');
	$('#wpClose').removeAttr('disabled');
};

mediawiki.AjaxLogin.prototype.disableForm = function() {
	$('#wpName1').attr('disabled', 'disabled');
	$('#wpPassword1').attr('disabled', 'disabled');
	$('#wpLoginattempt').attr('disabled', 'disabled');
	$('#wpRemember').attr('disabled', 'disabled');
	$('#wpMailmypassword').attr('disabled', 'disabled');
	$('#wpPassword1').attr('disabled', 'disabled');
	$('#wpClose').attr('disabled', 'disabled');
};

mediawiki.AjaxLogin.prototype.displayReason = function( reason ) {
	$('#wpError').html(reason + '<br /><br />').show();
};

mediawiki.AjaxLogin.prototype.doRegister = function( event ) {
	if( $('#wpPreview').length > 0 && $('#wpLogin').length > 0 ) {
		if( typeof( ajaxLogin2 ) != 'undefined' && !confirm( ajaxLogin2 ) ) {
			event.preventDefault();
		}
	}
};

mediawiki.AjaxLogin.prototype.refreshForm = function() {
	$('#wpName1').val('');
	$('#wpPassword1').val('');
	$('#wpError').html('');
	this.enableForm();
};

mediawiki.AjaxLogin.prototype.doClose = function( event ) {
	this._loginPanel.jqmHide();
};

mediawiki.AjaxLogin.prototype.requestSuccess = function( data, dataString, actionURL ) {
	var responseResult = data.ajaxlogin.result;
	switch( responseResult ) {
		case 'Reset':
			if( $('#wpPreview').length > 0 && $('#wpLogin').length > 0 ) {
				if( typeof( ajaxLogin1 ) != 'undefined' && !confirm( ajaxLogin1 ) ) {
					break;
				}
			}
			this._loginForm.attr('action', wgServer + wgScriptPath + '/index.php?title=Special:Userlogin&action=submitlogin&type=login');
			this._loginForm.unbind('submit');
			this.disableForm();
			this._loginForm.submit();
			this.enableForm();
			break;
		case 'Success':
			if( $('#wpPreview').length > 0 && $('#wpLogin').length > 0 ) {
				if( $('#wikiDiff').length > 0 && ( $('#wikiDiff').children.length > 0 ) ) {
					$('#wpDiff').click();
				} else {
					if( $('#wikiPreview') && $('#wikiPreview').children.length == 0 ) {
						$('#wpLogin').val( 1 );
					}
					$('#wpPreview').click();
				}
			} else {
				if( wgCanonicalSpecialPageName == 'Userlogout' ) {
					window.location.href = wgServer + wgScriptPath;
				} else {
					window.location.reload( true );
				}
			}
			break;
		case 'NeedToken':
		case 'WrongToken':
			// TODO: make it so this can't go in an infinite loop
			var that = this;
			$.ajax({
				type : 'POST',
				url : actionURL,
				dataType : 'json',
				data : dataString + '&wpToken=' + data.ajaxlogin.token,
				success : function( data ) {
					that.requestSuccess( data, dataString, actionURL );
				},
				error : function( XMLHttpRequest, textStatus, errorThrown ) {
					// TODO : add error handling here
					if( typeof console != 'undefined' ) {
						console.log( 'Error in AjaxLogin.js!' );
					}
				}
			});
			break;
		case 'NotExists':
			this.enableForm();
			$('#wpName1').value = '';
			$('#wpPassword1').value = '';
			$('#wpName1').focus();
		case 'WrongPass':
			this.enableForm();
			$('#wpPassword1').val('');
			$('#wpPassword1').focus();
		default:
			this.enableForm();
			this.displayReason( data.ajaxlogin.text );
			break;
	}
};

$(document).ready( function() {
	if( typeof wgEnableAjaxLogin != 'undefined' && wgEnableAjaxLogin ) {
		var ajaxLogin = new mediawiki.AjaxLogin();
		ajaxLogin.initialize();
	}
});

})(jQuery);
