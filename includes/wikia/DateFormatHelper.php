<?
class DateFormatHelper {
	protected static $jsDateFormatReplaces = [
		//day
		'd' => 'dd',	//day of the month
		'j' => 'd',	//3 letter name of the day
		'l' => 'DD',	//full name of the day
		'z' => 'o',	//day of the year

			//month
		'F' => 'MM',	//Month name full
		'M' => 'M',	//Month name short
		'n' => 'm',	//numeric month no leading zeros
		'm' => 'mm',	//numeric month leading zeros

			//year
		'Y' => 'yy', //full numeric year
		'y' => 'y'	//numeric year: 2 digit
	];

	public static function convertFormatToJqueryUiFormat($phpDateFormat) {
		return strtr($phpDateFormat, self::$jsDateFormatReplaces);
	}
}