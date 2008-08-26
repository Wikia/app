<!-- s:<?= __FILE__ ?> -->
<style type="text/css">/*<![CDATA[*/
#rw-form label { display: block; width: 12em !important; float: left; padding-right: 1em; text-align: right;font-weight: bold; }
#rw-form input.text { width: 24em;}
#rw-form textarea { width: 20em; height: 10em;}
#rw-form div.row { padding-bottom: 0.8em; margin-bottom: 0.8em; display: block; clear: both; border-bottom: 1px solid #DCDCDC; overflow: auto;}
#rw-form div.hint { width: 18em; font-style: italic; text-align: left; padding: 0.5em; background: #eeeeee;border: 1px solid #DCDCDC;}
a.r-template {font-weight: bold; cursor:pointer;}
a.r-email {font-weight: bold; cursor:pointer;}
/*]]>*/</style>
<script type="text/javascript">
/*<![CDATA[*/

YAHOO.namespace("Wikia.Reject");

YAHOO.Wikia.Reject.changeTemplate = function ( e, title ) {
    YAHOO.util.Event.preventDefault(e);
    YAHOO.util.Dom.get( "rw-reject-info" ).value = "{{" + title + "|<?=$request->request_language;?>}}";
    YAHOO.util.Dom.get( "rw-reject-summary" ).value = title;
}

YAHOO.Wikia.Reject.changeEmail = function ( e, title ) {
				var changeEmailHandler = {
					success: function(response) {
						YAHOO.util.Dom.get("rw-reject-email").value = response.responseText;
						YAHOO.util.Dom.get("rw-reject-email-loading").innerHTML = 'Loaded: <a href="/index.php?title=MediaWiki:Rejectwiki-'+title+'" target="_blank">MediaWiki:Rejectwiki-'+title+'</a>';
					},
					failure: function(response) {
						YAHOO.util.Dom.get("rw-reject-email-loading").innerHTML = '<font color="red"><b>Unable to load</b></font>: <a href="/index.php?title=MediaWiki:Rejectwiki-'+title+'" target="_blank">MediaWiki:Rejectwiki-'+title+'</a>';
					}
				};

				YAHOO.util.Dom.get("rw-reject-email-loading").innerHTML = '<img src="http://images.wikia.com/common/progress_bar.gif" width="70" height="11" alt="Wait..." border="0" />';
				YAHOO.util.Connect.asyncRequest('GET', '/index.php?action=raw&title=MediaWiki:Rejectwiki-'+title, changeEmailHandler);
}

YAHOO.Wikia.Reject.init = function () {
    // get all links with "r-template" class and add listener
    var links = YAHOO.util.Dom.getElementsByClassName("r-template", "a");
    for ( var l in links ) {
        YAHOO.util.Event.addListener( links[l], "click", YAHOO.Wikia.Reject.changeTemplate, links[l].title );
    }

    // get all links with "r-email" class ann add listener
    var links = YAHOO.util.Dom.getElementsByClassName("r-email", "a");
    for ( var l in links ) {
    				YAHOO.util.Event.addListener( links[l], "click", YAHOO.Wikia.Reject.changeEmail, links[l].title );
    }

}
YAHOO.util.Event.onDOMReady(YAHOO.Wikia.Reject.init);

/*]]>*/
</script>


<div id="rw-form">
    <form name="rejectForm" action="<?= $title->getLocalUrl("action=reject&doit=1") ?>" method="post">
    <fieldset>
        <legend>Please confirm rejecting of Wiki:</legend>
        <div class="row">
            <label>Name:</label>
            <span><?= $request->request_name ?></span>
        </div>
        <div class="row">
            <label>Title:</label>
            <span><?= $request->request_title ?></span>
        </div>
        <div class="row">
            <label>Description:</label>
            <span><?= $request->request_description_english ?></span>
            <span><?= $request->request_description_international ?></span>
        </div>
        <div class="row">
            <label>Reason for rejecting:</label>
            <div>
                <input id="rw-reject-summary" type="hidden" name="wpRejectSummary" value="" />
                <textarea id="rw-reject-info" name="wpRejectInfo" style="float: left; width: 350px; height: 250px;" tabindex="1" /></textarea>
                <div class="hint" style="float: left;">
                    <?= wfMsg("createwikirejecttemplates"); ?>
                </div>
            </div>
        </div>
        <div class="row">
        				<label>Rejection email (optional):</label>
        				<div>
    												<div id="rw-reject-email-loading"></div>
        								<textarea id="rw-reject-email" name="wpRejectEmail" style="float: left; width: 350px; height: 250px;" tabindex="2" /></textarea>
        								<div class="hint" style="float: left; width: 350px;">
        												<?= wfMsg("createwiki-reject-emails"); ?>
        								 <br />
        								 <b>Template variables:</b><br />
        								 <ul>
        								 	<li><b>$1</b> - USERNAME</li>
        								 	<li><b>$2</b> - http://requests.wikia.com/wiki/REQUESTNAME</li>
        								 	<li><b>$3</b> - http://WIKINAME.wikia.com</li>
        								 	<li><b>$4</b> - http://www.wikia.com/wiki/WIKINAME</li>
        								 	<li><b>$5</b> - staff member real name (chosen by lang)</li>
        								 </ul>
        								</div>
        				</div>
        </div>
        <div style="text-align: center;">
            <input type="hidden" name="request" id="request" value="<?= $request->request_id ?>" />
            <input type="submit" name="rw-submit" id="rw-submit" value="Reject request" tabindex="3" />
        </div>
    </fieldset>
    </form>
</div>
<!-- e:<?= __FILE__ ?> -->
