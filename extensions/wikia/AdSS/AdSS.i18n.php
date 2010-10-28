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
	'adss-form-password' => 'Your password:',
	'adss-form-login-link' => 'Log in', // FIXME: 'adss-form-login-desc'
	'adss-form-login-desc' => 'Have a password? $1 to save your time and buy the ad with just one click!',
	'adss-form-usd-per-day' => '$$1 per day',
	'adss-form-usd-per-week' => '$$1 per week',
	'adss-form-usd-per-month' => '$$1 per month',
	'adss-form-auth-errormsg' => 'Either your e-mail address or password is incorrect.',
	'adss-form-field-empty-errormsg' => 'This field must not be empty',
	'adss-form-non-existent-title-errormsg' => 'This page does not exist',
	'adss-form-pick-plan-errormsg' => 'You must select a plan',
	'adss-form-pick-plan' => 'Choose your plan',
	'adss-form-site-plan-header' => 'Buy a link across the whole wiki',
	'adss-form-site-plan-description' => 'Get your links running across the whole wiki for one low price.
	
1 share is currently equal to $1% of {{SITENAME}} sponsored links and only costs $2. You can cancel at any time.',
	'adss-form-site-plan-price' => '$1 for one share',
	'adss-form-page-plan-header' => 'Buy a link on just this page',
	'adss-form-page-plan-description' => 'This let you target a custom message to the best page for your product at only $1, and you can cancel at any time.',
	'adss-form-page-plan-price' => '$1 for one link',
	'adss-form-or' => '- or -',
	'adss-form-thanks' => "Thank you for your sponsorship! Your ad has been purchased and will go live after manual approval (within 48 hours).

	 Go and [[Special:AdSS|buy]] another ad!",
	'adss-button-preview' => 'Preview',
	'adss-button-edit' => 'Edit',
	'adss-button-login' => 'Log in',
	'adss-button-login-buy' => 'Log in and buy NOW',
	'adss-button-save-pay' => 'Save & pay',
	'adss-button-pay-paypal' => 'Pay with PayPal',
	'adss-button-select' => 'Select',
	'adss-preview-header' => 'Preview',
	'adss-preview-prompt' => 'Here is what your sponsorship will look like - click "{{int:adss-button-edit}}" to go back and make changes, or "{{int:adss-button-save-pay}}" to save it and go to PayPal.',
	'adss-click-here' => 'Click here', // FIXME: Merge in 'adss-paypal-redirect'. Bad i18n.
	'adss-paypal-redirect' => '$1 if you are not redirected to PayPal within 5 seconds.',
	'adss-paypal-error' => "Couldn't create PayPal payment this time. Please try again later.

Return to [[Special:AdSS|{{int:Adss}}]].",
	'adss-error' => "An error ocurred. Please try again later.

Return to [[Special:AdSS|{{int:Adss}}]].",
	'adss-per-site' => 'All pages',
	'adss-per-page' => 'One page only',
	'adss-close' => 'Close',
	'adss-manager-tab-adList' => 'Your ads',
	'adss-manager-tab-billing' => 'Billing',
	'adss-admin-tab-adList' => 'List of ads',
	'adss-admin-tab-billing' => 'Billing',
	'adss-admin-tab-reports' => 'Reports',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'adss-form-shares' => 'This is a field label for a dropdown selector that indicates the number of shares to buy.',
	'adss-form-login-link' => '{{doc-important|Substituted in {{msg-mw|adss-form-login-desc}} as $1.}}',
	'adss-form-login-desc' => '{{doc-important|$1 is substituted from {{msg-mw|adss-form-login-link}}.}}',
	'adss-form-site-plan-description' => 'Parameters:
* $1 is a number, possibly having decimals.',
	'adss-form-site-plan-price' => 'A share is a stake in the total volume of sponsored links for a site. The size of a share may go up or down depending on how many others buy shares. Parameters:
* $1 is a price in a currency.',
	'adss-button-preview' => 'Button text that will preview an advert',
	'adss-preview-header' => 'This is a header',
	'adss-click-here' => '{{doc-important|Substituted in {{msg-mw|adss-paypal-redirect}} as $1.}}',
	'adss-paypal-redirect' => '{{doc-important|$1 is substituted from {{msg-mw|adss-click-here}}.}}',
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
	'adss' => 'AdSS',
	'adss-ad-header' => '<h2>Liammoù davet ar paeroned diavaez</h2>',
	'adss-ad-default-text' => 'Klikit amañ !',
	'adss-form-url' => "URL al lec'hienn paeron (ho lec'hienn web) :",
	'adss-form-linktext' => "Testenn hoc'h eus c'hoant diskouez el liamm :",
	'adss-form-additionaltext' => 'Testenn da ziskouez dindan ho liamm :',
	'adss-form-page' => 'Pajenn da baeroniañ :',
	'adss-form-price' => 'Sammad ar paeroniañ :',
	'adss-form-email' => "Ho chomlec'h postel :",
	'adss-form-password' => 'Ho ker-tremen :',
	'adss-form-login-link' => 'Kevreañ',
	'adss-form-usd-per-day' => '$1 USD dre zevezh',
	'adss-form-usd-per-week' => '$1 USD dre sizhun',
	'adss-form-usd-per-month' => '$1 USD dre miz',
	'adss-form-or' => '- pe -',
	'adss-form-thanks' => 'Trugarez evit ho paeroniañ !',
	'adss-button-preview' => 'Rakwelet',
	'adss-button-edit' => 'Kemmañ',
	'adss-button-login' => 'Kevreañ',
	'adss-button-login-buy' => 'Kevreañ ha prenañ BREMAÑ',
	'adss-button-save-pay' => 'Enrollañ',
	'adss-button-pay-paypal' => 'Paeañ dre PayPal',
	'adss-button-select' => 'Diuzañ',
	'adss-preview-header' => 'Rakwelet',
	'adss-preview-prompt' => 'Setu da betra e tenno ho paeroniañ. Klikit war "kemmañ" evit distreiñ ha degas kemmoù pe war "saveteiñ" evit enrollañ hag evit mont war PayPal.',
	'adss-click-here' => 'Klikit amañ',
	'adss-per-site' => 'An holl bajennoù',
	'adss-per-page' => 'Ur bajenn hepken',
	'adss-close' => 'Serriñ',
	'adss-manager-tab-billing' => 'O fakturenniñ',
	'adss-admin-tab-billing' => 'O fakturenniñ',
	'adss-admin-tab-reports' => 'Danevelloù',
);

