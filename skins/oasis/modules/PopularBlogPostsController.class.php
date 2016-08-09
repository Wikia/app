<?php

class PopularBlogPostsController extends WikiaController {

	public function index() {
		wfProfileIn( __METHOD__ );

		$mcKey = wfMemcKey( "OasisPopularBlogPosts", $this->wg->Lang->getCode() );
		$this->body = $this->wg->Memc->get( $mcKey );
		if ( empty ( $this->body ) ) {
			$input = "	<title>" . wfMessage( 'oasis-popular-blogs-title' )->plain() . "</title>
						<type>box</type>
						<order>date</order>";

			$time = date( 'Ymd', strtotime( "-1 week" ) ) . '000000'; // 7 days ago
//			$time = '20091212000000';  // use this value for testing if there are no recent posts
			$params = [
				'summary' => true,
				'paging' => false,
				'create_timestamp' => $time,
				'count' => 50,
				'displaycount' => 4,
				'order' => 'comments'
				// 'style' => 'add additionalClass if necessary'
			];

			$this->body = BlogTemplateClass::parseTag( $input, $params, $this->wg->Parser );
			if ( substr( $this->body, 0, 9 ) == '<p><br />' ) {
				$this->body = '<p>' . substr( $this->body, 9 );
			}
			if ( substr( $this->body, 0, 45 ) !== '<section class="WikiaBlogListingBox module ">' ) {
				$this->body = '<section class="WikiaBlogListingBox module ">' . $this->body . '</section>';
			}
			$this->wg->Memc->set( $mcKey, $this->body, 60 * 60 );  // cache for 1 hour
		}

		wfProfileOut( __METHOD__ );
	}

}
