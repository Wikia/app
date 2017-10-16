<?php
/**
 * Copyright (C) 2017 Wikia, Inc.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * https://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

class WallTabsRendererTest extends WikiaBaseTest {
	/** @var WallTabsRenderer $wallTabsRenderer */
	private $wallTabsRenderer;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../Wall.setup.php';
		parent::setUp();
		$this->mockGlobalVariable( 'wgEnableWallExt', true );

		/** @var RequestContext|PHPUnit_Framework_MockObject_MockObject $contextMock */
		$contextMock = $this->getMockBuilder( RequestContext::class )
			->setMethods( [ 'msg' ] )
			->getMock();

		// Return msg key
		$contextMock->expects( $this->any() )
			->method( 'msg' )
			->willReturnCallback( function ( $key ) {
				return new RawMessage( $key );
			} );

		$this->wallTabsRenderer = new WallTabsRenderer( $contextMock );
	}

	/**
	 * @dataProvider provideUserPageContentActions
	 * @param string $title
	 * @param array $expected
	 */
	public function testRendersCorrectUserPageContentActions( string $title, array $expected ) {
		$contentActions = [
			'namespaces' => [
				'user_talk' => [
					'class' => 'new',
					'primary' => true,
				]
			]
		];

		$this->wallTabsRenderer->getContext()->setTitle( Title::makeTitle(NS_USER, $title ) );

		$this->wallTabsRenderer->renderUserPageContentActions( $contentActions );

		$this->assertEquals( $expected, $contentActions );
	}

	public function provideUserPageContentActions(): array {
		return [
			[
				'title' => 'Jandamunda',
				'expected' => [
					'namespaces' => [
						'user_talk' => [
							'class' => [],
							'primary' => true,
							'text' => 'wall-message-wall',
							'href' => '/wiki/Message_Wall:Jandamunda'
						]
					]
				]
			]
		];
	}

	/**
	 * @dataProvider provideUserTalkArchiveContentActions
	 * @param string $title
	 * @param array $expected
	 */
	public function testRendersCorrectUserTalkArchiveContentActions( string $title, array $expected ) {
		$contentActions = [];

		$this->wallTabsRenderer->getContext()->setTitle( Title::makeTitle( NS_USER_WALL, $title ) );

		$this->wallTabsRenderer->renderUserTalkArchiveContentActions( $contentActions );

		$this->assertEquals( $expected, $contentActions );
	}

	public function provideUserTalkArchiveContentActions(): array {
		return [
			[
				'title' => 'Jandamunda',
				'expected' => [
					'namespaces' => [
						'view-source' => [
							'class' => false,
							'text' => 'user-action-menu-view-source',
							'href' => '/wiki/User_talk:Jandamunda?action=edit'
						],
						'history' => [
							'class' => false,
							'text' => 'user-action-menu-history',
							'href' => '/wiki/User_talk:Jandamunda?action=history'
						],
					]
				]
			]
		];
	}
}
