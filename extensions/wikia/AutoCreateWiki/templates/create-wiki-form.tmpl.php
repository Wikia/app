<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
.infoline {float:left; width:auto;font-size:105%;}
#type-selector { margin-bottom: 1em; margin-top: 1em; }
#options {
	text-align: right;
	margin-bottom: 1em;
}
#options-form {
	display: inline;
}
</style>
<script type="text/javascript">
/*<![CDATA[*/
var divErrors = new Array();
var isAutoCreateWiki = true;
var createType = "<?php echo $mType ?>";
var formViewAction = "<?=$mTitle->getLocalURL(( $mLanguage != 'en' ) ? 'action=view&uselang=' . $mLanguage  : 'action=reload')?>";
formViewAction += ( createType ) ? '&type=' + createType : '';
var msgError = "<?php echo addslashes(wfMsg('autocreatewiki-invalid-wikiname'))?>";
var defaultDomain = "<?php echo $defaultDomain ?>";
var definedDomains = YAHOO.Tools.JSONParse('<?php echo Wikia::json_encode($mDomains); ?>');
var definedSitename = YAHOO.Tools.JSONParse('<?php echo Wikia::json_encode($mSitenames); ?>');
/*]]>*/
</script>
<?php
$cgiArgs = array();
if( $mLanguage != 'en' ) {
	$cgiArgs[ "uselang" ] = $mLanguage;
}
$type = "default";
if( !empty( $mType ) ) {
	$cgiArgs[ "type" ] = $mType;
	$type = $mType;
}
?>
<div id="type-selector" class="wikia-tabs">
	<ul>
		<li class="<?= ( $type == 'default' ) ? 'selected' : 'accent' ?>">
			<a href="<?= $mTitle->escapeLocalURL() ?>"><?= wfMsg( 'autocreatewiki-page-title-default' ) ?></a>
		</li>
		<li class="<?= ( $type == 'answers' ) ? 'selected' : 'accent' ?>">
			<a href="<?= $mTitle->escapeLocalURL( array( 'type' => 'answers' ) ) ?>"><?=wfMsg('autocreatewiki-page-title-answers')?></a>
		</li>
	</ul>
</div>
<div id="options">
	<?php if ( $wgUser->isAnon() ) { ?>
	<form id="options-form" method="post" action="<?= $mTitle->escapeLocalURL( $cgiArgs ) ?>">
		<label for="uselang"><?= wfMsg( 'yourlanguage' ) ?></label>
		<select id="uselang" name="uselang" onchange="$('#options-form').submit()">
		<?php
		$selected = !empty( $uselang ) ? $uselang : $wgUser->getOption('language');
		$languages = Language::getLanguageNames();
		foreach( $languages as $code => $name ) {
			echo Xml::option( "$code - $name", $code, ($code == $selected) ) . "\n";
		}
		?>
		</select>
	</form>
	<?php } ?>
</div>
<form class="highlightform" id="highlightform" method="post" action="<?= $mTitle->escapeLocalURL( $cgiArgs ) ?>">
<div id="monobook_font">
	<div id="tagline"><? echo wfMsgExt('autocreatewiki-tagline', array('parse') ); ?></div>
	<div class="legend"><?=wfMsg("autocreatewiki-required", "<img src='{$wgStylePath}/common/required.png?{$wgStyleVersion}' />")?></div>
	<div id="moving" class="formhighlight"></div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-name-label"><?=wfMsg('allmessagesname')?>:</label></li>
			<li class="data1">
				<input type="text" autocomplete="off" name="wiki-name" id="wiki-name" value="<?=@$params['wiki-name']?>"/> <span id="wiki-subTitle"><?php echo $subName ?></span><span class="error-status" id="wiki-name-error-status">&nbsp;</span>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-name'])) ? 'block' : 'none'?>;" id="wiki-name-error"><?=@$mPostedErrors['wiki-name']?></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-topic')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-domain-label"><?=wfMsg('autocreatewiki-web-address')?></label></li>
			<li class="data1">
				<span id="prefixedAddress">http://</span><input type="text" maxlength="245" autocomplete="off" name="wiki-domain" id="wiki-domain" value="<?=@$params['wiki-domain']?>" style="width:145px" />.<span id="domainAddress"><?php echo $subDomain ?></span> <span class="error-status" id="wiki-domain-error-status">&nbsp;</span>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-domain'])) ? 'block' : 'none'?>;" id="wiki-domain-error"><?=@$mPostedErrors['wiki-domain']?></div>				
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-domain')?></span></li>
		</ul>
	</div>
