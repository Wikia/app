<?php
/**
 * This file is part of phpUnderControl.
 *
 * PHP Version 5.2.0
 *
 * Copyright (c) 2007-2010, Manuel Pichler <mapi@phpundercontrol.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    Graph
 * @subpackage Input
 * @author     Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright  2007-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.phpundercontrol.org/
 */

/**
 * This class defines a single input rule for a chart input.
 *
 * @category   QualityAssurance
 * @package    Graph
 * @subpackage Input
 * @author     Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright  2007-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.6.1beta1
 * @link       http://www.phpundercontrol.org/
 */
class phpucInputRule
{
    /**
     * The human readable label.
     *
     * @var string
     */
    public $label = null;

    /**
     * The xpath query for data selection.
     *
     * @var string
     */
    public $xpath = null;

    /**
     * The value calculation mode.
     *
     * @var integer
     */
    public $mode = null;

    /**
     * List of valid modes.
     *
     * @var array(integer)
     */
    private $modes = array(
        phpucInputI::MODE_COUNT,
        phpucInputI::MODE_SUM,
        phpucInputI::MODE_VALUE,
        phpucInputI::MODE_LIST,
    );

    /**
     * Constructs a new input rule
     *
     * @param string  $label The human readable legend name.
     * @param string  $xpath The data select xpath query.
     * @param integer $mode  The value calculation mode.
     *
     * @throws InvalidArgumentException For an invalid calculation mode.
     */
    public function __construct( $label, $xpath, $mode )
    {
        $this->label = $label;
        $this->xpath = $xpath;

        if ( !in_array( $mode, $this->modes ) )
        {
            throw new InvalidArgumentException( 'Invalid rule mode given.' );
        }
        $this->mode = $mode;
    }
}