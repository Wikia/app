<?php
require_once( $IP . '/extensions/wikia/CuratedContent/CuratedContentValidator.class.php' );

class CuratedContentValidatorTest extends WikiaBaseTest
{

	/**
	 * @param $item
	 * @param $expectedResult
	 * @dataProvider validationDataProvider
	 */
	public function testValidateFeaturedItem($item, $expectedResult) {
		$validator = new CuratedContentValidator();
		$result = $validator->validateFeaturedItem($item);
		$this->assertEquals($result, $expectedResult);
	}

	public function validationDataProvider() {
		return [
			[
				['article_id' => 9, 'image_id' => 9, 'label'=> 'foo', 'type' => 'category'],
				[]
			], [
				['article_id' => null, 'image_id' => 9, 'label'=> 'foo', 'type' => 'file'],
				[CuratedContentValidator::ERR_ARTICLE_NOT_FOUND],
			], [
				['article_id' => null, 'image_id' => 9, 'label'=> 'foo', 'type' => 'category'],
				[],
			], [
				['article_id' => 9, 'image_id' => 0, 'label'=> 'foo', 'type' => 'category'],
				[CuratedContentValidator::ERR_IMAGE_MISSING],
			], [
				['article_id' => 9, 'image_id' => 9, 'label'=> '', 'type' => 'category'],
				[CuratedContentValidator::ERR_EMPTY_LABEL],
			], [
				[
					'article_id' => 9,
					'image_id' => 9,
					'label'=> 'thisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabel',
					'type' => 'category'
				],
				[CuratedContentValidator::ERR_TOO_LONG_LABEL],
			], [
				['article_id' => 9, 'image_id' => 9, 'label'=> 'foo', 'type' => 'video', 'video_info' => [
						'provider' => 'notSupported'
					]
				],
				[CuratedContentValidator::ERR_VIDEO_NOT_SUPPORTED],
			], [
				['article_id' => 9, 'image_id' => 9, 'label'=> 'foo', 'type' => 'video'],
				[CuratedContentValidator::ERR_VIDEO_WITHOUT_INFO],
			], [
				['article_id' => 9, 'image_id' => 9, 'label'=> 'foo', 'type' => 'video', 'video_info' => [
						'provider' => 'youtube'
					]
				],
				[],
			], [
				['article_id' => 9, 'image_id' => 9, 'label'=> 'foo', 'type' => 'video', 'video_info' => [
						'provider' => 'ooyalaFoo'
					]
				],
				[],
			], [
				['article_id' => 9, 'image_id' => 9, 'label'=> 'foo', 'type' => ''],
				[CuratedContentValidator::ERR_NOT_SUPPORTED_TYPE],
			], [
				['article_id' => null, 'image_id' => null, 'label'=> '', 'type' => ''],
				[
					CuratedContentValidator::ERR_IMAGE_MISSING,
					CuratedContentValidator::ERR_ARTICLE_NOT_FOUND,
					CuratedContentValidator::ERR_EMPTY_LABEL,
					CuratedContentValidator::ERR_NOT_SUPPORTED_TYPE
				],
			],
		];
	}
}
