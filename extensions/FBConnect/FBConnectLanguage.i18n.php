<?php
/*
 * @author Sean Colombo
 */

/*
 * Not a valid entry pointx, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * FBConnectLanguage.i18n.php
 * 
 * Contains a message which represents a mapping of MediaWiki language codes to Facebook Locales.
 */


$messages = array();

/** English */
$messages['en'] = array(

	'fbconnect-mediawiki-lang-to-fb-locale' => "",
	

/*

// TODO: Use this info from Facebook's locale XML file to build the initial i18n message in FBConnectLanguage.i18n.php

// 'ca_ES' # Catalan

Czech
<codes>
<code>
<standard>
<name>FB</name>
<representation>cs_CZ</representation>

</code>
</codes>
</locale>
<locale>
Welsh
<codes>

<code>
<standard>
<name>FB</name>
<representation>cy_GB</representation>

</code>
</codes>
</locale>
<locale>
Danish
<codes>
<code>
<standard>
<name>FB</name>

<representation>da_DK</representation>

</code>
</codes>
</locale>
<locale>
German
<codes>
<code>
<standard>
<name>FB</name>
<representation>de_DE</representation>


</code>
</codes>
</locale>
<locale>
Basque
<codes>
<code>
<standard>
<name>FB</name>
<representation>eu_ES</representation>

</code>
</codes>
</locale>

<locale>
English (Pirate)
<codes>
<code>
<standard>
<name>FB</name>
<representation>en_PI</representation>

</code>
</codes>
</locale>
<locale>
English (Upside Down)

<codes>
<code>
<standard>
<name>FB</name>
<representation>en_UD</representation>

</code>
</codes>
</locale>
<locale>
Cherokee
<codes>
<code>
<standard>

<name>FB</name>
<representation>ck_US</representation>

</code>
</codes>
</locale>
<locale>
English (US)
<codes>
<code>
<standard>
<name>FB</name>
<representation>en_US</representation>


</code>
</codes>
</locale>
<locale>
Spanish
<codes>
<code>
<standard>
<name>FB</name>
<representation>es_LA</representation>

</code>
</codes>

</locale>
<locale>
Spanish (Chile)
<codes>
<code>
<standard>
<name>FB</name>
<representation>es_CL</representation>

</code>
</codes>
</locale>
<locale>
Spanish (Colombia)

<codes>
<code>
<standard>
<name>FB</name>
<representation>es_CO</representation>

</code>
</codes>
</locale>
<locale>
Spanish (Spain)
<codes>
<code>
<standard>

<name>FB</name>
<representation>es_ES</representation>

</code>
</codes>
</locale>
<locale>
Spanish (Mexico)
<codes>
<code>
<standard>
<name>FB</name>
<representation>es_MX</representation>


</code>
</codes>
</locale>
<locale>
Spanish (Venezuela)
<codes>
<code>
<standard>
<name>FB</name>
<representation>es_VE</representation>

</code>
</codes>

</locale>
<locale>
Finnish (test)
<codes>
<code>
<standard>
<name>FB</name>
<representation>fb_FI</representation>

</code>
</codes>
</locale>
<locale>
Finnish

<codes>
<code>
<standard>
<name>FB</name>
<representation>fi_FI</representation>

</code>
</codes>
</locale>
<locale>
French (France)
<codes>
<code>
<standard>

<name>FB</name>
<representation>fr_FR</representation>

</code>
</codes>
</locale>
<locale>
Galician
<codes>
<code>
<standard>
<name>FB</name>
<representation>gl_ES</representation>


</code>
</codes>
</locale>
<locale>
Hungarian
<codes>
<code>
<standard>
<name>FB</name>
<representation>hu_HU</representation>

</code>
</codes>

</locale>
<locale>
Italian
<codes>
<code>
<standard>
<name>FB</name>
<representation>it_IT</representation>

</code>
</codes>
</locale>
<locale>
Japanese

<codes>
<code>
<standard>
<name>FB</name>
<representation>ja_JP</representation>

</code>
</codes>
</locale>
<locale>
Korean
<codes>
<code>
<standard>

<name>FB</name>
<representation>ko_KR</representation>

</code>
</codes>
</locale>
<locale>
Norwegian (bokmal)
<codes>
<code>
<standard>
<name>FB</name>
<representation>nb_NO</representation>


</code>
</codes>
</locale>
<locale>
Norwegian (nynorsk)
<codes>
<code>
<standard>
<name>FB</name>
<representation>nn_NO</representation>

</code>
</codes>

</locale>
<locale>
Dutch
<codes>
<code>
<standard>
<name>FB</name>
<representation>nl_NL</representation>

</code>
</codes>
</locale>
<locale>
Polish

<codes>
<code>
<standard>
<name>FB</name>
<representation>pl_PL</representation>

</code>
</codes>
</locale>
<locale>
Portuguese (Brazil)
<codes>
<code>
<standard>

<name>FB</name>
<representation>pt_BR</representation>

</code>
</codes>
</locale>
<locale>
Portuguese (Portugal)
<codes>
<code>
<standard>
<name>FB</name>
<representation>pt_PT</representation>


</code>
</codes>
</locale>
<locale>
Romanian
<codes>
<code>
<standard>
<name>FB</name>
<representation>ro_RO</representation>

</code>
</codes>

</locale>
<locale>
Russian
<codes>
<code>
<standard>
<name>FB</name>
<representation>ru_RU</representation>

</code>
</codes>
</locale>
<locale>
Slovak

<codes>
<code>
<standard>
<name>FB</name>
<representation>sk_SK</representation>

</code>
</codes>
</locale>
<locale>
Slovenian
<codes>
<code>
<standard>

<name>FB</name>
<representation>sl_SI</representation>

</code>
</codes>
</locale>
<locale>
Swedish
<codes>
<code>
<standard>
<name>FB</name>
<representation>sv_SE</representation>


</code>
</codes>
</locale>
<locale>
Thai
<codes>
<code>
<standard>
<name>FB</name>
<representation>th_TH</representation>

</code>
</codes>

</locale>
<locale>
Turkish
<codes>
<code>
<standard>
<name>FB</name>
<representation>tr_TR</representation>

</code>
</codes>
</locale>
<locale>
Kurdish

<codes>
<code>
<standard>
<name>FB</name>
<representation>ku_TR</representation>

</code>
</codes>
</locale>
<locale>
Simplified Chinese (China)
<codes>
<code>
<standard>

<name>FB</name>
<representation>zh_CN</representation>

</code>
</codes>
</locale>
<locale>
Traditional Chinese (Hong Kong)
<codes>
<code>
<standard>
<name>FB</name>
<representation>zh_HK</representation>


</code>
</codes>
</locale>
<locale>
Traditional Chinese (Taiwan)
<codes>
<code>
<standard>
<name>FB</name>
<representation>zh_TW</representation>

</code>
</codes>

</locale>
<locale>
Leet Speak
<codes>
<code>
<standard>
<name>FB</name>
<representation>fb_LT</representation>

</code>
</codes>
</locale>
<locale>
Afrikaans

<codes>
<code>
<standard>
<name>FB</name>
<representation>af_ZA</representation>

</code>
</codes>
</locale>
<locale>
Albanian
<codes>
<code>
<standard>

<name>FB</name>
<representation>sq_AL</representation>

</code>
</codes>
</locale>
<locale>
Armenian
<codes>
<code>
<standard>
<name>FB</name>
<representation>hy_AM</representation>


</code>
</codes>
</locale>
<locale>
Azeri
<codes>
<code>
<standard>
<name>FB</name>
<representation>az_AZ</representation>

</code>
</codes>

</locale>
<locale>
Belarusian
<codes>
<code>
<standard>
<name>FB</name>
<representation>be_BY</representation>

</code>
</codes>
</locale>
<locale>
Bengali

<codes>
<code>
<standard>
<name>FB</name>
<representation>bn_IN</representation>

</code>
</codes>
</locale>
<locale>
Bosnian
<codes>
<code>
<standard>

<name>FB</name>
<representation>bs_BA</representation>

</code>
</codes>
</locale>
<locale>
Bulgarian
<codes>
<code>
<standard>
<name>FB</name>
<representation>bg_BG</representation>


</code>
</codes>
</locale>
<locale>
Croatian
<codes>
<code>
<standard>
<name>FB</name>
<representation>hr_HR</representation>

</code>
</codes>

</locale>
<locale>
Dutch (België)
<codes>
<code>
<standard>
<name>FB</name>
<representation>nl_BE</representation>

</code>
</codes>
</locale>
<locale>
English (UK)

<codes>
<code>
<standard>
<name>FB</name>
<representation>en_GB</representation>

</code>
</codes>
</locale>
<locale>
Esperanto
<codes>
<code>
<standard>

<name>FB</name>
<representation>eo_EO</representation>

</code>
</codes>
</locale>
<locale>
Estonian
<codes>
<code>
<standard>
<name>FB</name>
<representation>et_EE</representation>


</code>
</codes>
</locale>
<locale>
Faroese
<codes>
<code>
<standard>
<name>FB</name>
<representation>fo_FO</representation>

</code>
</codes>

</locale>
<locale>
French (Canada)
<codes>
<code>
<standard>
<name>FB</name>
<representation>fr_CA</representation>

</code>
</codes>
</locale>
<locale>
Georgian

<codes>
<code>
<standard>
<name>FB</name>
<representation>ka_GE</representation>

</code>
</codes>
</locale>
<locale>
Greek
<codes>
<code>
<standard>

<name>FB</name>
<representation>el_GR</representation>

</code>
</codes>
</locale>
<locale>
Gujarati
<codes>
<code>
<standard>
<name>FB</name>
<representation>gu_IN</representation>


</code>
</codes>
</locale>
<locale>
Hindi
<codes>
<code>
<standard>
<name>FB</name>
<representation>hi_IN</representation>

</code>
</codes>

</locale>
<locale>
Icelandic
<codes>
<code>
<standard>
<name>FB</name>
<representation>is_IS</representation>

</code>
</codes>
</locale>
<locale>
Indonesian

<codes>
<code>
<standard>
<name>FB</name>
<representation>id_ID</representation>

</code>
</codes>
</locale>
<locale>
Irish
<codes>
<code>
<standard>

<name>FB</name>
<representation>ga_IE</representation>

</code>
</codes>
</locale>
<locale>
Javanese
<codes>
<code>
<standard>
<name>FB</name>
<representation>jv_ID</representation>


</code>
</codes>
</locale>
<locale>
Kannada
<codes>
<code>
<standard>
<name>FB</name>
<representation>kn_IN</representation>

</code>
</codes>

</locale>
<locale>
Kazakh
<codes>
<code>
<standard>
<name>FB</name>
<representation>kk_KZ</representation>

</code>
</codes>
</locale>
<locale>
Latin

<codes>
<code>
<standard>
<name>FB</name>
<representation>la_VA</representation>

</code>
</codes>
</locale>
<locale>
Latvian
<codes>
<code>
<standard>

<name>FB</name>
<representation>lv_LV</representation>

</code>
</codes>
</locale>
<locale>
Limburgish
<codes>
<code>
<standard>
<name>FB</name>
<representation>li_NL</representation>


</code>
</codes>
</locale>
<locale>
Lithuanian
<codes>
<code>
<standard>
<name>FB</name>
<representation>lt_LT</representation>

</code>
</codes>

</locale>
<locale>
Macedonian
<codes>
<code>
<standard>
<name>FB</name>
<representation>mk_MK</representation>

</code>
</codes>
</locale>
<locale>
Malagasy

<codes>
<code>
<standard>
<name>FB</name>
<representation>mg_MG</representation>

</code>
</codes>
</locale>
<locale>
Malay
<codes>
<code>
<standard>

<name>FB</name>
<representation>ms_MY</representation>

</code>
</codes>
</locale>
<locale>
Maltese
<codes>
<code>
<standard>
<name>FB</name>
<representation>mt_MT</representation>


</code>
</codes>
</locale>
<locale>
Marathi
<codes>
<code>
<standard>
<name>FB</name>
<representation>mr_IN</representation>

</code>
</codes>

</locale>
<locale>
Mongolian
<codes>
<code>
<standard>
<name>FB</name>
<representation>mn_MN</representation>

</code>
</codes>
</locale>
<locale>
Nepali

<codes>
<code>
<standard>
<name>FB</name>
<representation>ne_NP</representation>

</code>
</codes>
</locale>
<locale>
Punjabi
<codes>
<code>
<standard>

<name>FB</name>
<representation>pa_IN</representation>

</code>
</codes>
</locale>
<locale>
Romansh
<codes>
<code>
<standard>
<name>FB</name>
<representation>rm_CH</representation>


</code>
</codes>
</locale>
<locale>
Sanskrit
<codes>
<code>
<standard>
<name>FB</name>
<representation>sa_IN</representation>

</code>
</codes>

</locale>
<locale>
Serbian
<codes>
<code>
<standard>
<name>FB</name>
<representation>sr_RS</representation>

</code>
</codes>
</locale>
<locale>
Somali

<codes>
<code>
<standard>
<name>FB</name>
<representation>so_SO</representation>

</code>
</codes>
</locale>
<locale>
Swahili
<codes>
<code>
<standard>

<name>FB</name>
<representation>sw_KE</representation>

</code>
</codes>
</locale>
<locale>
Filipino
<codes>
<code>
<standard>
<name>FB</name>
<representation>tl_PH</representation>


</code>
</codes>
</locale>
<locale>
Tamil
<codes>
<code>
<standard>
<name>FB</name>
<representation>ta_IN</representation>

</code>
</codes>

</locale>
<locale>
Tatar
<codes>
<code>
<standard>
<name>FB</name>
<representation>tt_RU</representation>

</code>
</codes>
</locale>
<locale>
Telugu

<codes>
<code>
<standard>
<name>FB</name>
<representation>te_IN</representation>

</code>
</codes>
</locale>
<locale>
Malayalam
<codes>
<code>
<standard>

<name>FB</name>
<representation>ml_IN</representation>

</code>
</codes>
</locale>
<locale>
Ukrainian
<codes>
<code>
<standard>
<name>FB</name>
<representation>uk_UA</representation>


</code>
</codes>
</locale>
<locale>
Uzbek
<codes>
<code>
<standard>
<name>FB</name>
<representation>uz_UZ</representation>

</code>
</codes>

</locale>
<locale>
Vietnamese
<codes>
<code>
<standard>
<name>FB</name>
<representation>vi_VN</representation>

</code>
</codes>
</locale>
<locale>
Xhosa

<codes>
<code>
<standard>
<name>FB</name>
<representation>xh_ZA</representation>

</code>
</codes>
</locale>
<locale>
Zulu
<codes>
<code>
<standard>

<name>FB</name>
<representation>zu_ZA</representation>

</code>
</codes>
</locale>
<locale>
Khmer
<codes>
<code>
<standard>
<name>FB</name>
<representation>km_KH</representation>


</code>
</codes>
</locale>
<locale>
Tajik
<codes>
<code>
<standard>
<name>FB</name>
<representation>tg_TJ</representation>

</code>
</codes>

</locale>
<locale>
Arabic
<codes>
<code>
<standard>
<name>FB</name>
<representation>ar_AR</representation>

</code>
</codes>
</locale>
<locale>
Hebrew

<codes>
<code>
<standard>
<name>FB</name>
<representation>he_IL</representation>

</code>
</codes>
</locale>
<locale>
Urdu
<codes>
<code>
<standard>

<name>FB</name>
<representation>ur_PK</representation>

</code>
</codes>
</locale>
<locale>
Persian
<codes>
<code>
<standard>
<name>FB</name>
<representation>fa_IR</representation>


</code>
</codes>
</locale>
<locale>
Syriac
<codes>
<code>
<standard>
<name>FB</name>
<representation>sy_SY</representation>

</code>
</codes>

</locale>
<locale>
Yiddish
<codes>
<code>
<standard>
<name>FB</name>
<representation>yi_DE</representation>

</code>
</codes>
</locale>
<locale>
Guaraní

<codes>
<code>
<standard>
<name>FB</name>
<representation>gn_PY</representation>

</code>
</codes>
</locale>
<locale>
Quechua
<codes>
<code>
<standard>

<name>FB</name>
<representation>qu_PE</representation>

</code>
</codes>
</locale>
<locale>
Aymara
<codes>
<code>
<standard>
<name>FB</name>
<representation>ay_BO</representation>


</code>
</codes>
</locale>
<locale>
Northern Sámi
<codes>
<code>
<standard>
<name>FB</name>
<representation>se_NO</representation>

</code>
</codes>

</locale>
<locale>
Pashto
<codes>
<code>
<standard>
<name>FB</name>
<representation>ps_AF</representation>

</code>
</codes>
</locale>
<locale>
Klingon

<codes>
<code>
<standard>
<name>FB</name>
<representation>tl_ST</representation>

</code>
</codes>
</locale>
</locales>


*/

);

/**
 * Message documentation.
 */
$messages['qqq'] = array(
	'fbconnect-mediawiki-lang-to-fb-locale' => 'Do not translate this message.  It is a representation of a mapping from MediaWiki language codes to corresponding Facebook locales.'
);
