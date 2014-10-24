<?php

class FacebookClientLocale {

	private static $mwLocalToFBLocale = [
		'af'        => 'af_ZA',
		'ar'        => 'ar_AR',
		'ay'        => 'ay_BO',
		'be'        => 'be_BY',
		'be-tarask' => 'be_BY',
		'be-x-old'  => 'be_BY',
		'bg'        => 'bg_BG',
		'bs'        => 'bs_BA',
		'ca'        => 'ca_ES',
		'chr'       => 'ck_US',
		'cs'        => 'cs_CZ',
		'cy'        => 'cy_GB',
		'da'        => 'da_DK',
		'de'        => 'de_DE',
		'el'        => 'el_GR',
		'en'        => 'en_US',
		'en-gb'     => 'en_GB',
		'eo'        => 'eo_EO',
		'es'        => 'es_ES',
		'et'        => 'et_EE',
		'eu'        => 'eu_ES',
		'fa'        => 'fa_IR',
		'fi'        => 'fi_FI',
		'fo'        => 'fo_FO',
		'fr'        => 'fr_FR',
		'ga'        => 'ga_IE',
		'gl'        => 'gl_ES',
		'gn'        => 'gn_PY',
		'gu'        => 'gu_IN',
		'he'        => 'he_IL',
		'hi'        => 'hi_IN',
		'hr'        => 'hr_HR',
		'hu'        => 'hu_HU',
		'hy'        => 'hy_AM',
		'id'        => 'id_ID',
		'is'        => 'is_IS',
		'it'        => 'it_IT',
		'ja'        => 'ja_JP',
		'jv'        => 'jv_ID',
		'ka'        => 'ka_GE',
		'kk'        => 'kk_KZ',
		'km'        => 'km_KH',
		'kn'        => 'kn_IN',
		'ko'        => 'ko_KR',
		'ku'        => 'ku_TR',
		'la'        => 'la_VA',
		'li'        => 'li_NL',
		'lt'        => 'lt_LT',
		'lv'        => 'lv_LV',
		'mg'        => 'mg_MG',
		'mk'        => 'mk_MK',
		'ml'        => 'ml_IN',
		'mn'        => 'mn_MN',
		'mr'        => 'mr_IN',
		'ms'        => 'ms_MY',
		'mt'        => 'mt_MT',
		'nb'        => 'nb_NO',
		'ne'        => 'ne_NP',
		'nl'        => 'nl_NL',
		'nn'        => 'nn_NO',
		'no'        => 'nb_NO',
		'pa'        => 'pa_IN',
		'pl'        => 'pl_PL',
		'ps'        => 'ps_AF',
		'pt'        => 'pt_PT',
		'pt-br'     => 'pt_BR',
		'qu'        => 'qu_PE',
		'ro'        => 'ro_RO',
		'ru'        => 'ru_RU',
		'sa'        => 'sa_IN',
		'se'        => 'se_NO',
		'sk'        => 'sk_SK',
		'sl'        => 'sl_SI',
		'so'        => 'so_SO',
		'sq'        => 'sq_AL',
		'sr'        => 'sr_RS',
		'sv'        => 'sv_SE',
		'sw'        => 'sw_KE',
		'ta'        => 'ta_IN',
		'te'        => 'te_IN',
		'tg'        => 'tg_TJ',
		'th'        => 'th_TH',
		'tl'        => 'tl_PH',
		'tr'        => 'tr_TR',
		'tt'        => 'tt_RU',
		'uk'        => 'uk_UA',
		'ur'        => 'ur_PK',
		'uz'        => 'uz_UZ',
		'vi'        => 'vi_VN',
		'xh'        => 'xh_ZA',
		'yi'        => 'yi_DE',
		'zh-hans'   => 'zh_CN',
		'zh-hk'     => 'zh_HK',
		'zh-tw'     => 'zh_TW',
		'zu'        => 'zu_ZA',
	];

	/**
	 * Convert a Mediawiki language code to a Facebook language code
	 *
	 * @param $code
	 *
	 * @return string
	 */
	public static function codeToFaceBookLocale( $code ) {
		if ( empty( self::$mwLocalToFBLocale[$code] ) ) {
			return '';
		} else {
			return self::$mwLocalToFBLocale[$code];
		}
	}

	public static function getLocale() {
		return self::codeToFaceBookLocale( F::app()->wg->Lang->getCode() );
	}
}