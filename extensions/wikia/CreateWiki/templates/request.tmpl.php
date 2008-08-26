<!-- s:<?php echo __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#CreateWikiForm label { display: block; width: 12em !important; float: left; padding-right: 1em; text-align: right;}
#CreateWikiForm label.long { display: block; width: 14em !important; float: left; padding-right: 1em; text-align: right;}
#CreateWikiForm input.text { width: 16em;}
#CreateWikiForm select { width: 18em;}
#CreateWikiForm option {width: 20em; }
#CreateWikiForm textarea { width: 18em; height: 12em;}
#CreateWikiForm .inactive {color: #2F4F4F; padding: 0.2em; font-weight: bold;}
#CreateWikiForm .admin { background: #F0E68C; }
#CreateWikiForm div.row { padding: 0.8em; display: block !important; clear: both; }
#CreateWikiForm div.container { clear: both; width: 100%; margin-bottom: 0.8em; border-bottom: 1px solid #DCDCDC;}
#CreateWikiForm div.column { display: block; width: 49%; float: left; }
#CreateWikiForm div.error { text-align: center; color: #fe0000; font-size: small;}
#CreateWikiForm div.hint {font-style: italic; margin-left: 15em;}
<?php // #sidebar { display: none } ?>
tr { border: 1px solid #dcdcdc; }
/*]]>*/
</style>

<script type="text/javascript">
/*<![CDATA[*/
//
YAHOO.namespace("Wiki.Create");

var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var WC = YAHOO.Wiki.Create;
var ajaxpath = "<?php echo $GLOBALS["wgScriptPath"]."/index.php" ?>";


YAHOO.Wiki.Create.domainCallback = {
    success: function( oResponse ) {
        var respData = YAHOO.Tools.JSONParse(oResponse.responseText);
        YD.get( "domains-exact" ).innerHTML = respData["exact"];
        YD.get( "domains-like" ).innerHTML = respData["like"];
        if (respData["requestPage"] != "none") {
        				YD.get( "requestPageWarning" ).innerHTML = "Request page <a href=\""+ajaxpath+"?title="+respData["requestPage"]+"\" target=\"_blank\">"+respData["requestPage"]+"</a> already exists. Please move or delete before continuing.";
        }
        else {
        				YD.get( "requestPageWarning" ).innerHTML = "";
        }
    },
    failure: function( oResponse ) {
    },
    timeout: 50000
};

function ucfirst(string) {
				return string.substr(0,1).toUpperCase() + string.substr(1, string.length);
}

YAHOO.Wiki.Create.domainWatch = function (e) {
    var subdomain = YD.get( "wc-name" ).value;
    var lang = YD.get( "wc-language" ).value;
    var prefix = YD.get( "wc-prefix" ).checked;

			 var requestPage = ucfirst(subdomain);

    if (subdomain == "<?=$request->request_name;?>") {
    				requestPage = '';
    }

    if (prefix) {
        subdomain = lang + "." + subdomain;
        if (requestPage != '') {
        				requestPage = ucfirst(lang) + "." + requestPage;
        }
    }


    var domain = subdomain + ".wikia.com";
    YD.get( "domains-like" ).innerHTML =  '<?php echo Wikia::ImageProgress() ?>';
    YD.get( "domain-preview" ).innerHTML = domain ;
    YAHOO.util.Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWCreateCheckName&name="+subdomain+"&requestPage="+requestPage, WC.domainCallback);
};

YAHOO.Wiki.Create.check = function(e) {
    YAHOO.util.Event.preventDefault( e ); //--- do not submit by default
    oForm = YAHOO.util.Dom.get( "CreateWikiForm" )
    oHub = YAHOO.util.Dom.get( "wiki-category" );
    if ( oHub.value == 0 ) {
        alert("Select hub for breadcrumbs, please.");
    }
    else {
        oForm.submit();
    }
    return false;
}

YAHOO.util.Event.addListener( "wc-name", "change", WC.domainWatch );
YAHOO.util.Event.addListener( "wc-prefix", "change", WC.domainWatch );
YAHOO.util.Event.addListener( "wc-language", "change", WC.domainWatch );
// YAHOO.util.Event.addListener( "CreateWikiForm", "submit", YAHOO.Wiki.Create.check );
/*]]>*/
</script>
<div>

<?php echo $lock_info ?>
<form name="createwiki" id="CreateWikiForm" method="post" action="<?php echo $title->getLocalUrl();?>">
    <input type="hidden" name="wpFounderUserID" value="<?php echo $request->request_user_id ?>" />
    <input type="hidden" name="wpRequestID" value="<?php echo $request->request_id ?>" />
    <input type="hidden" name="request" value="<?php echo $request->request_id ?>" />
    <div class="row">
        <label><?php echo wfMsg( "createwikifounder" ) ?></label>
        <strong>
            <a href="<?php echo htmlspecialchars($founderpage["href"]) ?>" <?php echo $founderpage["href"] ? "" : "class=\"new\""?>>
                <?php echo $founder->mName ?>
            </a>
            <?php echo "{$founder->mRealName} &lt;{$founder->mEmail}&gt;" ?>
        </strong>
    </div>


<!-- 2-col container /Start -->
<div class="container">
<!-- Left column /Start -->
<div class="column">
    <div class="row">
        <label><?php echo wfMsg( "createwikiname" ) ?></label>
        <input type="text" class="text" id="wc-name" name="wpCreateWikiName" value="<?=($wgRequest->getCheck('wpCreateWikiName') ? $wgRequest->getVal('wpCreateWikiName') : strtolower($request->request_name));?>" maxlength="255" />
        <div class="error">
        <?php
            if (isset($data["errors"]["wpCreateWikiName"])):
                echo $data["errors"]["wpCreateWikiName"];
            endif
        ?>
        </div>
        <div id="requestPageWarning" style="color: red;">
        </div>
        <div class="hint">
        <ul>
        <li>
            <strong>Proposed domain:</strong> <span id="domain-preview"><?php echo $name ?></span>
        </li>
        <?php if (is_array($domains) && count($domains)): ?>
        <li>
            <strong>Wiki with the same name:</strong>
            <span id="domains-exact">
            <?php foreach( $domains["exact"] as $domain ): ?>
                <a href="http://<?php echo $domain->city_domain ?>/" target="_blank"><?php echo $domain->city_domain ?></a>&nbsp;
            <?php endforeach ?>
            </span>
        </li>
        <li>
            <strong>Wiki with similar names:</strong>
            <span id="domains-like">
            <?php foreach( $domains["like"] as $domain ): ?>
                <a href="http://<?php echo $domain->city_domain ?>/" target="_blank"><?php echo $domain->city_domain ?></a>&nbsp;
            <?php endforeach ?>
            </span>
        </li>
        <?php endif ?>
        </ul>
        </div>
    </div>
</div>
<!-- Left column /End -->

<!-- Right column /Start -->
<div class="column">
    <div class="row">
        <label class="long"><?php echo wfMsg( "createwikititle" ) ?></label>
    	<input type="text" class="text" name="wpCreateWikiTitle" value="<?=($wgRequest->getCheck('wpCreateWikiTitle') ? $wgRequest->getVal('wpCreateWikiTitle') : $request->request_title);?>" maxlength="255" />
    </div>

    <div class="row">
<?php
    global $wgContLang;
    #--- remove Wiki from title if last part
    $title = trim( $request->request_title );
    $title = preg_replace("/wiki$/i", "", $title);
    $title = $wgContLang->ucfirst( trim( $title ) );
?>
        <label class="long">Page title for Central Wikia</label>
    	<input type="text" class="text" name="wpCreateWikiDescPageTitle" value="<?=($wgRequest->getCheck('wpCreateWikiDescPageTitle') ? $wgRequest->getVal('wpCreateWikiDescPageTitle') : $title);?>" />
        <div class="hint">
            http://www.wikia.com/<strong>Page_title</strong>
        </div>
    </div>
    <div class="row">
        <label class="long">Additional domains</label>
        <input type="text" class="text" name="wpCreateWikiDomains" value="<?=($wgRequest->getCheck('wpCreateWikiDomains') ? $wgRequest->getVal('wpCreateWikiDomains') : '');?>" />
        <div class="hint">
            domain1.wikia.com domain2.wikia.com domain3.wikia.com
        </div>
    </div>

</div>
<!-- Right column /End -->
</div>
<!-- 2-col container /End -->

<!-- 2-col container /Start -->
<div class="container">
<!-- Left column /Start -->
<div class="column">
    <div class="row">
        <label><?php echo wfMsg( "createwikilang" ) ?></label>
        <select name="wpCreateWikiLang" id="wc-language">
        <?php
        foreach ($languages as $key => $language) {
            $selected = "";
            if ($wgRequest->getCheck('wpCreateWikiLang')) {
            	if ($wgRequest->getVal('wpCreateWikiLang') == $key) {
                echo "selected: $key";
                $selected = "selected=\"selected\"";
            	}
            }
            elseif ( (empty($langSelected) && ($key === $request->request_language)) || (!empty($langSelected) && ($key === $langSelected)) ) {
                $selected = "selected=\"selected\"";
            }
            echo "<option value=\"{$key}\" {$selected}>{$key} - {$language}</option>";
        }
        ?>
        </select>
        <div class="hint">
            &nbsp;
        </div>
    </div>
</div>
<!-- Left column /End -->
<!-- Right column /Start -->
<div class="column">
    <div class="row">
        <label class="long">Include language prefix in URL</label>
        <input type="checkbox" name="wpCreateWikiLangPrefix" <?=($wgRequest->wasPosted() ? ($wgRequest->getCheck('wpCreateWikiLangPrefix') ? "checked=\"checked\"" : "") : (!empty($request_prefix) ? "checked=\"checked\"" : ""));?> id="wc-prefix" />
    </div>
    <div class="row">
        <label class="long">Import content from <a href="http://starter.wikia.com/">starter.wikia.com</a></label>
        <input type="checkbox" name="wpCreateWikiImportStarter" <?=($wgRequest->wasPosted() ? ($wgRequest->getCheck('wpCreateWikiImportStarter') ? "checked=\"checked\"" : "") : (!empty($request_starter) ? "checked=\"checked\"" : ""));?> />
    </div>
</div>
<!-- Right column /End -->
</div>
<!-- 2-col container /End -->

<!-- 2-col container /Start -->
<div class="container">
<!-- Left column /Start -->
<div class="column">

    <div class="row">
        <label><?php echo wfMsg( "createwikidescen" ) ?></label>
        <textarea name="wpCreateWikiDescPage" /><?=($wgRequest->getCheck('wpCreateWikiDescPage') ? $wgRequest->getVal('wpCreateWikiDescPage') : $description);?></textarea>
    </div>

</div>
<!-- Left column /End -->
<!-- Right column /Start -->
<div class="column">

    <div class="row">
        <label><?php echo wfMsg( "createwikicategory" ) ?></label>
        <textarea name="wpCreateWikiCategory" style="height: 4em;" /><?=($wgRequest->getCheck('wpCreateWikiCategory') ? $wgRequest->getVal('wpCreateWikiCategory') : $request->request_category);?></textarea>
    </div>
    <div class="row">
        <label>Hub</label>
        <?php echo $hubs ?>
        <div class="hint">
            Hub for Breadcrumb
        </div>
        <div class="error">
        <?php
            if(isset($data["errors"]["wpWikiCategory"])):
                echo $data["errors"]["wpWikiCategory"];
            endif
        ?>
        </div>

    </div>
    <div class="row">
        <label>Starter</label>
        <select name="wpCreateWikiCategoryStarter">
            <option value="0" <?=(($wgRequest->getCheck('wpCreateWikiCategoryStarter') && ($wgRequest->getVal('wpCreateWikiCategoryStarter') == 0)) ? "selected=\"selected\"" : "");?> >--- not selected ---</option>
            <option value="3711" <?=(($wgRequest->getCheck('wpCreateWikiCategoryStarter') && ($wgRequest->getVal('wpCreateWikiCategoryStarter') == 3711)) ? "selected=\"selected\"" : "");?> >entertainmentstarter.wikia.com</option>
            <option value="3578" <?=(($wgRequest->getCheck('wpCreateWikiCategoryStarter') && ($wgRequest->getVal('wpCreateWikiCategoryStarter') == 3578)) ? "selected=\"selected\"" : "");?> >gamingstarter.wikia.com</option>
        </select>
        <div class="hint">
            so far, only two
        </div>
    </div>

</div>
<!-- Right column /End -->

<!-- Left column /Start -->
<div class="column">

    <div class="row">
        <label><?php echo wfMsg( "createwikidescnational" ) ?></label>
        <textarea name="wpCreateWikiDesc" /><?=($wgRequest->getCheck('wpCreateWikiDesc') ? $wgRequest->getVal('wpCreateWikiDesc') : $descriptionIntl);?></textarea>
    </div>

</div>
<!-- Left column /End -->
<!-- Right column /Start -->
<div class="column">
 <!-- empty -->
</div>
<!-- Right column /End -->

</div>
<!-- 2-col container /End -->


    <div style="text-align: center; clear: both;">
        <input type="hidden" name="action" value="process" />
        <input type="submit" name="wpCreateSubmit" value="Create new Wiki from this data" />
        <input type="submit" name="wpRejectSubmit" value="Reject this Wiki" id="wc-reject" />
    </div>

    <div class="row">
        <label>Questions &amp; Comments</label>
        <div class="hint" style="background: #eeeeee;border: 1px solid #DCDCDC; padding: 0.2em;">
            <?php echo $talk->getText() ?>
        </div>
    </div>

</form>
</div>

<!-- e:<?php echo __FILE__ ?> -->
