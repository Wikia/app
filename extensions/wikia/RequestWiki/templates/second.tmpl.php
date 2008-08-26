<!-- s:<?= __FILE__ ?> -->
<?php global $wgScriptPath, $wgRequestWikiMoreInfoDropDownCount ?>
<style type="text/css">
/*<![CDATA[*/
#rw-form label { display: block; width: auto !important; float: left; padding-right: 1em;}
#rw-form input.text { width: 24em;}
#rw-form option {width: 20em; }
#rw-form textarea { width: 44em; height: 6em;}
#rw-form .admin {background: #F0E68C;}
#rw-form div.row { padding: 0.8em; margin-bottom: 0.8em; display: block; clear: both; border-bottom: 1px solid #DCDCDC; }
#rw-form div.info, div.hint { text-align: left;}
#rw-form div.hint {font-style: italic; text-align: left; margin: 4px 0; clear: both}
#rw-form div.row label {font-weight: bold}
#rw-form .rw-moreinfo {width: 250px}
.example_hint {margin: 4px 0; color: #BBBBBB;}
.inline_hint_admin {font-style: italic; margin-left: 16em; color: black;}
/*]]>*/
</style>
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("WRequest");

var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var WR = YAHOO.WRequest;
var ajaxpath = "<?= "{$wgScriptPath}/index.php" ?>";
YAHOO.util.Event.preventDefault('rw-form');

YAHOO.WRequest.NameCallback = {
    success: function( oResponse ) {
        var divData = YAHOO.Tools.JSONParse(oResponse.responseText);
        var div = YD.get( divData["div-name"] );
        var error = divData["is-error"];
        if (error == 1) {
            YD.get( "rw-submit" ).disabled = true;
        }
        else {
            YD.get( "rw-submit" ).disabled = false;
        }
        div.innerHTML = divData["div-body"];
    },
    failure: function( oResponse ) {
        YAHOO.log( "simple replace failure " + oResponse.responseText );
    },
    timeout: 50000
};
YAHOO.WRequest.watchName = function (e) {
    YD.get("rw-name-check").innerHTML = '<img src="http://images.wikia.com/common/progress_bar.gif" width="70" height="11" alt="Wait..." border="0" />';
    var name = YD.get("rw-name").value;
    var lang = YD.get("rw-language").value;

    // to lowercase
    name = name.toLowerCase();
    YD.get("rw-name").value = name;

    YC.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWRequestCheckName&name="+escape(name)+"&lang="+escape(lang)+"&edit=<?= $request_id ?>", YAHOO.WRequest.NameCallback);
};

YAHOO.WRequest.watchLanguage = function (e) {
    if ( YD.get("rw-language").value != 'en' ) {
        YD.get( "rw-description-english" ).disabled = false;
        YD.setStyle( "rw-div-descen", "display", "block" );
        YD.setStyle( "rw-description-english", "background", "inherit" );
    }
    else {
        // YD.get( "rw-description-english" ).disabled = true;
        // YD.setStyle( "rw-description-english", "background", "#DCDCDC" );
        YD.setStyle( "rw-div-descen", "display", "none" );
    }
    var name = YD.get("rw-name").value;
	if (name != '') {
		var lang = YD.get("rw-language").value;
		YD.get("rw-name-check").innerHTML = '<img src="http://images.wikia.com/common/progress_bar.gif" width="70" height="11" alt="Wait..." border="0" />';
		YC.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWRequestCheckName&name="+escape(name)+"&lang="+escape(lang)+"&edit=<?= $request_id ?>", YAHOO.WRequest.NameCallback);
	}
};

// check all form, unlock fileds which are locked
YAHOO.WRequest.watchForm = function (e) {
};

// init all fields
YAHOO.WRequest.init = function () {
};

YAHOO.WRequest.Uppercase = function( e, field ) {
    var _tmp = YD.get( field ).value;
    YD.get( field ).value = _tmp.substring(0, 1).toUpperCase() + _tmp.substring(1, _tmp.length);
    YD.get( field ).disabled = false;
}

YE.addListener("rw-name", "change", WR.watchName );
YE.addListener("rw-language", "change", WR.watchLanguage );
YE.addListener("rw-title", "change", WR.Uppercase, "rw-title" );
YE.addListener("rw-submit", "submit", WR.watchForm );

// #3296
WR.addTracker = function(elem, type, url) {
        YE.addListener(elem, type, function(e, url) {
                YAHOO.Wikia.Tracker.trackByStr(null, 'RequestWiki/' + url);
        }, url);
}

WR.addTracker('rw-form', 'submit', 'SubmitRequest');
WR.addTracker('rw-submit', 'click', 'SubmitRequest');

/*]]>*/
</script>
<?php if (!empty($is_staff)): ?>
<div>
    [<a href="<?= $title->getLocalUrl("action=list") ?>">list of requests</a>]
<?php
    if (!empty($editing)):
        foreach($links as $action => $link):
?>
    [<a href="<?= $link ?>"><?= $action ?></a>]
<?php
        endforeach;
    endif;
?>
</div>
<? endif ?>
<div>
<form id="rw-form" action="<?= $title->getLocalUrl("action=third") ?>" method="post" style="margin-left: auto; margin-right: auto;">
 <input type="hidden" name="wiki_tos_agree" value="<?= $params['wiki_tos_agree'] ?>">
 <div class="info"><?= (!empty($errors)) ? Wikia::errormsg(wfMsg('requestwiki-second-error')) : '' ?></div>
 <div class="row">
    <label><?= wfMsg("requestwiki-second-username") ?></label>
<?php if (!empty($is_staff)): ?>
    <div class="hint"><?= wfMsg("requestwiki-second-username-hint") ?></div>
    <div class="info"><?= (!empty($errors["rw-username"])) ? $errors["rw-username"] : '' ?></div>
    <input maxlength="100" type="text" name="rw-username" id="rw-username" value="<?= $user->mName ?>" />
<?php else: ?>
    <strong><?= $user->mName ?></strong>
    <input type="hidden" name="rw-username" id="rw-username" value="<?= $user->mName ?>" readonly="readonly" />
<?php endif ?>
    <input type="hidden" name="rw-userid" value="<?= $user->mId ?>" />
    <?php if($editing==1): ?>
    <input type="hidden" name="editing" value="1" />
    <input type="hidden" name="id" value="<?= $request_id ?>" />
    <?php else: ?>
    <input type="hidden" name="editing" value="0" />
    <?php endif ?>
 </div>

<?php if (!empty($is_staff)): ?>
 <div class="row admin">
	<span class="inline_hint_admin">Fields on backgound like this are visible only by staff</span><br/>
	<label><?= wfMsg("email") ?></label>
	<strong><?= $user->mEmail ?></strong>
	<br/>
 	<label><?= wfMsg("requestwiki-second-date") ?></label>
	<?= ($editing == 1) ? $params['request_timestamp'] : wfTimestampNow() ?>
	<input size="14" type="hidden" name="rw-timestamp" id="rw-timestamp" value="<?= ($editing == 1) ? $params['request_timestamp'] : wfTimestampNow() ?>" readonly="readonly" />
	<span class="inline_hint_admin"><?= wfMsg("requestwiki-second-date-hint") ?></span>
	<br/>
 </div>
<?php endif ?>

<?php if (empty($is_staff)): ?>
 <input size="14" type="hidden" name="rw-timestamp" id="rw-timestamp" value="<?= ($editing == 1) ? $params['request_timestamp'] : wfTimestampNow() ?>" readonly="readonly" />
<?php endif ?>

 <div class="row">
    <label for="rw-title"><?= wfMsg('requestwiki-second-title') ?></label>
    <div class="hint"><?= wfMsg('requestwiki-second-title-hint') ?></div>
    <div class="example_hint"><?= wfMsg('requestwiki-second-title-example') ?></div>
    <div class="info"><?= (!empty($errors["rw-title"])) ? $errors["rw-title"] : '' ?></div>
    <input maxlength="100" type="text" id="rw-title" name="rw-title" value="<?= isset($params['request_title']) ? $params['request_title'] : '' ?>" class="text" />
 </div>

 <div class="row">
	<label><?= wfMsg('requestwiki-second-language') ?></label>
	<div class="hint"><?= wfMsg('requestwiki-second-language-hint') ?></div>
    <div class="info"><?= (!empty($errors['rw-language'])) ? $errors['rw-language'] : '' ?></div>
<?php
	$top_languages = explode(',', wfMsg('requestwiki-second-language-top'));
?>
	<select id="rw-language" name="rw-language">
		<optgroup label="<?= wfMsg('requestwiki-second-language-group-top', array(1 => count($top_languages))) ?>">
<?php
	$isSelected = false;	//prevent adding multiple "selected" to option
	foreach ($top_languages as $key) {
		$selected = '';
		if (!$isSelected && ((!empty($params['request_language']) && $key===$params['request_language']) || empty($params['request_language']) && $key === 'en'))
		{
			$isSelected = true;
			$selected = ' selected="selected"';
		}
		echo "\t\t\t<option value=\"$key\"$selected>$key - {$languages[$key]}</option>\n";
	}
?>
		</optgroup>
		<optgroup label="<?= wfMsg('requestwiki-second-language-group-all') ?>">
<?php
	foreach ($languages as $key => $language) {
		$selected = '';
		if (!$isSelected && ((!empty($params['request_language']) && $key===$params['request_language']) || empty($params['request_language']) && $key === 'en'))
		{
			$isSelected = true;
			$selected = ' selected="selected"';
		}
		echo "\t\t\t<option value=\"$key\"$selected>$key - $language</option>\n";
	}
?>
		</optgroup>
	</select>
 </div>

 <div class="row">
    <label for="rw-name"><?= wfMsg('requestwiki-second-url') ?></label>
    <div class="hint"><?= wfMsg('requestwiki-second-url-hint') ?></div>
    <div class="example_hint"><?= wfMsg('requestwiki-second-url-example') ?></div>
    <div class="info" id="rw-name-check"><?= (!empty($errors["rw-name"])) ? $errors["rw-name"] : '' ?></div>
    <?php if ($is_staff || empty($editing)): ?>
    http://<input maxlength="50" type="text" name="rw-name" id="rw-name" value="<?= isset($params['request_name']) ? $params['request_name'] : '' ?>" />.wikia.com
    <?php else: ?>
    http://<span class="inactive"><?= $params['request_name'] ?></span>.wikia.com
    <input type="hidden" name="rw-name" id="rw-name" value="<?= $params['request_name'] ?>" />
    <?php endif ?>
 </div>

 <div class="row">
    <label><?= wfMsg('requestwiki-second-description') ?></label>
    <div class="hint"><?= wfMsg('requestwiki-second-description-hint') ?></div>
    <div class="info"><?= (!empty($errors['rw-description-international'])) ? $errors['rw-description-international'] : '' ?></div>
    <textarea id="rw-description-international" name="rw-description-international"/><?= isset($params['request_description_international']) ? $params['request_description_international'] : '' ?></textarea>
 </div>

 <div class="row">
    <label><?= wfMsg('requestwiki-second-category') ?></label>
    <div class="hint"><?= wfMsg('requestwiki-second-category-hint') ?></div>
    <div class="info"><?= (!empty($errors["rw-category"])) ? $errors["rw-category"] : '' ?></div>
    <select id="rw-category" name="rw-category">
        <option value=""><?= wfMsg('requestwiki-second-category-choose-option') ?></option>
<?php
	$selected = '';
    foreach ($categories as $cat) {
        if (!empty($params['request_category']))
            $selected = htmlspecialchars($cat)===$params['request_category'] ? ' selected="selected"' : '';
        echo "\t<option value=\"$cat\"$selected>$cat</option>\n";
    }
?>
    </select>
 </div>


 <?php $hidediv = (!isset($params['request_language']) || $params['request_language'] == "en" ) ? "display: none;": "display: block;"; ?>
 <div class="row" id="rw-div-descen" style="<?= $hidediv ?>">
    <label><?= wfMsg('requestwiki-second-description-english') ?></label>
    <div class="hint"><?= wfMsg('requestwiki-second-description-english-hint') ?></div>
    <?php $dscparams = (!isset($params['request_language']) || $params['request_language'] == "en") ? "class=\"inactive\" disabled=\"disabled\"": ""; ?>
    <textarea id="rw-description-english" name="rw-description-english" <?= $dscparams ?> /><?= isset($params['request_description_english']) ? $params['request_description_english'] : '' ?></textarea>
 </div>

 <div class="row">
    <label><?= wfMsg('requestwiki-second-community') ?></label>
    <div class="hint"><?= wfMsg('requestwiki-second-community-hint') ?></div>
    <div class="info"><?= (!empty($errors['rw-community'])) ? $errors['rw-community'] : '' ?></div>
    <textarea id="rw-community" name="rw-community" /><?= isset($params['request_community']) ? $params['request_community'] : '' ?></textarea>
 </div>

<?php
	//the count of SELECTs here are defined in LocalSettings.php in variable $wgRequestWikiMoreInfoDropDownCount
	if (isset ($wgRequestWikiMoreInfoDropDownCount) && $wgRequestWikiMoreInfoDropDownCount > 0) {
	//don't show this if no fields will be displayed
?>
 <div class="row">
	<label><?= wfMsg('requestwiki-second-moreinfo') ?></label>
	<div class="hint"><?= wfMsg('requestwiki-second-moreinfo-hint') ?></div>
    <div class="info"><?= (!empty($errors['rw-moreinfo'])) ? $errors['rw-moreinfo'] : '' ?></div>
	<input type="hidden" id="rw-moreinfo-count" name="rw-moreinfo-count" value="<?= $wgRequestWikiMoreInfoDropDownCount ?>" />
<?php
	$moreinfo_params = isset($params['request_moreinfo']) ? explode("\n", $params['request_moreinfo']) : array();
	$urls = explode("\n", wfMsg('requestwiki-second-moreinfo-urls'));
	for ($urlNo = 0; $urlNo < $wgRequestWikiMoreInfoDropDownCount; $urlNo++) {
?>
		<select class="rw-moreinfo" id="rw-moreinfo-url-<?= $urlNo ?>" name="rw-moreinfo-url-<?= $urlNo ?>">
			<option value=""><?= wfMsg('requestwiki-second-category-choose-option') ?></option>
<?php
		$more_info_item = explode('=', array_pop($moreinfo_params));
		$isSelected = false; //speed up long condition
		foreach ($urls as $url) {
			$url = trim($url);
			$selected = '';
			//$params["request_moreinfo_url_$urlNo" - used when redirect after error
			//$params['request_moreinfo'] - used when editing informations (id=xx in URL)
			if (!$isSelected && ((!empty($params["request_moreinfo_url_$urlNo"]) && $url === $params["request_moreinfo_url_$urlNo"]) ||
				(!is_null($more_info_item) && $more_info_item[0] === $url))) {
				$isSelected = true;
				$selected = ' selected="selected"';
			}
			echo "\t\t\t<option value=\"" . addslashes($url) . "\"$selected>$url</option>\n";
		}
?>
		</select>
		<input maxlength="255" type="text" id="rw-moreinfo-url-txt-<?= $urlNo ?>" name="rw-moreinfo-url-txt-<?= $urlNo ?>" class="text" value="<?= empty($params["request_moreinfo_url_txt_$urlNo"]) ? (isset($more_info_item[1]) ? $more_info_item[1] : '') : $params["request_moreinfo_url_txt_$urlNo"] ?>"/>
<?php
		if (!$urlNo) {
			echo '<span class="example_hint">' . wfMsg('requestwiki-second-moreinfo-example') . '</span>';
		}
		if ($urlNo < $wgRequestWikiMoreInfoDropDownCount -1) {
			echo "<br/>\n";
		}
	}
	unset($moreinfo_params);
	unset($urls);
?>
 </div>
<?php
	}
?>

 <div class="row">
    <label><?= wfMsg('requestwiki-second-extrainfo') ?></label>
    <div class="hint"><?= wfMsg('requestwiki-second-extrainfo-hint') ?></div>
    <textarea id="rw-extrainfo" name="rw-extrainfo" /><?= isset($params['request_extrainfo']) ? $params['request_extrainfo'] : '' ?></textarea>
 </div>

<?php
	wfRunHooks( 'RequestWiki::showRequestForm:presubmit' ) ;
 ?>
 <div style="text-align: center;">
   <input type="submit" name="rw-submit" id="rw-submit" value="<?= wfMsg('requestwiki-second-submit') ?>" />
 </div>

</form>
</div>
<!-- e:<?= __FILE__ ?> -->
