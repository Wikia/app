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
	'adss-ad-header' => '<h2>External sponsor links</h2>',
	'adss-ad-default-text' => 'Click here!',
	'adss-ad-default-desc' => 'Buy a sponsored link and description for your website on this page. Act quickly, the few sponsorship slots sell out fast!',
	'adss-form-header' => 'Design your ad',
	'adss-form-url' => 'URL of sponsoring website (your website):',
	'adss-form-linktext' => 'Text you want displayed in the link:',
	'adss-form-additionaltext' => 'Text to be displayed under your link:',
	'adss-form-type' => 'Sponsorship type:',
	'adss-form-page' => 'Page to sponsor:',
	'adss-form-banner' => 'Your banner:',
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
	'adss-form-site-premium-plan-header' => 'Buy a premium link across the whole wiki',
	'adss-form-site-premium-plan-description' => 'Get your links running across the whole wiki for one low price and get even more exposure by buying more shares.

1 share is currently equal to $1% of {{SITENAME}} sponsored links. With this option you are buying four shares at the price of three! You can cancel at any time.',
	'adss-form-site-premium-plan-price' => 'Only $1 for four shares!',
	'adss-form-page-plan-header' => 'Buy a link on just this page',
	'adss-form-page-plan-description' => 'This let you target a custom message to the best page for your product at only $1, and you can cancel at any time.',
	'adss-form-page-plan-price' => '$1 for one link',
	'adss-form-banner-plan-header' => 'Buy a banner on top of every page',
	'adss-form-banner-plan-description' => 'Get your banner running across the whole wiki for one low price.',
	'adss-form-banner-plan-price' => '$1 for one banner',
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
	'adss-cancel' => 'Cancel',
	'adss-manager-tab-adList' => 'Your ads',
	'adss-manager-tab-billing' => 'Billing',
	'adss-admin-tab-adList' => 'List of ads',
	'adss-admin-tab-billing' => 'Billing',
	'adss-admin-tab-reports' => 'Reports',
	'adss-not-logged-in' => 'You must be logged-in',
	'adss-wrong-id' => 'Wrong id',
	'adss-no-permission' => 'No permission',
	'adss-canceled' => 'Canceled',
	'adss-rejected' => 'Rejected',
	'adss-approved' => 'Approved',
	'adss-pending' => 'Pending',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Type',
	'adss-no-shares' => '# shares',
	'adss-price' => 'Price',
	'adss-ad' => 'Ad',
	'adss-status' => 'Status',
	'adss-created' => 'Created',
	'adss-your-balance' => 'Balance due:',
	'adss-your-billing-agreement' => 'PayPal billing agreement:',
	'adss-no-billing-agreement' => 'None. You need to re-create a billing agreement in order to keep your ads running.',
	'adss-create-billing-agreement' => 'Create a billing agreement',
	'adss-billing-agreement-created' => 'The billing agreement has been successfully created (BAID=$1). Return to [[Special:AdSS/manager|the dashboard]].',
	'adss-paypal-payment' => 'PayPal payment',
	'adss-adss-fee' => 'AdSS Fee',
	'adss-fee' => 'Fee',
	'adss-paid' => 'Paid',
	'adss-timestamp' => 'Timestamp',
	'adss-description' => 'Description',
	'adss-amount' => '$$1',
	'adss-welcome-subject' => '[AdSS] Thank you for your sponsorship!',
	'adss-welcome-body' => 'Hi,

Congratulations, your account is set up and your ads will start
running within 48 hours. You can login using the details below to
double check your ad text, purchase additional ads or review your
bill. Wikia bills are sent via Paypal every time you have spent
$$4 or more.
	
URL: $1
Username: $2
Password: $3

Please save your password in a secure spot.  If you lose it, you can
contact customer support at: http://www.wikia.com/wiki/Special:Contact
and we will send you the password to your email address on file.

