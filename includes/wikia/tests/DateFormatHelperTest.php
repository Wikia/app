<?
class DateFormatHelperTest extends WikiaBaseTest {

	/**
	 * @dataProvider convertFormatToJqueryUiFormatDataProvider
	 */
	public function testConvertFormatToJqueryUiFormat($expected, $inputFormat) {
		$this->assertEquals($expected, DateFormatHelper::convertFormatToJqueryUiFormat($inputFormat));
	}

	public function convertFormatToJqueryUiFormatDataProvider() {
		return [
			['dd', 'd'],
			['d', 'j'],
			['DD', 'l'],
			['o', 'z'],
			['MM', 'F'],
			['M', 'M'],
			['m', 'n'],
			['mm', 'm'],
			['yy', 'Y'],
			['y', 'y'],
			['yy-MM-dd', 'Y-F-d'],
			['MM d, yy', 'F j, Y'],
			['dd/MM/yy', 'd/F/Y'],
			['ddmmyy', 'dmY'],
			['dd.mm.yy', 'd.m.Y'],
			['yy/mm/dd', 'Y/m/d'],
			['dd/mm/yy', 'd/m/Y'],
			['yy-mm-dd', 'Y-m-d'],
		];
	}
}
