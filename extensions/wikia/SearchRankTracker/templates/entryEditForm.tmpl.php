<!-- s:<?= __FILE__ ?> -->
<style type="text/css">/*<![CDATA[*/
#entry-form label { display: block; width: 12em !important; float: left; padding-right: 1em; text-align: right;font-weight: bold; }
#entry-form input.text { width: 24em;}
#entry-form div.row { padding-bottom: 0.8em; margin-bottom: 0.8em; display: block; clear: both; overflow: auto;}
#entry-form div.hint { width: 18em; font-style: italic; text-align: left; padding: 0.5em; background: #eeeeee;border: 1px solid #DCDCDC;}
#entry-form div.form-error { background: #fefefe; border: 1px solid #ff0000; color: red; padding: 3px; }
/*]]>*/</style>

<script type="text/javascript">
/*<![CDATA[*/
//
YAHOO.namespace('Wiki.SearchRank');

var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var YT = YAHOO.Tools;
var YW = YAHOO.Wiki;

var ajaxpath = "<?=$GLOBALS["wgScriptPath"]."/index.php";?>";

YW.SearchRank.pageCheckCallback = {
    success: function( oResponse ) {
        var respData = YT.JSONParse(oResponse.responseText);
        if (respData["result"] == "not_found") {
        	YD.get( "wiki-page-url" ).innerHTML = "<font color=\"red\">Page <a href=\""+respData["pageUrl"]+"\" target=\"_blank\">"+respData["pageUrl"]+"</a> not found.</font>";
        }
        else {
									var mainPage = "";
									if (respData["mainPage"] == true) {
									 mainPage = " <strong>(wiki main page)</strong>";	
									}
        	YD.get( "wiki-page-url" ).innerHTML = "<a href=\""+respData["pageUrl"]+"\" target=\"_blank\">"+respData["pageUrl"]+"</a>"+mainPage;
        }
    },
    failure: function( oResponse ) {
    },
    timeout: 50000
};

YW.SearchRank.pageCheck = function (e) {
	var page = YD.get("entry-page").value;	
	if(page != "") {
		YD.get("wiki-page-url").innerHTML =  '<?=Wikia::ImageProgress();?>';
		YC.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWSearchRankCheckPage&name="+page, YW.SearchRank.pageCheckCallback);		
	}
	else {
		YD.get("wiki-page-url").innerHTML =  '';
	}
};

YE.addListener( "entry-page", "change", YW.SearchRank.pageCheck );

/*]]>*/
</script>



<div id="entry-form">
<?php if(count($formErrors)): ?>
 <div class="form-error">
  <?php foreach($formErrors as $errorMsg): ?>
   <?=wfMsg($errorMsg);?><br />
  <?php endforeach; ?>
 </div>
<?php endif; ?>
	<form name="entryEditForm" method="POST" action="<?=$title->getLocalUrl('action=list');?>">
	 	<fieldset>
	 		<legend>Editing entry</legend>
	 		<div class="row">
	 			<label>Wiki page:</label>
	 			<input type="text" id="entry-page" name="entryPage" value="<?=$entry->getPageName();?>" tabindex="1" />
					<div>
						<label>URL:</label>
						<div id='wiki-page-url'><?=$entry->getPageUrl()?("<a href=\"" . $entry->getPageUrl() . "\" targer=\"_blank\">" . $entry->getPageUrl() . "</a>" . ($entry->isMainPage() ? " <strong>(wiki main page)</strong>" : "") ):"";?></div>
					</div>
	 		</div>
	 		<div class="row">
	 			<label>Search Phrase:</label>
	 			<input type="text" id="entry-phrase" name="entryPhrase" value="<?=$entry->getPhrase();?>" tabindex="2" />
	 		</div>
	
				<div style="text-align: center;">
	    <input type="hidden" name="entryId" id="entry-id" value="<?=$entry->getId();?>" />
	    <input type="submit" name="entrySubmit" id="entry-submit" value="Save entry" tabindex="3" />
	    <input type="submit" name="cancel" id="cancel" value="Cancel" tabindex="4" />
				</div>
				
	 	</fieldset>
	</form>
</div>
<!-- e:<?= __FILE__ ?> -->