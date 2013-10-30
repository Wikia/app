<?php
	$selectedLang = empty($params['wikiLanguage']) ? $wg->LanguageCode : $params['wikiLanguage'];
?>
<section id="CreateNewWiki">
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<h1><?= wfMessage('cnw-title')->escaped() ?></h1>
	<ol class="steps">
		<li id="NameWiki" class="step">
			<h2><?= wfMessage('cnw-name-wiki-headline')->escaped() ?></h2>
			<p class="creative"><?= wfMessage('cnw-name-wiki-creative')->escaped() ?></p>
			<form name="label-wiki-form">
				<label for="wiki-name"><?= wfMessage('cnw-name-wiki-label')->escaped() ?></label>
				<span class="wiki-name-status-icon status-icon"></span>
				<input type="text" name="wiki-name" value="<?= empty($params['wikiName']) ? '' : $params['wikiName'] ?>"> <?= wfMessage('cnw-name-wiki-wiki')->escaped() ?>
				<div class="wiki-name-error error-msg"></div>
				<label for="wiki-domain" dir="ltr"><?= wfMessage('cnw-name-wiki-domain-label')->escaped() ?></label>
				<div class="wiki-domain-container">
					<span class="domain-status-icon status-icon"></span>
					<span class="domain-country"><?= empty($selectedLang) || $selectedLang === 'en' ? '' : $selectedLang.'.' ?></span>
					<?= wfMessage('cnw-name-wiki-language')->escaped() ?>
					<input type="text" name="wiki-domain" value="<?= empty($params['wikiDomain']) ? '' : $params['wikiDomain'] ?>"> <?= wfMessage('cnw-name-wiki-domain')->escaped() ?>
				</div>
				<div class="wiki-domain-error error-msg"></div>
				<div class="language-default">
					<?= wfMessage('cnw-desc-default-lang', Language::getLanguageName($selectedLang) )->escaped() ?> - <a href="#" id="ChangeLang"><?= wfMessage('cnw-desc-change-lang')->escaped() ?></a>
				</div>
				<div class="language-choice">
					<label for="wiki-language"><?= wfMessage('cnw-desc-lang')->escaped() ?></label>
					<select name="wiki-language">

					<?php
		$isSelected = false;
		if (!empty($aTopLanguages) && is_array($aTopLanguages)) :
	?>
					<optgroup label="<?= wfMessage('autocreatewiki-language-top', count($aTopLanguages))->escaped() ?>">
	<?php foreach ($aTopLanguages as $sLang) :
			$selected = '';
			if ( empty($isSelected) && $sLang == $selectedLang ) {
				$isSelected = true;
				$selected = ' selected="selected"';
			}
	?>
					<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$aLanguages[$sLang]?></option>
	<?php endforeach ?>
					</optgroup>
	<?php endif ?>
					<optgroup label="<?= wfMessage('autocreatewiki-language-all')->escaped() ?>">
	<?php if (!empty($aLanguages) && is_array($aLanguages)) : ?>
	<?php
		ksort($aLanguages);
		foreach ($aLanguages as $sLang => $sLangName) :
			$selected = "";
			if ( empty($isSelected) && ( ( isset($params['wiki-language'] ) && ( $sLang == $params['wiki-language'] ) ) || ( !isset($params['wiki-language']) && ( $sLang == $selectedLang ) ) ) ) :
				$isSelected = true;
				$selected = ' selected="selected"';
			endif;
	?>
					<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$sLangName?></option>
	<?php endforeach ?>
					</optgroup>
	<?php endif ?>

					</select>
				</div>
				<nav class="next-controls">
					<span class="submit-error error-msg"></span>
					<input type="button" value="<?= wfMessage('cnw-next')->escaped() ?>" class="next">
				</nav>
			</form>
		</li>