/** German (Deutsch)
 * @author Diebuche
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
	'adss-form-field-empty-errormsg' => 'Dieses Feld darf nicht leer sein',
	'adss-form-non-existent-title-errormsg' => 'Die Seite existiert nicht!',
	'adss-form-thanks' => 'Vielen Dank für dein Sponsoring!',
	'adss-button-preview' => 'Vorschau',
	'adss-button-edit' => 'Bearbeiten',
	'adss-button-save-pay' => 'Speichern',
	'adss-button-pay-paypal' => 'Mit PayPal bezahlen',
	'adss-button-select' => 'Auswählen',
	'adss-preview-header' => 'Vorschau',
	'adss-preview-prompt' => 'Hier siehst du, wie deine Patenschaft aussehen wird - klicke auf „Bearbeiten“, um Änderungen vorzunehmen, oder auf „Speichern“, um mit PayPal fortzufahren.',
	'adss-per-site' => 'Alle Seiten',
	'adss-per-page' => 'Nur eine Seite',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Laximilian scoken
 */
$messages['de-formal'] = array(
	'adss-form-email' => 'Ihre E-Mail-Adresse:',
);

/** Spanish (Español)
 * @author Absay
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
	'adss-form-thanks' => '¡Gracias por su patrocinio! Su anuncio ha sido comprado y dentro de 48 horas entrará en funcionamiento después de activación manual.

¡[[Special:AddSS|Comprar]] otro anuncio!',
	'adss-button-preview' => 'Vista previa',
	'adss-button-edit' => 'Editar',
	'adss-button-save-pay' => 'Grabar',
	'adss-button-pay-paypal' => 'Pagar con PayPal',
	'adss-button-select' => 'Seleccionar',
	'adss-preview-header' => 'Vista previa',
	'adss-preview-prompt' => 'Aquí está como tu patrocinio se verá - haz click en "Editar" para regresar y hacer cambios, o "Grabar" para guardarlo e ir a PayPal.',
	'adss-paypal-error' => 'No ha sido posible realizar el pago a través de PayPal en este momento. Por favor, inténtelo de nuevo más tarde.

Volver a [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Se produjo un error. Por favor, inténtelo de nuevo más tarde. 

Volver [[Special:ADS|{{int:ADS}}]].',
	'adss-per-site' => 'Todas las páginas',
	'adss-per-page' => 'Una sola página',
);

/** French (Français)
 * @author Peter17
 * @author Verdy p
 */
