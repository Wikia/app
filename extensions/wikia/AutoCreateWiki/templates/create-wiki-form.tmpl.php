<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
.infoline {float:left; width:auto;font-size:105%;}
</style>
<script type="text/javascript">
/*<![CDATA[*/
var divErrors = new Array();
var msgError = "<?=addslashes(wfMsg('autocreatewiki-invalid-wikiname'))?>";
/*]]>*/
</script>
<form class="highlightform" id="highlightform" method="post" action="<?=$mTitle->escapeLocalURL("")?>">
<div id="monobook_font">
	<div class="legend"><?=wfMsg("autocreatewiki-required", "<img src='{$wgStylePath}/common/required.png?{$wgStyleVersion}' />")?></div>
	<div id="moving" class="formhighlight"></div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-name-label"><?=wfMsg('allmessagesname')?>:</label></li>
			<li class="data1">
				<input type="text" autocomplete="off" name="wiki-name" id="wiki-name" value="<?=@$params['wiki-name']?>"/> Wiki <span class="error-status" id="wiki-name-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-name-error">
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-topic')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-domain-label"><?=wfMsg('autocreatewiki-web-address')?></label></li>
			<li class="data1">
				<span id="prefixedAddress">http://</span><input type="text" maxlength="245" autocomplete="off" name="wiki-domain" id="wiki-domain" value="<?=@$params['wiki-domain']?>" style="width:145px" />.wikia.com <span class="error-status" id="wiki-domain-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-domain-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-domain')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-category-label"><?=wfMsg('nstab-category')?>:</label></li>
			<li class="data1"><select name="wiki-category" id="wiki-category"><option value=""><?=wfMsg('autocreatewiki-category-select')?></option>
<?php if (!empty($aCategories) && is_array($aCategories)) :  ?>
<?php 
	foreach ($aCategories as $iCat => $sCatName) : 
	if ($sCatName == 'Wikia') continue;
	$selected = "";
	if ( isset($params['wiki-category']) && ($params['wiki-category'] == $iCat) ) {
		$selected = " selected='selected'";
	}
?>

				<option value="<?=$iCat?>" <?=$selected?>><?=$sCatName?></option>
<?php 
	endforeach 
?>
<?php endif ?>
				</select>
				<div class="error" style="display: none;" id="wiki-category-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-category')?></span></li>
		</ul>
	</div>
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
		if ( empty($isSelected) && ( ( isset( $params['wiki-language'] ) && ($sLang == $params['wiki-language']) ) || ( !isset($params['wiki-language']) && ( $sLang == 'en' ) ) ) ) :
			$isSelected = true;
			$selected = ' selected="selected"';
		endif; 
?>
				<option value="<?=$sLang?>" <?=$selected?>><?=$aLanguages[$sLang]?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				<optgroup label="<?= wfMsg('autocreatewiki-language-all') ?>">
<?php if (!empty($aLanguages) && is_array($aLanguages)) : ?>
<?php 
	foreach ($aLanguages as $sLang => $sLangName) :
		if ( empty($isSelected) && ( ( isset($params['wiki-language'] ) && ( $sLang == $params['wiki-language'] ) ) || ( !isset($params['wiki-language']) && ( $sLang == 'en' ) ) ) ) :
			$isSelected = true;
			$selected = ' selected="selected"';
		endif; 
?>
				<option value="<?=$sLang?>" <?=$selected?>><?=$sLangName?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				</select>
				<div class="error" style="display: none;" id="wiki-language-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-language')?></span></li>
		</ul>
	</div>
<?php if ($wgUser->isAnon()) : ?>
	<br />
<!-- Create an account -->	
	<h1><?=wfMsg('nologinlink')?></h1>
	<div class="formblock" style="padding:2px;">
		<ul>
		<li class="infoline"><?=wfMsg('autocreatewiki-haveaccount-question')?></li>
		<li class="data1">
			<a id="AWClogin" class="bigButton" href="/index.php?title=Special:UserLogin&returnto=Special:AutoCreateWiki" rel="nofollow"><big><?=wfMsg('login')?></big><small> </small></a>
		</li>
		<li class="legend"><?=wfMsg("autocreatewiki-required", "<img src='{$wgExtensionsPath}/wikia/AutoCreateWiki/images/required.png?{$wgStyleVersion}' />")?></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-username-label"><?=wfMsg('yourname')?></label></li>
			<li class="data1">
				<input type="text" autocomplete="off" name="wiki-username" value="<?=@$params['wiki-username']?>" id="wiki-username" /> <span class="error-status" id="wiki-username-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-username-error"></div>
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-email-label"><?=wfMsg('youremail')?></label></li>
			<li class="data1">
				<input type="text" autocomplete="off" value="<?=@$params['wiki-email']?>" name="wiki-email" id="wiki-email" /> <span class="error-status" id="wiki-email-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-email-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-email-address')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-password-label"><?=wfMsg('yourpassword')?></label></li>
			<li class="data1">
				<input type="password" name="wiki-password" id="wiki-password" /> <span class="error-status" id="wiki-password-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-password-error"></div>				
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-retype-password-label"><?=wfMsg('yourpasswordagain')?></label></li>
			<li class="data1">
				<input type="password" id="wiki-retype-password" name="wiki-retype-password" /> <span class="error-status" id="wiki-retype-password-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-retype-password-error"></div>				
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
				<div class="error" style="display: none;" id="wiki-birthday-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-birthdate')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required" id="wiki-blurry-word-label"><?=wfMsg('autocreatewiki-blurry-word')?></label></li>
			<li class="data1">
				<span class="note"><?=wfMsg('autocreatewiki-info-blurry-word')?></span><br />
				<?=$captchaForm?>
				<input type="hidden" name="wiki-blurry-word" id="wiki-blurry-word" />
				<div class="error" style="display: none;" id="wiki-blurry-word-error"></div>
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
			</li>
			<li class="data2"></li>
		</ul>
	</div>
<?php endif ?>
	<div class="toolbar color1 clearfix">
		<input type="submit" value="Create Wiki" name="wiki-submit" id="wiki-submit" />
		<input type="reset" value="Cancel" name="wiki-cancel" id="wiki-cancel" />
	</div>
</div>
</form>
<iframe id="awc-process-login" height="1" width="1" style="visibility: hidden;"></iframe>
<script type="text/javascript">
/*<![CDATA[*/
var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
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
/*]]>*/
</script>
<script type="text/javascript" src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/js/autocreatewiki.js?<?=$wgStyleVersion?>"></script>
<script type="text/javascript">
/*<![CDATA[*/
YE.onDOMReady(function () {
	if (YD.get('userloginRound')) {
		__showLoginPanel = function(e) {
			var ifr = YD.get('awc-process-login');
			var titleUrl = '<?=$mTitle->getLocalURL()."/Caching"?>'; 
			var wikiName = YD.get('wiki-name');
			var wikiDomain = YD.get('wiki-domain');
			var wikiCategory = YD.get('wiki-category');
			var wikiLanguage = YD.get('wiki-language');
			titleUrl += "?wiki-name=" + wikiName.value;
			titleUrl += "&wiki-domain=" + wikiDomain.value;
			titleUrl += "&wiki-category=" + wikiCategory.value;
			titleUrl += "&wiki-language=" + wikiLanguage.value;
			ifr.src = titleUrl;
			YAHOO.wikia.AjaxLogin.showLoginPanel(e);
			return false;
		}
		
		YE.addListener('AWClogin', 'click', __showLoginPanel);
		YE.addListener('login', 'click', __showLoginPanel);
	}
});
/*]]>*/
</script>
<!-- e:<?= __FILE__ ?> -->
