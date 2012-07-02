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
 * @version    $Id: SharedKeyCredentialsTest.php 22847 2009-06-24 06:51:14Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

date_default_timezone_set('UTC');
require_once dirname(__FILE__) . '/../../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/Credentials/SharedAccessSignature.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: SharedKeyCredentialsTest.php 22847 2009-06-24 06:51:14Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_Credentials_SharedAccessSignatureTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test signing a container
     */
    public function testGenerateSignatureContainer()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedAccessSignature('myaccount', 'WXuEUKMijV/pxUu5/RhDn1bYRuFlLSbmLUJJWRqYQ/uxbMpEx+7S/jo9sT3ZIkEucZGbEafDuxD1kwFOXf3xyw==', false);
        $result = $credentials->createSignature(
            'pictures',
            'c',
            'r',
            '2009-02-09',
            '2009-02-10',
            'YWJjZGVmZw=='
        );
        $this->assertEquals('TEfqYYiY9Qrb7fH7nhiRCP9o5BzfO/VL8oYgfVpUl6s=', $result);
    }
    
    /**
     * Test signing a blob
     */
    public function testGenerateSignatureBlob()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedAccessSignature('myaccount', 'WXuEUKMijV/pxUu5/RhDn1bYRuFlLSbmLUJJWRqYQ/uxbMpEx+7S/jo9sT3ZIkEucZGbEafDuxD1kwFOXf3xyw==', false);
        $result = $credentials->createSignature(
            'pictures/blob.txt',
            'b',
            'r',
            '2009-08-14T11:03:40Z',
            '2009-08-14T11:53:40Z'
        );
        $this->assertEquals('hk78uZGGWd8B2NYoBwKSPs5gen3xYqsd3DPO8BQhgTU=', $result);
    }
    
    /**
     * Test container signed query string
     */
    public function testContainerSignedQueryString()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedAccessSignature('myaccount', '', false);
        $result = $credentials->createSignedQueryString(
            'pictures',
            '',
            'c',
            'r',
            '2009-02-09',
            '2009-02-10',
            'YWJjZGVmZw=='
        );
        $this->assertEquals('st=2009-02-09&se=2009-02-10&sr=c&sp=r&si=YWJjZGVmZw%3D%3D&sig=iLe%2BC%2Be85l8%2BMneC9psdTCg7hJxKh314aRq3SnqPuyM%3D', $result);
    }
    
    /**
     * Test blob signed query string
     */
    public function testBlobSignedQueryString()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedAccessSignature('myaccount', '', false);
        $result = $credentials->createSignedQueryString(
            'pictures/blob.txt',
        	'',
            'b',
            'w',
            '2009-02-09',
            '2009-02-10'
        );
        $this->assertEquals('st=2009-02-09&se=2009-02-10&sr=b&sp=w&sig=MUrHltHOJkj4425gorWWKr%2FO6mHC3XeRQ2MD6jn8jI8%3D', $result);
    }
    
    /**
     * Test sign request URL
     */
    public function testSignRequestUrl()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedAccessSignature('myaccount', '', false);
        $queryString = $credentials->createSignedQueryString('pictures/blob.txt', '', 'b', 'r', '2009-02-09', '2009-02-10');
        
        $credentials->setPermissionSet(array(
            'http://blob.core.windows.net/myaccount/pictures/blob.txt?' . $queryString
        ));

        $requestUrl = 'http://blob.core.windows.net/myaccount/pictures/blob.txt?comp=metadata';
        $result = $credentials->signRequestUrl($requestUrl, Microsoft_WindowsAzure_Storage::RESOURCE_BLOB);
        
        $this->assertEquals('http://blob.core.windows.net/myaccount/pictures/blob.txt?comp=metadata&' . $queryString, $result);
    }
}