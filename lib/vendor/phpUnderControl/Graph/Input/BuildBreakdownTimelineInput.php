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
 * This input provides data for the timeline of good and broken builds.
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
class phpucBuildBreakdownTimelineInput extends phpucAbstractInput
{
    /**
     * Constructs a build timeline input instance.
     */
    public function __construct()
    {
        parent::__construct(
            'Breakdown of Build Timeline', 
            '02-breakdown-of-build-timeline', 
            phpucChartI::TYPE_DOT
        );
        
        $this->yAxisLabel = 'Time';
        $this->xAxisLabel = 'Date ';
        
        $this->addRule(
            new phpucInputRule(
                'builddate',
                '/cruisecontrol/info[1]/property[@name = "builddate"]/@value',
                self::MODE_VALUE
                
            )
        );
        $this->addRule(
            new phpucInputRule(
                'builddate_error',
                '/cruisecontrol[
                     build/@error
                 ]/info[1]/property[
                     @name = "builddate"
                 ]/@value',
                self::MODE_VALUE
                
            )
        );
    }
    
    /**
     * Counts te good and broken builds and extracts the day time.
     *
     * @param array(string=>array) $logs Fetched log data.
     * 
     * @return array(string=>array)
     */
    protected function postProcessLog( array $logs )
    {
        $data = array();
        
        foreach ( $logs['builddate'] as $date )
        {
            // Generate time stamp
            $timestamp = strtotime( $date );

            $label = 'Good Builds';
            if ( in_array( $date, $logs['builddate_error'] ) )
            {
                $label = 'Broken Builds';
            }
            
            $data[$label][$timestamp] = date( 'H:i', $timestamp );
        }
        
        krsort( $data );
        
        return $data;
    }
}