-- 
Wikia Team',
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
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Liammoù paeroniet war Wikia',
	'adss-ad-header' => '<h2>Liammoù davet ar paeroned diavaez</h2>',
	'adss-ad-default-text' => 'Klikit amañ !',
	'adss-form-header' => 'Krouit ho pruderezh',
	'adss-form-url' => "URL al lec'hienn paeron (ho lec'hienn web) :",
	'adss-form-linktext' => "Testenn hoc'h eus c'hoant diskouez el liamm :",
	'adss-form-additionaltext' => 'Testenn da ziskouez dindan ho liamm :',
	'adss-form-type' => 'Doare ar paeroniañ :',
	'adss-form-page' => 'Pajenn da baeroniañ :',
	'adss-form-price' => 'Sammad ar paeroniañ :',
	'adss-form-email' => "Ho chomlec'h postel :",
	'adss-form-password' => 'Ho ker-tremen :',
	'adss-form-login-link' => 'Kevreañ',
	'adss-form-usd-per-day' => '$1 USD dre zevezh',
	'adss-form-usd-per-week' => '$1 USD dre sizhun',
	'adss-form-usd-per-month' => '$1 USD dre miz',
	'adss-form-page-plan-price' => '$1 eo koust ul liamm',
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
	'adss-cancel' => 'Nullañ',
	'adss-manager-tab-adList' => 'Ho pruderezhioù',
	'adss-manager-tab-billing' => 'O fakturenniñ',
	'adss-admin-tab-adList' => 'Roll ar bruderezhioù',
	'adss-admin-tab-billing' => 'O fakturenniñ',
	'adss-admin-tab-reports' => 'Danevelloù',
	'adss-not-logged-in' => "Ret eo deoc'h kevreañ",
	'adss-wrong-id' => 'Id fall',
	'adss-no-permission' => 'Aotre ebet',
	'adss-canceled' => 'Nullet',
	'adss-rejected' => 'Distaolet',
	'adss-approved' => 'Asantet',
	'adss-pending' => "O c'hortoz",
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Seurt',
	'adss-price' => 'Priz',
	'adss-ad' => 'Bruderezh',
	'adss-status' => 'Statud',
	'adss-created' => 'Krouet',
	'adss-paypal-payment' => 'Paeamant PayPal',
	'adss-paid' => 'Paet',
	'adss-description' => 'Deskrivadur',
	'adss-amount' => '$1$',
);

/** German (Deutsch)
 * @author Diebuche
 * @author LWChris
 * @author The Evil IP address
 * @author Wikifan
 */
