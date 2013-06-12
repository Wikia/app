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
 * @category  QualityAssurance
 * @package   Graph
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Displays a metrics pie chart.
 *
 * @category  QualityAssurance
 * @package   Graph
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucPieChart extends ezcGraphPieChart implements phpucChartI
{
    /**
     * Constructs a new pie chart instance.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->init();
    }
    
    /**
     * Sets the input instance for the next rendering process.
     *
     * @param phpucAbstractInput $input The input object.
     * 
     * @return void
     */
    public function setInput( phpucAbstractInput $input )
    {
        $this->title = $input->title;
        
        $this->data['label'] = new ezcGraphArrayDataSet( $input->data );
    }

    /**
     * Setter method for the number of log entries shown in a generated chart.
     * phpUnderControl will render all log entries if no value was set.
     *
     * @param integer $numberOfEntries Number of log entries shown in a chart.
     *
     * @return void
     * @SuppressWarnings("PMD.UnusedParameter")
     */
    public function setNumberOfEntries( $numberOfEntries )
    {
        // Nothing todo, the pie chart can contain all entries
    }
    
    /**
     * Initializes the chart properties.
     *
     * @return void
     */
    protected function init()
    {
        $this->palette = new phpucGraphPalette();
        $this->legend  = false;
        
        $this->initTitle();
        $this->initRenderer();
    }
    
    /**
     * Inits the title properties.
     *
     * @return void
     */
    protected function initTitle()
    {
        $this->title->background = '#d3d7cf';
        $this->title->padding = 1;
        $this->title->margin = 1;
        $this->title->border = '#555753';
        $this->title->borderWidth = 1;
    }
    
    /**
     * Creates the used 3D renderer and set's some layout properties. 
     *
     * @return void
     */
    protected function initRenderer()
    {
        $this->renderer = new ezcGraphRenderer3d();

        $this->renderer->options->moveOut = .0;

        $this->renderer->options->pieChartGleam      = .3;
        $this->renderer->options->pieChartGleamColor = '#FFFFFF';

        $this->renderer->options->pieChartShadowSize  = 5;
        $this->renderer->options->pieChartShadowColor = '#2e3436';
        $this->renderer->options->dataBorder          = .2;

        $this->renderer->options->legendSymbolGleam      = .3;
        $this->renderer->options->legendSymbolGleamColor = '#FFFFFF';

        $this->renderer->options->pieChartSymbolColor = '#55575388';

        $this->renderer->options->pieChartHeight   = 6;
        $this->renderer->options->pieChartRotation = .8;
    }
}