<?php
if (!empty($aCategories) && is_array($aCategories) && ( $mType != "answers" ) ):
?>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-category-label"><?=wfMsg('autocreatewiki-category-label')?></label></li>
			<li class="data1"><select name="wiki-category" id="wiki-category">
				<option value=""><?=wfMsg('autocreatewiki-category-select')?></option>
<?php
	foreach ($aCategories as $iCat => $sCatName) :
		if( in_array( $sCatName, array( 'Wikia', 'Wikianswers' ) ) )
			continue;

		$selected = "";
		if ( isset($params['wiki-category']) && ($params['wiki-category'] == $iCat) ):
			$selected = " selected=\"selected\"";
		endif;
?>
				<option value="<?php echo $iCat ?>" <?php echo $selected?>><?php echo $sCatName?></option>
<?php
	endforeach
?>
				<option value="9"><?=wfMsg('autocreatewiki-category-other')?></option>
				</select>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-category'])) ? 'block' : 'none'?>;" id="wiki-category-error"><?=@$mPostedErrors['wiki-category']?></div>				
			</li>
			<li class="data2"><span class="note"><?php echo wfMsg('autocreatewiki-info-category-' . $type )?></span></li>
		</ul>
	</div>
<?php
elseif( $mType == "answers" ):
?>
	<input name="wiki-category" type="hidden" value="20" /><!--Wikianswers-->
<?php
endif
?>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-language-label"><?=wfMsg('yourlanguage')?></label></li>
			<li class="data1">
				<select name="wiki-language" id="wiki-language">
<?php
	$isSelected = false;
	if (!empty($aTopLanguages) && is_array($aTopLanguages)) :
?>
				<optgroup label="<?= wfMsg('autocreatewiki-language-top', count($aTopLanguages)) ?>">
<?php foreach ($aTopLanguages as $sLang) :
		$selected = '';
		if ( empty($isSelected) && ( ( isset( $params['wiki-language'] ) && ($sLang == $params['wiki-language']) ) || ( !isset($params['wiki-language']) && ( $sLang == $mLanguage ) ) ) ) :
			$isSelected = true;
			$selected = ' selected="selected"';
		endif;
?>
				<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$aLanguages[$sLang]?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				<optgroup label="<?= wfMsg('autocreatewiki-language-all') ?>">
<?php if (!empty($aLanguages) && is_array($aLanguages)) : ?>
<?php
	ksort($aLanguages);
	foreach ($aLanguages as $sLang => $sLangName) :
		$selected = "";
		if ( empty($isSelected) && ( ( isset($params['wiki-language'] ) && ( $sLang == $params['wiki-language'] ) ) || ( !isset($params['wiki-language']) && ( $sLang == $mLanguage ) ) ) ) :
			$isSelected = true;
			$selected = ' selected="selected"';
		endif;
?>
				<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$sLangName?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				</select>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-language'])) ? 'block' : 'none'?>;" id="wiki-language-error"><?=@$mPostedErrors['wiki-language']?></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-language')?></span></li>
		</ul>
	</div>
<!-- staff section -->
<?php if ( $wgUser->isAllowed( 'createwikimakefounder' ) ) : ?>
	<div class="formblock">
		<ul>
			<li class="label"><label><?=wfMsg('yourname')?></label></li>
			<li class="data1">
				<input type="text" maxlength="245" autocomplete="off" name="wiki-staff-username" id="wiki-staff-username" value="<?=@$params['wiki-staff-username']?>" style="width:145px" /> <span class="error-status" id="wiki-staff-username-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-staff-username-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-staff-username')?></span></li>
		</ul>
	</div>
<!-- end of staff section --->
<?php endif ?>
<?php if ($wgUser->isAnon()) : ?>
	<br />
