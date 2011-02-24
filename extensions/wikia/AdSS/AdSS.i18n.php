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
	'adss-form-banner' => 'Upload your banner here:',
	'adss-form-price' => 'Sponsorship amount:',
	'adss-form-shares' => 'Number of shares:',
	'adss-form-email' => 'Your e-mail address:',
	'adss-form-password' => 'Your password:',
	'adss-form-login-link' => 'Log in', // FIXME: 'adss-form-login-desc'
	'adss-form-login-desc' => 'Have a password? $1 to save your time and buy the ad with just one click!',
	'adss-form-usd-per-day' => '$$1 per day',
	'adss-form-usd-per-week' => '$$1 per week',
	'adss-form-usd-per-month' => '$$1 per month',
	'adss-form-usd-per-quarter' => '$$1 per quarter',
	'adss-form-usd-per-year' => '$$1 per year',
	'adss-form-auth-errormsg' => 'Either your e-mail address or password is incorrect.',
	'adss-form-field-empty-errormsg' => 'This field must not be empty',
	'adss-form-non-existent-title-errormsg' => 'This page does not exist',
	'adss-form-banner-upload-errormsg' => 'You must select an image to upload',
	'adss-form-pick-plan-errormsg' => 'You must select a plan',
	'adss-form-pick-plan' => 'Choose an ad package',
	'adss-form-site-plan-header' => 'Buy a Sponsored Link across the whole wiki',
	'adss-form-site-plan-description' => 'Get Sponsored Links on {{SITENAME}} for one low price.

1 share is currently equal to $1% of {{SITENAME}} sponsored links and only costs $2. You can cancel at any time.',
	'adss-form-site-plan-price' => '$1 for one share',
	'adss-form-site-premium-plan-header' => 'Buy 4 Sponsored Links for the price of 3',
	'adss-form-site-premium-plan-description' => 'Get Sponsored Links on {{SITENAME}} and get even more exposure by buying in bulk.

1 share is currently equal to $1% of {{SITENAME}} sponsored links. With this option you are buying four shares at the price of three! You can cancel at any time.',
	'adss-form-site-premium-plan-price' => 'Only $1 for four shares!',
	'adss-form-page-plan-header' => 'Buy a link on just one page',
	'adss-form-page-plan-description' => 'This let you target a custom message to the best page for your product at only $1, and you can cancel at any time.',
	'adss-form-page-plan-price' => '$1 for one link',
	'adss-form-banner-plan-header' => 'Buy a share of the 728x90 graphical banners at the top of the wiki',
	'adss-form-banner-plan-description' => 'Get a share of the banners running across the site for one low price.',
	'adss-form-banner-plan-price' => '$1 for one share of the banners',
	'adss-form-hub-plan-header' => 'Buy a Sponsored Link across all $1 wikis',
	'adss-form-hub-plan-description' => 'Get Sponsored Links on all (over $2) $1 wikis for one low price.

This lets you reach more audience by showing your ad on others wikis from the same hub.',
	'adss-form-hub-plan-price' => '$1 for one share',
	'adss-form-or' => '- or -',
	'adss-form-thanks' => 'You completed your purchase.  Your ad will go live after being approved (within 48 hours, usually less).',
	'adss-form-buy-another' => 'Want to purchase a 2nd ad now?  [[Special:AdSS|Click here]]',
	'adss-upsell-header' => 'Special One-time Offer',
	'adss-upsell-text' => 'Get your first month free on the ad you just bought!<br />
Convert your ad to a quarterly subscription now<br />and pay $$1 instead of $$2 (33% off)!',
	'adss-upsell-yes' => 'Yes, I want it!',
	'adss-upsell-no' => 'No, thanks',
	'adss-upsell-thanks' => 'Thank you for choosing the offer!',
	'adss-upsell-error' => 'An error occurred!',
	'adss-button-preview' => 'Preview',
	'adss-button-edit' => 'Edit',
	'adss-button-login' => 'Log in',
	'adss-button-login-buy' => 'Log in and buy NOW',
	'adss-button-save-pay' => 'Save & pay',
	'adss-button-pay-paypal' => 'Pay with PayPal',
	'adss-button-select' => 'Select',
	'adss-button-buy-now' => 'Buy NOW',
	'adss-button-save' => 'Save',
	'adss-button-cancel' => 'Cancel',
	'adss-button-yes' => 'Yes',
	'adss-button-no' => 'No',
	'adss-buy-another' => 'Buy another ad!',
	'adss-edit-thanks' => 'Your ad changes have been saved and will go live after manual approval (within 48 hours).',
	'adss-preview-header' => 'Preview',
	'adss-preview-prompt' => 'Here is what your sponsorship will look like - click "{{int:adss-button-edit}}" to go back and make changes, or "{{int:adss-button-save-pay}}" to save it and go to PayPal.',
	'adss-click-here' => 'Click here', // FIXME: Merge in 'adss-paypal-redirect'. Bad i18n.
	'adss-paypal-redirect' => '$1 if you are not redirected to PayPal within 5 seconds.',
	'adss-paypal-error' => "Couldn't create PayPal payment this time. Please try again later.

Return to [[Special:AdSS|{{int:Adss}}]].",
	'adss-error' => "An error ocurred. Please try again later.

Return to [[Special:AdSS|{{int:Adss}}]].",
	'adss-per-site' => 'All pages',
	'adss-per-hub' => 'Hub',
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
	'adss-no-billing-agreement' => 'No valid PayPal agreement. Recreate your billing agreement to keep your ads running.',
	'adss-create-billing-agreement' => 'Create a billing agreement',
	'adss-cancel-billing-agreement-confirmation' => 'Are you sure you want to cancel your billing agreement? Your ads will stop running without a valid PayPal agreement.', 
	'adss-billing-agreement-created' => 'The billing agreement has been successfully created (BAID=$1). Return to [[Special:AdSS/manager/billing|the dashboard]].',
	'adss-billing-agreement-canceled' => 'Your billing agreement has been successfully canceled. Return to [[Special:AdSS/manager/billing|the dashboard]].',
	'adss-paypal-payment' => 'PayPal payment',
	'adss-adss-fee' => 'AdSS Fee',
	'adss-adss-refund' => 'AdSS Refund',
	'adss-fee' => 'Fee',
	'adss-paid' => 'Paid',
	'adss-timestamp' => 'Timestamp',
	'adss-description' => 'Description',
	'adss-amount' => '$$1',
	'adss-cancel-confirmation' => 'Are you sure you want to delete this ad?',
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

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
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
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'adss-desc' => 'Bruderezh emservij',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Liammoù paeroniet war Wikia',
	'adss-ad-header' => '<h2>Liammoù davet ar paeroned diavaez</h2>',
	'adss-ad-default-text' => 'Klikit amañ !',
	'adss-ad-default-desc' => "Prenit ul liamm sponsoret hag un deskrivadur evit ho lec'hienn web war ar bajenn-mañ. Hastit buan, nebeut a ginnigoù sponsorañ zo ha gwerzhet bua e vezont !",
	'adss-form-header' => 'Krouit ho pruderezh',
	'adss-form-url' => "URL al lec'hienn paeron (ho lec'hienn web) :",
	'adss-form-linktext' => "Testenn hoc'h eus c'hoant diskouez el liamm :",
	'adss-form-additionaltext' => 'Testenn da ziskouez dindan ho liamm :',
	'adss-form-type' => 'Doare ar paeroniañ :',
	'adss-form-page' => 'Pajenn da baeroniañ :',
	'adss-form-banner' => 'Enporzhit ho kiton amañ :',
	'adss-form-price' => 'Sammad ar paeroniañ :',
	'adss-form-shares' => 'Niver a oberoù :',
	'adss-form-email' => "Ho chomlec'h postel :",
	'adss-form-password' => 'Ho ker-tremen :',
	'adss-form-login-link' => 'Kevreañ',
	'adss-form-login-desc' => "Ur ger-tremen hoc'h eus ? $1 evit gounit amzer ha prenañ bruderezh gant ur c'hlik hepken !",
	'adss-form-usd-per-day' => '$1 USD dre zevezh',
	'adss-form-usd-per-week' => '$1 USD dre sizhun',
	'adss-form-usd-per-month' => '$1 USD dre miz',
	'adss-form-auth-errormsg' => "Direizh eo ho chomlec'h postel pe ho ker-tremen.",
	'adss-form-field-empty-errormsg' => 'Ar vaezienn-se ne rank ket bezañ goullo !',
	'adss-form-non-existent-title-errormsg' => "N'eus ket eus ar bajenn-se",
	'adss-form-banner-upload-errormsg' => "Ret eo deoc'h diuzañ ur skeudenn da gargañ",
	'adss-form-pick-plan-errormsg' => "Ret eo deoc'h diuzañ ur steuñv",
	'adss-form-pick-plan' => 'Dibabit ur pakad bruderezh',
	'adss-form-site-plan-header' => 'Prenañ ul liamm sponsoret war wel er wiki a-bezh',
	'adss-form-site-plan-price' => '$1 eo an tamm',
	'adss-form-site-premium-plan-header' => 'Prenañ 4 liamm sponsoret e priz 3',
	'adss-form-site-premium-plan-price' => '$1 hepken evit pevar zamm !',
	'adss-form-page-plan-header' => 'Prenañ ul liamm war ur bajenn hepken',
	'adss-form-page-plan-price' => '$1 eo koust ul liamm',
	'adss-form-banner-plan-price' => '$1 evit un tamm eus ar bannieloù',
	'adss-form-hub-plan-price' => '$1 eo an tamm',
	'adss-form-or' => '- pe -',
	'adss-form-thanks' => 'Trugarez evit ho paeroniañ !',
	'adss-button-preview' => 'Rakwelet',
	'adss-button-edit' => 'Kemmañ',
	'adss-button-login' => 'Kevreañ',
	'adss-button-login-buy' => 'Kevreañ ha prenañ BREMAÑ',
	'adss-button-save-pay' => 'Enrollañ',
	'adss-button-pay-paypal' => 'Paeañ dre PayPal',
	'adss-button-select' => 'Diuzañ',
	'adss-button-buy-now' => 'Prenañ BREMAÑ',
	'adss-button-save' => 'Enrollañ',
	'adss-button-cancel' => 'Nullañ',
	'adss-button-yes' => 'Ya',
	'adss-button-no' => 'Ket',
	'adss-buy-another' => 'Prenañ ur bruderezh all !',
	'adss-preview-header' => 'Rakwelet',
	'adss-preview-prompt' => 'Setu da betra e tenno ho paeroniañ. Klikit war "kemmañ" evit distreiñ ha degas kemmoù pe war "saveteiñ" evit enrollañ hag evit mont war PayPal.',
	'adss-click-here' => 'Klikit amañ',
	'adss-paypal-redirect' => "$1 ma n'oc'h ket adkaset da bPaypal a-benn 5 eilenn.",
	'adss-paypal-error' => "Ne c'haller ket paeañ gant PayPal bremañ. Esaeit en-dro diwezhatoc'h, mar plij.

Distreiñ da [[Special:AdSS|{{int:Adss}}]].",
	'adss-error' => "C'hoarvezet ez eus ur fazi. Esaeit en-dro diwezhatoc'h.

Distreiñ da [[Special:AdSS|{{int:Adss}}]].",
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
	'adss-no-shares' => '# kenlodenn',
	'adss-price' => 'Priz',
	'adss-ad' => 'Bruderezh',
	'adss-status' => 'Statud',
	'adss-created' => 'Krouet',
	'adss-your-billing-agreement' => 'Asant fakturenniñ PayPal :',
	'adss-create-billing-agreement' => 'Krouiñ un emglev fakturenniñ',
	'adss-paypal-payment' => 'Paeamant PayPal',
	'adss-adss-fee' => 'Frejoù AdSS',
	'adss-adss-refund' => 'Daskor AdSS',
	'adss-fee' => 'Frejoù',
	'adss-paid' => 'Paet',
	'adss-timestamp' => 'Merker amzer',
	'adss-description' => 'Deskrivadur',
	'adss-amount' => '$1$',
	'adss-cancel-confirmation' => "Ha sur oc'h hoc'h eus c'hoant da zilemel ar c'hemennad-mañ ?",
	'adss-welcome-subject' => '[AdSS] Trugarez evit ho paeroniañ !',
);

