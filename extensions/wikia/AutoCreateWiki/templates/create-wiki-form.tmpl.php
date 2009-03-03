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
	width: 200px;
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
	width: 300px;	
}
.formblock .data1 input {
	width: 150px;	
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
	margin: 10px 0 0 0;	
}
label.error {
	color: #C00;	
}
input.error, select.error {
	border: 1px solid #C00;
}

</style>
<form class="highlightform" id="highlightform">
<div id="monobook_font">
<div class="legend"><img src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/images/required.png?<?=$wgStyleVersion?>" /> = required</div>
	<div id="moving" class="formhighlight"></div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Web Address:</label></li>
			<li class="data1"><span id="prefixedAddress">http://</span><input type="text" maxlength="245" />.wikia.com
				<div class="error" style="display: none;"></div>
			</li>
			<li class="data2"><span class="note">It's best to use a word likely to be a search keyword for your topic.</span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Topic:</label></li>
			<li class="data1"><input type="text" />
				<div class="error" style="display: none;"></div>
			</li>
			<li class="data2"><span class="note">Add a short description such as "Star Wars" or "TV Shows"</span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Category:</label></li>
			<li class="data1"><select name="wiki-category" id="wiki-category">
<?php if (!empty($aCategories) && is_array($aCategories)) :  ?>
<?php foreach ($aCategories as $iCat => $sCatName) : ?>
				<option value="<?=$iCat?>"><?=$sCatName?></option>
<?php endforeach ?>
<?php endif ?>
				</select>
				<div class="error" style="display: none;"></div>
			</li>
			<li class="data2"><span class="note">This will help visitors find your wiki</span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Language:</label></li>
			<li class="data1">
				<select name="wiki-language" id="wiki-language"><option value="0"><?=wfMsg('autocreatewiki-chooseone')?></option>
<?php if (!empty($aLanguages) && is_array($aLanguages)) :  ?>
<?php foreach ($aLanguages as $sLang => $sLangName) : ?>
				<option value="<?=$sLang?>" <?=(($sLang == 'en') ? "selected=\"true\"" : "")?>><?=$sLangName?></option>
<?php endforeach ?>
<?php endif ?>
				</select>
				<div class="error" style="display: none;"></div>
			</li>
			<li class="data2"><span class="note">This will be the default language for visitors to your wiki</span></li>
		</ul>
	</div>
</div>
<?php if ($wgUser->isAnon()) : ?>
<h1>Create an Account</h1>
<div class="legend"><img src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/images/required.png?<?=$wgStyleVersion?>" /> = required</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Username:</label></li>
			<li class="data1"><input type="text" /></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label>Email Address:</label></li>
			<li class="data1"><input type="text" /></li>
			<li class="data2"><span class="note">Your email address is never shown to anyone on Wikia.</span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Password:</label></li>
			<li class="data1"><input type="password" /></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Retype password:</label></li>
			<li class="data1"><input type="password" /></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label>Real name:</label></li>
			<li class="data1"><input type="text" /></li>
			<li class="data2"><span class="note">If you choose to provide it this will be used for giving you attribution for your work.</span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Birth date:</label></li>
			<li class="data1">
				<select name="wiki-user-year" class="birthdate"><? for ($year = 1900; $year <= date("Y"); $year++) { ?><option><?=$year?></option><? } ?></select>
				<select name="wiki-user-month" class="birthdate"><? for ($month = 1; $month <= 12; $month++) { ?><option><?=$month?></option><? } ?></select>
				<select name="wiki-user-day" class="birthdate"><? for ($day = 1; $day <= 31; $day++) { ?><option><?=$day?></option><? } ?></select>
			</li>
			<li class="data2"><span class="note">Wikia requires all users to provide their real date of birth as both a safety precaution and as a means of preserving the integrity of the site while complying with federal regulations.</span></li>
		</ul>
	</div>
	<div class="formblock">
		<ul>
			<li class="label"><label class="required">Blurry word:</label></li>
			<li class="data1">
				To help protect against automated account creation, please type the blurry word that you see into this field.<br />
				<input type="text" />
			</li>
			<li class="data2">CAPTCHA</li>
		</ul>
	</div>
	<div class="formblock">
		<ul class="col2">
			<li class="label">&nbsp;</li>
			<li class="data1">
				By creating an account, you agree to the <a href="#">Wikia's Terms of Use</a><br />
				<input type="checkbox" /> Remember me
			</li>
		</ul>
	</div>
	<div class="toolbar color1 clearfix">
		<input type="submit" value="Create Wiki" />
		<input type="button" value="Cancel" />
	</div>