<?php
	if (!$isUserLoggedIn) {
		if($wg->ComboAjaxLogin) {
?>
		<li id="Auth" class="step">
			<h2 class="headline login"><?= wfMessage('cnw-auth-headline')->escaped() ?></h2>
			<h2 class="headline signup"><?= wfMessage('cnw-auth-headline2')->escaped() ?></h2>
			<p class="creative login"><?= wfMessage('cnw-auth-creative')->escaped() ?></p>
			<p class="creative signup"><?= wfMessage('cnw-auth-signup-creative')->escaped() ?></p>
			<?= AjaxLoginForm::getTemplateForCombinedForms()->render('ComboAjaxLogin') ?>
			<p class="signup-msg">
				<?= wfMessage('cnw-signup-prompt')->escaped() ?> <a href="#"><?= wfMessage('cnw-call-to-signup')->escaped() ?></a>
			</p>
			<p class="login-msg">
				<?= wfMessage('cnw-login-prompt')->escaped() ?> <a href="#"><?= wfMessage('cnw-call-to-login')->escaped() ?></a>
				<br>
				<?php print '<fb:login-button id="fbAjaxSignupConnect" size="large" length="short"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'>'.wfMessage('cnw-auth-facebook-signup')->escaped().'</fb:login-button>'; ?>
			</p>
			<div class="facebook login">
				<span>- <?= wfMessage('cnw-or')->escaped() ?> -</span>
				<?php print '<fb:login-button id="fbAjaxLoginConnect" size="large" length="short"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'>'.wfMessage('cnw-auth-facebook-login')->escaped().'</fb:login-button>'; ?>
			</div>
			<nav class="back-controls">
				<input type="button" value="<?= wfMessage('cnw-back')->escaped() ?>" class="secondary back">
			</nav>
			<nav class="next-controls">
				<input type="button" value="<?= wfMessage('cnw-login')->escaped() ?>" class="login">
				<input type="button" value="<?= wfMessage('cnw-signup')->escaped() ?>" class="signup">
			</nav>
		</li>
<?php
		} // $wgComboAjaxLogin
		else if($wg->EnableUserLoginExt){
?>
	<li id="UserAuth" class="step">
		<h2 class="headline"><?= wfMessage('cnw-userauth-headline')->escaped() ?></h2>
		<p class="creative"><?= wfMessage('cnw-userauth-creative')->escaped() ?></p>
		<div class="signup-loginmodal"><?= F::app()->sendRequest('UserLoginSpecial', 'modal') ?></div>
		<div class="signup-marketing">
			<h3><?= wfMessage('cnw-userauth-marketing-heading')->escaped() ?></h3>
			<p><?= wfMessage('cnw-userauth-marketing-body')->parse() ?></p>
			<form method="post" action="<?= $signupUrl ?>" id="SignupRedirect">
				<input type="hidden" name="returnto" value="">
				<input type="hidden" name="redirected" value="true">
				<input type="hidden" name="uselang" value="<?= $params['wikiLanguage'] ?>">
				<input type="submit" value="<?= wfMessage('cnw-userauth-signup-button')->escaped() ?>">
			</form>
		</div>
	</li>
<?php
		} // else, UserLogin
	} // if isLoggedIn