<!-- Create an account -->
	<h1><?=wfMsg('nologinlink')?></h1>
	<div class="formblock" style="padding:2px;">
		<ul>
		<li class="infoline"><?=wfMsg('autocreatewiki-haveaccount-question')?></li>
		<li class="data1">
			<a id="AWClogin" class="wikia-button ajaxLogin" style="z-index: 10;" href="/index.php?title=Special:Signup&returnto=Special:CreateWiki&type=login" rel="nofollow"><?=wfMsg('login')?></a>
		</li>
		<li class="legend"><?=wfMsg("autocreatewiki-required", "<img src='{$wgExtensionsPath}/wikia/AutoCreateWiki/images/required.png?{$wgStyleVersion}' />")?></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-username-label"><?=wfMsg('yourname')?></label></li>
			<li class="data1">
				<input type="text" autocomplete="off" name="wiki-username" value="<?=@$params['wiki-username']?>" id="wiki-username" /> <span class="error-status" id="wiki-username-error-status">&nbsp;</span>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-username'])) ? 'block' : 'none'?>;" id="wiki-username-error"><?=@$mPostedErrors['wiki-username']?></div>
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-email-label"><?=wfMsg('youremail')?></label></li>
			<li class="data1">
				<input type="text" autocomplete="off" value="<?=@$params['wiki-email']?>" name="wiki-email" id="wiki-email" /> <span class="error-status" id="wiki-email-error-status">&nbsp;</span>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-email'])) ? 'block' : 'none'?>;" id="wiki-email-error"><?=@$mPostedErrors['wiki-email']?></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-email-address')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-password-label"><?=wfMsg('yourpassword')?></label></li>
			<li class="data1">
				<input type="password" name="wiki-password" id="wiki-password" /> <span class="error-status" id="wiki-password-error-status">&nbsp;</span>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-password'])) ? 'block' : 'none'?>;" id="wiki-password-error"><?=@$mPostedErrors['wiki-password']?></div>
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-retype-password-label"><?=wfMsg('yourpasswordagain')?></label></li>
			<li class="data1">
				<input type="password" id="wiki-retype-password" name="wiki-retype-password" /> <span class="error-status" id="wiki-retype-password-error-status">&nbsp;</span>
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-retype-password'])) ? 'block' : 'none'?>;" id="wiki-retype-password-error"><?=@$mPostedErrors['wiki-retype-password']?></div>
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-birthday-label"><?=wfMsg('autocreatewiki-birthdate')?></label></li>
			<li class="data1">
				<select name="wiki-user-year" id="wiki-user-year" class="birthdate" size="1">
					<option selected="true" value="-1">----</option>
					<? for ($year = date("Y"); $year >= 1900; $year--) { ?>
						<option value="<?=$year?>" <?= (@$params['wiki-user-year'] == $year) ? "selected='selected'" : ""; ?> ><?=$year?></option>
					<? } ?>
				</select>
				<select name="wiki-user-month" id="wiki-user-month" class="birthdate" size="1">
					<option selected="true" value="-1">--</option>
					<? for ($month = 1; $month <= 12; $month++) { ?>
						<option value="<?=$month?>" <?= (@$params['wiki-user-month'] == $month) ? "selected='selected'" : ""; ?> ><?=$month?></option>
					<? } ?>
				</select>
				<select name="wiki-user-day" id="wiki-user-day" class="birthdate" size="1">
					<option selected="true" value="-1">--</option>
					<? for ($day = 1; $day <= 31; $day++) { ?>
						<option value="<?=$day?>" <?= (@$params['wiki-user-day'] == $day) ? "selected='selected'" : ""; ?>><?=$day?></option>
					<? } ?>
				</select><span class="error-status" id="wiki-birthday-error-status">&nbsp;</span>
				<input type="hidden" name="wiki-birthday" id="wiki-birthday" />
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-birthday'])) ? 'block' : 'none'?>;" id="wiki-birthday-error"><?=@$mPostedErrors['wiki-birthday']?></div>
			</li>
			<li id="AWCInfoBirthday" class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-birthdate')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-blurry-word-label"><?=wfMsg('autocreatewiki-blurry-word')?></label></li>
			<li class="data1">
				<span class="note"><?=wfMsg('autocreatewiki-info-blurry-word')?></span><br />
				<?=$captchaForm?>
				<input type="hidden" name="wiki-blurry-word" id="wiki-blurry-word" />
				<div class="error" style="display: <?= (!empty($mPostedErrors['wiki-blurry-word'])) ? 'block' : 'none'?>;" id="wiki-blurry-word-error"><?=@$mPostedErrors['wiki-blurry-word']?></div>
			</li>
			<li class="data2"></li>
		</ul>
	</div>
	<div class="formblock">
		<ul class="col2">
			<li class="label">&nbsp;</li>
			<li class="data1">
				<?=wfMsg('autocreatewiki-info-terms-agree')?>
				<br /><input type="checkbox" id="wiki-remember" name="wiki-remember" style="width:auto" <?= (isset($params['wiki-remember'])) ? "checked='checked'" : "" ?> /><?=wfMsg('autocreatewiki-remember')?>
				<br /><input type="checkbox" id="wiki-marketing" name="wiki-marketing" style="width:auto" <?= (isset($params['wiki-marketing-unchecked'])) ? "" : "checked='checked'" ?> /><?=wfMsg('tog-marketingallowed')?>
			</li>
			<li class="data2"></li>
		</ul>
	</div>