</div>
<?php endif ?>
<script language="javascript">

YAHOO.util.Event.onAvailable("moving", function() {
	var aBodyXY = YAHOO.util.Dom.getXY('highlightform');
	var aDivSel = YAHOO.util.Dom.getElementsByClassName('formblock', 'div');
	var height, width;
	var curDiv = null;
	if (aDivSel) {
		height = YAHOO.util.Dom.getStyle(aDivSel[0], 'height').replace("px", "");
		width = YAHOO.util.Dom.getStyle(aDivSel[0], 'width').replace("px", "");

		function findDiv(target) {
			var cDiv = null;			
			while (cDiv == null) { 
				if (target.nodeName.toUpperCase() == 'DIV') {
					cDiv = target;
				} else {
					target = target.parentNode; 
				}
			}
			return cDiv;
		}
		
		function onblurFormElem(event) {
			curDiv = null;
		}
		
		function onfocusFormElem(event) {
			if (!curDiv) {
				var target = YAHOO.util.Event.getTarget(event, true);
				curDiv = findDiv(target);
			}
			
			var selectedDivs = YAHOO.util.Dom.getElementsByClassName('selected', 'div');
			if (selectedDivs.length == 0) {
				YAHOO.util.Dom.setStyle("moving", 'display', 'none');
				if (curDiv) {
					YAHOO.util.Dom.addClass(curDiv, 'selected'); 
				}
			} else {
				if (selectedDivs.length > 0) {
					var prevDiv = selectedDivs[0];
					if (prevDiv != curDiv) {
						height = curDiv.offsetHeight;
						width = YAHOO.util.Dom.getStyle(curDiv, 'width').replace("px", "");
						if (prevDiv) YAHOO.util.Dom.removeClass(prevDiv, 'selected'); 
						var move = new YAHOO.util.Anim("moving", {
							top: {
								from: (prevDiv) ? (YAHOO.util.Dom.getXY(prevDiv)[1] - aBodyXY[1]) : 0, 
								to: (prevDiv) ? (YAHOO.util.Dom.getXY(curDiv)[1] - aBodyXY[1]) : 0
							},
							height: { from: height, to: height },
							width: { from: width, to: width }
						}, 1);
						move.duration = 0.5;
						move.onComplete.subscribe(function() {
							YAHOO.util.Dom.addClass(curDiv, 'selected'); 
							YAHOO.util.Dom.setStyle("moving", 'display', 'none');
						}); 
						YAHOO.util.Dom.setStyle("moving", 'display', 'block');
						move.animate();
					}
				}
			}
		}
			
		var oF = document.forms['highlightform'];
		var oElm = oF.getElementsByTagName('INPUT');
		var els = oElm.length;
		for(i = 0; i < els; i++) {
			if (oElm[i].type != 'hidden' && oElm[i].type != 'submit' && oElm[i].type != 'reset') {
				YAHOO.util.Event.addListener(oElm[i], "focus", onfocusFormElem);
				YAHOO.util.Event.addListener(oElm[i], "blur", onblurFormElem);
			}
		}
		var oEls = oF.getElementsByTagName('SELECT');
		var elss = oEls.length;
		for(i = 0; i < elss; i++) {
			YAHOO.util.Event.addListener(oEls[i], "focus", onfocusFormElem);
			YAHOO.util.Event.addListener(oEls[i], "blur", onblurFormElem);
		}

		YAHOO.util.Dom.setStyle("moving", 'display', 'none');
		YAHOO.util.Dom.addClass(aDivSel[0], 'selected'); 
		//curDiv = aDivSel[0];
	}
});

</script>
<!-- e:<?= __FILE__ ?> -->