?>
		<li id="DescWiki" class="step">
			<h2><?= wfMessage('cnw-desc-headline') ?></h2>
			<p class="creative"><?= wfMessage('cnw-desc-creative')->escaped() ?></p>
			<form name="desc-form">
				<textarea id="Description" placeholder="<?= wfMessage('cnw-desc-placeholder')->escaped() ?>"></textarea>
				<ol>
					<li>
						<?= wfMessage('cnw-desc-tip1')->escaped() ?>
						<div class="tip-creative"><?= wfMessage('cnw-desc-tip1-creative')->escaped() ?></div>
					</li>
					<li>
						<?= wfMessage('cnw-desc-tip2')->escaped() ?>
						<div class="tip-creative"><?= wfMessage('cnw-desc-tip2-creative')->escaped() ?></div>
					</li>
					<li>
						<?= wfMessage('cnw-desc-tip3')->escaped() ?>
						<div class="tip-creative"><?= wfMessage('cnw-desc-tip3-creative')->escaped() ?></div>
					</li>
				</ol>
				<label for="wiki-category"><?= wfMessage('cnw-desc-choose')->escaped() ?></label>
				<select name="wiki-category">
					<option value=""><?= wfMessage('cnw-desc-select-one')->escaped() ?></option>
	<?php
		foreach ($aCategories as $iCat => $catData) {
			$sCatName = $catData["name"];
			if( in_array( $sCatName, array( 'Wikia', 'Wikianswers' ) ) )
				continue;
	?>
					<option value="<?php echo $iCat ?>"><?php echo $sCatName?></option>
	<?php
		}
	?>
					<option value="3"><?= wfMessage('autocreatewiki-category-other')->escaped() ?></option>
				</select>

		        <div class="checkbox" id="all-ages-div" <?php echo empty($selectedLang) || $selectedLang === $params['LangAllAgesOpt'] ? '':'style=display:none' ?> >
					<input type="checkbox" name="all-ages" value="1">
					<?= $app->renderView(
						'WikiaStyleGuideTooltipIcon',
						'index',
						array(
							'text' => wfMessage('cnw-desc-all-ages')->escaped(),
							'tooltipIconTitle' => wfMessage('cnw-desc-tip-all-ages')->escaped(),
						)
					);
					?>
				</div>


				<nav class="back-controls">
					<input type="button" value="<?= wfMessage('cnw-back')->escaped() ?>" class="secondary back">
				</nav>
				<nav class="next-controls">
					<span class="submit-error error-msg"></span>
					<input type="button" value="<?= wfMessage('cnw-next')->escaped() ?>" class="next">
				</nav>
			</form>
		</li>
		<li id="ThemeWiki" class="step">
			<h2><?= wfMessage('cnw-theme-headline')->escaped() ?></h2>
			<p class="creative"><?= wfMessage('cnw-theme-creative')->escaped() ?></p>
			<?= F::app()->renderView('ThemeDesigner', 'ThemeTab') ?>
			<p class="instruction creative"><?= wfMessage('cnw-theme-instruction')->escaped() ?></p>
			<nav class="next-controls">
				<span class="submit-error finish-status"></span>
				<input type="button" value="<?= wfMessage('cnw-next')->escaped() ?>" class="next" disabled>
			</nav>
		</li>
	</ol>
	<ul id="StepsIndicator">
		<?php
			$steps = $isUserLoggedIn ? 4 : 5;
			$active = empty($currentStep) ? 1 : 3;
			for($i = 0; $i < $steps; $i++) {
		?>
			<li class="step<?= $active > 0 ? ' active' : '' ?>"></li>
		<?php
				$active--;
			}
		?>
	</ul>
	<img class="awesome-box" src="<?= $wg->ExtensionsPath ?>/wikia/CreateNewWiki/images/box_art.png">
</section>
<script>
	WikiBuilderCfg = {
		'name-wiki-submit-error':'<?= wfMessage('cnw-name-wiki-submit-error')->escaped() ?>',
		'desc-wiki-submit-error':'<?= wfMessage('cnw-desc-wiki-submit-error')->escaped() ?>',
		'currentstep':'<?= $currentStep ?>',
		'skipwikiaplus':'<?= $skipWikiaPlus ?>',
		'descriptionplaceholder':'<?= wfMessage('cnw-desc-placeholder')->escaped() ?>',
		'cnw-error-general':'<?= wfMessage('cnw-error-general')->escaped() ?>',
		'cnw-error-general-heading':'<?= wfMessage('cnw-error-general-heading')->escaped() ?>',
		'cnw-keys': <?= json_encode($keys) ?>
	};
	var themes = <?= json_encode($wg->OasisThemes) ?>;
	var applicationThemeSettings = <?= json_encode($applicationThemeSettings) ?>;
</script>
