<?php
/**
 * Internationalisation file for extension AdSS.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'adss-desc' => 'Ad Self Service',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Sponsored links on Wikia',
	'adss-ad-header' => '== External sponsor links ==',
	'adss-ad-default-text' => 'Click here!',
	'adss-ad-default-desc' => 'Buy a sponsored link and description for your website on this page. Act quickly, the few sponsorship slots sell out fast!',
	'adss-form-header' => 'Design your ad',
	'adss-form-url' => 'URL of sponsoring website (your website):',
	'adss-form-linktext' => 'Text you want displayed in the link:',
	'adss-form-additionaltext' => 'Text to be displayed under your link:',
	'adss-form-type' => 'Sponsorship type:',
	'adss-form-page' => 'Page to sponsor:',
	'adss-form-price' => 'Sponsorship amount:',
	'adss-form-shares' => 'Number of shares:',
	'adss-form-email' => 'Your e-mail address:',
	'adss-form-usd-per-day' => '$$1 per day',
	'adss-form-usd-per-week' => '$$1 per week',
	'adss-form-usd-per-month' => '$$1 per month',
	'adss-form-field-empty-errormsg' => 'This field must not be empty',
	'adss-form-non-existent-title-errormsg' => 'This page does not exist',
	'adss-form-pick-plan-errormsg' => 'You must select a plan',
	'adss-form-pick-plan' => 'Pick a plan',
	'adss-form-site-plan-header' => 'Buy a link across a wiki',
	'adss-form-site-plan-description' => 'Gain greater exposure by buying a sponsored link across a wiki.

1 share is currently equal to 25% of {{SITENAME}} sponsored links. The size of the share may go up or down depending on how many others buy shares. You can cancel at any time.',
	'adss-form-site-plan-price' => '1 share costs $1',
	'adss-form-page-plan-header' => 'Buy a link on an individual page',
	'adss-form-page-plan-description' => 'Target specific pages to match your Campaign',
	'adss-form-page-plan-price' => '1 link costs $1',
	'adss-form-thanks' => "Thank you for your Sponsorship! Your ad has been purchased and will go live after manual approval (within 48 hours).

	 Go and [[Special:AdSS|buy]] another ad!",
	'adss-button-preview' => 'Preview',
	'adss-button-edit' => 'Edit',
	'adss-button-save-pay' => 'Save & pay',
	'adss-button-pay-paypal' => 'Pay with PayPal',
	'adss-button-select' => 'Select',
	'adss-preview-header' => 'Preview',
	'adss-preview-prompt' => 'Here is what your sponsorship will look like - click "{{int:adss-button-edit}}" to go back and make changes, or "{{int:adss-button-save-pay}}" to save it and go to PayPal.',
	'adss-paypal-error' => "Couldn't create PayPal payment this time. Please try again later.

Return to [[Special:AdSS|{{int:Adss}}]].",
	'adss-error' => "An error ocurred. Please try again later.

Return to [[Special:AdSS|{{int:Adss}}]].",
	'adss-per-site' => 'All pages',
	'adss-per-page' => 'One page only',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'adss-button-preview' => 'Button text that will preview an advert',
	'adss-preview-header' => 'This is a header',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'adss-ad-header' => '<h2>Вонкавыя спасылкі спонсара</h2>',
	'adss-form-url' => 'URL-адрас спонсара (Ваш ўэб-сайт):',
	'adss-form-linktext' => 'Тэкст, які будзе паказвацца ў спасылцы:',
	'adss-form-additionaltext' => 'Тэкст, які будзе паказвацца пад Вашай-спасылкай:',
	'adss-form-page' => 'Старонка, якую Вы жадаеце спансіраваць:',
	'adss-form-price' => 'Сума спонсарскага ўнёску:',
	'adss-form-email' => 'Ваш адрас электроннай пошты:',
	'adss-form-thanks' => 'Дзякуй за Вашую спонсарскую падтрымку!',
	'adss-button-edit' => 'Рэдагаваць',
	'adss-button-save-pay' => 'Захаваць',
	'adss-preview-prompt' => 'Так будзе выглядаць Вашае спонсарства. Націсьніце кнопку «Рэдагаваць», каб вярнуцца і ўнесьці зьмены, ці «Захаваць», каб захаваць і перайсьці да PayPal.',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'adss-ad-header' => '<h2>Liammoù davet ar paeroned diavaez</h2>',
	'adss-form-url' => "URL al lec'hienn paeron (ho lec'hienn web) :",
	'adss-form-linktext' => "Testenn hoc'h eus c'hoant diskouez el liamm :",
	'adss-form-additionaltext' => 'Testenn da ziskouez dindan ho liamm :',
	'adss-form-page' => 'Pajenn da baeroniañ :',
	'adss-form-price' => 'Sammad ar paeroniañ :',
	'adss-form-email' => "Ho chomlec'h postel :",
	'adss-form-thanks' => 'Trugarez evit ho paeroniañ !',
	'adss-button-edit' => 'Kemmañ',
	'adss-button-save-pay' => 'Enrollañ',
	'adss-preview-prompt' => 'Setu da betra e tenno ho paeroniañ. Klikit war "kemmañ" evit distreiñ ha degas kemmoù pe war "saveteiñ" evit enrollañ hag evit mont war PayPal.',
);

/** German (Deutsch)
 * @author The Evil IP address
 * @author Wikifan
 */