/** Czech (Česky)
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'adss-desc' => 'Reklamová samoobslužná služba',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Sponzorované odkazy na Wikii',
	'adss-ad-header' => '<h2>Externí sponzorovací odkazy</h2>',
	'adss-ad-default-text' => 'Klikněte zde!',
	'adss-ad-default-desc' => 'Koupit sponzorovaný odkaz a popis Vaší webové stránky na této stránce. Jednejte rychle, sponzorovací sloty se vyprodají rychle!',
	'adss-form-header' => 'Navrhněte svou reklamu',
	'adss-form-url' => 'URL sponzorující stránky (Vaší webové stránky):',
	'adss-form-linktext' => 'Text, který chcete zobrazit v odkazu:',
	'adss-form-additionaltext' => 'Text, který se zobrazí pod odkazem:',
	'adss-form-type' => 'Typ sponzorování:',
	'adss-form-page' => 'Stránka ke sponzorování:',
	'adss-form-banner' => 'Zde nahrajte svůj banner:',
	'adss-form-price' => 'Cena sponzoringu:',
	'adss-form-shares' => 'Počet reklam:',
	'adss-form-email' => 'Váš e-mail:',
	'adss-form-password' => 'Vaše heslo:',
	'adss-form-login-link' => 'Přihlašte se',
	'adss-form-login-desc' => 'Máte heslo? $1 a ušetřete čas, kupte si inzerát pouhým jedním kliknutím!',
	'adss-form-usd-per-day' => '$$1 na den',
	'adss-form-usd-per-week' => '$$1 za týden',
	'adss-form-usd-per-month' => '$$1 za měsíc',
	'adss-form-auth-errormsg' => 'Vaše e-mailová adresa nebo heslo není správné.',
	'adss-form-field-empty-errormsg' => 'Toto pole nesmí být prázdné',
	'adss-form-non-existent-title-errormsg' => 'Tato stránka neexistuje',
	'adss-form-banner-upload-errormsg' => 'Musíte vybrat obrázek pro nahrání',
	'adss-form-pick-plan-errormsg' => 'Musíte vybrat plán',
	'adss-form-pick-plan' => 'Vyberte si reklamní balíček',
	'adss-form-site-plan-header' => 'Koupit sponzorovaný odkaz na celé wiki',
	'adss-form-site-plan-description' => 'Získejte sponzorované odkazy na {{SITENAME}} za jednu nízkou cenu. 

1 sada je v současné době $1% sponzorovaných odkazů na {{SITENAME}} a stojí jen $2. Můžete to kdykoliv zrušit.',
	'adss-form-site-plan-price' => '$1 za 1 sadu',
	'adss-form-site-premium-plan-header' => 'Koupit 4 sady za cenu 3',
	'adss-form-site-premium-plan-description' => 'Získejte sponzorované odkazy na {{SITENAME}} a získejte ještě větší vystavení koupí v balíku. 

1 sada je v současné době $1% sponzorovaných odkazů na {{SITENAME}}. Takto koupíte 4 sady za cenu 3. Můžete to kdykoliv zrušit.',
	'adss-form-site-premium-plan-price' => 'Pouze $1 za 4 sady!',
	'adss-form-page-plan-header' => 'Koupit odkaz jen na jedné stránce',
	'adss-form-page-plan-description' => 'Toto Vám umožní zacílit vlastní zprávu na nejlepší stránku pro Váš produkt pouze za $1, a můžete to kdykoliv zrušit.',
	'adss-form-page-plan-price' => '$1 za odkaz',
	'adss-form-banner-plan-header' => 'Koupit sadu grafických bannerů 728x90 na vrchu wiki',
	'adss-form-banner-plan-description' => 'Získejte sadu bannerů na celé stránce za 1 nízkou cenu.',
	'adss-form-banner-plan-price' => '$1 za 1 sadu bannerů',
	'adss-form-or' => '- nebo -',
	'adss-form-thanks' => 'Děkujeme vám za sponzorství! Vaše reklama byla zakoupena a bude vystavena ručním schválení (do 48 hodin). 

[[Special:AdSS|Koupit]] další reklamu!',
	'adss-button-preview' => 'Náhled',
	'adss-button-edit' => 'Editovat',
	'adss-button-login' => 'Přihlásit se',
	'adss-button-login-buy' => 'Přihlaste se a koupit NYNÍ',
	'adss-button-save-pay' => 'Uložit a zaplatit',
	'adss-button-pay-paypal' => 'Platit přes PayPal',
	'adss-button-select' => 'Vybrat',
	'adss-button-buy-now' => 'Kup teď',
	'adss-button-save' => 'Uložit',
	'adss-button-cancel' => 'Storno',
	'adss-button-yes' => 'Ano',
	'adss-button-no' => 'Ne',
	'adss-buy-another' => 'Koupit další reklamu!',
	'adss-edit-thanks' => 'Změny na Vaší reklamě byly uloženy a budou použity po ručním schválení (do 48 hodin).',
	'adss-preview-header' => 'Náhled',
	'adss-preview-prompt' => 'Takhle bude Vaše reklama vypadat - klikněte na "{{int:adss-button-edit}}", pokud chcete provést změny, nebo "{{int:adss-button-save-pay}}" pro uložení a přechod na PayPal.',
	'adss-click-here' => 'Klikněte zde',
	'adss-paypal-redirect' => '$1, pokud nejste přesměrováni na PayPal do 5 sekund.',
	'adss-paypal-error' => 'Nepovedlo se vytvořit platbu PayPal. Zkuste to prosím později.

Návrat na [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Došlo k chybě. Zkuste to prosím později. 

Návrat na [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Všechny stránky',
	'adss-per-page' => 'Pouze jedna stránka',
	'adss-close' => 'Zavřít',
	'adss-cancel' => 'Zrušit',
	'adss-manager-tab-adList' => 'Vaše reklamy',
	'adss-manager-tab-billing' => 'Fakturace',
	'adss-admin-tab-adList' => 'Seznam reklam',
	'adss-admin-tab-billing' => 'Fakturace',
	'adss-admin-tab-reports' => 'Hlášení',
	'adss-not-logged-in' => 'Musíte se přihlásit.',
	'adss-wrong-id' => 'Špatné ID',
	'adss-no-permission' => 'Žádné povolení',
	'adss-canceled' => 'Zrušeno',
	'adss-rejected' => 'Odmítnuto',
	'adss-approved' => 'Schváleno',
	'adss-pending' => 'Zatím neurčeno',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Typ',
	'adss-no-shares' => '# sdílení',
	'adss-price' => 'Cena',
	'adss-ad' => 'Reklama',
	'adss-status' => 'Stav',
	'adss-created' => 'Vytvořeno',
	'adss-your-balance' => 'Nedoplatek:',
	'adss-your-billing-agreement' => 'SOuhlas účtování PayPal:',
	'adss-no-billing-agreement' => 'Není platné povolení k fakturaci přes PayPal. Prosím, vytvořte jej znovu.',
	'adss-create-billing-agreement' => 'Vytvořit svolení k fakturaci',
	'adss-cancel-billing-agreement-confirmation' => 'Jste si jisti, že chcete zrušit svolení k fakturaci? Bez toho nebudou Vaše reklamy v provozu.',
	'adss-billing-agreement-created' => 'Fakturační svolení bylo vytvořeno (BAID=$1). Vrátit se na [[Special:AdSS/manager/billing|přehled]].',
	'adss-billing-agreement-canceled' => 'Vaše fakturační svolení bylo úspěšně zrušeno. Návrat na [[Special:AdSS/manager/billing|přehled]].',
	'adss-paypal-payment' => 'Platba PayPal',
	'adss-adss-fee' => 'AdSS poplatek',
	'adss-adss-refund' => 'Vrácení poplatku za AdSS',
	'adss-fee' => 'Poplatek',
	'adss-paid' => 'Zaplaceno',
	'adss-timestamp' => 'Časové razítko',
	'adss-description' => 'Popis',
	'adss-amount' => '$$1',
	'adss-cancel-confirmation' => 'Jste si jisti, že chcete smazat tuto reklamu?',
	'adss-welcome-subject' => '[AdSS] Děkujeme za sponzorství!',
	'adss-welcome-body' => 'Dobrý den, 

Gratulujeme, váš účet je nastaven a vaše reklamy se začnou zobrazovat do 48 hodin. Můžete se přihlásit pomocí údajů níže, pokud chcete překontrolovat svůj reklamní text, nakoupit další reklamy, nebo zkontrolovat platbu. Faktury Wikia jsou posílány přes PayPal pokaždé, když utratíte $$4 a více. 

URL: $1 
Uživatelské jméno: $2 
Heslo: $3 

Uložte heslo na bezpečném místě. Pokud jej ztratíte, můžete kontaktujte zákaznickou podporu na adrese: http://www.wikia.com/wiki/Special:Contact a my vám pošleme heslo na Vaši e-mailovou adresu. 

-- 
Wikia tým',
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
	'adss-form-banner' => 'Lade dein Banner hier hoch:',
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
	'adss-form-banner-upload-errormsg' => 'Du musst ein Bild zum Hochladen auswählen',
	'adss-form-pick-plan-errormsg' => 'Du musst einen Plan auswählen',
	'adss-form-pick-plan' => 'Wähle eine Werbepaket',
	'adss-form-site-plan-header' => 'Kaufe einen Link über das ganze Wiki',
	'adss-form-site-plan-description' => 'Hol dir deine Links übers ganze Wiki für einen Tiefpreis.

1 Aktie entsprich momentan $1% der {{SITENAME}} gesponserten Links und kostet bloß $2. Du kannst jederzeit abbrechen.',
	'adss-form-site-plan-price' => '$1 für eine Aktie',
	'adss-form-site-premium-plan-header' => 'Kaufe 4 gesponserte Links zum Preis von 3',
	'adss-form-site-premium-plan-description' => 'Hol dir gesponserte Links auf {{SITENAME}} und erreiche sogar noch mehr Präsenz indem du einen ganzen Haufen kaufst.

1 Aktie entspricht derzeit $1% aller gesponserten Links auf {{SITENAME}}. Mit dieser Option kaufst du vier Aktien zum Preis von drei! Du kannst jederzeit kündigen.',
	'adss-form-site-premium-plan-price' => 'Nur $1 für vier Aktien!',
	'adss-form-page-plan-header' => 'Nur auf einer Seite einen Link kaufen',
	'adss-form-page-plan-description' => 'Hiermit kannst du für nur $1 eine personalisierte Anzeige auf der für dein Produkt besten Seite schalten, und du kannst jederzeit kündigen.',
	'adss-form-page-plan-price' => '$1 für einen Link',
	'adss-form-banner-plan-header' => 'Einen Bereich vom 728x90 Grafikbanner oben im Wiki kaufen',
	'adss-form-banner-plan-description' => 'Hol dir einen Anteil an den quer über die Webseite verteilten Bannern zu einem einzigen niedrigen Preis.',
	'adss-form-banner-plan-price' => '$1 für eine Aktie der Banner',
	'adss-form-or' => '- oder -',
	'adss-form-thanks' => 'Vielen Dank für dein Sponsoring!',
	'adss-button-preview' => 'Vorschau',
	'adss-button-edit' => 'Bearbeiten',
	'adss-button-login' => 'Anmelden',
	'adss-button-login-buy' => 'Anmelden und jetzt kaufen',
	'adss-button-save-pay' => 'Speichern',
	'adss-button-pay-paypal' => 'Mit PayPal bezahlen',
	'adss-button-select' => 'Auswählen',
	'adss-button-buy-now' => 'JETZT kaufen',
	'adss-button-save' => 'Speichern',
	'adss-button-cancel' => 'Abbrechen',
	'adss-button-yes' => 'Ja',
	'adss-button-no' => 'Nein',
	'adss-buy-another' => 'Eine weitere Anzeige kaufen!',
	'adss-edit-thanks' => 'Deine Ad-Änderungen wurden gespeichert und erscheinen nach manueller Genehmigung (innerhalb von 48 Stunden).',
	'adss-preview-header' => 'Vorschau',
	'adss-preview-prompt' => 'Hier siehst du, wie deine Patenschaft aussehen wird - klicke auf „Bearbeiten“, um Änderungen vorzunehmen, oder auf „Speichern“, um mit PayPal fortzufahren.',
	'adss-click-here' => 'Hier klicken',
	'adss-paypal-redirect' => '$1 wenn du nicht innerhalb von 5 Sekunden zu PayPal weitergeleitet wirst',
	'adss-paypal-error' => 'PayPal-Zahlung konnte dieses Mal nicht erstellt werden. Bitte versuche es später erneut.

Zurück zu [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Ein Fehler ist aufgetreten. Bitte versuche es später noch einmal.

Zurück zu [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Alle Seiten',
	'adss-per-page' => 'Nur eine Seite',
	'adss-close' => 'Schließen',
	'adss-cancel' => 'Abbrechen',
	'adss-manager-tab-adList' => 'Deine Anzeigen',
	'adss-manager-tab-billing' => 'Abrechnung',
	'adss-admin-tab-adList' => 'Liste der Anzeigen',
	'adss-admin-tab-billing' => 'Abrechnung',
	'adss-admin-tab-reports' => 'Berichte',
	'adss-not-logged-in' => 'Du musst eingeloggt sein',
	'adss-wrong-id' => 'Falsche ID',
	'adss-no-permission' => 'Keine Berechtigung',
	'adss-canceled' => 'Abgebrochen',
	'adss-rejected' => 'Abgelehnt',
	'adss-approved' => 'Angenommen',
	'adss-pending' => 'Ausstehend',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Typ',
	'adss-no-shares' => '# Aktien',
	'adss-price' => 'Preis',
	'adss-ad' => 'Anzeige',
	'adss-status' => 'Status',
	'adss-created' => 'Erstellt',
	'adss-your-balance' => 'Restbetrag:',
	'adss-your-billing-agreement' => 'PayPal Abrechnung Vereinbarung:',
	'adss-no-billing-agreement' => 'Keine gültige Paypal-Vereinbarung. Erstelle deine Abrechnungs-Vereinbarung erneut um deine Anzeigen am laufen zu halten.',
	'adss-create-billing-agreement' => 'Eine Abrechnungs-Vereinbarung erstellen',
	'adss-cancel-billing-agreement-confirmation' => 'Bist du dir sicher, dass du deine Abrechnungs-Vereinbarung abbrechen möchtest? Deine Anzeigen werden ohne gültige Paypal-Vereinbarung nicht mehr angezeigt.',
	'adss-billing-agreement-created' => 'Die Abrechnungs-Vereinbarung wurde erfolgreich erstellt (BAID=$1). Zurück zur [[Special:AdSS/manager/billing|Übersicht]].',
	'adss-billing-agreement-canceled' => 'Die Abrechnungs-Vereinbarung wurde erfolgreich abgebrochen. Zurück zur [[Special:AdSS/manager/billing|Übersicht]].',
	'adss-paypal-payment' => 'PayPal-Zahlung',
	'adss-adss-fee' => 'AdSS Gebühr',
	'adss-adss-refund' => 'AdSS Rückerstattung',
	'adss-fee' => 'Gebühr',
	'adss-paid' => 'Bezahlt',
	'adss-timestamp' => 'Zeitstempel',
	'adss-description' => 'Beschreibung',
	'adss-amount' => '$$1',
	'adss-cancel-confirmation' => 'Bist du sicher, dass du diese Anzeige löschen möchtest?',
	'adss-welcome-subject' => '[AdSS] Vielen Dank für dein Sponsoring!',
	'adss-welcome-body' => 'Hallo,

Herzlichen Glückwunsch, dein Konto ist eingerichtet und deine Anzeigen werden
innerhalb von 48 Stunden geschaltet. Du kannst dich mit den Angaben unten Einloggen
um deinen Anzeigentext zu überprüfen, zusätzliche Anzeigen zu kaufen oder deine Rechnung
zu überprüfen. Wikia Rechnungen werden per PayPal versendet, sobald du $$4 oder mehr
ausgegeben hast.

URL: $1
Benutzername: $2
Passwort: $3

Bewahre dein Passwort bitte an einem sicheren Ort auf.  Wenn du es verlierst, kannst du
den Kundendienst kontaktieren unter: http://www.wikia.com/wiki/Special:Contact und
wir senden dir das Passwort an deine bei uns gespeicherte E-Mail-Adresse.

--
Wikia Team',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Laximilian scoken
 */
