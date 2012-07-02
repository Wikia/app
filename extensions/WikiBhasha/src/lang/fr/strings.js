/*
 *
 *   Copyright (c) Microsoft. All rights reserved.
 *   Copyirght (c) 2010, Ashar Voultoiz.
 *
 *	This code is licensed under the Apache License, Version 2.0.
 *   THIS CODE IS PROVIDED *AS IS* WITHOUT WARRANTY OF
 *   ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY
 *   IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR
 *   PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
 *
 *   The apache license details from
 *   ‘http://www.apache.org/licenses/’ are reproduced
 *   in ‘Apache2_license.txt’
 *
 */

/*
 * wikiBhasha.strings.js
 * wikiBhasha class with french localized strings.
 */
(function() {

	wikiBhasha.localStrings = {

		failureMsg:                 "Impossible de démarrer WikiBhasha\n",
		collaborativeTitle:         "Bienvenue à la beta de WikiBhasha, un outil collaboratif pour améliorer le contenu multilingue de Wikipedia.",
		collaborativeSearchTitle:   "Entrez des termes à rechercher sur le Wikipedia anglophone et celui de la langue cible.",
		currentLanguage1:           "Vous êtes actuellement sur l'article ",
		currentLanguage2:           "du Wikipedia anglophone.",
		exit:                       "Quitter WikiBhasha",
		languageArticle:            "Choisissez la langue cible.",
		detectArticle:              "L'article n'existe pas dans la langue ciblé. Indiquez un titre pour le créer.",
		existingtArticle:           "L'article existe déjà dans la langue cible.",
		notApplicableStep:          "Cette étape n'est pas applicable à l'article en cours.",
		important:                  "Important !",
		importantNote:              "Cliquez à nouveau sur le marque-page \"WikiBhasha (Beta)\" lorsque vous serez sur le Wikipedia de la langue cible.",
		contributeBtn:              "Contribuer à son équivalent dans une autre langue",
		articleTitle:               "Titre d'Article",
		searchTabTitle:             "Chercher l'article source",
		contributeTo:               "Améliorer l'article existant dans la langue cible",
		create:                     "Créer l'article dans la langue cible",
		space:                      " ",
		dot:                        ".",
		themeBlue:                  "Thème Bleu",
		themeBlack:                 "Thème Noir",
		themeSilver:                "Thème Argent",
		help:                       "Aide",
		maximize:                   "Agrandir",
		close:                      "Fermer",
		sourceArticle:              "Article Source",
		search:                     "Chercher",
		historyLabel:               "Sujets visités",
		translate:                  "Traduire en",
		scratchPad:                 "Scratch Pad",
		searchHeader:               "Recherche",
		convertEntireArticle:       "Récupérer l'article de la Source",
		emptySearchResult:          "Aucun résultat pour la requête.",
		english:                    "Anglais",
		toText:                     "en",
		bringContentFromPane:       "Apporter le contenu traduit et corrigé",
		articleAlreadyExists:       "Un article avec le titre '{0}' existe déjà dans le Wikipedia cible, souhaitez-vous éditer cette page ?",
		emptySearchResult:          "Aucun résultat pour la recherche.",
		emptySource:                "L'interwiki pour l'anglais n'existe pas. Recherchez un article approprié.",
		emptyInputText:             "Entrez un texte valide et continuez.",
		unSupportedLanguage:        "La langue cible n'est pas supportée par WikiBasha pour le moment.",
		invalidBookmarklet:         "Choisissez un autre marque-page",
		defaultLanguageText:        "Choix de langue",
		warningMsg:                 "Merci d'enregistrer votre travail",
		clearAll:                   "Tout Vider",
		sourceTextHeader:           "Texte Source",
		translatedTextHeader:       "Texte Traduit",
		loadingElementContent:      "Chargement de l'article ...",
		sourceArticleNotApplicable: "Le contenu de la langue source n'est pas applicable ici..",
		scratchPadTextLimitConfirmMsg: "Le texte entré dépasse la limite de {0} caractères.\n\nSi vous poursuivez votre traduction, vous détruirez le texte qui dépasse cette limite",
		scratchPadTextLimitNote:    "Chaque traduction est limitée à {0} caractères maximum.",
		feedbackTextLimitNote:      "[Maximum de {0} caractères]",
		feedbackThankYouMessage:    "Merci pour votre avis!",
		feedbackErrorMessage:       "Impossible d'envoyer votre avis.<br/><br/>Cliquez <a href='javascript:;' id='feedbackEmailLink'>ici</a> pour l'envoyer par courriel.",
		feedbackEmptyTextAlertMessage: "Choisissez une option ou entrez du texte.",
		warningSaveComposeChanges:  "Tout changement réalisé lors de cette étape sera perdu si vous revenez à une étape précédente. Voulez-vous tout de même revenir en arrière ?",
		noTargetLanguageArticleFound: "Article lié introuvable dans le Wikipedia de la langue cible.",
		feedbackQuestionMessage:    "Avant de quitter WikiBhasha, voulez-vous nous donner votre avis ?",

		//tooptip strings
		searchInputTooltip:         "Recherche",
		collapseTooltip:            "Réduire",
		expandPaneTooltip:          "Agrandir",

		//help tutorials array[slideNo,text]
		tutorials:                  [" Bienvenue dans WikiBhasha beta, un outil collaboratif qui aide les communautés de Wikipedia" +
				" à améliorer leur contenu dans leur langues respectives. WikiBhasha était un projet de recherche" +
				" de Microsoft Research. Il est maintenant mis à disposition en tant que projet open source" +
				" de MediaWiki. L'outil est également disponible en tant que gadget utilisateur sur Wikipedia" +
				" et en tant que marque-page sur <a href=\"http://www.wikibhasha.org/\" class=\"external\">www.WikiBhasha.org</a>." +
				" Merci de respecter les règles de Wikipedia pour en distribuer le contenu." +
				"<br/><br/>" +
				"Version en cours de WikiBhasha beta : 1.0.0<br/><br/>" +
			//"<a href=\"mailto:wikibfb@microsoft.com?subject=WikiBhasha beta Feedback\">Feedback to WikiBhasha team</a> welcome.",
				"<b>Plateformes supportées : </b><P><P>\tIE 7/8 sur Windows XP/Vista/Win7 et " +
				"Firefox 3.5 ou suivant sur Linux Fedora 11/12.  " +
				"<b><P><P> Langues supportées : </b><P><P>\t" +
				"Actuellement, WikiBhasha (Beta) supporte toutes les paires de langues gérées par " +
				" <a href=\"http://www.microsofttranslator.com/\" class=\"external\">Microsoft Translator</a>" +
				" où la langue source est l'anlais<P><P>"
		],
		nonWikiDomainMsg:           "Choisissez un article valide de Wikipedia et lancez WikiBhasha.",
		noSourceArticleFound:       "Sur le Wikipedia anglais, WikiBhasha ne peut être utilisé que sur des articles existants.",
		waitUntilTranslationComplete: "Patientez jusqu'à ce que la traduction soit complète.",
		thanksMessage:              "Merci pour votre contribution à Wikipedia. Voulez-vous nous donner votre avis ?",
		nonEditableMessage:         "WikiBhasha ne peut être utiliser que sur des articles éditable; celui-ci est protégé sur Wikipedia."
	};

	//short cut to call local strings
	wbLocal = wikiBhasha.localStrings;

})();
