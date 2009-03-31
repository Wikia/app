<?php
/**
 * LinkOpenID.i18n.php - Internationalisation for LinkOpenID
 *
 * @author Michael Holzt <kju@fqdn.org>
 * @copyright 2008 Michael Holzt
 * @license GNU General Public License 2.0
 */

$messages = array();

/** English
 * @author Michael Holzt <kju@fqdn.org>
 */
$messages['en'] = array(
	# for Special:Version
	'linkopenid-desc' => 'Allow users to link their account to an external OpenID',

	# for Special:Preferences
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'If you have a OpenID from an external provider you can specify it here.
This allows you to use your userpage as an OpenID as well.',
	'linkopenid-prefstext-openid' => 'Your OpenID:',
	'linkopenid-prefstext-v1url' => 'Server-URL for OpenID Version 1.1:',
	'linkopenid-prefstext-v2url' => 'Server-URL for OpenID Version 2:',
	'linkopenid-prefstext-xrdsurl' => 'XRDS-URL:', # Only translate this if needed.
);

/** Message documentation (Message documentation)
 * @author Purodha
 */
$messages['qqq'] = array(
	'linkopenid-desc' => 'Short desciption of this extension.
Shown in [[Special:Version]].
Do not translate or change tag names, or link anchors.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ramsis II
 */
$messages['arz'] = array(
	'linkopenid-desc' => 'السماح لليوزرز انهم يوصول الحساب بتاعهم ب ID مفتوحه خارجيه',
	'linkopenid-prefs' => 'ID مفتوحه',
	'linkopenid-prefstext-openid' => 'الاي دي المفتوحه بتاعتك:',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'linkopenid-desc' => 'Omogućava korisnicima da povežu svoj račun sa vanjskim OpenID',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Ako imate OpenID od Vašeg vanjskog provajdera možete ga navesti ovdje.
Ovo Vam omogućava da koristite Vašu korisničku stranicu kao i Vaš OpenID.',
	'linkopenid-prefstext-openid' => 'Vaš OpenID:',
	'linkopenid-prefstext-v1url' => 'URL servera za OpenID verziju 1.1:',
	'linkopenid-prefstext-v2url' => 'URL servera za OpenID verziju 2:',
);

/** German (Deutsch)
 * @author Michael Holzt <kju@fqdn.org>
 */
$messages['de'] = array(
	'linkopenid-desc' => 'Erlaubt Benutzern eine externe OpenID ihrem Account zuzuordnen',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Wenn du eine OpenID bei einem externen Anbieter besitzt, kannst du diese hier angeben.
Dies ermöglicht dir die alternative Nutzung deiner Benutzerseite als OpenID.',
	'linkopenid-prefstext-openid' => 'Deine OpenID:',
	'linkopenid-prefstext-v1url' => 'Server-URL für OpenID Version 1.1:',
	'linkopenid-prefstext-v2url' => 'Server-URL für OpenID Version 2:',
);

/** German (formal address) (Deutsch (Sie-Form)) */
$messages['de-formal'] = array(
	'linkopenid-prefstext-pre' => 'Wenn Sie eine OpenID bei einem externen Anbieter besitzen, können Sie diese hier angeben.
Dies ermöglicht Ihnen die alternative Nutzung Ihrer Benutzerseite als OpenID.',
	'linkopenid-prefstext-openid' => 'Ihre OpenID:',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'linkopenid-desc' => 'Wužywarjam dowóliś jich konto z eksternym OpenID zwězaś',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Jolic maš OpenID wót eksternego póbitowarja, móžoš jen how pódaś.
To śi dowólijo swój wužywarski bok teke ako OpenID wužywaś.',
	'linkopenid-prefstext-openid' => 'Twój OpenID:',
	'linkopenid-prefstext-v1url' => 'Serwerowy URL za OpenID wersiju 1.1.:',
	'linkopenid-prefstext-v2url' => 'Serwerowy URL za OpenID wersiju 2;',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-openid' => 'Via OpenID:',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Vililikku
 */
$messages['fi'] = array(
	'linkopenid-desc' => 'Antaa käyttäjille mahdollisuuden linkittää heidän tunnuksensa ulkoiseen OpenID-palveluun.',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Jos sinulla on OpenID-tunnus ulkoisella palveluntarjoajalla, voit määritellä sen tässä.
Tämä antaa sinun käyttää myös käyttäjäsivuasi OpenID:nä.',
	'linkopenid-prefstext-openid' => 'OpenID:si',
	'linkopenid-prefstext-v1url' => 'Palvelimen osoite OpenID:n versiolle 1.1:',
	'linkopenid-prefstext-v2url' => 'Palvelimen osoite OpenID:n versiolle 2:',
	'linkopenid-prefstext-xrdsurl' => 'XRDS-osoite:',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'linkopenid-desc' => 'Permet aux utilisateurs de lier leur compter avec un OpenID externe',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => "Si vous avez un OpenID d'un fournisseur externe, vous pouvez le spécifier ici.
Ceci vous permet aussi d'utiliser votre page utilisateur comme OpenID.",
	'linkopenid-prefstext-openid' => 'Votre OpenID :',
	'linkopenid-prefstext-v1url' => 'URL du serveur pour OpenID version 1.1 :',
	'linkopenid-prefstext-v2url' => 'URL du serveur pour OpenID version 2 :',
	'linkopenid-prefstext-xrdsurl' => 'XRDS-URL :',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'linkopenid-desc' => 'Permite aos usuarios ligar a súa conta cun OpenID externo',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Se ten un OpenID dun proveedor externo pode especificalo aquí.
Isto permitiralle usar a súa páxina de usuario tamén como un OpenID.',
	'linkopenid-prefstext-openid' => 'O seu OpenID:',
	'linkopenid-prefstext-v1url' => 'URL do servidor para a versión 1.1 do OpenID:',
	'linkopenid-prefstext-v2url' => 'URL do servidor para a versión 2 do OpenID:',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'linkopenid-desc' => 'Wužiwarjam dowolić, jich konto z eksternym OenID zwjazać',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Jeli maš OpenID wot eksterneho poskićowarja, móžeš jón tu podać. To ći dowola twoju wužiwarsku stronu tohorunja jako OpenID wužiwać.',
	'linkopenid-prefstext-openid' => 'Twój OpenID:',
	'linkopenid-prefstext-v1url' => 'Serwerowy URL za OpenID wersiju 1.1:',
	'linkopenid-prefstext-v2url' => 'Serwerowy URL za OpenID wersiju 2:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'linkopenid-desc' => 'Permitter que usatores liga lor conto a un OpenID externe',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Si tu possede un OpenID de un providitor externe, tu pote specificar lo hic.
Isto te permitte etiam usar tu pagina de usator como OpenID.',
	'linkopenid-prefstext-openid' => 'Tu OpenID:',
	'linkopenid-prefstext-v1url' => 'URL de servitor pro OpenID version 1.1:',
	'linkopenid-prefstext-v2url' => 'URL de servitor pro OpenID version 2:',
	'linkopenid-prefstext-xrdsurl' => 'XRDS-URL:',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'linkopenid-desc' => '利用者がアカウントを外部のOpenIDと関連付けられるようにする',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'あなたが外部プロバイダからのOpenIDをもっているならば、ここでそれを指定できます。
その指定によって、あなたの利用者ページを同様にOpenIDとして使えます。',
	'linkopenid-prefstext-openid' => 'あなたのOpenID:',
	'linkopenid-prefstext-v1url' => 'OpenID バージョン1.1用の Server-URL:',
	'linkopenid-prefstext-v2url' => 'OpenID バージョン2用の Server-URL:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'linkopenid-desc' => 'Maat et müjjelesch, dat Metmaacher en <i lang="en">OpenID</i> fun wo anders met dänne iere Aanmeldung hee verbenge künne.',
	'linkopenid-prefs' => '<i lang="en">OpenID</i>',
	'linkopenid-prefstext-pre' => 'Wann de en <i lang="en">OpenID</i> fun woanders haß, dann kanns De di hee aanjävve. Domet kanns De dann Ding Metmaachersigg hee och als en <i lang="en">OpenID</i> bruche.',
	'linkopenid-prefstext-openid' => 'Ding <i lang="en">OpenID</i>:',
	'linkopenid-prefstext-v1url' => 'De <i lang="en">Server-URL</i> för <i lang="en">OpenID</i> Version 1.1:',
	'linkopenid-prefstext-v2url' => 'De <i lang="en">Server-URL</i> för <i lang="en">OpenID</i> Version 2:',
	'linkopenid-prefstext-xrdsurl' => 'De <i lang="en">XRDS-URL</i>:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'linkopenid-desc' => 'Erlaabt de Benotzer et fir hire Benotzerkont mat enger externer OpenID ze verbannen',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Wann Dir eng OpenID vun engem externe rovider hutt, da  kënnt dir se hei uginn.
Dëst erlaabt et datt Dir Är Benotzersäit och als OpenID benotze kënnt.',
	'linkopenid-prefstext-openid' => 'Är OpenID:',
	'linkopenid-prefstext-v1url' => "Server-URL fir d'Versioun 1.1 vun OpenID:",
	'linkopenid-prefstext-v2url' => "Server-URL fir d'Versioun 2 vun OpenID:",
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'linkopenid-desc' => 'Maakt het voor gebruikers mogelijk een koppeling te maken met een externe OpenID-gebruiker',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Als u een OpenID hebt van een externe provider dan kunt u die hier aangeven.
Hierdoor wordt het mogelijk uw gebruikerspagina ook al OpenID te gebruiken.',
	'linkopenid-prefstext-openid' => 'Uw OpenID:',
	'linkopenid-prefstext-v1url' => 'Server-URL voor OpenID-versie 1.1:',
	'linkopenid-prefstext-v2url' => 'Server-URL voor OpenID-versie 2:',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'linkopenid-desc' => 'Gjer det mogleg for brukarar å lenkja kontoen sin til ein ekstern OpenID',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Om du har ein OpenID frå ein ekstern leverandør, kan du oppgje det her.
Dette lèt deg nytta brukarsida di som ein OpenID.',
	'linkopenid-prefstext-openid' => 'Din OpenID:',
	'linkopenid-prefstext-v1url' => 'Tenar-URL for OpenID-versjon 1.1:',
	'linkopenid-prefstext-v2url' => 'Tenar-URL for OpenID-versjon 2:',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'linkopenid-desc' => 'Permet als utilizaires de ligar lor comptador amb un OpenID extèrn',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => "S'avètz un OpenID d'un provesidor extèrn, o podètz especificar aicí.
Aquò vos permet tanben d'utilizar vòstra page d'utilizaire coma OpenID.",
	'linkopenid-prefstext-openid' => 'Vòstre OpenID :',
	'linkopenid-prefstext-v1url' => 'URL del servidor per OpenID version 1.1 :',
	'linkopenid-prefstext-v2url' => 'URL del servidor per OpenID version 2 :',
	'linkopenid-prefstext-xrdsurl' => 'XRDS-URL :',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'linkopenid-desc' => 'Umožniť používateľom spojiť svoj účet s externým OpenID',
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => 'Ak máte OpenID od externého poskytovateľa, môžete ho tu uviesť.
To vám umožní používať svoju používateľskú stránku tiež ako OpenID.',
	'linkopenid-prefstext-openid' => 'Váš OpenID:',
	'linkopenid-prefstext-v1url' => 'URL servera OpenID verzie 1.1:',
	'linkopenid-prefstext-v2url' => 'URL servera OpenID verzie 2:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-openid' => 'Ó-nia OpenID:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'linkopenid-desc' => 'Nagpapahintulot sa mga tagagamit na ikawing ang kanilang mga kuwenta sa isang panlabas na OpenID (Bukas na ID)',
	'linkopenid-prefs' => 'OpenID ("Bukas na ID")',
	'linkopenid-prefstext-pre' => 'Kung mayroon kang isang OpenID (Bukas na ID) mula sa isang panlabas na tagapagbigay nito maaari mong tukuyin ito dito. 
Magpapahintulot ito na magamit ang iyong pahina ng tagagamit bilang isa ring OpenID.',
	'linkopenid-prefstext-openid' => 'Ang OpenID (Bukas na ID) mo:',
	'linkopenid-prefstext-v1url' => 'Serbidor-URL para sa Bersyong 1.1 ng OpenID:',
	'linkopenid-prefstext-v2url' => 'Serbidor-URL para sa Bersyong 2 ng OpenID:',
	'linkopenid-prefstext-xrdsurl' => 'XRDS-URL:',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'linkopenid-desc' => "Kullanıcıların hesaplarını bir dış OpenID'ye bağlamalarına olanak sağlar",
	'linkopenid-prefs' => 'OpenID',
	'linkopenid-prefstext-pre' => "Eğer bir dış sağlayıcıdan OpenID'niz varsa burada belirtebilirsiniz.
Bu ayrıca, kullanıcı sayfanızı OpenID olarak kullanmanıza da izin verir.",
	'linkopenid-prefstext-openid' => "OpenID'niz:",
	'linkopenid-prefstext-v1url' => "OpenID Versiyon 1.1 için Sunucu-URL'si:",
	'linkopenid-prefstext-v2url' => "OpenID Versiyon 2 için Sunucu-URL'si:",
	'linkopenid-prefstext-xrdsurl' => 'XRDS-URL:',
);

