<script type="text/javascript">
/*<![CDATA[*/
 YAHOO.namespace('WRequest');
 YAHOO.namespace("Wikia.Createpage");
 YAHOO.namespace("Wikia.CreatepageInfobox");

 var YC = YAHOO.util.Connect;
 var YD = YAHOO.util.Dom;
 var YE = YAHOO.util.Event;
 var WR = YAHOO.WRequest;
 var YT = YAHOO.Tools;
 var YWC = YAHOO.Wikia.Createpage ;
 var YWCI = YAHOO.Wikia.CreatepageInfobox ;
 var DisabledCr = false ;

var ajaxpath = '<?php echo "{$GLOBALS['wgScriptPath']}/index.php"; ?>';

WR.callbackTitle =
{
	success:
		function(r)
		{
			YD.get('cp-title-check').innerHTML = '';

			var res = YT.JSONParse(r.responseText);
			if ((false != res ['text']) && (true != res ['empty']))
			{
				var url  = res['url' ].replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
				var text = res['text'].replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

				YD.get('cp-title-check').innerHTML = '<span style="color: red;"><?= wfMsg ('createpage_article_exists') ?> <a href="' + url +'?action=edit" title="' + text + '">' + text + '</a> <?= wfMsg ('createpage_article_exists2') ?></span>';
				//YD.get('Createtitle').value = '' ;
				if (YAHOO.Wikia.Createpage.Overlay) {
					YAHOO.Wikia.Createpage.Overlay.show () ;				
					var helperButton = YAHOO.util.Dom.get ('wpRunInitialCheck') ;
			                helperButton.style.display = '' ;
//					YAHOO.util.Dom.get ('wpAdvancedEdit').style.display = 'none' ;
				} else {
					YAHOO.Wikia.Createpage.ContentOverlay () ;
				}
			} else if (true == res ['empty']) {
				YD.get('cp-title-check').innerHTML = '<span style="color: red;"><?= wfMsg ('createpage_title_invalid') ?> </span>';
			        //YD.get('Createtitle').value = '' ;
				if (YAHOO.Wikia.Createpage.Overlay) {
					YAHOO.Wikia.Createpage.ResizeOverlay (0) ;
					YAHOO.Wikia.Createpage.Overlay.show () ;				
					var helperButton = YAHOO.util.Dom.get ('wpRunInitialCheck') ;
			                helperButton.style.display = '' ;
//					YAHOO.util.Dom.get ('wpAdvancedEdit').style.display = 'none' ;
				} else {
					YAHOO.Wikia.Createpage.ContentOverlay () ;
				}
			} else {
				if (YAHOO.Wikia.Createpage.Overlay) {
					YAHOO.Wikia.Createpage.Overlay.hide () ;
					var helperButton = YAHOO.util.Dom.get ('wpRunInitialCheck') ;
			                helperButton.style.display = 'none' ;
//					YAHOO.util.Dom.get ('wpAdvancedEdit').style.display = '' ;
				}
			}			
			NoCanDo = false ;
		},
	failure:
		function(r)
		{
			YD.get('cp-title-check').innerHTML = '' ;

			// comment out before going live!
			//YD.get('cp-title-check').innerHTML = 'callbackTitle failure: ' + r.responseText;
		},
	timeout: 50000
};

WR.watchTitle = function(e)
{
	YD.get('cp-title-check').innerHTML = '<img src="http://images.wikia.com/common/progress_bar.gif" width="70" height="11" alt="<?= wfMsg ('createpage_please_wait')  ?>" border="0" />';
	NoCanDo = true ;
	YC.asyncRequest('GET', ajaxpath + '?action=ajax&rs=axTitleExists&title=' + YD.get('Createtitle').value, WR.callbackTitle);
	
};

YE.addListener('Createtitle', 'change', WR.watchTitle );

/*]]>*/
</script>
