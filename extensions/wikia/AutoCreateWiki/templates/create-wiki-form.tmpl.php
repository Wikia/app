<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
li {
	list-style-image:none;
	list-style-position:outside;
	list-style-type:none;
}
/*** FORM STYLES ***/
form.highlightform {
	min-width: 700px;
	position: relative;
}
div.formhighlight {
	background: #dbe7ff;	
	position: absolute;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;	
}
.formblock {
	overflow: hidden;	
	padding: 10px 0;
	position: relative;
	width: 100%;
	z-index: 1;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
}
.formblock ul {
	overflow: hidden;	
	padding: 10px 0;
}
.formblock .label {
	font-weight: bold;
	float: left;
	width: 175px;
}
.label label {
	display: block;
	padding-left: 15px;	
}
.label label.required {
		background: url(<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/images/required.png?<?=$wgStyleVersion?>) 5px .3em no-repeat;	
}
.formblock .data1 {
	float: left;
	padding-left: 10px;
	width: 350px;	
}
.formblock .data1 input {
	width: 200px;	
}
.formblock .data1 select {
	width: 250px;	
}
.formblock ul.col2 .data1 {
	float: none;
	margin-left: 200px;
	padding-right: 15px;
	width: auto;	
}
.formblock .data2 {
	margin-left: 520px;
	padding-right: 15px;
	padding-left: 5px;
}
.birthdate {
	width: auto !important;
}
.selected {
	background: #dbe7ff;	
}
.note {
	color: #666;
	font-size: 9pt;
	font-style: italic;
}
.selected .note {
	color: #333;
}
.toolbar {
	margin: 5px 0;
	padding: 10px 15px;
}

.legend {
	margin-bottom: 5px;
	text-align: right;	
}

/*** ERROR HANDLING***/
div.error {
	background: #FFE;
	border: 1px solid #98988E;
	margin: 0 0 10px 0;
	padding: 10px;
}
form div.error {
	font-family: sans-serif;
	font-size: x-small;
	margin: 10px 10px 0 0;	
}
label.error {
	color: #C00;	
}
input.error, select.error {
	border: 1px solid #C00;
}
.error-status {
	padding-left:5px;
}
</style>
<script type="text/javascript">
/*<![CDATA[*/
var divErrors = new Array();
/*]]>*/
</script>
<form class="highlightform" id="highlightform" method="post" action="<?=$mTitle->escapeLocalURL("")?>">
<div id="monobook_font">
	<div class="legend"><?=wfMsg("autocreatewiki-required", "<img src='{$wgExtensionsPath}/wikia/AutoCreateWiki/images/required.png?{$wgStyleVersion}' />")?></div>
	<div id="moving" class="formhighlight"></div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-web-address')?></label></li>
			<li class="data1">
				<span id="prefixedAddress">http://</span><input type="text" maxlength="245" autocomplete="off" name="wiki-domain" id="wiki-domain" style="width:145px" />.wikia.com <span class="error-status" id="wiki-domain-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-domain-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-domain')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-topic')?></label></li>
			<li class="data1"><input type="text" autocomplete="off" name="wiki-topic" id="wiki-topic" /></li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-topic')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-category')?></label></li>
			<li class="data1"><select name="wiki-category" id="wiki-category">
<?php if (!empty($aCategories) && is_array($aCategories)) :  ?>
<?php foreach ($aCategories as $iCat => $sCatName) : ?>
				<option value="<?=$iCat?>"><?=$sCatName?></option>
<?php endforeach ?>
<?php endif ?>
				</select>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-category')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-language')?></label></li>
			<li class="data1">
				<select name="wiki-language" id="wiki-language"><option value="0"><?=wfMsg('autocreatewiki-chooseone')?></option>
<?php if (!empty($aLanguages) && is_array($aLanguages)) :  ?>
<?php foreach ($aLanguages as $sLang => $sLangName) : ?>
				<option value="<?=$sLang?>" <?=(($sLang == 'en') ? "selected=\"true\"" : "")?>><?=$sLangName?></option>
<?php endforeach ?>
<?php endif ?>
				</select>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-language')?></span></li>
		</ul>
	</div>
<?php if ($wgUser->isAnon()) : ?>
	<br />
	<h1>Create an Account</h1>
	<div class="legend"><?=wfMsg("autocreatewiki-required", "<img src='{$wgExtensionsPath}/wikia/AutoCreateWiki/images/required.png?{$wgStyleVersion}' />")?></div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-username')?></label></li>
			<li class="data1">
				<input type="text" autocomplete="off" name="wiki-username" id="wiki-username" /> <span class="error-status" id="wiki-username-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-username-error"></div>
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label><?=wfMsg('autocreatewiki-email-address')?></label></li>
			<li class="data1">
				<input type="text" autocomplete="off" name="wiki-email" id="wiki-email" /> <span class="error-status" id="wiki-email-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-email-error"></div>
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-email-address')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-password')?></label></li>
			<li class="data1">
				<input type="password" name="wiki-password" id="wiki-password" /> <span class="error-status" id="wiki-password-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-password-error"></div>				
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-retype-password')?></label></li>
			<li class="data1">
				<input type="password" id="wiki-retype-password" name="wiki-retype-password" /> <span class="error-status" id="wiki-retype-password-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-retype-password-error"></div>				
			</li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label><?=wfMsg('autocreatewiki-realname')?></label></li>
			<li class="data1"><input type="text" id="wiki-realname" name="wiki-realname" /></li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-realname')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-birthdate')?></label></li>
			<li class="data1">
				<select name="wiki-user-year" id="wiki-user-year" class="birthdate"><option selected="true" value="-1">----</option><? for ($year = 1900; $year <= date("Y"); $year++) { ?><option><?=$year?></option><? } ?></select>
				<select name="wiki-user-month" id="wiki-user-month" class="birthdate"><option selected="true" value="-1">--</option><? for ($month = 1; $month <= 12; $month++) { ?><option><?=$month?></option><? } ?></select>
				<select name="wiki-user-day" id="wiki-user-day" class="birthdate"><option selected="true" value="-1">--</option><? for ($day = 1; $day <= 31; $day++) { ?><option><?=$day?></option><? } ?></select> <span class="error-status" id="wiki-birthday-error-status">&nbsp;</span>
				<div class="error" style="display: none;" id="wiki-birthday-error"></div>				
			</li>
			<li class="data2"><span class="note"><?=wfMsg('autocreatewiki-info-birthdate')?></span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required"><?=wfMsg('autocreatewiki-blurry-word')?></label></li>
			<li class="data1">
				<?=wfMsg('autocreatewiki-info-blurry-word')?><br />
				<input type="text" id="wiki-blurry-word" name="wiki-blurry-word" />
			</li>
			<li class="data2">CAPTCHA</li>
		</ul>
	</div>
	<div class="formblock">
		<ul class="col2">
			<li class="label">&nbsp;</li>
			<li class="data1">
				<?=wfMsg('autocreatewiki-info-terms-agree')?><br />
				<input type="checkbox" id="wiki-remember" name="wiki-remember" /> <?=wfMsg('autocreatewiki-remember')?>
			</li>
		</ul>
	</div>
	<div class="toolbar color1 clearfix">
		<input type="submit" value="Create Wiki" name="wiki-submit" id="wiki-submit" />
		<input type="button" value="Cancel" name="wiki-cancel" id="wiki-cancel" />
	</div>
<?php endif ?>
</div>
</form>
<script type="text/javascript" src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/js/autocreatewiki.js?<?=$wgStyleVersion?>"></script>
<!-- e:<?= __FILE__ ?> -->
