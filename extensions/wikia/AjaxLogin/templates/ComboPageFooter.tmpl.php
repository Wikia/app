<?php
/**
 * @author Sean Colombo
 *
 * This will be put on Special:Signup below the content which normally goes in the Combo Ajax dialog.
 *
 * Since the combo ajax dialog has different needs than the page (since it has to pop a modal dialog box, etc.),
 * this javascript will differ from that at the bottom of showComboAjaxForPlaceHolder() in /monaco/js/main.js.
 */
?><script type='text/javascript'>
	$(document).ready(function(){
		$.getScript(window.wgScript + '?action=ajax&rs=getRegisterJS&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, function(){
			// Move the login boxes that are built into the page to their new spot in the form.
			AjaxLogin.init( $('#AjaxLoginLoginForm form:first') );
			showComboAjaxForPlaceHolder.statusAjaxLogin = false;

			// Select the correct tab (login by default).
			<?php
				if(isset($actiontype) && $actiontype == 'signup'){
					print "AjaxLogin.showRegister($('#wpGoRegister'));\n";
				} else {
					print "AjaxLogin.showLogin($('#wpGoLogin'));\n";
				}
			?>
		});
	});
</script>