$messages['de-formal'] = array(
	'adss-form-email' => 'Ihre E-Mail-Adresse:',
);

/** Greek (Ελληνικά)
 * @author Evropi
 */
$messages['el'] = array(
	'adss-ad-default-text' => 'Κάνετε κλικ εδώ!',
	'adss-form-header' => 'Σχεδιάστε διαφήμιση',
	'adss-form-login-link' => 'Είσοδος',
	'adss-form-login-desc' => 'Έχετε κωδικό πρόσβασης; $1 για να σώστε χρόνο και να αγοράσετε τη διαφήμιση με ένα κλικ!',
	'adss-form-usd-per-day' => '$$1 ανά ημέρα',
	'adss-form-usd-per-week' => '$$1 ανά εβδομάδα',
	'adss-form-usd-per-month' => '$$1 ανά μήνα',
	'adss-button-select' => 'Επιλογή',
	'adss-button-buy-now' => 'Αγοράστε ΤΩΡΑ',
	'adss-button-save' => 'Αποθήκευση',
	'adss-button-cancel' => 'Ακύρωση',
	'adss-button-yes' => 'Ναι',
	'adss-button-no' => 'Όχι',
	'adss-buy-another' => 'Αγοράστε κι άλλη διαφήμιση!',
	'adss-preview-header' => 'Προεπισκόπηση',
	'adss-click-here' => 'Κάνετε κλικ εδω',
	'adss-close' => 'Κλείσιμο',
	'adss-manager-tab-adList' => 'Οι διαφημίσεις σας',
	'adss-manager-tab-billing' => 'Χρέωση',
	'adss-admin-tab-adList' => 'Κατάλογος διαφημίσεων',
	'adss-type' => 'Τύπος',
	'adss-no-shares' => '# μετοχών',
	'adss-price' => 'Τιμή',
	'adss-ad' => 'Διαφήμιση',
	'adss-status' => 'Κατάσταση',
	'adss-created' => 'Δημιουργήθηκε',
);

/** Spanish (Español)
 * @author Absay
 * @author Crazymadlover
 * @author VegaDark
 */