$messages['de'] = array(
	'adss-desc' => 'Ad Self Service',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Gesponserte Links auf Wikia',
	'adss-ad-header' => '<h2> Links von Sponsoren </h2>',
	'adss-ad-default-text' => 'Hier klicken!',
	'adss-ad-default-desc' => 'Kaufe einen gesponserten Link und eine Beschreibung für deine Webseite auf dieser Seite. Beeil dich, die wenigen Sponsoring-Slots sind schnell ausverkauft!',
	'adss-form-header' => 'Gestalte deine Anzeige',
	'adss-form-url' => 'URL deiner sponsernden Website:',
	'adss-form-linktext' => 'Text, der als Link angezeigt werden soll:',
	'adss-form-additionaltext' => 'Text, der unter deinem Link angezeigt werden soll:',
	'adss-form-type' => 'Sponsoring-Typ:',
	'adss-form-page' => 'Seite, die du sponsern willst:',
	'adss-form-price' => 'Höhe des Sponsorings:',
	'adss-form-shares' => 'Anzahl der Aktien:',
	'adss-form-email' => 'Deine E-Mail-Adresse:',
	'adss-form-password' => 'Dein Passwort:',
	'adss-form-login-link' => 'Anmelden',
	'adss-form-login-desc' => 'Passwort parat? $1 um deine Zeit zu sparen und kaufe die Anzeige mit bloß einem Klick!',
	'adss-form-usd-per-day' => '$$1 pro Tag',
	'adss-form-usd-per-week' => '$$1 pro Woche',
	'adss-form-usd-per-month' => '$$1 pro Monat',
	'adss-form-auth-errormsg' => 'Entweder ist die E-Mail-Adresse oder das Passwort falsch.',
	'adss-form-field-empty-errormsg' => 'Dieses Feld darf nicht leer sein',
	'adss-form-non-existent-title-errormsg' => 'Die Seite existiert nicht!',
	'adss-form-pick-plan-errormsg' => 'Du musst einen Plan auswählen',
	'adss-form-pick-plan' => 'Deinen Plan wählen',
	'adss-form-site-plan-header' => 'Kaufe einen Link über das ganze Wiki',
	'adss-form-site-plan-description' => 'Hol dir deine Links übers ganze Wiki für einen Tiefpreis.

1 Aktie entsprich momentan $1% der {{SITENAME}} gesponserten Links und kostet bloß $2. Du kannst jederzeit abbrechen.',
	'adss-form-site-plan-price' => '$1 für eine Aktie',
	'adss-form-page-plan-header' => 'Nur auf dieser Seite einen Link kaufen',
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
	'adss-form-pick-plan' => 'Escolla o seu plan',
	'adss-form-site-plan-header' => 'Comprar unha ligazón en todo o wiki',
	'adss-form-site-plan-price' => '$1 por unha acción',
	'adss-form-page-plan-header' => 'Comprar unha ligazón soamente nesta páxina',
	'adss-form-page-plan-price' => '1 ligazón custa $1',
	'adss-form-or' => '- ou -',
	'adss-form-thanks' => 'Grazas polo seu patrocinio! O seu anuncio xa está comprado e comezará a aparecer despois da aprobación manual (nas vindeiras 48 horas).

Por que non [[Special:AdSS|merca]] outro anuncio?',
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
	'adss-cancel' => 'Cancelar',
	'adss-manager-tab-adList' => 'Os seus anuncios',
	'adss-manager-tab-billing' => 'Facturación',
	'adss-admin-tab-adList' => 'Lista de anuncios',
	'adss-admin-tab-billing' => 'Facturación',
	'adss-admin-tab-reports' => 'Informes',
	'adss-no-permission' => 'Non ten permisos',
	'adss-canceled' => 'Cancelado',
	'adss-rejected' => 'Rexeitado',
	'adss-approved' => 'Aprobado',
	'adss-pending' => 'Pendente',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Tipo',
	'adss-status' => 'Estado',
	'adss-created' => 'Creado',
	'adss-fee' => 'Custo',
	'adss-paid' => 'Pagado',
	'adss-timestamp' => 'Data e hora',
	'adss-description' => 'Descrición',
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
	'adss-form-pick-plan' => 'Selige tu plano',
	'adss-form-site-plan-header' => 'Compra un ligamine in tote le wiki',
	'adss-form-site-plan-description' => 'Diffunde vostre ligamines in tote le wiki pro un sol precio basse.

1 parte equala actualmente $1% del ligamines sponsorisate de {{SITENAME}} e costa solmente $2. Vos pote cancellar a omne momento.',
	'adss-form-site-plan-price' => '$1 per parte',
	'adss-form-page-plan-header' => 'Acquire un ligamine sur iste pagina individual',
	'adss-form-page-plan-description' => 'Isto permitte diriger un message personalisate al optime pagina pro vostre producto pro solmente $1, e vos pote cancellar a omne momento.',
	'adss-form-page-plan-price' => '1 ligamine costa $1',
	'adss-form-or' => '- o -',
	'adss-form-thanks' => 'Gratias pro le sponsorisation! Le acquisition del annuncio ha succedite e illo entrara in circulation post approbation manual (intra 48 horas).

	 Ora tu pote [[Special:AdSS|comprar]] un altere annuncio!',
	'adss-button-preview' => 'Previsualisar',
	'adss-button-edit' => 'Modificar',
	'adss-button-login' => 'Aperir session',
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
	'adss-cancel' => 'Cancellar',
	'adss-manager-tab-adList' => 'Tu annuncios',
	'adss-manager-tab-billing' => 'Facturation',
	'adss-admin-tab-adList' => 'Lista de annuncios',
	'adss-admin-tab-billing' => 'Facturation',
	'adss-admin-tab-reports' => 'Reportos',
	'adss-not-logged-in' => 'Tu debe esser authenticate',
	'adss-wrong-id' => 'ID incorrecte',
	'adss-no-permission' => 'Nulle permission',
	'adss-canceled' => 'Cancellate',
	'adss-rejected' => 'Rejectate',
	'adss-approved' => 'Approbate',
	'adss-pending' => 'Pendente',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Typo',
	'adss-no-shares' => 'Numero de partes',
	'adss-price' => 'Precio',
	'adss-ad' => 'Annuncio',
	'adss-status' => 'Stato',
	'adss-created' => 'Create le',
	'adss-paypal-payment' => 'Pagamento via PayPal',
	'adss-adss-fee' => 'Costos de AdSS',
	'adss-fee' => 'Costos',
	'adss-paid' => 'Pagate',
	'adss-timestamp' => 'Data e hora',
	'adss-description' => 'Description',
	'adss-amount' => '$$1',
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
	'adss-form-site-plan-description' => 'Набавете врски за цело вики за една, ниска цена.

1 акција моментално вреди $1% спонзорирани врски на {{SITENAME}}, и чини само $2. Ова можете да го откажете во секое време.',
	'adss-form-site-plan-price' => '$1 за една акција',
	'adss-form-page-plan-header' => 'Купете врска само на оваа страница',
	'adss-form-page-plan-description' => 'Со ова можете да составите прилагодена порака за страницата што е најпогодна за вашиот производ, и тоа за само $1. Ова можете да го откажете во секое време.',
	'adss-form-page-plan-price' => '1 врска чини $1',
	'adss-form-or' => '- или -',
	'adss-form-thanks' => 'Ви благодариме за спонзорството! Рекламата е успешно купена, и истата ќе оди во живо откако ќе биде рачно одобрена (макс. во рок од 48 часа).

[[Special:AdSS|Купете]] уште една реклама!',
	'adss-button-preview' => 'Преглед',
	'adss-button-edit' => 'Уреди',
	'adss-button-login' => 'Најава',
	'adss-button-login-buy' => 'Најавете се и купете ВЕДНАШ',
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
	'adss-close' => 'Затвори',
	'adss-cancel' => 'Откажи',
	'adss-manager-tab-adList' => 'Ваши реклами',
	'adss-manager-tab-billing' => 'Фактурирање',
	'adss-admin-tab-adList' => 'Список на реклами',
	'adss-admin-tab-billing' => 'Фактурирање',
	'adss-admin-tab-reports' => 'Извештаи',
	'adss-not-logged-in' => 'Мора да сте најавени',
	'adss-wrong-id' => 'Грешна назнака (ID)',
	'adss-no-permission' => 'Немате дозвола',
	'adss-canceled' => 'Откажано',
	'adss-rejected' => 'Одбиено',
	'adss-approved' => 'Одобрено',
	'adss-pending' => 'Во исчекување',
	'adss-wikia' => 'Викија',
	'adss-type' => 'Тип',
	'adss-no-shares' => 'бр. на акции',
	'adss-price' => 'Цена',
	'adss-ad' => 'Реклама',
	'adss-status' => 'Статус',
	'adss-created' => 'Создадено',
	'adss-paypal-payment' => 'Плаќање со PayPal',
	'adss-adss-fee' => 'Наплата за AdSS',
	'adss-fee' => 'Наплата',
	'adss-paid' => 'Платено',
	'adss-timestamp' => 'Датум и време',
	'adss-description' => 'Опис',
	'adss-amount' => '$$1',
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
	'adss-form-site-plan-description' => 'Laat uw verwijzing weergeven in de hele wiki voor één lage prijs.

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
	'adss-cancel' => 'Annuleren',
	'adss-manager-tab-adList' => 'Uw advertenties',
	'adss-manager-tab-billing' => 'Facturatie',
	'adss-admin-tab-adList' => 'Lijst van advertenties',
	'adss-admin-tab-billing' => 'Facturatie',
	'adss-admin-tab-reports' => 'Rapportages',
	'adss-not-logged-in' => 'U moet aangemeld zijn',
	'adss-wrong-id' => 'Onjuist ID',
	'adss-no-permission' => 'Geen toestemming',
	'adss-canceled' => 'Geannuleerd',
	'adss-rejected' => 'Afgewezen',
	'adss-approved' => 'Goedgekeurd',
	'adss-pending' => 'In behandeling',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Type',
	'adss-no-shares' => 'Aantal aandelen',
	'adss-price' => 'Prijs',
	'adss-ad' => 'Advertentie',
	'adss-status' => 'Status',
	'adss-created' => 'Aangemaakt op',
	'adss-paypal-payment' => 'PayPal-betaling',
	'adss-adss-fee' => 'Kosten AdSS',
	'adss-fee' => 'Kosten',
	'adss-paid' => 'Betaald',
	'adss-timestamp' => 'Tijdstip',
	'adss-description' => 'Beschrijving',
	'adss-amount' => '$$1',
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
	'adss-form-pick-plan' => 'Velg din plan',
	'adss-form-site-plan-header' => 'Kjøp en lenke over hele wikien',
	'adss-form-site-plan-description' => 'Få lenkene dine over hele wikien til én lav pris.

1 aksje er for øyeblikket tilsvarende $1 % av {{SITENAME}}-sponsede lenker og koster kun $2. Du kan avbestille når som helst.',
	'adss-form-site-plan-price' => '$1 for én aksje',
	'adss-form-page-plan-header' => 'Kjøp en lenke kun på denne siden',
	'adss-form-page-plan-description' => 'Dette lar deg velge en egen melding til den beste siden for ditt produkt kun på $1, og du kan avbestille når som helst.',
	'adss-form-page-plan-price' => '1 lenke koster $1',
	'adss-form-or' => '- eller -',
	'adss-form-thanks' => 'Takk for sponsingen din! Annonsen din har blitt kjøpt og vil offentliggjøres etter manuell godkjenning (innen 48 timer).

Gå og [[Special:AdSS|kjøp]] enda en annonse!',
	'adss-button-preview' => 'Forhåndsvis',
	'adss-button-edit' => 'Rediger',
	'adss-button-login' => 'Logg inn',
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
	'adss-cancel' => 'Avbryt',
	'adss-manager-tab-adList' => 'Dine annonser',
	'adss-manager-tab-billing' => 'Betaling',
	'adss-admin-tab-adList' => 'Liste over annonser',
	'adss-admin-tab-billing' => 'Betaling',
	'adss-admin-tab-reports' => 'Rapporter',
	'adss-not-logged-in' => 'Du må være innlogget',
	'adss-wrong-id' => 'Gal id',
	'adss-no-permission' => 'Ingen tillatelse',
	'adss-canceled' => 'Avbrutt',
	'adss-rejected' => 'Avslått',
	'adss-approved' => 'Godkjent',
	'adss-pending' => 'Venter',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Type',
	'adss-no-shares' => '# aksjer',
	'adss-price' => 'Pris',
	'adss-ad' => 'Annonse',
	'adss-status' => 'Status',
	'adss-created' => 'Opprettet',
	'adss-paypal-payment' => 'PayPal-betaling',
	'adss-adss-fee' => 'AdSS-gebyr',
	'adss-fee' => 'Gebyr',
	'adss-paid' => 'Betalt',
	'adss-timestamp' => 'Tidsangivelse',
	'adss-description' => 'Beskrivelse',
	'adss-amount' => '$1 $',
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

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'adss-ad-default-text' => 'دلته وټوکۍ!',
	'adss-form-email' => 'ستاسې برېښليک پته:',
	'adss-form-password' => 'ستاسې پټنوم:',
	'adss-form-login-link' => 'ننوتل',
	'adss-form-non-existent-title-errormsg' => 'پدې نوم مخ نشته!',
	'adss-button-preview' => 'مخليدنه',
	'adss-button-edit' => 'سمول',
	'adss-button-login' => 'ننوتل',
	'adss-button-select' => 'ټاکل',
	'adss-preview-header' => 'مخليدنه',
	'adss-click-here' => 'دلته وټوکۍ',
	'adss-close' => 'تړل',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'adss-desc' => 'Anúncios Self Service',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Links patrocinados na Wikia',
	'adss-ad-header' => '<h2> Links de patrocinadores externos </h2>',
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
	'adss-form-pick-plan' => 'Escolha o seu plano',
	'adss-form-site-plan-header' => 'Compre um link para a wiki toda',
	'adss-form-site-plan-description' => 'Tenha os seus links na wiki toda por baixo custo.

1 acção é, neste momento, igual a $1% dos links patrocinados da {{SITENAME}} e só custa $2. Pode cancelar em qualquer altura.',
	'adss-form-site-plan-price' => '$1 por uma acção',
	'adss-form-page-plan-header' => 'Comprar um link só nesta página',
	'adss-form-page-plan-description' => 'Isto permite-lhe direccionar uma mensagem personalizada para a melhor página para o seu produto por apenas $1 e pode cancelar em qualquer altura.',
	'adss-form-page-plan-price' => '1 link custa $1',
	'adss-form-or' => '- ou -',
	'adss-form-thanks' => 'Obrigado pelo seu patrocínio! O seu anúncio foi comprado e ficará visível após aprovação manual (dentro de 48 horas).

Agora [[Special:AdSS|compre]] outro anúncio!',
	'adss-button-preview' => 'Antevisão',
	'adss-button-edit' => 'Editar',
	'adss-button-login' => 'Autenticação',
	'adss-button-login-buy' => 'Autentique-se e compre AGORA',
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
	'adss-close' => 'Fechar',
	'adss-manager-tab-adList' => 'Os seus anúncios',
	'adss-manager-tab-billing' => 'Facturação',
	'adss-admin-tab-adList' => 'Lista de anúncios',
	'adss-admin-tab-billing' => 'Facturação',
	'adss-admin-tab-reports' => 'Relatórios',
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

