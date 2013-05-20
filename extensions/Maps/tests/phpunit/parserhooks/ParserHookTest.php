<?php

namespace Maps\Test;

/**
 * Tests for the MapsCoordinates class.
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
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @since 2.0
 *
 * @ingroup Maps
 * @ingroup Test
 *
 * @group Maps
 * @group ParserHook
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ParserHookTest extends \MediaWikiTestCase {

	/**
	 * @since 2.0
	 * @return \ParserHook
	 */
	protected abstract function getInstance();

	/**
	 * @since 2.0
	 * @return array
	 */
	public abstract function parametersProvider();

	/**
	 * @dataProvider parametersProvider
	 * @since 2.0
	 * @param array $parameters
	 */
	public function testRender( array $parameters ) {
		$parserHook = $this->getInstance();

		$parser = new \Parser();
		$parser->mOptions = new \ParserOptions();
		$parser->clearState();
		$parser->setTitle( \Title::newMainPage() );

		$renderResult = $parserHook->renderTag( null, $parameters, $parser );
		$this->assertInternalType( 'string', $renderResult );
	}

}