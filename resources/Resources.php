<?php

return array(

	/* Special modules who have their own classes */

	'site' => array( 'class' => 'ResourceLoaderSiteModule' ),
	'noscript' => array( 'class' => 'ResourceLoaderNoscriptModule' ),
	'startup' => array( 'class' => 'ResourceLoaderStartUpModule' ),
	'user' => array( 'class' => 'ResourceLoaderUserModule' ),
	'user.groups' => array( 'class' => 'ResourceLoaderUserGroupsModule' ),
	'user.options' => array( 'class' => 'ResourceLoaderUserOptionsModule' ),
	'user.cssprefs' => array( 'class' => 'ResourceLoaderUserCSSPrefsModule' ),
	'user.tokens' => array( 'class' => 'ResourceLoaderUserTokensModule' ),
	'filepage' => array( 'class' => 'ResourceLoaderFilePageModule' ),

	// Scripts for the dynamic language specific data, like grammar forms.
	'mediawiki.language.data' => array( 'class' => 'ResourceLoaderLanguageDataModule' ),

	/* Skins */

	'skins.monobook' => array(
		'styles' => array(
			'common/commonElements.css' => array( 'media' => 'screen' ),
			'common/commonContent.css' => array( 'media' => 'screen' ),
			'common/commonInterface.css' => array( 'media' => 'screen' ),
			'monobook/main.css' => array( 'media' => 'screen' ),
		),
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
	),

	/* jQuery */

	'jquery' => array(
		// Wikia change - begin
		'skinScripts' => [
			'default' => 'resources/jquery/jquery-' . AssetsConfig::JQUERY_VERSION . '.js',
		],
		// Wikia change - end
		'debugRaw' => false,
	),

	/* jQuery Plugins */

	'jquery.appear' => array(
		'scripts' => 'resources/jquery/jquery.appear.js',
	),
	'jquery.arrowSteps' => array(
		'scripts' => 'resources/jquery/jquery.arrowSteps.js',
		'styles' => 'resources/jquery/jquery.arrowSteps.css',
	),
	'jquery.async' => array(
		'scripts' => 'resources/jquery/jquery.async.js',
	),
	'jquery.autoEllipsis' => array(
		'scripts' => 'resources/jquery/jquery.autoEllipsis.js',
		'dependencies' => 'jquery.highlightText',
	),
	'jquery.byteLength' => array(
		'scripts' => 'resources/jquery/jquery.byteLength.js',
	),
	'jquery.byteLimit' => array(
		'scripts' => 'resources/jquery/jquery.byteLimit.js',
		'dependencies' => 'jquery.byteLength',
	),
	'jquery.checkboxShiftClick' => array(
		'scripts' => 'resources/jquery/jquery.checkboxShiftClick.js',
	),
	'jquery.client' => array(
		'scripts' => 'resources/jquery/jquery.client.js',
	),
	'jquery.collapsibleTabs' => array(
		'scripts' => 'resources/jquery/jquery.collapsibleTabs.js',
	),
	'jquery.color' => array(
		'scripts' => 'resources/jquery/jquery.color.js',
		'dependencies' => 'jquery.colorUtil',
	),
	'jquery.colorUtil' => array(
		'scripts' => 'resources/jquery/jquery.colorUtil.js',
	),
	'jquery.cookie' => array(
		'scripts' => 'resources/jquery/jquery.cookie.js',
	),
	'jquery.delayedBind' => array(
		'scripts' => 'resources/jquery/jquery.delayedBind.js',
	),
	'jquery.expandableField' => array(
		'scripts' => 'resources/jquery/jquery.expandableField.js',
		'dependencies' => 'jquery.delayedBind',
	),
	'jquery.farbtastic' => array(
		'scripts' => 'resources/jquery/jquery.farbtastic.js',
		'styles' => 'resources/jquery/jquery.farbtastic.css',
		'dependencies' => 'jquery.colorUtil',
	),
	'jquery.footHovzer' => array(
		'scripts' => 'resources/jquery/jquery.footHovzer.js',
		'styles' => 'resources/jquery/jquery.footHovzer.css',
	),
	'jquery.form' => array(
		'scripts' => 'resources/jquery/jquery.form.js',
	),
	'jquery.getAttrs' => array(
		'scripts' => 'resources/jquery/jquery.getAttrs.js',
	),
	'jquery.highlightText' => array(
		'scripts' => 'resources/jquery/jquery.highlightText.js',
	),
	'jquery.hoverIntent' => array(
		'scripts' => 'resources/jquery/jquery.hoverIntent.js',
	),
	'jquery.json' => array(
		'scripts' => 'resources/jquery/jquery.json.js',
	),
	'jquery.localize' => array(
		'scripts' => 'resources/jquery/jquery.localize.js',
	),
	'jquery.makeCollapsible' => array(
		'scripts' => 'resources/jquery/jquery.makeCollapsible.js',
		'styles' => 'resources/jquery/jquery.makeCollapsible.css',
		'messages' => array( 'collapsible-expand', 'collapsible-collapse' ),
	),
	'jquery.messageBox' => array(
		'scripts' => 'resources/jquery/jquery.messageBox.js',
		'styles' => 'resources/jquery/jquery.messageBox.css',
	),
	'jquery.mockjax' => array(
		'scripts' => 'resources/jquery/jquery.mockjax.js',
	),
	'jquery.mw-jump' => array(
		'scripts' => 'resources/jquery/jquery.mw-jump.js',
	),
	'jquery.mwExtension' => array(
		'scripts' => 'resources/jquery/jquery.mwExtension.js',
	),
	'jquery.placeholder' => array(
		'scripts' => 'resources/jquery/jquery.placeholder.js',
	),
	'jquery.qunit' => array(
		'scripts' => 'resources/jquery/jquery.qunit.js',
		'styles' => 'resources/jquery/jquery.qunit.css',
		'position' => 'top',
	),
	'jquery.qunit.completenessTest' => array(
		'scripts' => 'resources/jquery/jquery.qunit.completenessTest.js',
		'dependencies' => 'jquery.qunit',
	),
	'jquery.spinner' => array(
		'scripts' => 'resources/jquery/jquery.spinner.js',
		'styles' => 'resources/jquery/jquery.spinner.css',
	),
	'jquery.suggestions' => array(
		'scripts' => 'resources/jquery/jquery.suggestions.js',
		'styles' => 'resources/jquery/jquery.suggestions.css',
		'dependencies' => 'jquery.autoEllipsis',
	),
	'jquery.tabIndex' => array(
		'scripts' => 'resources/jquery/jquery.tabIndex.js',
	),
	'jquery.tablesorter' => array(
		'scripts' => 'resources/jquery/jquery.tablesorter.js',
		'styles' => 'resources/jquery/jquery.tablesorter.css',
		'messages' => array( 'sort-descending', 'sort-ascending' ),
		'dependencies' => 'jquery.mwExtension',
	),
	'jquery.textSelection' => array(
		'scripts' => 'resources/jquery/jquery.textSelection.js',
	),
	'jquery.validate' => array(
		'scripts' => 'resources/jquery/jquery.validate.js',
	),
	'jquery.xmldom' => array(
		'scripts' => 'resources/jquery/jquery.xmldom.js',
	),

	/* jQuery Tipsy */

	'jquery.tipsy' => array(
		'scripts' => 'resources/jquery.tipsy/jquery.tipsy.js',
		'styles' => 'resources/jquery.tipsy/jquery.tipsy.css',
	),

	/* jQuery UI */

	// Core
	'jquery.ui.core' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.core.js',
		'skinStyles' => array(
			'default' => array(
				'resources/jquery.ui/themes/default/jquery.ui.core.css',
				'resources/jquery.ui/themes/default/jquery.ui.theme.css',
			),
			// wikia change - begin
			// @author macbre
			'oasis' => array(
				'resources/jquery.ui/themes/default/jquery.ui.core.css',
				// TODO: use /skins/oasis/css/core/jquery.ui.autocomplete.scss SASS file here
			),
			// wikia change - end
		),
		'dependencies' => 'jquery',
		'group' => 'jquery.ui',
	),
	'jquery.ui.widget' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.widget.js',
		'group' => 'jquery.ui',
	),
	'jquery.ui.mouse' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.mouse.js',
		'dependencies' => 'jquery.ui.widget',
		'group' => 'jquery.ui',
	),
	'jquery.ui.position' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.position.js',
		'group' => 'jquery.ui',
	),
	// Interactions
	'jquery.ui.draggable' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.draggable.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.mouse', 'jquery.ui.widget' ),
		'group' => 'jquery.ui',
	),
	'jquery.ui.droppable' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.droppable.js',
		'dependencies' => array(
			'jquery.ui.core', 'jquery.ui.mouse', 'jquery.ui.widget', 'jquery.ui.draggable',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.resizable' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.resizable.js',
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.resizable.css',
		),
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget', 'jquery.ui.mouse' ),
		'group' => 'jquery.ui',
	),
	'jquery.ui.selectable' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.selectable.js',
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.selectable.css',
		),
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget', 'jquery.ui.mouse' ),
		'group' => 'jquery.ui',
	),
	'jquery.ui.sortable' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.sortable.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget', 'jquery.ui.mouse' ),
		'group' => 'jquery.ui',
	),
	// Widgets
	'jquery.ui.accordion' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.accordion.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget' ),
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.accordion.css',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.autocomplete' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.autocomplete.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget', 'jquery.ui.position' ),
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.autocomplete.css',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.button' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.button.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget' ),
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.button.css',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.datepicker' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.datepicker.js',
		'dependencies' => 'jquery.ui.core',
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.datepicker.css',
		),
		'languageScripts' => array(
			'af' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-af.js',
			'ar' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ar.js',
			'az' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-az.js',
			'bg' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-bg.js',
			'bs' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-bs.js',
			'ca' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ca.js',
			'cs' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-cs.js',
			'da' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-da.js',
			'de' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-de.js',
			'el' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-el.js',
			'en-gb' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-en-GB.js',
			'eo' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-eo.js',
			'es' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-es.js',
			'et' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-et.js',
			'eu' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-eu.js',
			'fa' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-fa.js',
			'fi' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-fi.js',
			'fo' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-fo.js',
			'fr-ch' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-fr-CH.js',
			'fr' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-fr.js',
			'gl' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-gl.js',
			'he' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-he.js',
			'hr' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-hr.js',
			'hu' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-hu.js',
			'hy' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-hy.js',
			'id' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-id.js',
			'is' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-is.js',
			'it' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-it.js',
			'ja' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ja.js',
			'kk' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-kk.js',
			'ko' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ko.js',
			'lb' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-lb.js',
			'lt' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-lt.js',
			'lv' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-lv.js',
			'mk' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-mk.js',
			'ml' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ml.js',
			'ms' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ms.js',
			'nl' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-nl.js',
			'no' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-no.js',
			'pl' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-pl.js',
			'pt' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-pt.js',
			'pt-br' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-pt-BR.js',
			'rm' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-rm.js',
			'ro' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ro.js',
			'ru' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ru.js',
			'sk' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-sk.js',
			'sl' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-sl.js',
			'sq' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-sq.js',
			'sr-sr' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-sr-SR.js',
			'sr' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-sr.js',
			'sv' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-sv.js',
			'ta' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-ta.js',
			'th' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-th.js',
			'tr' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-tr.js',
			'uk' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-uk.js',
			'vi' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-vi.js',
			'zh-cn' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-zh-CN.js',
			'zh-hk' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-zh-HK.js',
			'zh-tw' => 'resources/jquery.ui/i18n/jquery.ui.datepicker-zh-TW.js',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.dialog' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.dialog.js',
		'dependencies' => array(
			'jquery.ui.core',
			'jquery.ui.widget',
			'jquery.ui.button',
			'jquery.ui.draggable',
			'jquery.ui.mouse',
			'jquery.ui.position',
			'jquery.ui.resizable',
		),
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.dialog.css',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.progressbar' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.progressbar.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget' ),
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.progressbar.css',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.slider' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.slider.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget', 'jquery.ui.mouse' ),
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.slider.css',
		),
		'group' => 'jquery.ui',
	),
	'jquery.ui.tabs' => array(
		'scripts' => 'resources/jquery.ui/jquery.ui.tabs.js',
		'dependencies' => array( 'jquery.ui.core', 'jquery.ui.widget' ),
		'skinStyles' => array(
			'default' => 'resources/jquery.ui/themes/default/jquery.ui.tabs.css',
		),
		'group' => 'jquery.ui',
	),
	// Effects
	'jquery.effects.core' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.core.js',
		'dependencies' => 'jquery',
		'group' => 'jquery.ui',
	),
	'jquery.effects.blind' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.blind.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.bounce' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.bounce.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.clip' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.clip.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.drop' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.drop.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.explode' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.explode.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.fade' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.fade.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.fold' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.fold.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.highlight' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.highlight.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.pulsate' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.pulsate.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.scale' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.scale.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.shake' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.shake.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.slide' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.slide.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),
	'jquery.effects.transfer' => array(
		'scripts' => 'resources/jquery.effects/jquery.effects.transfer.js',
		'dependencies' => 'jquery.effects.core',
		'group' => 'jquery.ui',
	),

	/* MediaWiki */

	'mediawiki' => array(
		'scripts' => 'resources/mediawiki/mediawiki.js',
		'debugScripts' => 'resources/mediawiki/mediawiki.log.js',
		'debugRaw' => false,
	),
	'mediawiki.api' => array(
		'scripts' => 'resources/mediawiki.api/mediawiki.api.js',
		'dependencies' => 'mediawiki.util',
	),
	'mediawiki.api.category' => array(
		'scripts' => 'resources/mediawiki.api/mediawiki.api.category.js',
		'dependencies' => array(
			'mediawiki.api',
			'mediawiki.Title'
		),
	),
	'mediawiki.api.edit' => array(
		'scripts' => 'resources/mediawiki.api/mediawiki.api.edit.js',
		'dependencies' => array(
			'mediawiki.api',
			'mediawiki.Title'
		),
	),
	'mediawiki.api.parse' => array(
		'scripts' => 'resources/mediawiki.api/mediawiki.api.parse.js',
		'dependencies' => 'mediawiki.api',
	),
	'mediawiki.api.titleblacklist' => array(
		'scripts' => 'resources/mediawiki.api/mediawiki.api.titleblacklist.js',
		'dependencies' => array(
			'mediawiki.api',
			'mediawiki.Title'
		),
	),
	'mediawiki.api.watch' => array(
		'scripts' => 'resources/mediawiki.api/mediawiki.api.watch.js',
		'dependencies' => array('mediawiki.api', 'mediawiki.user'),
	),
	'mediawiki.debug' => array(
		'scripts' => 'resources/mediawiki/mediawiki.debug.js',
		'styles' => 'resources/mediawiki/mediawiki.debug.css',
		'dependencies' => 'jquery.footHovzer',
		'position' => 'bottom',
	),
	'mediawiki.debug.init' => array(
		'scripts' => 'resources/mediawiki/mediawiki.debug.init.js',
		'dependencies' => 'mediawiki.debug',
		// Uses a custom mw.config variable that is set in debughtml,
		// must be loaded on the bottom
		'position' => 'bottom',
	),
	'mediawiki.feedback' => array(
		'scripts' => 'resources/mediawiki/mediawiki.feedback.js',
		'styles' => 'resources/mediawiki/mediawiki.feedback.css',
		'dependencies' => array(
			'mediawiki.api.edit',
			'mediawiki.Title',
			'mediawiki.jqueryMsg',
			'jquery.ui.dialog',
		),
		'messages' => array(
			'feedback-bugornote',
			'feedback-subject',
			'feedback-message',
			'feedback-cancel',
			'feedback-submit',
			'feedback-adding',
			'feedback-error1',
			'feedback-error2',
			'feedback-error3',
			'feedback-thanks',
			'feedback-close',
			'feedback-bugcheck',
			'feedback-bugnew',
		),
	),
	'mediawiki.htmlform' => array(
		'scripts' => 'resources/mediawiki/mediawiki.htmlform.js',
	),
	'mediawiki.Title' => array(
		'scripts' => 'resources/mediawiki/mediawiki.Title.js',
		'dependencies' => 'mediawiki.util',
	),
	'mediawiki.Uri' => array(
		'scripts' => 'resources/mediawiki/mediawiki.Uri.js',
	),
	'mediawiki.user' => array(
		'scripts' => 'resources/mediawiki/mediawiki.user.js',
		'dependencies' => array(
			'jquery.cookie',
		),
	),
	'mediawiki.util' => array(
		'scripts' => 'resources/mediawiki/mediawiki.util.js',
		'dependencies' => array(
			'jquery.client',
			'jquery.cookie',
			'jquery.messageBox',
			'jquery.mwExtension',
		),
		'messages' => array( 'showtoc', 'hidetoc' ),
		'position' => 'top', // For $wgPreloadJavaScriptMwUtil
	),

	/* MediaWiki Action */

	'mediawiki.action.edit' => array(
		'scripts' => 'resources/mediawiki.action/mediawiki.action.edit.js',
		'position' => 'top', // @author: wladek - workaround for JS error: "mw.toolbar is undefined"
		'dependencies' => array(
			'jquery.textSelection',
			'jquery.byteLimit',
		),
	),
	'mediawiki.action.history' => array(
		'scripts' => 'resources/mediawiki.action/mediawiki.action.history.js',
		'dependencies' => 'jquery.ui.button',
		'group' => 'mediawiki.action.history',
	),
	'mediawiki.action.history.diff' => array(
		'styles' => 'resources/mediawiki.action/mediawiki.action.history.diff.css',
		'group' => 'mediawiki.action.history',
	),
	'mediawiki.action.view.dblClickEdit' => array(
		'scripts' => 'resources/mediawiki.action/mediawiki.action.view.dblClickEdit.js',
		'dependencies' => array(
			'mediawiki.util',
			// Wikia change - begin - @author: wladek - wait for mw.util.$content (BugId: 35040)
			'mediawiki.page.startup',
			// Wikia change - end
		),
	),
	'mediawiki.action.view.metadata' => array(
		'scripts' => 'resources/mediawiki.action/mediawiki.action.view.metadata.js',
		'messages' => array(
			'metadata-expand',
			'metadata-collapse',
		),
	),
	'mediawiki.action.view.rightClickEdit' => array(
		'scripts' => 'resources/mediawiki.action/mediawiki.action.view.rightClickEdit.js',
	),
	'mediawiki.action.watch.ajax' => array(
		'scripts' => 'resources/mediawiki.action/mediawiki.action.watch.ajax.js',
		'dependencies' => array(
			'mediawiki.api.watch',
			'mediawiki.util',
		),
		'messages' => array(
			'watch',
			'unwatch',
			'watching',
			'unwatching',
			'tooltip-ca-watch',
			'tooltip-ca-unwatch',
			'watcherrortext',
		),
	),

	/* MediaWiki Language */

	'mediawiki.language' => array(
		'scripts' => array(
			'resources/src/mediawiki.language/mediawiki.language.js',
			'resources/src/mediawiki.language/mediawiki.language.numbers.js'
		),
		'languageScripts' => array(
			'bs' => 'resources/src/mediawiki.language/languages/bs.js',
			'dsb' => 'resources/src/mediawiki.language/languages/dsb.js',
			'fi' => 'resources/src/mediawiki.language/languages/fi.js',
			'ga' => 'resources/src/mediawiki.language/languages/ga.js',
			'he' => 'resources/src/mediawiki.language/languages/he.js',
			'hsb' => 'resources/src/mediawiki.language/languages/hsb.js',
			'hu' => 'resources/src/mediawiki.language/languages/hu.js',
			'hy' => 'resources/src/mediawiki.language/languages/hy.js',
			'la' => 'resources/src/mediawiki.language/languages/la.js',
			'os' => 'resources/src/mediawiki.language/languages/os.js',
			'ru' => 'resources/src/mediawiki.language/languages/ru.js',
			'sl' => 'resources/src/mediawiki.language/languages/sl.js',
			'uk' => 'resources/src/mediawiki.language/languages/uk.js',
		),
		'dependencies' => array(
				'mediawiki.language.data',
				'mediawiki.cldr',
			),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'mediawiki.cldr' => array(
		'scripts' => 'resources/src/mediawiki.language/mediawiki.cldr.js',
		'dependencies' => array(
			'mediawiki.libs.pluralruleparser',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'mediawiki.libs.pluralruleparser' => array(
		'scripts' => 'resources/src/mediawiki.libs/CLDRPluralRuleParser.js',
		'targets' => array( 'desktop', 'mobile' ),
	),

	'mediawiki.language.init' => array(
		'scripts' => 'resources/src/mediawiki.language/mediawiki.language.init.js',
		'targets' => array( 'desktop', 'mobile' ),
	),

	'mediawiki.jqueryMsg' => array(
		'scripts' => 'resources/src/mediawiki/mediawiki.jqueryMsg.js',
		'dependencies' => array(
			'mediawiki.util',
			'mediawiki.language',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'mediawiki.language.months' => array(
		'scripts' => 'resources/src/mediawiki.language/mediawiki.language.months.js',
		'dependencies' => 'mediawiki.language',
		'messages' => array_merge(
			Language::$mMonthMsgs,
			Language::$mMonthGenMsgs,
			Language::$mMonthAbbrevMsgs
		)
	),

	'mediawiki.language.names' => array( 'class' => 'ResourceLoaderLanguageNamesModule' ),

	/* MediaWiki Libs */

	'mediawiki.libs.jpegmeta' => array(
		'scripts' => 'resources/mediawiki.libs/mediawiki.libs.jpegmeta.js',
	),

	/* MediaWiki Page */

	'mediawiki.page.ready' => array(
		'scripts' => 'resources/mediawiki.page/mediawiki.page.ready.js',
		'dependencies' => array(
			'jquery.checkboxShiftClick',
			'jquery.makeCollapsible',
			//'jquery.placeholder', /* Wikia change - Using Wikia's version of placeholder plugin [Liz] bugid-52001 */
			'jquery.mw-jump',
			'mediawiki.util',
		),
	),
	'mediawiki.page.startup' => array(
		'scripts' => 'resources/mediawiki.page/mediawiki.page.startup.js',
		'dependencies' => array(
			'jquery.client',
			'mediawiki.util',
		),
		'position' => 'top',
	),


	/* MediaWiki Special pages */

	'mediawiki.special' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.js',
		'styles' => 'resources/mediawiki.special/mediawiki.special.css',
	),
	'mediawiki.special.block' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.block.js',
		'dependencies' => array(
			'mediawiki.util',
		),
	),
	'mediawiki.special.changeemail' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.changeemail.js',
		'styles' => 'resources/mediawiki.special/mediawiki.special.changeemail.css',
		'dependencies' => array(
			'mediawiki.util',
		),
		'messages' => array(
			'email-address-validity-valid',
			'email-address-validity-invalid',
		),
	),
	'mediawiki.special.changeslist' => array(
		'styles' => 'resources/mediawiki.special/mediawiki.special.changeslist.css',
		'dependencies' => array( 'jquery.makeCollapsible' ),
	),
	'mediawiki.special.movePage' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.movePage.js',
		'dependencies' => 'jquery.byteLimit',
	),
	'mediawiki.special.preferences' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.preferences.js',
	),
	'mediawiki.special.recentchanges' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.recentchanges.js',
		'dependencies' => array( 'mediawiki.special' ),
		'position' => 'top',
	),
	'mediawiki.special.search' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.search.js',
		'styles' => 'resources/mediawiki.special/mediawiki.special.search.css',
	),
	'mediawiki.special.undelete' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.undelete.js',
	),
	'mediawiki.special.upload' => array(
		// @TODO: merge in remainder of mediawiki.legacy.upload
		'scripts' => 'resources/mediawiki.special/mediawiki.special.upload.js',
		'messages' => array(
			'widthheight',
			'size-bytes',
			'size-kilobytes',
			'size-megabytes',
			'size-gigabytes',
			'largefileserver',
		),
		'dependencies' => array( 'mediawiki.libs.jpegmeta', 'mediawiki.util' ),
	),
	'mediawiki.special.javaScriptTest' => array(
		'scripts' => 'resources/mediawiki.special/mediawiki.special.javaScriptTest.js',
		'messages' => array_merge( Skin::getSkinNameMessages(), array(
			'colon-separator',
			'javascripttest-pagetext-skins',
		) ),
		'dependencies' => array( 'jquery.qunit' ),
		'position' => 'top',
	),

	/* MediaWiki Tests */

	'test.sinonjs' => array(
		'scripts' => array(
			'resources/sinonjs/sinon-1.9.0.js',
			// We want tests to work in IE, but can't include this as it
			// will break the placeholders in Sinon because the hack it uses
			// to hijack IE globals relies on running in the global scope
			// and in ResourceLoader this won't be running in the global scope.
			// Including it results (among other things) in sandboxed timers
			// being broken due to Date inheritance being undefined.
			// 'resources/sinonjs/sinon-ie-1.9.0.js',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'mediawiki.tests.qunit.testrunner' => array(
		'scripts' => 'tests/qunit/data/testrunner.js',
		'dependencies' => array(
			'jquery.qunit',
			'jquery.qunit.completenessTest',
			'mediawiki.page.startup',
			'mediawiki.page.ready',
			'test.sinonjs'
		),
		'position' => 'top',
	),

	/* MediaWiki Legacy */

	'mediawiki.legacy.ajax' => array(
		'scripts' => 'common/ajax.js',
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'dependencies' => array(
			'mediawiki.util',
			'mediawiki.legacy.wikibits',
		),
		'position' => 'top', // Temporary hack for legacy support
	),
	'mediawiki.legacy.commonPrint' => array(
		'styles' => array( 'common/commonPrint.css' => array( 'media' => 'print' ) ),
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
	),
	'mediawiki.legacy.config' => array(
		'scripts' => 'common/config.js',
		'styles' => array( 'common/config.css', 'common/config-cc.css' ),
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'dependencies' => 'mediawiki.legacy.wikibits',
	),
	'mediawiki.legacy.IEFixes' => array(
		'scripts' => 'common/IEFixes.js',
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'dependencies' => 'mediawiki.legacy.wikibits',
	),
	'mediawiki.legacy.mwsuggest' => array(
		'scripts' => 'common/mwsuggest.js',
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'dependencies' => 'mediawiki.legacy.wikibits',
		'messages' => array( 'search-mwsuggest-enabled', 'search-mwsuggest-disabled' ),
	),
	'mediawiki.legacy.preview' => array(
		'scripts' => 'common/preview.js',
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'dependencies' => 'mediawiki.legacy.wikibits',
	),
	'mediawiki.legacy.protect' => array(
		'scripts' => 'common/protect.js',
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'dependencies' => array(
			'mediawiki.legacy.wikibits',
			'jquery.byteLimit',
		),
		'position' => 'top',
	),
	'mediawiki.legacy.shared' => array(
		'styles' => array( 'common/shared.css' => array( 'media' => 'screen' ) ),
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
	),
	'mediawiki.legacy.upload' => array(
		'scripts' => 'common/upload.js',
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'dependencies' => array(
			/*
			 * Wikia Change
			 * @author Jakub Olek
			 */
			'jquery.spinner',
			 //End of Wikia Change
			'mediawiki.util',
		),
	),
	'mediawiki.legacy.wikibits' => array(
		// Wikia - change begin - @author: wladek, kamil
//		'scripts' => 'common/wikibits.js',
//		'remoteBasePath' => $GLOBALS['wgStylePath'],
//		'localBasePath' => $GLOBALS['wgStyleDirectory'],
		'scripts' => array(
			'skins/common/wikibits.js',
			'resources/wikia/wikia.wikibits.js',
		),
		'messages' => array(
			'import-article-missing-single',
			'import-article-missing-multiple',
			'import-article-missing-more-single',
			'import-article-missing-more-multiple',
			'import-article-not-js-single',
			'import-article-not-js-multiple',
		),
		// Wikia - change end
		'dependencies' => array(
			'mediawiki.util',
			'wikia.importScript'
		),
		'position' => 'top',
	),
	'mediawiki.legacy.wikiprintable' => array(
		'styles' => array( 'common/wikiprintable.css' => array( 'media' => 'print' ) ),
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
	),
);
