<?php
/**
 * Copyright (c) 2009 - 2011, RealDolmen
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of RealDolmen nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY RealDolmen ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL RealDolmen BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: BlobStorageTest.php 14561 2009-05-07 08:05:12Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

date_default_timezone_set('UTC');
require_once dirname(__FILE__) . '/../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/Storage/TableEntity.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: BlobStorageTest.php 14561 2009-05-07 08:05:12Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_TableEntityTest extends PHPUnit_Framework_TestCase
{    
    /**
     * Test constructor
     */
    public function testConstructor()
    {
        $target = new TSETTest_TestEntity('partition1', '000001');
        $this->assertEquals('partition1', $target->getPartitionKey());
        $this->assertEquals('000001',     $target->getRowKey());
    }
    
    /**
     * Test get Azure values
     */
    public function testGetAzureValues()
    {
        $target = new TSETTest_TestEntity('partition1', '000001');
        $result = $target->getAzureValues();
        
        $this->assertEquals('Name',       $result[0]->Name);
        $this->assertEquals(null,         $result[0]->Value);
        
        $this->assertEquals('Age',        $result[1]->Name);
        $this->assertEquals('Edm.Int64',  $result[1]->Type);
        
        $this->assertEquals('Visible',    $result[2]->Name);
        $this->assertEquals(false,        $result[2]->Value);
        
        $this->assertEquals('partition1', $result[3]->Value);
        $this->assertEquals('000001',     $result[4]->Value);
    }
    
    /**
     * Test set Azure values
     */
    public function testSetAzureValuesSuccess()
    {
        $values = array(
            'PartitionKey' => 'partition1',
            'RowKey' => '000001',
            'Name' => 'Maarten',
            'Age' => 25,
            'Visible' => true
        );
        
        $target = new TSETTest_TestEntity();
        $target->setAzureValues($values);
        
        $this->assertEquals('partition1', $target->getPartitionKey());
        $this->assertEquals('000001',     $target->getRowKey());
        $this->assertEquals('Maarten',    $target->FullName);
        $this->assertEquals(25,           $target->Age);
        $this->assertEquals(true,         $target->Visible);
    }
    
    /**
     * Test set Azure values
     */
    public function testSetAzureValuesFailure()
    {
        $values = array(
            'PartitionKey' => 'partition1',
            'RowKey' => '000001'
        );
        
        $exceptionRaised = false;
        $target = new TSETTest_TestEntity();
        try 
        {
            $target->setAzureValues($values, true);
        }
        catch (Exception $ex) {
            $exceptionRaised = true;
        }
        
        $this->assertTrue($exceptionRaised);
    }
}

/**
 * Test entity
 */
class TSETTest_TestEntity extends Microsoft_WindowsAzure_Storage_TableEntity
{
    /**
     * @azure Name
     */
    public $FullName;
    
    /**
     * @azure Age Edm.Int64
     */
    public $Age;
    
    /**
     * @azure Visible Edm.Boolean
     */
    public $Visible = false;
}