<?php
use Swagger\Annotations as SWG;

/**
 *	@SWG\Resource(
 *		apiVersion="0.2",
 *		swaggerVersion="1.1",
 *		resourcePath="UserApi",
 *		basePath="http://www.wikia.com"
 *	)
 *
 *	@SWG\Model( id="UserElement" )
 *		@SWG\Property(
 *			name="user_id",
 *			type="int",
 *			required="true",
 *			description="Wikia user ID"
 *		)
 *		@SWG\Property(
 *			name="title",
 *			type="string",
 *			required="true",
 *			description="Wikia user login"
 *		)
 *		@SWG\Property(
 *			name="name",
 *			type="string",
 *			required="true",
 *			description="Wikia user name (it can contain space characters)"
 *		)
 *		@SWG\Property(
 *			name="url",
 *			type="string",
 *			required="true",
 *			description="Relative URL for user profile page"
 *		)
 *		@SWG\Property(
 *			name="numberofedits",
 *			type="int",
 *			required="true",
 *			description="Number of edits made by user on the current wiki"
 *		)
 *		@SWG\Property(
 *			name="avatar",
 *			type="string",
 *			required="true",
 *			description="Full URL for user avatar image"
 *		)
 *
 *		@SWG\Model( id="UserResultSet" )
 *			@SWG\Property(
 *				name="items",
 *				required="true",
 *				type="Array",
 *				items="$ref:UserElement",
 *				description="A list of selected users"
 *			)
 *			@SWG\Property(
 *				name="basepath",
 *				type="string",
 *				required="true",
 *				description="Base path of current wiki; used for constructing absolute URLs from relative ones"
 *			)
 *
 *
 *	@SWG\Api(
 *		path="/wikia.php?controller=UserApi&method=getDetails",
 *		description="Get details about one or more user",
 *		@SWG\Operations(
 *			@SWG\Operation(
 *				httpMethod="GET",
 *				summary="Fetch details about selected users",
 *				nickname="getDetails",
 *				responseClass="UserResultSet",
 *				@SWG\ErrorResponses(
 *					@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 *					@SWG\ErrorResponse( code="404", reason="Results not found" )
 *				),
 *				@SWG\Parameters(
 *					@SWG\Parameter(
 *						name="ids",
 *						description="The integer user ID values, comma-separated, max number of IDs is 100",
 *						paramType="query",
 *						required="true",
 *						allowMultiple="true",
 *						dataType="Array",
 *						defaultValue=""
 *					),
 *					@SWG\Parameter(
 *						name="size",
 *						description="The desired width (and height, because it is a square) for the thumbnail, defaults to 100, 0 for no thumbnail",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="int",
 *						defaultValue=""
 *					)
 *				)
 *			)
 *		)
 * )
 *
 */


/**
 * Controller to fetch information about users
 *
 * @author adam
 */

class UserApiController extends WikiaApiController {

	const AVATAR_DEFAULT_SIZE = 100;
	const USER_LIMIT = 100;

	/**
	 * Get details about one or more user
	 *
	 * @requestParam string $ids A string with a comma-separated list of user ID's, limit for query equals 100
	 * @requestParam integer $size [OPTIONAL] The desired width and height for the thumbnail, defaults to 100, 0 for no thumbnail
	 *
	 * @responseParam array $items A list of results with the user ID as the index, each item has a title, name, url, avatar, numberofedits
	 * @responseParam string $basepath domain of a wiki to create a url for an user
	 *
	 * @example &ids=123&size=150
	 */
	public function getDetails() {
		wfProfileIn( __METHOD__ );
		$ids =  $this->request->getVal( 'ids' );
		if ( empty( $ids ) ) {
			throw new InvalidParameterApiException( 'ids' );
		}
		$ids = explode( ',', trim( $ids ) );
		$size = $this->request->getInt( 'size', static::AVATAR_DEFAULT_SIZE );

		//limit number of users
		$ids = array_slice( $ids, 0, static::USER_LIMIT );
		//users are cached inside the service
		$users = (new UserService())->getUsers( $ids );
		$items = array();
		foreach ( $users as $user ) {

			$item = array(
				'user_id' => $user->getId(),
				'title' => $user->getTitleKey(),
				'name' => $user->getName(),
				'url' => AvatarService::getUrl( $user->getName() ),
				'numberofedits' => $user->getEditCountLocal()
			);
			//add avatar url if size !== 0
			if ( $size > 0 ) {
				$item[ 'avatar' ] = AvatarService::getAvatarUrl( $user, $size );
			}
			$items[] = $item;
		}
		if ( !empty( $items ) ) {
			$this->response->setVal( 'items', $items );
			$this->response->setVal( 'basepath', $this->wg->Server );
		} else {
			throw new NotFoundApiException();
		}
		wfProfileOut( __METHOD__ );
	}

}