<?php endif ?>
	<div class="toolbar neutral">
		<input type="hidden" value="<?php echo $mType ?>" name="wiki-type" id="wiki-type" />
		<input type="submit" value="<?php echo wfMsg( "autocreatewiki-page-title-" . $type ) ?>" name="wiki-submit" id="wiki-submit" />
	</div>
</div>
</form>
<iframe id="awc-process-login" height="1" width="1" style="visibility: hidden;"></iframe>
<script type="text/javascript">
/*<![CDATA[*/
$(function () { 
	$.loadYUI( function() {
		YC = YAHOO.util.Connect;
		YD = YAHOO.util.Dom;
		YE = YAHOO.util.Event;
		<?php if ( !empty($mPostedErrors) && is_array($mPostedErrors) ) : ?>
		<?php 	foreach ( $mPostedErrors as $field => $value ) : ?>
		<?php 		if ( !empty($value) ) : ?>
		if ( YD.get('<?=$field?>') ) {
			YD.addClass('<?=$field?>', 'error');
			if ( YD.get('<?=$field?>-error') ) {
				YD.setStyle('<?=$field?>-error', 'display', 'block');
				YD.get('<?=$field?>-error').innerHTML = "<?=str_replace("\n", "<br />", $value)?>";
			}
			if ( YD.get('<?=$field?>-label') ) YD.addClass('<?=$field?>-label', 'error');
		<?
			if ($field == 'wiki-blurry-word') {
		?>
				if ( YD.get('wpCaptchaWord') ) YD.addClass('wpCaptchaWord', 'error');
		<?
			}
		?>
		}
		<?php		endif ?>
		<?php 	endforeach ?>
		<?php endif ?>
	});
});
/*]]>*/
</script>
<script type="text/javascript" src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/js/autocreatewiki.js?<?=$wgStyleVersion?>"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function () {
	$.loadYUI( function() {
		if (YD.get('userloginRound')) {
			// TODO: FBConnect: Make sure this still works now that the YUI version of AjaxLogin has been removed.  This login/signup part of CreateWiki probably just needs to be rewritten completely to re-use other code.
			//					What were all these variables being set up for?
			/*
			__showLoginPanel = function(e) {
				var ifr = YD.get('awc-process-login');
				var titleUrl = '<?=$mTitle->getLocalURL()."/Caching".(( $mLanguage != 'en' ) ? '?uselang=' . $mLanguage : '')?>';
				var wikiName = YD.get('wiki-name');
				var wikiDomain = YD.get('wiki-domain');
				var wikiCategory = YD.get('wiki-category');
				var wikiLanguage = YD.get('wiki-language');
				titleUrl += "?wiki-name=" + wikiName.value;
				titleUrl += "&wiki-domain=" + wikiDomain.value;
				titleUrl += "&wiki-category=" + wikiCategory.value;
				titleUrl += "&wiki-language=" + wikiLanguage.value;
				ifr.src = titleUrl;

				openLogin(e); // THIS WASN'T IN THE YUI VERSION, THE ABOVE AND BELOW WERE

				return false;
			}
			*/

			YE.addListener('AWClogin', 'click', openLogin);
			YE.addListener('login', 'click', openLogin);
		}
	});
});
/*]]>*/
</script>
<!-- e:<?= __FILE__ ?> -->
