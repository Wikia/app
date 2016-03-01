<?
global $wgTitle, $wgArticle, $wgOut;
//if ($wgTitle->isContentPage() && !WikiaPageType::isMainPage()) {
if ( $wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $wgOut->isArticle() ) {

?>
<script type="text/javascript">
jQuery.noConflict();
function ask_question() {
	
	q = document.getElementById('answers_ask_field').value.replace(/\s/g,"_");
	if( !q )return;
	
	if( q.charAt( q.length-1 ) == "?" ) q = q.substr(0,q.length-1) ; //removes question mark
	q = encodeURIComponent( q );
	
	var url = "http://answers.wikia.com/api.php?action=query&titles=" + q + "&format=json";
	var params = '';

	var callback = {
		success: function( oResponse ) {
			eval("j=" + oResponse.responseText)
			
			page = j.query.pages["-1"]
			path = wgServer + wgArticlePath.replace("$1","");
			
			if( typeof( page ) != "object" ){
				url = path + q
			}else{
				url = path + "Special:CreateQuestionPage?questiontitle=" + q.charAt(0).toUpperCase() + q.substring(1)
			}
			window.location = url
		}
	};
	
	var request = YAHOO.util.Connect.asyncRequest('GET', url, callback, params);
}
</script>

<div id="answers_ask">
	<form method="get" action="javascript:ask_question();">
		<input type="text" id="answers_ask_field" value="Ask a question" /><span>?</span>
		<a href="#" class="huge_button green"><div></div>Ask</a>
	</form>
</div>

<script type="text/javascript">
jQuery.noConflict();
var answers_field_default = 'Ask a question';
if (jQuery("#answers_ask_field").attr('value') == answers_field_default) {
	jQuery("#answers_ask_field").addClass('alt');
}
jQuery("#answers_ask_field").focus(function() {
	if (jQuery(this).attr('value') == answers_field_default) {
		jQuery(this).removeClass('alt').attr('value', '');
	}
}).blur(function() {
	if (jQuery(this).attr('value') == '') {
		jQuery(this).addClass('alt').attr('value', answers_field_default);
	}
/* Remove question marks as they're typed
}).keyup(function(e) {
	if (e.which == 191) {
		var q = jQuery(this).attr('value');
		var qArray = q.split('?');
		jQuery(this).attr('value', qArray.join(''));
	}
*/
});

</script>
<?
}