$messages['fr'] = array(
	'adss-desc' => 'Self service de pub',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Liens sponsorisés sur Wikia',
	'adss-ad-header' => '<h2>Liens vers les parrains externes</h2>',
	'adss-ad-default-text' => 'Cliquez ici !',
	'adss-ad-default-desc' => 'Achetez un lien sponsorisé et une description pour vos sites web sur cette page. Agissez vite, les quelques offres de parrainage se vendent vite !',
	'adss-form-header' => 'Créez votre annonce',
	'adss-form-url' => 'URL du site parrain (votre site web) :',
	'adss-form-linktext' => 'Texte que vous voulez afficher dans le lien :',
	'adss-form-additionaltext' => 'Texte à afficher sous votre lien :',
	'adss-form-type' => 'Type de parrainage :',
	'adss-form-page' => 'Page à parrainer :',
	'adss-form-price' => 'Montant du parrainage :',
	'adss-form-shares' => 'Nombre d’actions :',
	'adss-form-email' => 'Votre adresse électronique :',
	'adss-form-usd-per-day' => '$1 USD par jour',
	'adss-form-usd-per-week' => '$1 USD par semaine',
	'adss-form-usd-per-month' => '$1 USD par mois',
	'adss-form-field-empty-errormsg' => 'Ce champ ne doit pas être vide !',
	'adss-form-non-existent-title-errormsg' => "Cette page n'existe pas",
	'adss-form-pick-plan-errormsg' => 'Vous devez sélectionner un plan',
	'adss-form-pick-plan' => 'Choisissez un plan de campagne',
	'adss-form-site-plan-header' => 'Acheter un lien exposé sur un wiki',
	'adss-form-site-plan-description' => 'Obtenez une plus grande visibilité en achetant un lien sponsorisé sur un wiki.

Une part vaut actuellement $1 % des liens sponsorisés de {{SITENAME}}. La taille de la part peut augmenter ou diminuer en fonction du nombre d’acheteurs de parts. Vous pouvez l’annuler à tout moment.',
	'adss-form-site-plan-price' => 'Une part coûte $1',
	'adss-form-page-plan-header' => 'Acheter un lien sur une page individuelle',
	'adss-form-page-plan-description' => 'Ciblez des pages spécifiques correspondant à votre campagne',
	'adss-form-page-plan-price' => '1 lien coûte $1',
	'adss-form-thanks' => 'Merci pour votre parrainage ! Votre annonce a été achetée et sera effective après une activation manuelle (dans les 48 heures).

Allez [[Special:AdSS|acheter]] un autre annonce !',
	'adss-button-preview' => 'Prévisualisation',
	'adss-button-edit' => 'Modifier',
	'adss-button-save-pay' => 'Sauvegarder',
	'adss-button-pay-paypal' => 'Payer avec PayPal',
	'adss-button-select' => 'Sélectionner',
	'adss-preview-header' => 'Prévisualisation',
	'adss-preview-prompt' => 'Voici à quoi votre parrainage ressemblera. Cliquez sur « modifier » pour revenir et apporter des changements ou sur « sauvegarder » pour enregistrer et vous rendre sur PayPal.',
	'adss-paypal-error' => 'Impossible de payer avec PayPal en ce moment. Veuillez essayer plus tard.

Retourner à [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Une erreur est survenue. Veuillez réessayer plus tard.

Retourner à [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Toutes les pages',
	'adss-per-page' => 'Une seule page',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'adss-desc' => 'Autoservizo de anuncios',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Ligazóns patrocinadas en Wikia',
	'adss-ad-header' => '<h2>Ligazóns externas patrocinadas</h2>',
	'adss-ad-default-text' => 'Prema aquí!',
	'adss-form-header' => 'Deseñe o seu anuncio',
	'adss-form-url' => 'URL do sitio web do patrocinador (a súa páxina web):',
	'adss-form-linktext' => 'Texto que queira mostrar na ligazón:',
	'adss-form-additionaltext' => 'Texto a mostrar baixo a súa ligazón:',
	'adss-form-type' => 'Tipo de patrocinio:',
	'adss-form-page' => 'Páxina a patrocinar:',
	'adss-form-price' => 'Cantidade do patrocinio:',
	'adss-form-shares' => 'Número de accións:',
	'adss-form-email' => 'O seu enderezo de correo electrónico:',
	'adss-form-password' => 'O seu contrasinal:',
	'adss-form-login-link' => 'Rexístrese',
	'adss-form-login-desc' => 'Ten un contrasinal? $1 para aforrar tempo e mercar o anuncio cun só clic!',
	'adss-form-usd-per-day' => '$1 dólar estadounidense ao día',
	'adss-form-usd-per-week' => '$1 dólar estadounidense á semana',
	'adss-form-usd-per-month' => '$1 dólar estadounidense ao mes',
	'adss-form-field-empty-errormsg' => 'Este campo non pode estar baleiro',
	'adss-form-non-existent-title-errormsg' => 'Esta páxina non existe',
	'adss-form-pick-plan-errormsg' => 'Ten que seleccionar un plan',
	'adss-form-pick-plan' => 'Elixir un plan',
	'adss-form-site-plan-header' => 'Comprar unha ligazón nun wiki',
	'adss-form-site-plan-price' => '1 acción custa $1',
	'adss-form-page-plan-header' => 'Comprar unha ligazón nunha páxina individual',
	'adss-form-page-plan-price' => '1 ligazón custa $1',
	'adss-form-or' => '- ou -',
	'adss-form-thanks' => 'Grazas polo seu patrocinio!',
	'adss-button-preview' => 'Vista previa',
	'adss-button-edit' => 'Editar',
	'adss-button-login' => 'Rexistro',
	'adss-button-login-buy' => 'Rexístrese e merque AGORA',
	'adss-button-save-pay' => 'Gardar',
	'adss-button-pay-paypal' => 'Pagar mediante o PayPal',
	'adss-button-select' => 'Seleccionar',
	'adss-preview-header' => 'Vista previa',
	'adss-preview-prompt' => 'Así aparecerá o seu patrocinio; prema sobre "Editar" para volver e facer algún cambio ou sobre "Gardar" para deixalo como esta e ir ao PayPal.',
	'adss-click-here' => 'Prema aquí',
	'adss-per-site' => 'Todas as páxinas',
	'adss-per-page' => 'Unha soa páxina',
	'adss-close' => 'Pechar',
	'adss-manager-tab-adList' => 'Os seus anuncios',
	'adss-manager-tab-billing' => 'Facturación',
	'adss-admin-tab-adList' => 'Lista de anuncios',
	'adss-admin-tab-billing' => 'Facturación',
	'adss-admin-tab-reports' => 'Informes',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'adss-desc' => 'Autoservicio de publicitate',
	'adss' => 'Autoservicio pub',
	'adss-sponsor-links' => 'Ligamines sponsorisate in Wikia',
	'adss-ad-header' => '<h2>Ligamines externe de sponsores</h2>',
	'adss-ad-default-text' => 'Clicca hic!',
	'adss-ad-default-desc' => 'Compra un ligamine sponsorisate e description pro tu sito web in iste pagina. Face lo tosto, le numero limitate de sponsorisationes se vende rapidemente!',
	'adss-form-header' => 'Designar tu annuncio',
	'adss-form-url' => 'URL del sito del sponsor (tu sito web):',
	'adss-form-linktext' => 'Le texto que tu vole monstrar in le ligamine:',
	'adss-form-additionaltext' => 'Le texto a monstrar sub tu ligamine:',
	'adss-form-type' => 'Typo de sponsorisation:',
	'adss-form-page' => 'Pagina a sponsorisar:',
	'adss-form-price' => 'Amonta de sponsoring:',
	'adss-form-shares' => 'Numero de actiones:',
	'adss-form-email' => 'Tu adresse de e-mail:',
	'adss-form-password' => 'Tu contrasigno:',
	'adss-form-login-link' => 'Aperi session',
	'adss-form-login-desc' => 'Ha un contrasigno? $1 pro economisar tempore e acquirer le annuncio con un sol clic!',
	'adss-form-usd-per-day' => '$1$ per die',
	'adss-form-usd-per-week' => '$1$ per septimana',
	'adss-form-usd-per-month' => '$1$ per mense',
	'adss-form-auth-errormsg' => 'Le adresse de e-mail o le contrasigno es incorrecte.',
	'adss-form-field-empty-errormsg' => 'Iste campo non debe esser vacue',
	'adss-form-non-existent-title-errormsg' => 'Iste pagina non existe',
	'adss-form-pick-plan-errormsg' => 'Tu debe seliger un plano',
	'adss-form-pick-plan' => 'Selige un plano',
	'adss-form-site-plan-header' => 'Compra un ligamine trans un wiki',
	'adss-form-site-plan-description' => 'Gania major visibilitate: acquire un ligamine sponsorisate in tote un wiki!

1 parte equala actualmente $1% del ligamines sponsorisate de {{SITENAME}}. Le grandor del parte pote augmentar o diminuer dependente del numero de personas qui compra partes. Tu pote cancellar a omne momento.',
	'adss-form-site-plan-price' => '1 parte costa $1',
	'adss-form-page-plan-header' => 'Acquire un ligamine sur un pagina individual',
	'adss-form-page-plan-description' => 'Selectionar paginas specificamente pro vostre campania',
	'adss-form-page-plan-price' => '1 ligamine costa $1',
	'adss-form-or' => '- o -',
	'adss-form-thanks' => 'Gratias pro le sponsorisation! Le acquisition del annuncio ha succedite e illo entrara in circulation post approbation manual (intra 48 horas).

	 Ora tu pote [[Special:AdSS|comprar]] un altere annuncio!',
	'adss-button-preview' => 'Previsualisar',
	'adss-button-edit' => 'Modificar',
	'adss-button-login' => 'Aperi session e compra ORA',
	'adss-button-login-buy' => 'Aperi session e compra ORA',
	'adss-button-save-pay' => 'Salveguardar',
	'adss-button-pay-paypal' => 'Pagar con PayPal',
	'adss-button-select' => 'Seliger',
	'adss-preview-header' => 'Previsualisation',
	'adss-preview-prompt' => 'Ecce le aspecto de tu sponsoring - clicca "Modificar" pro retornar e facer cambios, o "Salveguardar" pro salveguardar lo e continuar a PayPal.',
	'adss-click-here' => 'Clicca hic',
	'adss-paypal-redirect' => '$1 si tu non es redirigite a PayPal intra 5 secundas.',
	'adss-paypal-error' => 'Impossibile pagar con PayPal in iste momento. Per favor reproba plus tarde.

Retornar a [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Un error occurreva. Per favor reproba plus tarde.

Retornar a [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Tote le paginas',
	'adss-per-page' => 'Un sol pagina',
	'adss-close' => 'Clauder',
	'adss-manager-tab-adList' => 'Tu annuncios',
	'adss-manager-tab-billing' => 'Facturation',
	'adss-admin-tab-adList' => 'Lista de annuncios',
	'adss-admin-tab-billing' => 'Facturation',
	'adss-admin-tab-reports' => 'Reportos',
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
	'adss-desc' => 'Самопослужување за реклами',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Спонзорирани врски на Викија',
	'adss-ad-header' => '<h2>Надворешни врски на спонзори</h2>',
	'adss-ad-default-text' => 'Кликнете тука!',
	'adss-ad-default-desc' => 'Овде купете спонзорирана врска и опис за вашето мрежно место. Побрзајте, бидејќи овие неколку рекламни места се продаваат навистина брзо!',
	'adss-form-header' => 'Обликувајте ја вашата реклама',
	'adss-form-url' => 'URL-адреса на спонзорското мрежно место (вашето мреж. место):',
	'adss-form-linktext' => 'Текст што ќе се прикаже во врската:',
	'adss-form-additionaltext' => 'Текст што ќе се прикаже под вашата врска:',
	'adss-form-type' => 'Тип на спонзорство:',
	'adss-form-page' => 'Страница за спонзорирање:',
	'adss-form-price' => 'Износ на спонзорството:',
	'adss-form-shares' => 'Бр. на акции:',
	'adss-form-email' => 'Ваша е-пошта:',
	'adss-form-password' => 'Ваша лозинка:',
	'adss-form-login-link' => 'Најавете се',
	'adss-form-login-desc' => 'Имате лозинка? $1 да заштедите време - купете ја рекламата со само еден клик!',
	'adss-form-usd-per-day' => '$1 USD дневно',
	'adss-form-usd-per-week' => '$1 USD неделно',
	'adss-form-usd-per-month' => '$1 USD месечно',
	'adss-form-auth-errormsg' => 'Погрешна е-пошта или лозинка.',
	'adss-form-field-empty-errormsg' => 'Полето не смее да стои празно',
	'adss-form-non-existent-title-errormsg' => 'Оваа страница не постои',
	'adss-form-pick-plan-errormsg' => 'Мора да изберете план',
	'adss-form-pick-plan' => 'Одберете план',
	'adss-form-site-plan-header' => 'Купете врска за сите страници на викито',
	'adss-form-site-plan-description' => 'Стекнете поголема истакнатост со спонзорирана врска на сите страници на викито.

1 акција моментално вреди $1% спонзорирани врски на {{SITENAME}}. Вредноста на акцијата може да се менува, зависно од тоа колку корисници ќе купат акции. Ова можете да го откажете во секое време.',
	'adss-form-site-plan-price' => '1 акција чини $1',
	'adss-form-page-plan-header' => 'Купете врска на поединечна страница',
	'adss-form-page-plan-description' => 'Одберете поединечна страница што одговара на вашата кампања',
	'adss-form-page-plan-price' => '1 врска чини $1',
	'adss-form-or' => '- или -',
	'adss-form-thanks' => 'Ви благодариме за спонзорството! Рекламата е успешно купена, и истата ќе оди во живо откако ќе биде рачно одобрена (макс. во рок од 48 часа).

[[Special:AdSS|Купете]] уште една реклама!',
	'adss-button-preview' => 'Преглед',
	'adss-button-edit' => 'Уреди',
	'adss-button-login' => 'Најавете се и купете ВЕДНАШ',
	'adss-button-save-pay' => 'Зачувај',
	'adss-button-pay-paypal' => 'Платете со PayPal',
	'adss-button-select' => 'Одбери',
	'adss-preview-header' => 'Преглед',
	'adss-preview-prompt' => 'Вака ќе изгледа вашет оспонзорство - кликнете на „Уреди“ за да се вратите и направите промени, или на „Зачувај“ за да го зачувате и да прејдете на PayPal.',
	'adss-click-here' => 'Кликнете тука',
	'adss-paypal-redirect' => '$1 ако системот не ве одведе на PayPal во рок од 5 секунди.',
	'adss-paypal-error' => 'Не можев да го создадам плаќањето со PayPal. Обидете се подоцна.

Назад кон [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Се појави грешка. Обидете се подоцна.

Назад кон [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Сите страници',
	'adss-per-page' => 'Само една страница',
);

/** Dutch (Nederlands)
 * @author McDutchie
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
	'adss-form-header' => 'Uw advertentie ontwerpen',
	'adss-form-url' => 'URL van sponsorwebsite (uw website):',
	'adss-form-linktext' => 'Tekst die u wilt weergeven in de verwijzing:',
	'adss-form-additionaltext' => 'Tekst die wordt getoond onder uw link:',
	'adss-form-type' => 'Sonsoringstype:',
	'adss-form-page' => 'Te sponsoren pagina:',
	'adss-form-price' => 'Sponsorbedrag:',
	'adss-form-shares' => 'Aantal aandelen:',
	'adss-form-email' => 'Uw e-mailadres:',
	'adss-form-password' => 'Uw wachtwoord:',
	'adss-form-login-link' => 'Meld u aan',
	'adss-form-login-desc' => 'Hebt u een wachtwoord? $1 om tijd uit te sparen en de advertentie met één klik te kopen!',
	'adss-form-usd-per-day' => '$1 USD per dag',
	'adss-form-usd-per-week' => '$1 USD per week',
	'adss-form-usd-per-month' => '$1 USD per maand',
	'adss-form-auth-errormsg' => 'Uw e-mailadres of wachtwoord klopt niet.',
	'adss-form-field-empty-errormsg' => 'Dit veld mag niet leeggelaten worden',
	'adss-form-non-existent-title-errormsg' => 'Deze pagina bestaat niet',
	'adss-form-pick-plan-errormsg' => 'U moet een propositie kiezen',
	'adss-form-pick-plan' => 'Kies uw pakket',
	'adss-form-site-plan-header' => 'Koop een verwijzing in de hele wiki',
	'adss-form-site-plan-description' => 'Laat uw verwijzing weergeven in de hele wiki voor een lage prijs.

Eén aandeel staat momenteel gelijk aan $1% van de gesponsorde verwijzingen in {{SITENAME}} en kost maar $2.
U kunt op ieder moment annuleren.',
	'adss-form-site-plan-price' => '$1 voor één aandeel',
	'adss-form-page-plan-header' => 'Koop een verwijzing op alleen deze pagina',
	'adss-form-page-plan-description' => 'Laat u een aangepast bericht kiezen voor de beste pagina voor uw product voor slechts $1 en u kunt op ieder gewenst moment annuleren.',
	'adss-form-page-plan-price' => 'Een verwijzing kost $1',
	'adss-form-or' => '- or -',
	'adss-form-thanks' => 'Dank u wel voor uw sponsoring! Uw advertentie is aangekocht en wordt weergegeven na handmatige goedkeuring (binnen 48 uur).

U kunt [[Special:AdSS|nog een advertentie kopen]]!',
	'adss-button-preview' => 'Voorvertoning',
	'adss-button-edit' => 'Bewerken',
	'adss-button-login' => 'Aanmelden',
	'adss-button-login-buy' => 'Aanmelden en NU kopen',
	'adss-button-save-pay' => 'Opslaan',
	'adss-button-pay-paypal' => 'Betalen met PayPal',
	'adss-button-select' => 'Selecteren',
	'adss-preview-header' => 'Voorvertoning',
	'adss-preview-prompt' => 'Dit is een voorvertoning van uw sponsoring. Klik op "Bewerken" om terug te gaan en wijzigingen aan te brengen of klik op "Opslaan" om naar PayPal te gaan.',
	'adss-click-here' => 'Klik hier',
	'adss-paypal-redirect' => '$1 als u binnen vijf seconden niet wordt doorverwezen naar PayPal.',
	'adss-paypal-error' => 'Het was niet mogelijk een PayPalbetaling te maken. Probeer het later opnieuw. 

Terugkeren naar [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Er is een fout opgetreden. Probeer het later opnieuw.

Terug naar [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => "Alle pagina's",
	'adss-per-page' => 'Slechts één pagina',
	'adss-close' => 'Sluiten',
	'adss-manager-tab-adList' => 'Uw advertenties',
	'adss-manager-tab-billing' => 'Facturatie',
	'adss-admin-tab-adList' => 'Lijst van advertenties',
	'adss-admin-tab-billing' => 'Facturatie',
	'adss-admin-tab-reports' => 'Rapportages',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'adss-desc' => 'Ad Self Service',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Sponsede lenker på Wikia',
	'adss-ad-header' => '<h2>Eksterne sponsorlenker</h2>',
	'adss-ad-default-text' => 'Klikk her.',
	'adss-ad-default-desc' => 'Kjøp en sponset lenke og beskrivelse for ditt nettsted på denne siden. Vær rask, de få sponsorplassene blir fort utsolgt!',
	'adss-form-header' => 'Design annonsen din',
	'adss-form-url' => 'URL for det sponsende nettstedet (ditt nettsted):',
	'adss-form-linktext' => 'Tkest som skal vises i lenken:',
	'adss-form-additionaltext' => 'Tekst som skal vises under lenken din:',
	'adss-form-type' => 'Sponsingstype:',
	'adss-form-page' => 'Side som skal sponses:',
	'adss-form-price' => 'Sponsingsbeløp:',
	'adss-form-shares' => 'Antall aksjer:',
	'adss-form-email' => 'Din e-postadresse:',
	'adss-form-password' => 'Ditt passord:',
	'adss-form-login-link' => 'Logg inn',
	'adss-form-login-desc' => 'Har du et passord? $1 for å spare tid og kjøp annonsen med bare ett klikk!',
	'adss-form-usd-per-day' => '$$1 per dag',
	'adss-form-usd-per-week' => '$$1 per uke',
	'adss-form-usd-per-month' => '$$1 per måned',
	'adss-form-auth-errormsg' => 'Enten e-postadressen din eller passordet ditt er feil.',
	'adss-form-field-empty-errormsg' => 'Dette feltet kan ikke være tomt',
	'adss-form-non-existent-title-errormsg' => 'Denne siden finnes ikke',
	'adss-form-pick-plan-errormsg' => 'Du må velge en plan',
	'adss-form-pick-plan' => 'Velg en plan',
	'adss-form-site-plan-header' => 'Kjøp en lenke over hele wikien',
	'adss-form-site-plan-description' => 'Få større eksponering ved å kjøpe en sponset lenke over en hel wiki.

1 aksje er for øyeblikket tilsvarende $1 % av {{SITENAME}}-sponsede lenker. Størrelsen på aksjen kan gå opp og ned avhengig av hvor mange andre som kjøper aksjer. Du kan avbestille når som helst.',
	'adss-form-site-plan-price' => '1 aksje koster $1',
	'adss-form-page-plan-header' => 'Kjøp en lenke på en enkelt side',
	'adss-form-page-plan-description' => 'Velg ut spesifikke sider som passer din kampanje',
	'adss-form-page-plan-price' => '1 lenke koster $1',
	'adss-form-or' => '- eller -',
	'adss-form-thanks' => 'Takk for sponsingen din! Annonsen din har blitt kjøpt og vil offentliggjøres etter manuell godkjenning (innen 48 timer).

Gå og [[Special:AdSS|kjøp]] enda en annonse!',
	'adss-button-preview' => 'Forhåndsvis',
	'adss-button-edit' => 'Rediger',
	'adss-button-login' => 'Logg inn og kjøp NÅ',
	'adss-button-login-buy' => 'Logg inn og kjøp NÅ',
	'adss-button-save-pay' => 'Lagre',
	'adss-button-pay-paypal' => 'Betal med PayPal',
	'adss-button-select' => 'Velg',
	'adss-preview-header' => 'Forhåndsvisning',
	'adss-preview-prompt' => 'Dette er hvordan sponsorskapet vil se ut - trykk «Rediger» for å gå tilbake og gjøre endringer, eller «Lagre» for å lagre den og gå til PayPal.',
	'adss-click-here' => 'Klikk her',
	'adss-paypal-redirect' => '$1 hvis du ikke omdirigeres til PayPal innen 5 sekunder.',
	'adss-paypal-error' => 'Kunne ikke opprette PayPal-betaling denne gangen. Prøv igjen senere.

Tilbake til [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'En feil oppsto. Prøv igjen senere.

Tilbake til [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Alle sider',
	'adss-per-page' => 'Kun én side',
	'adss-close' => 'Lukk',
	'adss-manager-tab-adList' => 'Dine annonser',
	'adss-manager-tab-billing' => 'Betaling',
	'adss-admin-tab-adList' => 'Liste over annonser',
	'adss-admin-tab-billing' => 'Betaling',
	'adss-admin-tab-reports' => 'Rapporter',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'adss-desc' => 'Areclam a lìber servissi',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Colegament sponsorisà su Wikia',
	'adss-ad-header' => '<h2>Colegament a Sponsor Extern</h2>',
	'adss-ad-default-text' => 'Sgnaca ambelessì!',
	'adss-ad-default-desc' => "Ch'a cata na lira e na descrission dl'areclam për sò sit an sl'aragnà su costa pàgina. Ch'a fasa an pressa, le pòche oferte ëd reclamisassion as vendo an pressa!",
	'adss-form-header' => "ch'a crea sò anonsi",
	'adss-form-url' => "Adrëssa dël dit parin an sl'aragnà (sò sit):",
	'adss-form-linktext' => "Test ch'a veul mostré ant ël colegament:",
	'adss-form-additionaltext' => 'Test da mostré sota soa anliura:',
	'adss-form-type' => 'Sòrt dë sponsorisassion:',
	'adss-form-page' => 'Pàgina da feje da parin:',
	'adss-form-price' => 'Pressi dël parinagi:',
	'adss-form-shares' => 'Nùmer ëd condivision:',
	'adss-form-email' => 'Soa adrëssa ëd pòsta eletrònica:',
	'adss-form-usd-per-day' => '$1 USD al dì',
	'adss-form-usd-per-week' => '$1 USD a la sman-a',
	'adss-form-usd-per-month' => '$1 USD al mèis',
	'adss-form-field-empty-errormsg' => 'Sto camp a peul pa esse veuid',
	'adss-form-non-existent-title-errormsg' => 'Sta pàgina-sì a esist pa',
	'adss-form-pick-plan-errormsg' => 'A dev selessioné un pian',
	'adss-form-pick-plan' => 'Pija un pian',
	'adss-form-site-plan-header' => "Caté n'anliura ansima a na wiki",
	'adss-form-site-plan-description' => "Ch'a aumenta la visibilità an catand n'anliura sponsorisà su na wiki.

Na quòta a val al moment $1% dj'anliure sponsorisà ëd {{SITENAME}}. La dimension ëd la quòta a peul chërse o calé a sconda ëd vàire d'àutri a cato le quòte. A peul anulé quand a veul.",
	'adss-form-site-plan-price' => '1 condivision a costa $1',
	'adss-form-page-plan-header' => "Caté n'anliura su na pàgina individual",
	'adss-form-page-plan-description' => 'Pàgine identificà ëd fasson specìfica për soa campagna',
	'adss-form-page-plan-price' => '1 anliura a costa $1',
	'adss-form-thanks' => "Mersì për sò Parinagi! Sò anonsi a l'é stàit catà e a a sarà an fonsion apress l'aprovassion manual (an 48 ore).

Ch'a [[Special:AdSS|cata]] n'àutr anonsi!",
	'adss-button-preview' => 'Preuva',
	'adss-button-edit' => 'Modìfica',
	'adss-button-save-pay' => 'Salva',
	'adss-button-pay-paypal' => 'Paga con PayPal',
	'adss-button-select' => 'Selession-a',
	'adss-preview-header' => 'Preuva',
	'adss-preview-prompt' => 'Ambelessì a-i é lòn che sò parinagi a smijërà - sgnaché "Modifiché" për andé andré e fé ij cambi, o "Salvé" për salvé e andé a PayPal.',
	'adss-paypal-error' => "As peul pa paghé con PayPal al moment. Për piasì, ch'a preuva pi tard.

Torné andré a [[Special:AdSS|{{int:Adss}}]].",
	'adss-error' => "A l'é capitaje n'eror. Për piasì, ch'a preuva torna pi tard.

Torné a [[Special:AdSS|{{int:Adss}}]].",
	'adss-per-site' => 'Tute le pàgine',
	'adss-per-page' => 'Mach na pàgina',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'adss-desc' => 'Anúncios Self Service',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Links patrocinados na Wikia',
	'adss-ad-header' => '== Links de patrocinadores externos ==',
	'adss-ad-default-text' => 'Clique aqui!',
	'adss-ad-default-desc' => 'Compre nesta página um link e uma descrição patrocinados para o seu site. Faça-o depressa, os poucos lotes de patrocínio esgotam-se rapidamente!',
	'adss-form-header' => 'Desenhe o seu anúncio',
	'adss-form-url' => 'URL do site patrocinador (o seu site na internet):',
	'adss-form-linktext' => 'Texto que pretende que seja apresentado no link:',
	'adss-form-additionaltext' => 'Texto para ser apresentado abaixo do link:',
	'adss-form-type' => 'Tipo de patrocínio:',
	'adss-form-page' => 'Página para patrocinar:',
	'adss-form-price' => 'Montante do patrocínio:',
	'adss-form-shares' => 'Número de acções:',
	'adss-form-email' => 'Endereço de correio electrónico:',
	'adss-form-password' => 'A sua palavra-chave:',
	'adss-form-login-link' => 'Autentique-se',
	'adss-form-login-desc' => 'Tem uma palavra-chave? $1 para poupar tempo e compre o anúncio com um só clique!',
	'adss-form-usd-per-day' => '$1$ por dia',
	'adss-form-usd-per-week' => '$1$ por semana',
	'adss-form-usd-per-month' => '$1$ por mês',
	'adss-form-auth-errormsg' => 'O seu correio electrónico ou a palavra-chave estão incorrectos.',
	'adss-form-field-empty-errormsg' => 'Este campo não pode estar vazio',
	'adss-form-non-existent-title-errormsg' => 'Esta página não existe',
	'adss-form-pick-plan-errormsg' => 'Tem que seleccionar um plano',
	'adss-form-pick-plan' => 'Escolha um plano',
	'adss-form-site-plan-header' => 'Compre um link numa wiki',
	'adss-form-site-plan-description' => 'Receba mais exposição comprando um link patrocinado numa wiki.

1 acção é, neste momento, igual a $1% dos links patrocinados da {{SITENAME}}. O tamanho da acção pode aumentar ou diminuir, dependendo de quantas outras pessoas compram acções. Pode cancelar em qualquer altura.',
	'adss-form-site-plan-price' => '1 acção custa $1',
	'adss-form-page-plan-header' => 'Comprar um link numa página individual',
	'adss-form-page-plan-description' => 'Direccione a sua Campanha para páginas específicas relacionadas com ela',
	'adss-form-page-plan-price' => '1 link custa $1',
	'adss-form-or' => '- ou -',
	'adss-form-thanks' => 'Obrigado pelo seu patrocínio! O seu anúncio foi comprado e ficará visível após aprovação manual (dentro de 48 horas).

Agora [[Special:AdSS|compre]] outro anúncio!',
	'adss-button-preview' => 'Antevisão',
	'adss-button-edit' => 'Editar',
	'adss-button-login' => 'Autentique-se e compre AGORA',
	'adss-button-save-pay' => 'Gravar e pagar',
	'adss-button-pay-paypal' => 'Pagar com PayPal',
	'adss-button-select' => 'Seleccionar',
	'adss-preview-header' => 'Antevisão',
	'adss-preview-prompt' => 'O aspecto do seu patrocínio será este - clique "editar" para voltar atrás e fazer alterações, ou "gravar" para gravar e ir para o PayPal.',
	'adss-click-here' => 'Clique aqui',
	'adss-paypal-redirect' => '$1 se não for redireccionado para o PayPal nos próximos 5 segundos.',
	'adss-paypal-error' => 'Não foi possível criar o pagamento PayPal neste momento. Por favor, tente novamente mais tarde. 

Voltar para [[Special:AdSS|{{int:AdSS}}]].',
	'adss-error' => 'Ocorreu um erro. Por favor, tente novamente mais tarde. 

Voltar para [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Todas as páginas',
	'adss-per-page' => 'Apenas uma página',
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
 * @author Exlex
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
	'adss-form-non-existent-title-errormsg' => 'Этой страницы не существует',
	'adss-form-thanks' => 'Благодарим за спонсорскую помощь! Ваше объявление было принято и будет пущено в ротацию после ручной проверки (в течении 48 часов).

Перейти и [[Special:AdSS|купить]] другую рекламу!',
	'adss-button-preview' => 'Предпросмотр',
	'adss-button-edit' => 'Править',
	'adss-button-save-pay' => 'Сохранить',
	'adss-preview-header' => 'Предпросмотр',
	'adss-preview-prompt' => 'Так будет выглядеть ваше спонсорство. Нажмите кнопку "Изменить", чтобы вернуться и внести изменения, или "Сохранить", чтобы сохранить и перейти к PayPal.',
	'adss-per-site' => 'Все страницы',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'adss-button-save-pay' => 'Shrani',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'adss-button-preview' => 'முன்தோற்றம்',
	'adss-button-edit' => 'தொகு',
	'adss-button-select' => 'தேர்வு செய்',
	'adss-preview-header' => 'முன்தோற்றம்',
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