$messages['de'] = array(
	'adss-ad-header' => '<h2> Links von Sponsoren </h2>',
	'adss-form-url' => 'URL deiner sponsernden Website:',
	'adss-form-linktext' => 'Text, der als Link angezeigt werden soll:',
	'adss-form-additionaltext' => 'Text, der unter deinem Link angezeigt werden soll:',
	'adss-form-page' => 'Seite, die du sponsern willst:',
	'adss-form-price' => 'Höhe des Sponsorings:',
	'adss-form-email' => 'Deine E-Mail-Adresse:',
	'adss-form-thanks' => 'Vielen Dank für dein Sponsoring!',
	'adss-button-edit' => 'Bearbeiten',
	'adss-button-save-pay' => 'Speichern',
	'adss-preview-prompt' => 'Hier siehst du, wie deine Patenschaft aussehen wird - klicke auf „Bearbeiten“, um Änderungen vorzunehmen, oder auf „Speichern“, um mit PayPal fortzufahren.',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Laximilian scoken
 */
$messages['de-formal'] = array(
	'adss-form-email' => 'Ihre E-Mail-Adresse:',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'adss-ad-header' => '<h2>Vínculos a patrocinador externo</h2>',
	'adss-form-url' => 'URL del sitio wed del patrocinio (tu sitio web):',
	'adss-form-linktext' => 'Texto que deseas mostrar en el enlace:',
	'adss-form-additionaltext' => 'Texto que se muestra bajo tu enlace:',
	'adss-form-page' => 'Página a patrocinador:',
	'adss-form-price' => 'Cantidad de patrocinio:',
	'adss-form-email' => 'Tu dirección de correo electrónico:',
	'adss-form-thanks' => 'Gracias por tu patrocinio!',
	'adss-button-edit' => 'Editar',
	'adss-button-save-pay' => 'Grabar',
	'adss-preview-prompt' => 'Aquí está como tu patrocinio se verá - haz click en "Editar" para regresar y hacer cambios, o "Grabar" para guardarlo e ir a PayPal.',
);

/** French (Français)
 * @author Peter17
 */
$messages['fr'] = array(
	'adss-ad-header' => '<h2>Liens vers les parrains externes</h2>',
	'adss-form-url' => 'URL du site parrain (votre site web) :',
	'adss-form-linktext' => 'Texte que vous voulez afficher dans le lien :',
	'adss-form-additionaltext' => 'Texte à afficher sous votre lien :',
	'adss-form-page' => 'Page à parrainer :',
	'adss-form-price' => 'Montant du parrainage :',
	'adss-form-email' => 'Votre adresse électronique :',
	'adss-form-thanks' => 'Merci pour votre parrainage !',
	'adss-button-edit' => 'Modifier',
	'adss-button-save-pay' => 'Sauvegarder',
	'adss-preview-prompt' => 'Voici à quoi votre parrainage ressemblera. Cliquez sur « modifier » pour revenir et apporter des changements ou sur « sauvegarder » pour enregistrer et vous rendre sur PayPal.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'adss-ad-header' => '<h2>Ligazóns externas patrocinadas</h2>',
	'adss-form-url' => 'URL do sitio web do patrocinador (a súa páxina web):',
	'adss-form-linktext' => 'Texto que queira mostrar na ligazón:',
	'adss-form-additionaltext' => 'Texto a mostrar baixo a súa ligazón:',
	'adss-form-page' => 'Páxina a patrocinar:',
	'adss-form-price' => 'Cantidade do patrocinio:',
	'adss-form-email' => 'O seu enderezo de correo electrónico:',
	'adss-form-thanks' => 'Grazas polo seu patrocinio!',
	'adss-button-edit' => 'Editar',
	'adss-button-save-pay' => 'Gardar',
	'adss-preview-prompt' => 'Así aparecerá o seu patrocinio; prema sobre "Editar" para volver e facer algún cambio ou sobre "Gardar" para deixalo como esta e ir ao PayPal.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'adss-desc' => 'Autoservicio de publicitate',
	'adss' => 'Autoservicio pub',
	'adss-sponsor-links' => 'Ligamines sponsorisate in Wikia',
	'adss-ad-header' => '<h2>Ligamines externe de sponsores</h2>',
	'adss-form-url' => 'URL del sito del sponsor (tu sito web):',
	'adss-form-linktext' => 'Le texto que tu vole monstrar in le ligamine:',
	'adss-form-additionaltext' => 'Le texto a monstrar sub tu ligamine:',
	'adss-form-page' => 'Pagina a sponsorisar:',
	'adss-form-price' => 'Amonta de sponsoring:',
	'adss-form-email' => 'Tu adresse de e-mail:',
	'adss-form-thanks' => 'Gratias pro tu sponsoring!',
	'adss-button-edit' => 'Modificar',
	'adss-button-save-pay' => 'Salveguardar',
	'adss-preview-prompt' => 'Ecce le aspecto de tu sponsoring - clicca "Modificar" pro retornar e facer cambios, o "Salveguardar" pro salveguardar lo e continuar a PayPal.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'adss-button-edit' => 'Rüwa',
	'adss-button-save-pay' => 'Donyéré',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'adss-ad-header' => '<h2>Linke vun externe Sponsoren</h2>',
	'adss-form-page' => 'Säit fir ze sponsoren:',
	'adss-form-email' => 'Är E-Mailadress:',
	'adss-button-edit' => 'Änneren',
	'adss-button-save-pay' => 'Späicheren',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'adss-ad-header' => '<h2>Надворешни врски на спонзори</h2>',
	'adss-form-url' => 'URL-адреса на спонзорското мрежно место (вашето мреж. место):',
	'adss-form-linktext' => 'Текст што ќе се прикаже во врската:',
	'adss-form-additionaltext' => 'Текст што ќе се прикаже под вашата врска:',
	'adss-form-page' => 'Страница за спонзорирање:',
	'adss-form-price' => 'Износ на спонзорството:',
	'adss-form-email' => 'Ваша е-пошта:',
	'adss-form-thanks' => 'Ви благодариме за спонзорството!',
	'adss-button-edit' => 'Уреди',
	'adss-button-save-pay' => 'Зачувај',
	'adss-preview-prompt' => 'Вака ќе изгледа вашет оспонзорство - кликнете на „Уреди“ за да се вратите и направите промени, или на „Зачувај“ за да го зачувате и да прејдете на PayPal.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'adss-desc' => 'Zelfservice voor advertenties',
	'adss' => 'Advertentie zelfservice',
	'adss-sponsor-links' => 'Gesponsorde verwijzingen op Wikia',
	'adss-ad-header' => '<h2>Externe sponsors</h2>',
	'adss-ad-default-text' => 'Klik hier!',
	'adss-ad-default-desc' => 'Koop een gesponsorde verwijzing en beschrijving voor uw website op deze pagina. Handel snel, want het beperkte aantal beschikbare advertenties is snel uitverkocht!',
	'adss-form-url' => 'URL van sponsorwebsite (uw website):',
	'adss-form-linktext' => 'Tekst die u wilt weergeven in de verwijzing:',
	'adss-form-additionaltext' => 'Tekst die wordt getoond onder uw link:',
	'adss-form-page' => 'Te sponsoren pagina:',
	'adss-form-price' => 'Sponsorbedrag:',
	'adss-form-email' => 'Uw e-mailadres:',
	'adss-form-site-plan-price' => 'Een advertentie kost $1',
	'adss-form-page-plan-price' => 'Een verwijzing kost $1',
	'adss-form-thanks' => 'Dank u wel voor uw sponsoring! Uw advertentie is aangekocht en wordt weergegeven na handmatige goedkeuring (binnen 48 uur).

U kunt [[Special:AdSS|nog een advertentie kopen]]!',
	'adss-button-preview' => 'Voorvertoning',
	'adss-button-edit' => 'Bewerken',
	'adss-button-save-pay' => 'Opslaan',
	'adss-button-pay-paypal' => 'Betalen met PayPal',
	'adss-button-select' => 'Selecteren',
	'adss-preview-header' => 'Voorvertoning',
	'adss-preview-prompt' => 'Dit is een voorvertoning van uw sponsoring. Klik op "Bewerken" om terug te gaan en wijzigingen aan te brengen of klik op "Opslaan" om naar PayPal te gaan.',
	'adss-paypal-error' => 'Het was niet mogelijk een PayPalbetaling te maken. Probeer het later opnieuw. 

Terugkeren naar [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Er is een fout opgetreden. Probeer het later opnieuw.

Terug naar [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => "Alle pagina's",
	'adss-per-page' => 'Slechts één pagina',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'adss-ad-header' => '<h2>Eksterne sponsorlenker</h2>',
	'adss-form-url' => 'URL for det sponsende nettstedet (ditt nettsted):',
	'adss-form-linktext' => 'Tkest som skal vises i lenken:',
	'adss-form-additionaltext' => 'Tekst som skal vises under lenken din:',
	'adss-form-page' => 'Side som skal sponses:',
	'adss-form-price' => 'Sponsingsbeløp:',
	'adss-form-email' => 'Din e-postadresse:',
	'adss-form-thanks' => 'Takk for sponsingen din!',
	'adss-button-edit' => 'Rediger',
	'adss-button-save-pay' => 'Lagre',
	'adss-preview-prompt' => 'Dette er hvordan sponsorskapet vil se ut - trykk «Rediger» for å gå tilbake og gjøre endringer, eller «Lagre» for å lagre den og gå til PayPal.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'adss-ad-header' => '<h2>Colegament a Sponsor Extern</h2>',
	'adss-form-url' => "Adrëssa dël dit parin an sl'aragnà (sò sit):",
	'adss-form-linktext' => "Test ch'a veul mostré ant ël colegament:",
	'adss-form-additionaltext' => 'Test da mostré sota soa anliura:',
	'adss-form-page' => 'Pàgina da feje da parin:',
	'adss-form-price' => 'Pressi dël parinagi:',
	'adss-form-email' => 'Soa adrëssa ëd pòsta eletrònica:',
	'adss-form-thanks' => 'Mersì për sò parinagi!',
	'adss-button-edit' => 'Modìfica',
	'adss-button-save-pay' => 'Salva',
	'adss-preview-prompt' => 'Ambelessì a-i é lòn che sò parinagi a smijërà - sgnaché "Modifiché" për andé andré e fé ij cambi, o "Salvé" për salvé e andé a PayPal.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'adss-ad-header' => '<h2>Links de Patrocinadores Externos</h2>',
	'adss-form-url' => 'URL do site patrocinador (o seu site na internet):',
	'adss-form-linktext' => 'Texto que pretende que seja apresentado no link:',
	'adss-form-additionaltext' => 'Texto para ser apresentado abaixo do link:',
	'adss-form-page' => 'Página para patrocinar:',
	'adss-form-price' => 'Montante do patrocínio:',
	'adss-form-email' => 'Endereço de correio electrónico:',
	'adss-form-thanks' => 'Obrigado pelo seu patrocínio!',
	'adss-button-edit' => 'Editar',
	'adss-button-save-pay' => 'Gravar',
	'adss-preview-prompt' => 'O aspecto do seu patrocínio será este - clique "editar" para voltar atrás e fazer alterações, ou "gravar" para gravar e ir para o PayPal.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'adss-ad-header' => '<h2>Links de Patrocinadores Externos</h2>',
	'adss-form-url' => 'URL do site patrocinador (o seu site na internet):',
	'adss-form-linktext' => 'Texto que pretende que seja apresentado no link:',
	'adss-form-additionaltext' => 'Texto para ser apresentado abaixo do link:',
	'adss-form-page' => 'Página a patrocinar:',
	'adss-form-price' => 'Montante do patrocínio:',
	'adss-form-email' => 'Endereço de e-mail:',
	'adss-form-thanks' => 'Obrigado por seu patrocínio!',
	'adss-button-edit' => 'Editar',
	'adss-button-save-pay' => 'Salvar',
	'adss-preview-prompt' => 'O aspecto do seu patrocínio será este - clique "editar" para voltar atrás e fazer alterações, ou "salvar" para salvar e ir para o PayPal.',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Ytsukeng Fyvaprol
 */
$messages['ru'] = array(
	'adss-ad-header' => '<h2>Ссылки спонсора</h2>',
	'adss-form-url' => 'Адрес веб-сайта спонсора (ваш веб-сайт):',
	'adss-form-linktext' => 'Текст, который будет отображаться в ссылке:',
	'adss-form-additionaltext' => 'Текст, который будет отображаться под вашей ссылкой:',
	'adss-form-page' => 'Страница, которую вы желаете спонсировать:',
	'adss-form-price' => 'Сумма спонсорского взноса:',
	'adss-form-email' => 'Ваш адрес электронной почты:',
	'adss-form-thanks' => 'Благодарим Вас за спонсорство!',
	'adss-button-edit' => 'Править',
	'adss-button-save-pay' => 'Сохранить',
	'adss-preview-prompt' => 'Так будет выглядеть ваше спонсорство. Нажмите кнопку "Изменить", чтобы вернуться и внести изменения, или "Сохранить", чтобы сохранить и перейти к PayPal.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'adss-button-save-pay' => 'Shrani',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'adss-form-email' => 'మీ ఈ-మెయిలు చిరునామా:',
	'adss-button-save-pay' => 'భద్రపరచు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'adss-ad-header' => '<h2>Panlabas na mga Kawing ng Tagapagtaguyod</h2>',
	'adss-form-url' => 'URL ng nagtataguyod na websayt (websayt mo): 1',
	'adss-form-linktext' => 'Tekstong nais mong ipakita sa kawing:',
	'adss-form-additionaltext' => 'Tekstong ipapakita sa ilalim ng iyong kawing:',
	'adss-form-page' => 'Itataguyod na pahina:',
	'adss-form-price' => 'Halaga ng pagtataguyod:',
	'adss-form-email' => 'Tirahan mo ng e-liham:',
	'adss-form-thanks' => 'Salamat sa iyong Pagtataguyod!',
	'adss-button-edit' => 'Baguhin',
	'adss-button-save-pay' => 'Sagipin',
	'adss-preview-prompt' => 'Narito ang kung paano ang magiging anyo ng iyong pagtataguyod - pindutin ang "Baguhin" upang bumalik at gumawa ng mga pagbabago, o "Sagipin" upang masagip ito at pumunta sa PayPal.',
);