$messages['es'] = array(
	'adss-desc' => 'Servicio de autopublicidad',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Enlaces patrocinados en Wikia',
	'adss-ad-header' => '<h2>Vínculos a patrocinador externo</h2>',
	'adss-ad-default-text' => '¡Clic aquí!',
	'adss-ad-default-desc' => 'Compra un enlace patrocinado y la descripción para tu sitio web en esta página. Date prisa, ¡los pocos lotes de patrocinio se venden rápido!',
	'adss-form-header' => 'Diseña tu publicidad',
	'adss-form-url' => 'URL del sitio wed del patrocinio (tu sitio web):',
	'adss-form-linktext' => 'Texto que deseas mostrar en el enlace:',
	'adss-form-additionaltext' => 'Texto que se muestra bajo tu enlace:',
	'adss-form-type' => 'Tipo de patrocinio:',
	'adss-form-page' => 'Página a patrocinar:',
	'adss-form-banner' => 'Sube tu publicidad aquí:',
	'adss-form-price' => 'Cantidad de patrocinio:',
	'adss-form-shares' => 'Número de acciones',
	'adss-form-email' => 'Tu dirección de correo electrónico:',
	'adss-form-password' => 'Tu contraseña:',
	'adss-form-login-link' => 'Inicia sesión',
	'adss-form-login-desc' => '¿Tienes una contraseña? ¡$1 para ahorrar tiempo y comprar la publicidad con un solo clic!',
	'adss-form-usd-per-day' => '$$1 (USD) por día',
	'adss-form-usd-per-week' => '$$1 (USD) por semana',
	'adss-form-usd-per-month' => '$$1 (USD) por mes',
	'adss-form-auth-errormsg' => 'Tu dirección de correo electrónico o contraseña es incorrecta.',
	'adss-form-field-empty-errormsg' => 'Este campo no debe estar vacío.',
	'adss-form-non-existent-title-errormsg' => 'Esta página no existe',
	'adss-form-banner-upload-errormsg' => 'Debes seleccionar una imagen para subir',
	'adss-form-pick-plan-errormsg' => 'Debes seleccionar un plan',
	'adss-form-pick-plan' => 'Escoge tu plan',
	'adss-form-site-plan-header' => 'Compra un enlace a través de toda la wiki',
	'adss-form-site-plan-description' => 'Consigue tus enlaces en toda la wiki por un bajo precio.

1 acción equivale actualmente a un $1% de los enlaces patrocinados en {{SITENAME}} y cuestan solamente $2. Puedes cancelarlo en cualquier momento.',
	'adss-form-site-plan-price' => '$1 por una acción',
	'adss-form-site-premium-plan-header' => 'Compra 4 enlaces de oferta por el precio de 3',
	'adss-form-site-premium-plan-description' => 'Consigue enlaces de oferta en {{SITENAME}} por un precio bajo y obtiene aún más visibilidad por la compra de más patrocinios.

1 acción actualmente equivale a $1% de enlaces patrocinados en {{SITENAME}}. ¡Con esta opción estás comprando cuatro acciones por el precio de tres! Puedes cancelarlo en cualquier momento.',
	'adss-form-site-premium-plan-price' => '¡Solamente $1 por cuatro acciones!',
	'adss-form-page-plan-header' => 'Compra un enlace en una sola página',
	'adss-form-page-plan-description' => 'Esto te permite dirigir un mensaje personalizado a la mejor página para tu producto por solo $1, y puedes cancelarlo en cualquier momento.',
	'adss-form-page-plan-price' => '$1 por un enlace',
	'adss-form-banner-plan-header' => 'Compra una acción de 728x90 pixeles en la parte superior de cada página',
	'adss-form-banner-plan-description' => 'Consigue una acción de los anuncios en toda la wiki por un bajo precio.',
	'adss-form-banner-plan-price' => '$1 por una acción de los anuncios',
	'adss-form-or' => '- o -',
	'adss-form-thanks' => '¡Gracias por su patrocinio! Su anuncio ha sido comprado y dentro de 48 horas entrará en funcionamiento después de activación manual.

¡[[Special:AdSS|Comprar]] otro anuncio!',
	'adss-button-preview' => 'Vista previa',
	'adss-button-edit' => 'Editar',
	'adss-button-login' => 'Inicia sesión',
	'adss-button-login-buy' => 'Inicia sesión y compra YA',
	'adss-button-save-pay' => 'Grabar',
	'adss-button-pay-paypal' => 'Pagar con PayPal',
	'adss-button-select' => 'Seleccionar',
	'adss-button-buy-now' => 'Comprar AHORA',
	'adss-button-save' => 'Guardar',
	'adss-button-cancel' => 'Cancelar',
	'adss-button-yes' => 'Sí',
	'adss-button-no' => 'No',
	'adss-buy-another' => '¡Compra otra publicidad!',
	'adss-preview-header' => 'Vista previa',
	'adss-preview-prompt' => 'Aquí está como tu patrocinio se verá - haz click en "Editar" para regresar y hacer cambios, o "Grabar" para guardarlo e ir a PayPal.',
	'adss-click-here' => 'Clic aquí',
	'adss-paypal-redirect' => '$1 si no eres redirigido a PayPal dentro de 5 segundos.',
	'adss-paypal-error' => 'No ha sido posible realizar el pago a través de PayPal en este momento. Por favor, inténtelo de nuevo más tarde.

Volver a [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Se produjo un error. Por favor, inténtelo de nuevo más tarde. 

Volver [[Special:AdSS|{{int:ADS}}]].',
	'adss-per-site' => 'Todas las páginas',
	'adss-per-page' => 'Una sola página',
	'adss-close' => 'Cerrar',
	'adss-cancel' => 'Cancelar',
	'adss-manager-tab-adList' => 'Tu publicidad',
	'adss-manager-tab-billing' => 'Facturación',
	'adss-admin-tab-adList' => 'Lista de anuncios',
	'adss-admin-tab-billing' => 'Facturación',
	'adss-admin-tab-reports' => 'Informes',
	'adss-not-logged-in' => 'Debes estas autenticado',
	'adss-wrong-id' => 'Identificación incorrecta',
	'adss-no-permission' => 'Ningún permiso',
	'adss-canceled' => 'Cancelado',
	'adss-rejected' => 'Rechazado',
	'adss-approved' => 'Aprobado',
	'adss-pending' => 'Pendiente',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Tipo',
	'adss-no-shares' => '# acciones',
	'adss-price' => 'Precio',
	'adss-ad' => 'Publicidad',
	'adss-status' => 'Estado',
	'adss-created' => 'Creada',
	'adss-paypal-payment' => 'Pago mediante PayPal',
	'adss-adss-fee' => 'Tarifa de AdSS',
	'adss-fee' => 'Tarifa',
	'adss-paid' => 'Pago',
	'adss-timestamp' => 'Fecha y hora',
	'adss-description' => 'Descripción',
	'adss-amount' => '$$1 (USD)',
	'adss-welcome-subject' => '[AdSS] ¡Gracias por tu patrocinio!',
	'adss-welcome-body' => 'Hola,

Felicitaciones, tu cuenta está configurada y tu publicidad comenzará
dentro de 48 horas. Puedes iniciar sesión usando los detalles de abajo
para revisar el texto de tus anuncios, comprar anuncios adicionales o
revisar tu factura. Las facturas de Wikia son enviadas por PayPal
cuando hayas gastado $$4 (USD) o más.

URL: $1
Nombre de usuario: $2
Contraseña: $3

Guarda tu contraseña en un lugar seguro. Si la pierdes, puedes
contactar al servicio al cliente en: http://www.wikia.com/wiki/Special:Contact
y te enviaremos la contraseña a tu correo electrónico en un archivo.

-- 
Equipo de Wikia',
);

/** French (Français)
 * @author Peter17
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'adss-desc' => 'Publicité en libre-service',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Liens sponsorisés sur Wikia',
	'adss-ad-header' => '<h2>Liens externes vers les parrains</h2>',
	'adss-ad-default-text' => 'Cliquez ici !',
	'adss-ad-default-desc' => 'Achetez un lien sponsorisé et une description pour vos sites web sur cette page. Agissez vite, les quelques offres de parrainage se vendent vite !',
	'adss-form-header' => 'Concevez votre annonce',
	'adss-form-url' => 'Adresse URL du site parrain (votre site web) :',
	'adss-form-linktext' => 'Texte que vous voulez afficher dans le lien :',
	'adss-form-additionaltext' => 'Texte à afficher sous votre lien :',
	'adss-form-type' => 'Type de parrainage :',
	'adss-form-page' => 'Page à parrainer :',
	'adss-form-banner' => 'Téléversez votre bannière ici :',
	'adss-form-price' => 'Montant du parrainage :',
	'adss-form-shares' => 'Nombre d’actions :',
	'adss-form-email' => 'Votre adresse de courriel :',
	'adss-form-password' => 'Votre mot de passe :',
	'adss-form-login-link' => 'Connectez-vous',
	'adss-form-login-desc' => 'Vous avez un mot de passe ? $1 pour gagner du temps et acheter de la publicité en un clic !',
	'adss-form-usd-per-day' => '$1 USD par jour',
	'adss-form-usd-per-week' => '$1 USD par semaine',
	'adss-form-usd-per-month' => '$1 USD par mois',
	'adss-form-auth-errormsg' => 'Votre adresse de courriel ou votre mot de passe est incorrect.',
	'adss-form-field-empty-errormsg' => 'Ce champ ne doit pas être vide',
	'adss-form-non-existent-title-errormsg' => 'Cette page n’existe pas',
	'adss-form-banner-upload-errormsg' => 'Vous devez sélectionner une image à téléverser',
	'adss-form-pick-plan-errormsg' => 'Vous devez sélectionner un plan de campagne',
	'adss-form-pick-plan' => 'Choisissez un forfait d’annonce',
	'adss-form-site-plan-header' => 'Acheter un lien exposé sur l’ensemble du wiki',
	'adss-form-site-plan-description' => 'Obtenez des liens parrainés sur {{SITENAME}} pour un prix modique.

1 part représente actuellement $1&nbsp;% des liens parrainés sur {{SITENAME}} et ne coûte que $2. Vous pouvez annuler à tout moment.',
	'adss-form-site-plan-price' => 'Une part coûte $1',
	'adss-form-site-premium-plan-header' => 'Acheter 4 liens parrainés pour le prix de 3',
	'adss-form-site-premium-plan-description' => 'Obtenez des liens parrainés sur {{SITENAME}} et soyez plus visible en achetant en gros.

1 part représente actuellement $1&nbsp;% des liens parrainés sur {{SITENAME}}. Avec cette option, vous achetez quatre parts au prix de trois ! Vous pouvez annuler à tout moment.',
	'adss-form-site-premium-plan-price' => 'Seulement $1 pour quatre parts !',
	'adss-form-page-plan-header' => 'Acheter un lien uniquement sur une page',
	'adss-form-page-plan-description' => 'Ceci vous permet de cibler avec un message personnalisé la meilleure page pour votre produit, à seulement $1. Vous pouvez l’annuler à tout moment.',
	'adss-form-page-plan-price' => '$1 pour un lien',
	'adss-form-banner-plan-header' => 'Acheter une part des bannières graphiques 728x90 en haut du wiki',
	'adss-form-banner-plan-description' => 'Obtenez une part des bannières affichées sur le wiki pour un prix modique.',
	'adss-form-banner-plan-price' => '$1 pour une part des bannières',
	'adss-form-or' => '– ou –',
	'adss-form-thanks' => 'Merci pour votre parrainage ! Votre annonce a été achetée et sera effective après une approbation manuelle (dans les 48 heures).

Allez [[Special:AdSS|acheter]] une autre annonce !',
	'adss-button-preview' => 'Prévisualisation',
	'adss-button-edit' => 'Modifier',
	'adss-button-login' => 'Connexion',
	'adss-button-login-buy' => 'Connectez-vous et achetez MAINTENANT',
	'adss-button-save-pay' => 'Enregistrer et payer',
	'adss-button-pay-paypal' => 'Payer avec PayPal',
	'adss-button-select' => 'Sélectionner',
	'adss-button-buy-now' => 'Acheter MAINTENANT',
	'adss-button-save' => 'Enregistrer',
	'adss-button-cancel' => 'Annuler',
	'adss-button-yes' => 'Oui',
	'adss-button-no' => 'Non',
	'adss-buy-another' => 'Acheter une autre annonce !',
	'adss-edit-thanks' => 'Vos modifications ont été enregistrées et seront effectives après approbation manuelle (dans les 48 heures).',
	'adss-preview-header' => 'Prévisualisation',
	'adss-preview-prompt' => 'Voici à quoi votre parrainage ressemblera. Cliquez sur « modifier » pour revenir et apporter des changements ou sur « sauvegarder » pour enregistrer et vous rendre sur PayPal.',
	'adss-click-here' => 'Cliquez ici',
	'adss-paypal-redirect' => '$1 si vous n’êtes pas redirigé vers PayPal dans 5 secondes.',
	'adss-paypal-error' => 'Impossible de payer avec PayPal en ce moment. Veuillez essayer plus tard.

Retourner à [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Une erreur est survenue. Veuillez réessayer plus tard.

Retourner à [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Toutes les pages',
	'adss-per-page' => 'Une seule page',
	'adss-close' => 'Fermer',
	'adss-cancel' => 'Annuler',
	'adss-manager-tab-adList' => 'Vos annonces',
	'adss-manager-tab-billing' => 'Facturation',
	'adss-admin-tab-adList' => 'Liste des annonces',
	'adss-admin-tab-billing' => 'Facturation',
	'adss-admin-tab-reports' => 'Rapports',
	'adss-not-logged-in' => 'Vous devez être connecté',
	'adss-wrong-id' => 'Identifiant incorrect',
	'adss-no-permission' => 'Aucune autorisation',
	'adss-canceled' => 'Annulé',
	'adss-rejected' => 'Rejeté',
	'adss-approved' => 'Approuvé',
	'adss-pending' => 'En attente',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Type',
	'adss-no-shares' => 'Nb. de parts',
	'adss-price' => 'Prix',
	'adss-ad' => 'Annonce',
	'adss-status' => 'État',
	'adss-created' => 'Créé',
	'adss-your-balance' => 'Solde dû :',
	'adss-your-billing-agreement' => 'Accord de facturation PayPal :',
	'adss-no-billing-agreement' => 'Aucun accord valide de Paypal. Recréez l’accord de facturation afin que vos annonces restent diffusées.',
	'adss-create-billing-agreement' => 'Créer un accord de facturation',
	'adss-cancel-billing-agreement-confirmation' => 'Êtes-vous sûr{{GENDER:||e|}} de vouloir annuler l’accord de facturation ? Vos annonces cesseront d’être diffusées sans un accord de facturation valide de Paypal.',
	'adss-billing-agreement-created' => 'L’accord de facturation a été créé avec succès (BAID=$1). Revenir au [[Special:AdSS/manager/billing|tableau de bord]].',
	'adss-billing-agreement-canceled' => 'L’accord de facturation a été annulé avec succès. Revenir au [[Special:AdSS/manager/billing|tableau de bord]].',
	'adss-paypal-payment' => 'Paiement PayPal',
	'adss-adss-fee' => 'Frais de AdSS',
	'adss-adss-refund' => 'Remboursement AdSS',
	'adss-fee' => 'Frais',
	'adss-paid' => 'Payé',
	'adss-timestamp' => 'Horodatage',
	'adss-description' => 'Description',
	'adss-amount' => '$1&nbsp;$',
	'adss-cancel-confirmation' => 'Êtes vous sûr{{GENDER:||e|}} de vouloir supprimer cette annonce ?',
	'adss-welcome-subject' => '[AdSS] Merci pour votre parrainage !',
	'adss-welcome-body' => 'Bonjour, 

Félicitations, votre compte est créé et vos annonces commenceront à
paraître dans les 48 heures. Vous pouvez vous connecter en utilisant les
coordonnées ci-dessous pour vérifier votre texte d’annonce, acheter
d’autres annonces ou consulter sur votre facture. Les factures Wikia sont
adressées via Paypal à chaque fois que vous avez dépensé $4&nbsp;$ ou plus.

Adresse URL : $1 
Nom d’utilisateur : $2 
Mot de passe : $3

Veuillez enregistrer votre mot de passe dans un emplacement sécurisé.
Si vous le perdez, vous pouvez contacter le support client sur
http://www.wikia.com/wiki/Special:Contact et nous enverrons le mot de passe
associé à votre adresse de courriel dans nos fichiers. 

-- 
L’équipe Wikia',
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
	'adss-button-save' => 'Gardar',
	'adss-button-cancel' => 'Cancelar',
	'adss-button-yes' => 'Si',
	'adss-button-no' => 'Non',
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
	'adss-cancel-confirmation' => 'Está seguro de querer borrar este anuncio?',
	'adss-welcome-subject' => '[AdSS] Grazas polo seu patrocinio!',
);

/** Hebrew (עברית)
 * @author שומבלע
 */
$messages['he'] = array(
	'adss-button-preview' => 'תצוגה מקדימה',
	'adss-button-edit' => 'עריכה',
	'adss-button-login' => 'כניסה לחשבון',
	'adss-button-pay-paypal' => 'תשלום עם PayPal',
	'adss-button-select' => 'בחירה',
	'adss-button-save' => 'שמירה',
	'adss-button-cancel' => 'ביטול',
	'adss-button-yes' => 'כן',
	'adss-button-no' => 'לא',
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
	'adss-form-banner' => 'Incarga hic vostre bandiera:',
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
	'adss-form-banner-upload-errormsg' => 'Vos debe seliger un imagine a incargar',
	'adss-form-pick-plan-errormsg' => 'Tu debe seliger un plano',
	'adss-form-pick-plan' => 'Selige un pacchetto de publicitate',
	'adss-form-site-plan-header' => 'Compra un ligamine in tote le wiki',
	'adss-form-site-plan-description' => 'Diffunde vostre ligamines in tote le wiki pro un sol precio basse.

1 parte equala actualmente $1% del ligamines sponsorisate de {{SITENAME}} e costa solmente $2. Vos pote cancellar a omne momento.',
	'adss-form-site-plan-price' => '$1 per parte',
	'adss-form-site-premium-plan-header' => 'Compra 4 ligamines sponsorisate pro le precio de 3',
	'adss-form-site-premium-plan-description' => 'Face circular vostre ligamines sponsorisate in {{SITENAME}}, e augmenta le diffusion per comprar in massa.

1 parte equala actualmente $1% del ligamines sponsorisate de {{SITENAME}}. Con iste option, vos compra quatro partes pro le precio de tres! Vos pote cancellar a omne momento.',
	'adss-form-site-premium-plan-price' => 'Solmente $1 pro quatro partes!',
	'adss-form-page-plan-header' => 'Acquire un ligamine sur un sol pagina',
	'adss-form-page-plan-description' => 'Isto permitte diriger un message personalisate al optime pagina pro vostre producto pro solmente $1, e vos pote cancellar a omne momento.',
	'adss-form-page-plan-price' => '1 ligamine costa $1',
	'adss-form-banner-plan-header' => 'Compra un parte del bandieras graphic 728×90 situate in le parte superior del wiki',
	'adss-form-banner-plan-description' => 'Obtene un parte del bandieras circulante trans le sito pro un sol precio basse.',
	'adss-form-banner-plan-price' => '$1 pro un sol parte del bandieras',
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
	'adss-button-buy-now' => 'Comprar ORA',
	'adss-button-save' => 'Salveguardar',
	'adss-button-cancel' => 'Cancellar',
	'adss-button-yes' => 'Si',
	'adss-button-no' => 'No',
	'adss-buy-another' => 'Compra un altere annuncio!',
	'adss-edit-thanks' => 'Le modificationes a vostre annuncio ha essite salveguardate e entrara in circulation post approbation manual (intra 48 horas).',
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
	'adss-your-balance' => 'Saldo debite:',
	'adss-your-billing-agreement' => 'Contracto de facturation PayPal:',
	'adss-no-billing-agreement' => 'Non es un contracto valide de PayPal. Recrea vostre contracto de facturation pro continuar le circulation de vostre annuncios.',
	'adss-create-billing-agreement' => 'Crea un contracto de facturation',
	'adss-cancel-billing-agreement-confirmation' => 'Es vos secur de voler cancellar vostre contracto de facturation? Vostre annuncios essera retirate del circulation sin contracto valide de PayPal.',
	'adss-billing-agreement-created' => 'Le contracto de facturation ha essite create con successo (BAID=$1). Retorna a [[Special:AdSS/manager/billing|le tabuliero de instrumentos]].',
	'adss-billing-agreement-canceled' => 'Vostre contracto de facturation ha essite cancellate con successo. Retorna a [[Special:AdSS/manager/billing|le tabuliero de instrumentos]].',
	'adss-paypal-payment' => 'Pagamento via PayPal',
	'adss-adss-fee' => 'Costos de AdSS',
	'adss-adss-refund' => 'Reimbursamento AdSS',
	'adss-fee' => 'Costos',
	'adss-paid' => 'Pagate',
	'adss-timestamp' => 'Data e hora',
	'adss-description' => 'Description',
	'adss-amount' => '$$1',
	'adss-cancel-confirmation' => 'Es vos secur de voler deler iste annuncio?',
	'adss-welcome-subject' => '[AdSS] Gratias pro esser sponsor!',
	'adss-welcome-body' => 'Salute,

Congratulationes, vostre conto es installate e vostre annuncios comenciara a
circular intra 48 horas. Vos pote aperir session usante le detalios hic infra
pro re-verificar le texto de vostre annuncio, comprar additional annuncios o
revider vostre factura. Le facturas de Wikia es inviate via PayPal cata vice
que vos expende $$4 o plus.
	
URL: $1
Nomine de usator: $2
Contrasigno: $3

Per favor salveguarda vostre contrasigno in un loco secur. Si vos lo perde,
vos pote contactar le servicio pro clientes a:
http://www.wikia.com/wiki/Special:Contact
e nos vos inviara le contrasigno al adresse de e-mail registrate.

-- 
Le equipa de Wikia',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'adss-button-edit' => 'Rüwa',
	'adss-button-save-pay' => 'Donyéré',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'adss-form-password' => 'Şîfreya te:',
	'adss-form-usd-per-day' => 'rojê $$1',
	'adss-form-usd-per-week' => 'hefteyê $$1',
	'adss-form-usd-per-month' => 'mehê $$1',
	'adss-form-or' => '-an-',
	'adss-button-preview' => 'Pêşdîtin',
	'adss-button-edit' => 'Biguherîne',
	'adss-button-login' => 'Têkeve',
	'adss-button-login-buy' => 'Têkeve û NIHA bikirre',
	'adss-button-select' => 'Bijêre',
	'adss-button-save' => 'Qeyd bike',
	'adss-button-cancel' => 'Betal bike',
	'adss-button-yes' => 'Erê',
	'adss-button-no' => 'Na',
	'adss-preview-header' => 'Pêşdîtin',
	'adss-per-site' => 'Hêmû rûpel',
	'adss-cancel' => 'Betal bike',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'adss-ad-header' => '<h2>Linke vun externe Sponsoren</h2>',
	'adss-ad-default-text' => 'Klickt hei!',
	'adss-form-page' => 'Säit fir ze sponsoren:',
	'adss-form-email' => 'Är E-Mailadress:',
	'adss-form-password' => 'Äert Passwuert:',
	'adss-form-usd-per-day' => '$$1 pro Dag',
	'adss-form-usd-per-week' => '$$1 pro Woch',
	'adss-form-usd-per-month' => '$$1 pro Mount',
	'adss-form-non-existent-title-errormsg' => 'Dës Säit gëtt et net',
	'adss-form-or' => '- oder -',
	'adss-button-edit' => 'Änneren',
	'adss-button-save-pay' => 'Späicheren',
	'adss-button-save' => 'Späicheren',
	'adss-button-yes' => 'Jo',
	'adss-button-no' => 'Neen',
	'adss-click-here' => 'Hei klicken',
	'adss-per-site' => 'All Säiten',
	'adss-type' => 'Typ',
	'adss-price' => 'Präis',
	'adss-description' => 'Beschreiwung',
	'adss-amount' => '$1&nbsp;$',
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
	'adss-form-banner' => 'Подигнете го вашиот плакат тука:',
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
	'adss-form-banner-upload-errormsg' => 'Ќе мора да одберете слика за подигање',
	'adss-form-pick-plan-errormsg' => 'Мора да изберете план',
	'adss-form-pick-plan' => 'Одберете рекламен пакет',
	'adss-form-site-plan-header' => 'Купете врска за сите страници на викито',
	'adss-form-site-plan-description' => 'Набавете врски за цело вики за една, ниска цена.

1 акција моментално вреди $1% спонзорирани врски на {{SITENAME}}, и чини само $2. Ова можете да го откажете во секое време.',
	'adss-form-site-plan-price' => '$1 за една акција',
	'adss-form-site-premium-plan-header' => 'Добијте 4 спонзорирани врски, а платете само за 3',
	'adss-form-site-premium-plan-description' => 'Набавете спонзорирани врски на {{SITENAME}} и стекнете уште повеќе истакнатост со набавка на дополнителни акции.

1 акција моментално вреди $1% спонзорирани врски на {{SITENAME}}. Со оваа можност купувате три, а добивате четири акции! Можете да ги откажете во секое време.',
	'adss-form-site-premium-plan-price' => 'Само $1 за четири акции!',
	'adss-form-page-plan-header' => 'Купете врска само на една страница',
	'adss-form-page-plan-description' => 'Со ова можете да составите прилагодена порака за страницата што е најпогодна за вашиот производ, и тоа за само $1. Ова можете да го откажете во секое време.',
	'adss-form-page-plan-price' => '1 врска чини $1',
	'adss-form-banner-plan-header' => 'Купете акции за графичките плакати со 728x90 пикс. во најгорниот дел на викито',
	'adss-form-banner-plan-description' => 'Купете акции за плакатите што се истакнуваат на целото вики за една ниска цена.',
	'adss-form-banner-plan-price' => '$1 по акција',
	'adss-form-hub-plan-header' => 'Купи спонзорирана врска низ сите викија на $1',
	'adss-form-hub-plan-description' => 'Купете спонзорирани врски на сите (над $2) викија на $1 по една ниска цена.

Ова ви овозможува поголема изложеност бидејќи рекламата се прикажува на сите викија од истото собиралиште.',
	'adss-form-hub-plan-price' => '$1 за една акција',
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
	'adss-button-buy-now' => 'Купете СЕГА',
	'adss-button-save' => 'Зачувај',
	'adss-button-cancel' => 'Откажи',
	'adss-button-yes' => 'Да',
	'adss-button-no' => 'Не',
	'adss-buy-another' => 'Купете друга реклама!',
	'adss-edit-thanks' => 'Промените во вашите реклами се зачувани и ќе се прикажат откако ќе бидат рачно одобрени (во рок од 48 часа).',
	'adss-preview-header' => 'Преглед',
	'adss-preview-prompt' => 'Вака ќе изгледа вашет оспонзорство - кликнете на „Уреди“ за да се вратите и направите промени, или на „Зачувај“ за да го зачувате и да прејдете на PayPal.',
	'adss-click-here' => 'Кликнете тука',
	'adss-paypal-redirect' => '$1 ако системот не ве одведе на PayPal во рок од 5 секунди.',
	'adss-paypal-error' => 'Не можев да го создадам плаќањето со PayPal. Обидете се подоцна.

Назад кон [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Се појави грешка. Обидете се подоцна.

Назад кон [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Сите страници',
	'adss-per-hub' => 'Собиралиште',
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
	'adss-your-balance' => 'Износ:',
	'adss-your-billing-agreement' => 'Договор за наплата од PayPal:',
	'adss-no-billing-agreement' => 'Нема полноважен договор со PayPal. Направете го одново за да продолжат да течат рекламите.',
	'adss-create-billing-agreement' => 'Создај договор за наплата',
	'adss-cancel-billing-agreement-confirmation' => 'Дали сте сигурни дека сакате да го откажете договорот за наплата? Вашите реклами ќе престанат да течат доколку немате полноважен договор со PayPal.',
	'adss-billing-agreement-created' => 'Договорот за наплата е успешно направен (BAID=$1). Назад кон [[Special:AdSS/manager/billing|таблата]].',
	'adss-billing-agreement-canceled' => 'Договорот за наплата е успешно откажан. Назад кон [[Special:AdSS/manager/billing|таблата]].',
	'adss-paypal-payment' => 'Плаќање со PayPal',
	'adss-adss-fee' => 'Провизија за AdSS',
	'adss-adss-refund' => 'AdSS - Повраток',
	'adss-fee' => 'Провизија',
	'adss-paid' => 'Платено',
	'adss-timestamp' => 'Датум и време',
	'adss-description' => 'Опис',
	'adss-amount' => '$$1',
	'adss-cancel-confirmation' => 'Дали сте сигурни дека сакате да ја избришете рекламава?',
	'adss-welcome-subject' => '[AdSS] Ви благодариме на спонзорството!',
	'adss-welcome-body' => 'Здраво,

Congratulations, сметката е поставена и вашите реклами ќе почнат
да течат во рок 48 часа. Можете да се најавите со долунаведените податоци
за уште еднаш да го проверите текстот на рекламите, да купите уште реклами, или да
ја прегледате вашата сметка. Сметките ги праќаме преку Paypal секојпат кога ќе потрошите
барем $$4.

URL: $1
Корисничко име: $2
Лозинка: $3

Зачувајте си ја лозинката на некое безбедно место.  Ако ја изгубите, можете
да се обратите на: http://www.wikia.com/wiki/Special:Contact
и ние ќе ви ја испратиме лозинката по заведената е-пошта.

-- 
Екипата на Викија',
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
	'adss-form-banner' => 'Upload uw banner hier:',
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
	'adss-form-banner-upload-errormsg' => 'U moet een te uploaden afbeelding kiezen',
	'adss-form-pick-plan-errormsg' => 'U moet een propositie kiezen',
	'adss-form-pick-plan' => 'Kies een advertentiepakket',
	'adss-form-site-plan-header' => 'Koop een verwijzing in de hele wiki',
	'adss-form-site-plan-description' => 'Laat uw verwijzing weergeven in de hele wiki voor één lage prijs.

Eén aandeel staat momenteel gelijk aan $1% van de gesponsorde verwijzingen in {{SITENAME}} en kost maar $2.
U kunt op ieder moment annuleren.',
	'adss-form-site-plan-price' => '$1 voor één aandeel',
	'adss-form-site-premium-plan-header' => 'Koop 4 gesponsorde verwijzingen voor de prijs van 3',
	'adss-form-site-premium-plan-description' => 'Koop gesponsorde verwijzigingen op {{SITENAME}} en krijg nog meer zichtbaarheid door bulk in te kopen.

Eén aandeel staat op het moment gelijk aan $1% van de gesponsorde verwijzingen in {{SITENAME}}.
Met deze optie koopt u vier aandelen voor de prijs van drie!
U kunt op ieder moment opzeggen.',
	'adss-form-site-premium-plan-price' => 'Slechts $1 voor vier aandelen!',
	'adss-form-page-plan-header' => 'Koop een verwijzing op één pagina',
	'adss-form-page-plan-description' => 'Laat u een aangepast bericht kiezen voor de beste pagina voor uw product voor slechts $1 en u kunt op ieder gewenst moment annuleren.',
	'adss-form-page-plan-price' => 'Een verwijzing kost $1',
	'adss-form-banner-plan-header' => 'Koop een aandeel van de grafische banners van 728x90 bovenaan de wiki',
	'adss-form-banner-plan-description' => 'Koop een aandeel in de banners die in de hele wiki worden weergeven voor één lage prijs.',
	'adss-form-banner-plan-price' => '$1 voor één aandeel van de banners',
	'adss-form-hub-plan-header' => "Koop een gesponsorde verwijzing in alle $1 wiki's",
	'adss-form-hub-plan-description' => "Koop gesponsorde verwijzingen op alle (meer dan $2) $1 wiki's voor één lage prijs.

Hiermee bereikt u meer publiek doordat uw advertentie op andere wiki's van dezelfde hub wordt weergegeven.",
	'adss-form-hub-plan-price' => '$1 voor één aandeel',
	'adss-form-or' => '- of -',
	'adss-form-thanks' => 'Dank u wel voor uw sponsoring! Uw advertentie is aangekocht en wordt weergegeven na handmatige goedkeuring (binnen 48 uur).

U kunt [[Special:AdSS|nog een advertentie kopen]]!',
	'adss-button-preview' => 'Voorvertoning',
	'adss-button-edit' => 'Bewerken',
	'adss-button-login' => 'Aanmelden',
	'adss-button-login-buy' => 'Aanmelden en NU kopen',
	'adss-button-save-pay' => 'Opslaan',
	'adss-button-pay-paypal' => 'Betalen met PayPal',
	'adss-button-select' => 'Selecteren',
	'adss-button-buy-now' => 'NU kopen',
	'adss-button-save' => 'Opslaan',
	'adss-button-cancel' => 'Annuleren',
	'adss-button-yes' => 'Ja',
	'adss-button-no' => 'Nee',
	'adss-buy-another' => 'Nog een advertentie kopen!',
	'adss-edit-thanks' => 'De wijzigingen aan uw advertentie zijn opgeslagen en worden weergegeven na handmatige goedkeuring (binnen 48 uur).',
	'adss-preview-header' => 'Voorvertoning',
	'adss-preview-prompt' => 'Dit is een voorvertoning van uw sponsoring. Klik op "Bewerken" om terug te gaan en wijzigingen aan te brengen of klik op "Opslaan" om naar PayPal te gaan.',
	'adss-click-here' => 'Klik hier',
	'adss-paypal-redirect' => '$1 als u binnen vijf seconden niet wordt doorverwezen naar PayPal.',
	'adss-paypal-error' => 'Het was niet mogelijk een PayPalbetaling te maken. Probeer het later opnieuw. 

Terugkeren naar [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Er is een fout opgetreden. Probeer het later opnieuw.

Terug naar [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => "Alle pagina's",
	'adss-per-hub' => 'Hub',
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
	'adss-your-balance' => 'Verschuldigde saldo:',
	'adss-your-billing-agreement' => 'PayPal facturatieovereenkomst:',
	'adss-no-billing-agreement' => 'Dit is geen geldige PayPal-overeenkomst. Maak uw facturatieovereenkomst opnieuw om uw advertenties weergegeven te laten worden.',
	'adss-create-billing-agreement' => 'Facturatieovereenkomt maken',
	'adss-cancel-billing-agreement-confirmation' => 'Weet u zeker dat u uw facturtieovereenkomst wilt annuleren? Uw advertenties worden niet langer weergegeven zonder geldige PayPal-overeenkomst.',
	'adss-billing-agreement-created' => 'De facturatieovereenkomst is aangemaakt (BAID=$1). Ga terug naar het [[Special:AdSS/manager/billing|dashboard]].',
	'adss-billing-agreement-canceled' => 'Uw facturatieovereenkomst is geannuleerd. Ga terug naar het [[Special:AdSS/manager/billing|dashboard]].',
	'adss-paypal-payment' => 'PayPal-betaling',
	'adss-adss-fee' => 'Kosten AdSS',
	'adss-adss-refund' => 'AdSS terugbetaling',
	'adss-fee' => 'Kosten',
	'adss-paid' => 'Betaald',
	'adss-timestamp' => 'Tijdstip',
	'adss-description' => 'Beschrijving',
	'adss-amount' => '$$1',
	'adss-cancel-confirmation' => 'Weet u zeker dat u deze advertentie wilt verwijderen?',
	'adss-welcome-subject' => '[AdSS] Dank u wel voor uw sponsoring!',
	'adss-welcome-body' => 'Hallo,

Gefeliciteerd. Uw account is ingeregeld en uw advertenties worden
binnen 48 uur weergegeven. U kunt aanmelden gegevens hieronder
en uw advertentietekst controleren, extra advertenties kopen of uw
factuur controleren. Facturen van Wikia worden verzonden via PayPal,
iedere keer dat u USD $4 of meer besteedt.

URL: $1
Gebruikersnaam: $2
Wachtwoord: $3

Sal uw wachtwoord op een veilige plaats op. Als u het verliest, kunt
u contact opnemen met de klantenservice via
http://www.wikia.com/wiki/Special:Contact. We sturen u dan uw
wachtwoord toe op het bij ons geregistreerd staande e-mailadres.

--
Het Wikia-team',
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
	'adss-form-header' => 'Utform annonsen din',
	'adss-form-url' => 'URL for det sponsende nettstedet (ditt nettsted):',
	'adss-form-linktext' => 'Tekst som skal vises i lenken:',
	'adss-form-additionaltext' => 'Tekst som skal vises under lenken din:',
	'adss-form-type' => 'Sponsingstype:',
	'adss-form-page' => 'Side som skal sponses:',
	'adss-form-banner' => 'Last opp banneret ditt her:',
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
	'adss-form-banner-upload-errormsg' => 'Du må velge et bilde å laste opp',
	'adss-form-pick-plan-errormsg' => 'Du må velge en plan',
	'adss-form-pick-plan' => 'Velg en annonse-pakke',
	'adss-form-site-plan-header' => 'Kjøp en lenke over hele wikien',
	'adss-form-site-plan-description' => 'Få lenkene dine over hele wikien til én lav pris.

1 aksje er for øyeblikket tilsvarende $1 % av {{SITENAME}}-sponsede lenker og koster kun $2. Du kan avbestille når som helst.',
	'adss-form-site-plan-price' => '$1 for én aksje',
	'adss-form-site-premium-plan-header' => 'Kjøp fire sponsede lenker til prisen av tre',
	'adss-form-site-premium-plan-description' => 'Få sponsede lenker på {{SITENAME}} og få enda mer eksponering ved å kjøpe flere aksjer samtidig. 

1 aksje tilsvarer for øyeblikket $1 % av {{SITENAME}}-sponsede lenker. Med dette alternativet kjøper du fire aksjer til prisen av tre! Du kan avbestille når som helst.',
	'adss-form-site-premium-plan-price' => 'Kun $1 for fire aksjer!',
	'adss-form-page-plan-header' => 'Kjøp en lenke på kun én side',
	'adss-form-page-plan-description' => 'Dette lar deg velge en egen melding til den beste siden for ditt produkt kun på $1, og du kan avbestille når som helst.',
	'adss-form-page-plan-price' => '1 lenke koster $1',
	'adss-form-banner-plan-header' => 'Kjøp en andel av 728x90-bannerene på toppen av denne wikien',
	'adss-form-banner-plan-description' => 'Få en andel av bannerene over hele wikien for én lav pris.',
	'adss-form-banner-plan-price' => '$1 for en banner-aksje',
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
	'adss-button-buy-now' => 'Kjøp NÅ',
	'adss-button-save' => 'Lagre',
	'adss-button-cancel' => 'Avbryt',
	'adss-button-yes' => 'Ja',
	'adss-button-no' => 'Nei',
	'adss-buy-another' => 'Kjøp en annonse til!',
	'adss-edit-thanks' => 'Annonseendringen din har blitt lagret og vil tre i kraft etter manuell godkjenning (innen 48 timer).',
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
	'adss-your-balance' => 'Balanse forfaller:',
	'adss-your-billing-agreement' => 'Avtale for PayPal-fakturering:',
	'adss-no-billing-agreement' => 'Ingen gyldig PayPal-avtale. Gjenopprett faktureringsavtalen din for å holde annonsene dine oppe.',
	'adss-create-billing-agreement' => 'Opprett en faktureringsavtale',
	'adss-cancel-billing-agreement-confirmation' => 'Er du sikker på at du vil avbryte faktureringsavtalen? Annonsene dine vil slutte å kjøre uten en gyldig PayPal-avtale.',
	'adss-billing-agreement-created' => 'Faktureringsavtalen har blitt opprettet (BAID=$1). Returner til [[Special:AdSS/manager/billing|dashbordet]].',
	'adss-billing-agreement-canceled' => 'Faktureringsavtalen har blitt avbrutt. Returner til [[Special:AdSS/manager/billing|dashbordet]].',
	'adss-paypal-payment' => 'PayPal-betaling',
	'adss-adss-fee' => 'AdSS-gebyr',
	'adss-adss-refund' => 'AdSS-refusjon',
	'adss-fee' => 'Gebyr',
	'adss-paid' => 'Betalt',
	'adss-timestamp' => 'Tidsangivelse',
	'adss-description' => 'Beskrivelse',
	'adss-amount' => '$1 $',
	'adss-cancel-confirmation' => 'Er du sikker på at du ønsker å slette denne annonsen?',
	'adss-welcome-subject' => '[AdSS] Takk for sponsingen din!',
	'adss-welcome-body' => 'Hei,

Gratulerer, kontoen din er satt opp og annonsene vil vises
innen 48 timer. Du kan logge inn ved å bruke detaljene nedenfor
for å dobbeltsjekke annonseteksten, kjøpe flere annonser eller 
gjennomgå regningen. Wikia-regninger sendes via Paypal hver gang
du har brukt $4 $ eller mer.

URL: $1
Brukernavn: $2
Passord: $3

Vennligst lagre passordet ditt på et trygt sted. Hvis du mister det,
kan du kontakte kunde-service på: http://www.wikia.com/wiki/Special:Contact
og vi vil sende deg passordet til e-postadressen på filen.

--
Wikia-teamet',
);

/** Polish (Polski) */
$messages['pl'] = array(
	'adss-form-password' => 'Twoje hasło',
	'adss-form-login-link' => 'Zaloguj się',
	'adss-button-preview' => 'Podgląd',
	'adss-button-edit' => 'Edytuj',
	'adss-button-select' => 'Wybierz',
	'adss-preview-header' => 'Podgląd',
	'adss-wikia' => 'Wikia',
	'adss-price' => 'Cena',
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
	'adss-form-usd-per-day' => '$$1 په هرې ورځ کې',
	'adss-form-usd-per-week' => '$$1 په هرې مياشت کې',
	'adss-form-non-existent-title-errormsg' => 'پدې نوم مخ نشته!',
	'adss-button-preview' => 'مخليدنه',
	'adss-button-edit' => 'سمول',
	'adss-button-login' => 'ننوتل',
	'adss-button-select' => 'ټاکل',
	'adss-button-save' => 'خوندي کول',
	'adss-button-cancel' => 'ناګارل',
	'adss-button-yes' => 'هو',
	'adss-button-no' => 'نه',
	'adss-preview-header' => 'مخليدنه',
	'adss-click-here' => 'دلته وټوکۍ',
	'adss-per-site' => 'ټول مخونه',
	'adss-close' => 'تړل',
	'adss-cancel' => 'ناګارل',
	'adss-price' => 'بيه',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'adss-desc' => 'Anúncios Self Service',
	'adss' => 'AnúnciosSS',
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
	'adss-form-banner' => 'Faça o upload do seu anúncio aqui:',
	'adss-form-price' => 'Montante do patrocínio:',
	'adss-form-shares' => 'Número de quotas:',
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
	'adss-form-banner-upload-errormsg' => 'Tem de seleccionar uma imagem para enviar',
	'adss-form-pick-plan-errormsg' => 'Tem que seleccionar um plano',
	'adss-form-pick-plan' => 'Escolha o seu plano',
	'adss-form-site-plan-header' => 'Compre um link para a wiki toda',
	'adss-form-site-plan-description' => 'Tenha os seus links na wiki toda por baixo custo.

1 acção é, neste momento, igual a $1% dos links patrocinados da {{SITENAME}} e só custa $2. Pode cancelar em qualquer altura.',
	'adss-form-site-plan-price' => '$1 por uma acção',
	'adss-form-site-premium-plan-header' => 'Compre um link premium em toda a wiki',
	'adss-form-site-premium-plan-description' => 'Ponha os seus links em toda a wiki por um preço baixo e obtenha ainda mais exposição comprando mais acções.

1 acção é neste momento igual a $1% dos links patrocinados da {{SITENAME}}. Com esta opção está a comprar quatro acções pelo preço de três! Pode cancelar em qualquer altura.',
	'adss-form-site-premium-plan-price' => 'Só $1 por quatro acções!',
	'adss-form-page-plan-header' => 'Comprar um link só nesta página',
	'adss-form-page-plan-description' => 'Isto permite-lhe direccionar uma mensagem personalizada para a melhor página para o seu produto por apenas $1 e pode cancelar em qualquer altura.',
	'adss-form-page-plan-price' => '1 link custa $1',
	'adss-form-banner-plan-header' => 'Compre uma quota dos anúncios gráficos 728x90 no topo da wiki',
	'adss-form-banner-plan-description' => 'Obtenha uma quota dos anúncios de toda a wiki por um preço baixo.',
	'adss-form-banner-plan-price' => '$1 por uma acção dos anúncios',
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
	'adss-button-buy-now' => 'Comprar AGORA',
	'adss-button-save' => 'Gravar',
	'adss-button-cancel' => 'Cancelar',
	'adss-button-yes' => 'Sim',
	'adss-button-no' => 'Não',
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
	'adss-cancel' => 'Cancelar',
	'adss-manager-tab-adList' => 'Os seus anúncios',
	'adss-manager-tab-billing' => 'Facturação',
	'adss-admin-tab-adList' => 'Lista de anúncios',
	'adss-admin-tab-billing' => 'Facturação',
	'adss-admin-tab-reports' => 'Relatórios',
	'adss-not-logged-in' => 'Tem de estar autenticado',
	'adss-wrong-id' => 'Identificação errada',
	'adss-no-permission' => 'Não tem permissões',
	'adss-canceled' => 'Cancelado',
	'adss-rejected' => 'Rejeitado',
	'adss-approved' => 'Aprovado',
	'adss-pending' => 'Pendente',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Tipo',
	'adss-no-shares' => 'Acções',
	'adss-price' => 'Preço',
	'adss-ad' => 'Anúncio',
	'adss-status' => 'Estado',
	'adss-created' => 'Criado',
	'adss-paypal-payment' => 'Pagamento PayPal',
	'adss-adss-fee' => 'Taxa AnúnciosSS',
	'adss-fee' => 'Taxa',
	'adss-paid' => 'Pago',
	'adss-timestamp' => 'Data e hora',
	'adss-description' => 'Descrição',
	'adss-amount' => '$$1',
	'adss-welcome-subject' => '[AnúnciosSS] Obrigado pelo seu patrocínio!',
	'adss-welcome-body' => 'Olá,

Parabéns, a sua conta está configurada e os seus anúncios começarão a
ser apresentados nas próximas 48 horas. Pode autenticar-se usando os
detalhes abaixo para verificar o texto do anúncio, comprar mais anúncios
ou ver os seus gastos. As contas da Wikia são enviadas sempre que gasta
$$4 ou mais.

URL: $1
Nome de utilizador: $2
Palavra-chave: $3

Guarde a sua palavra-chave num sítio seguro, por favor. Se a perder pode
contactar o apoio a clientes em: http://www.wikia.com/wiki/Special:Contact
e enviaremos a palavra-chave para o seu correio electrónico.

--
A Equipa da Wikia',
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
	'adss-desc' => 'Сервис самостоятельных объявлений',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Спонсорские ссылки на Викии',
	'adss-ad-header' => '<h2>Ссылки спонсора</h2>',
	'adss-ad-default-text' => 'Щелкните здесь!',
	'adss-ad-default-desc' => 'Купите спонсорскую ссылку и опишите ваш сайт на этой странице. Действуйте быстро, потому что несколько спонсорских слотов продаются очень быстро!',
	'adss-form-header' => 'Дизайн вашего объявления',
	'adss-form-url' => 'Адрес веб-сайта спонсора (ваш веб-сайт):',
	'adss-form-linktext' => 'Текст, который будет отображаться в ссылке:',
	'adss-form-additionaltext' => 'Текст, который будет отображаться под вашей ссылкой:',
	'adss-form-type' => 'Вид спонсорства:',
	'adss-form-page' => 'Страница, которую вы желаете спонсировать:',
	'adss-form-banner' => 'Ваш баннер:',
	'adss-form-price' => 'Сумма спонсорского взноса:',
	'adss-form-shares' => 'Количество акций:',
	'adss-form-email' => 'Ваш адрес электронной почты:',
	'adss-form-password' => 'Ваш пароль:',
	'adss-form-login-link' => 'Представьтесь',
	'adss-form-login-desc' => 'Имеете пароль? $1, чтобы сэкономить ваше время и купить объявление всего за один клик!',
	'adss-form-usd-per-day' => '$$1 в день',
	'adss-form-usd-per-week' => '$$1 в неделю',
	'adss-form-usd-per-month' => '$$1 в месяц',
	'adss-form-auth-errormsg' => 'Адрес электронной почты или пароль введены некорректно.',
	'adss-form-field-empty-errormsg' => 'Это поле не должно быть пустым!',
	'adss-form-non-existent-title-errormsg' => 'Этой страницы не существует',
	'adss-form-pick-plan-errormsg' => 'Вы должны выбрать план!',
	'adss-form-pick-plan' => 'Выберите ваш план',
	'adss-form-site-plan-header' => 'Купите перекрёстную ссылку через всю вики',
	'adss-form-site-plan-description' => 'Получите ссылки работающие на всей вики по единой низкой цене. 

1 акция равна $1% спонсорских ссылок {{SITENAME}} и стоит всего $2. Вы в любое время можете отменить это.',
	'adss-form-site-plan-price' => '$1 за одну акцию',
	'adss-form-site-premium-plan-header' => 'Купите перекрёстную премиум-ссылку через всю вики',
	'adss-form-site-premium-plan-description' => 'Получите ссылки работающие на всей вики по единой низкой цене и получите ещё большую выдержку, покупая больше акций. 

1 акция равна $1% рекламных ссылок {{SITENAME}}. С помощью этой опции вы покупаете четыре акции по цене трех! Вы в любое время можете отменить это.',
	'adss-form-site-premium-plan-price' => 'Только $1 за четыре акции!',
	'adss-form-page-plan-header' => 'Покупайте ссылки только на этой странице',
	'adss-form-page-plan-description' => 'Это даст вам специальное сообщение на лучших страницах, для вашего продукта всего за $1, и вы в любое время можете отменить это.',
	'adss-form-page-plan-price' => '$1 за одну ссылку',
	'adss-form-banner-plan-header' => 'Купите баннер в верхней части каждой страницы',
	'adss-form-banner-plan-price' => '$1 за один баннер',
	'adss-form-or' => '- или -',
	'adss-form-thanks' => 'Благодарим за спонсорскую помощь! Ваше объявление было принято и будет пущено в ротацию после ручной проверки (в течении 48 часов).

Перейти и [[Special:AdSS|купить]] другую рекламу!',
	'adss-button-preview' => 'Предпросмотр',
	'adss-button-edit' => 'Править',
	'adss-button-login' => 'Войти',
	'adss-button-login-buy' => 'Войти и купить СЕЙЧАС',
	'adss-button-save-pay' => 'Сохранить',
	'adss-button-pay-paypal' => 'Заплатить с помощью PayPal',
	'adss-button-select' => 'Выбрать',
	'adss-preview-header' => 'Предпросмотр',
	'adss-preview-prompt' => 'Так будет выглядеть ваше спонсорство. Нажмите кнопку "Изменить", чтобы вернуться и внести изменения, или "Сохранить", чтобы сохранить и перейти к PayPal.',
	'adss-click-here' => 'Щелкните здесь',
	'adss-paypal-redirect' => '$1, если вы не были перенаправлены в PayPal в течение 5 секунд.',
	'adss-paypal-error' => 'Не удается создать платёж в PayPal. Повторите попытку позже.

Вернуться в [[Служебная:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Произошла ошибка. Пожалуйста, повторите попытку позже. 

Вернуться в [[Служебная:AdSS|{{int:Adss}}]]',
	'adss-per-site' => 'Все страницы',
	'adss-per-page' => 'Одна страница',
	'adss-close' => 'Закрыть',
	'adss-cancel' => 'Отменить',
	'adss-manager-tab-adList' => 'Ваши объявления',
	'adss-manager-tab-billing' => 'Биллинг',
	'adss-admin-tab-adList' => 'Список объявлений',
	'adss-admin-tab-billing' => 'Биллинг',
	'adss-admin-tab-reports' => 'Отчеты',
	'adss-not-logged-in' => 'Вы должны представиться',
	'adss-wrong-id' => 'Неверный ID',
	'adss-no-permission' => 'Отсутствует разрешение',
	'adss-canceled' => 'Отменено',
	'adss-rejected' => 'Отклонено',
	'adss-approved' => 'Подтверждено',
	'adss-pending' => 'На рассмотрении',
	'adss-wikia' => 'Викия',
	'adss-type' => 'Тип',
	'adss-no-shares' => '# акций',
	'adss-price' => 'Цена',
	'adss-ad' => 'Объявление',
	'adss-status' => 'Статус',
	'adss-created' => 'Создано',
	'adss-paypal-payment' => 'Платёж PayPal',
	'adss-adss-fee' => 'Оплата AdSS',
	'adss-fee' => 'Оплата',
	'adss-timestamp' => 'Дата/время',
	'adss-description' => 'Описание',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'adss-button-save-pay' => 'Shrani',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'adss-form-email' => 'Е-адреса:',
	'adss-button-preview' => 'Прегледај',
	'adss-button-edit' => 'Уреди',
	'adss-button-login' => 'Пријави ме',
	'adss-button-login-buy' => 'Пријави ме и купи',
	'adss-button-save-pay' => 'Уштеди и плати',
	'adss-button-pay-paypal' => 'Купи преко Пејпала',
	'adss-button-select' => 'Изабери',
	'adss-button-buy-now' => 'Купи',
	'adss-button-save' => 'Сачувај',
	'adss-button-cancel' => 'Откажи',
	'adss-button-yes' => 'Да',
	'adss-button-no' => 'Не',
	'adss-buy-another' => 'Купи још један оглас!',
	'adss-preview-header' => 'Претпреглед',
	'adss-click-here' => 'Кликните овде',
);

/** Swedish (Svenska)
 * @author Tobulos1
 */
$messages['sv'] = array(
	'adss-desc' => 'Ad Self Service',
	'adss' => 'AdSS',
	'adss-sponsor-links' => 'Sponsrade länkar på Wikia',
	'adss-ad-header' => '<h2>Externa sponsrade länkar</h2>',
	'adss-ad-default-text' => 'Klicka här!',
	'adss-ad-default-desc' => 'Köp en sponsrad länk och en beskrivning för din webbplats på denna sida. Agera snabbt, de få sponseringsplatserna säljer ut snabbt!',
	'adss-form-header' => 'Designa din annons',
	'adss-form-url' => 'Sponsringens URL webbplats (din hemsida):',
	'adss-form-linktext' => 'Texten som du vill att skall visas i länken:',
	'adss-form-additionaltext' => 'Texten som du vill att skall visas under din länk:',
	'adss-form-type' => 'Sponsringstyp:',
	'adss-form-page' => 'Sidan till sponsorn:',
	'adss-form-banner' => 'Ladda upp din banner här:',
	'adss-form-price' => 'Sponsringsbelopp:',
	'adss-form-shares' => 'Antal aktier:',
	'adss-form-email' => 'Din e-postadress:',
	'adss-form-password' => 'Ditt lösenord:',
	'adss-form-login-link' => 'Logga in',
	'adss-form-login-desc' => 'Har du ett lösenord? $1 för att spara tid och köp annonsen med bara ett klick!',
	'adss-form-usd-per-day' => '$$1 per dag',
	'adss-form-usd-per-week' => '$$1 per vecka',
	'adss-form-usd-per-month' => '$$1 per månad',
	'adss-form-auth-errormsg' => 'Din e-postadress eller lösenord är felaktig.',
	'adss-form-field-empty-errormsg' => 'Detta fält får inte vara tomt',
	'adss-form-non-existent-title-errormsg' => 'Denna sidan existerar inte',
	'adss-form-banner-upload-errormsg' => 'Du måste välja en bild att ladda upp',
	'adss-form-pick-plan-errormsg' => 'Du måste välja en plan',
	'adss-form-pick-plan' => 'Välj ett annonspaket',
	'adss-form-site-plan-header' => 'Köp en sponsrad länk för hela wikin',
	'adss-form-site-plan-description' => 'Få sponsrade länkar på {{SITENAME}} till ett lågt pris.

1 aktie är för närvarande lika med $1% av {{SITENAME}} sponsrade länkar och kostar bara $2. Du kan avbryta när som helst.',
	'adss-form-site-plan-price' => '$1 för en aktie',
	'adss-form-site-premium-plan-header' => 'Köp 4 Sponsrade Länkar till priset av 3',
	'adss-form-site-premium-plan-description' => 'Få Sponsrade Länkar på {{SITENAME}} och få ännu mer exponering genom att köpa i stora partier.

1 aktie är för närvarande lika med $1% av {{SITENAME}} sponsrade länkar. Med det här alternativet kan du köpa fyra aktier till priset av tre! Du kan avbryta när som helst.',
	'adss-form-site-premium-plan-price' => 'Endast $1 för fyra aktier!',
	'adss-form-page-plan-header' => 'Köp en länk på en enda sida',
	'adss-form-page-plan-price' => '$1 för en länk',
	'adss-form-or' => '- eller -',
	'adss-form-thanks' => 'Tack för din sponsring! Din annons har köpts in och kommer att släppas live efter ett manuellt godkännande (inom 48 timmar).

	 Gå och [[Special:AdSS|köp]] en till annons!',
	'adss-button-preview' => 'Förhandsgranska',
	'adss-button-edit' => 'Redigera',
	'adss-button-login' => 'Logga in',
	'adss-button-login-buy' => 'Logga in och köp NU',
	'adss-button-save-pay' => 'Spara & betala',
	'adss-button-pay-paypal' => 'Betala med PayPal',
	'adss-button-select' => 'Välj',
	'adss-button-buy-now' => 'Köp NU',
	'adss-button-save' => 'Spara',
	'adss-button-cancel' => 'Avbryt',
	'adss-button-yes' => 'Ja',
	'adss-button-no' => 'Nej',
	'adss-buy-another' => 'Köp en annan annons!',
	'adss-edit-thanks' => 'Dina annonsändringar har sparats och kommer släppas live efter ett manuellt godkännande (inom 48 timmar).',
	'adss-preview-header' => 'Förhandsgranska',
	'adss-preview-prompt' => 'Här är hur din sponsring kommer att se ut - klicka på "{{int:adss-button-edit}}" för att gå tillbaka och göra ändringar, eller "{{int:adss-button-save-pay}}" för att spara den och gå till PayPal.',
	'adss-click-here' => 'Klicka här',
	'adss-paypal-redirect' => '$1 om du inte omdirigeras till PayPal inom 5 sekunder.',
	'adss-paypal-error' => 'Kunde inte skapa PayPal betalning den här gången. Försök igen senare. 

Återgå till [[Special:AdSS|{{int:Adss}}]].',
	'adss-error' => 'Ett fel inträffade. Försök igen senare.

Återgå till [[Special:AdSS|{{int:Adss}}]].',
	'adss-per-site' => 'Alla sidor',
	'adss-per-page' => 'Bara en sida',
	'adss-close' => 'Stäng',
	'adss-cancel' => 'Avbryt',
	'adss-manager-tab-adList' => 'Dina annonser',
	'adss-admin-tab-adList' => 'Lista över annonser',
	'adss-admin-tab-reports' => 'Rapporter',
	'adss-not-logged-in' => 'Du måste vara inloggad',
	'adss-wrong-id' => 'Fel id',
	'adss-no-permission' => 'Inget tillstånd',
	'adss-canceled' => 'Avbruten',
	'adss-rejected' => 'Avvisad',
	'adss-approved' => 'Godkänd',
	'adss-pending' => 'Oavgjord',
	'adss-wikia' => 'Wikia',
	'adss-type' => 'Typ',
	'adss-no-shares' => '# aktier',
	'adss-price' => 'Pris',
	'adss-ad' => 'Annons',
	'adss-status' => 'Status',
	'adss-created' => 'Skapad',
	'adss-paypal-payment' => 'PayPal betalning',
	'adss-fee' => 'Avgift',
	'adss-paid' => 'Betald',
	'adss-timestamp' => 'Tidsstämpel',
	'adss-description' => 'Beskrivning',
	'adss-amount' => '$$1',
	'adss-cancel-confirmation' => 'Är du säker på att du vill ta bort denna annons?',
	'adss-welcome-subject' => '[AdSS] Tack för din sponsring!',
	'adss-welcome-body' => 'Hej,

Gratulerar, ditt konto är anordnat och dina annonser kommer starta
inom 48 timmar. Du kan logga in med uppgifterna nedan för att
dubbelkolla annonstexten, köpa ytterligare annonser eller se över din
räkning. Wikias räkningar skickas via Paypal varje gång du spenderar
$$4 eller mer.
	
URL: $1
Användarnamn: $2
Lösenord: $3

Vänligen spara lösenordet på en säker plats.  Om du tappar bort det, kan du
kontakta kundservicen på: http://www.wikia.com/wiki/Special:Contact
så skickar vi lösenordet till din e-postadress.

-- 
Wikia Team',
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

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'adss-ad-default-text' => 'Натисніть тут!',
	'adss-form-password' => 'Ваш пароль:',
	'adss-form-login-link' => 'Увійти',
	'adss-form-non-existent-title-errormsg' => 'Цієї сторінки не існує',
	'adss-button-preview' => 'Попередній перегляд',
	'adss-button-edit' => 'Редагувати',
	'adss-button-login' => 'Увійти',
	'adss-button-save' => 'Зберегти',
	'adss-button-cancel' => 'Скасувати',
	'adss-button-yes' => 'Так',
	'adss-button-no' => 'Ні',
	'adss-type' => 'Тип',
	'adss-status' => 'Статус',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'adss-form-email' => '您的电邮地址：',
	'adss-form-password' => '您的密码：',
	'adss-form-login-link' => '登入',
	'adss-button-edit' => '编辑',
	'adss-button-login' => '登入',
	'adss-button-save-pay' => '保存于还钱',
	'adss-button-pay-paypal' => '用 PayPal 来还钱',
	'adss-button-select' => '选择',
	'adss-button-buy-now' => '就在现在把它买了',
	'adss-button-save' => '保存',
	'adss-button-cancel' => '取消',
	'adss-button-yes' => '是',
	'adss-button-no' => '不是',
	'adss-click-here' => '点击这里',
	'adss-per-site' => '所有页面',
	'adss-per-page' => '一页而已',
	'adss-close' => '关闭',
	'adss-cancel' => '取消',
	'adss-manager-tab-adList' => '您的广告',
	'adss-canceled' => '已取消',
);

/** Chinese (Taiwan) (‪中文(台灣)‬) */
$messages['zh-tw'] = array(
	'adss-button-edit' => '編輯',
);

