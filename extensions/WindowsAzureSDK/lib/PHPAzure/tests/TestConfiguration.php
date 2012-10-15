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
 * @package    UnitTests
 * @version    $Id: TestConfiguration.php 66210 2011-11-08 12:44:39Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

/**
 * Include path
 */
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../library');

/**
 * Proxy settings
 */
define('TESTS_STORAGE_USEPROXY',                false);
define('TESTS_STORAGE_PROXY',                   '');
define('TESTS_STORAGE_PROXY_PORT',              '8080');
define('TESTS_STORAGE_PROXY_CREDENTIALS',       '');

/**
 * Azure hosts
 */
define('TESTS_BLOB_HOST_DEV',                   '127.0.0.1:10000');
define('TESTS_QUEUE_HOST_DEV',                  '127.0.0.1:10001');
define('TESTS_TABLE_HOST_DEV',                  '127.0.0.1:10002');
define('TESTS_BLOB_HOST_PROD',                  'blob.core.windows.net');
define('TESTS_QUEUE_HOST_PROD',                 'queue.core.windows.net');
define('TESTS_TABLE_HOST_PROD',                 'table.core.windows.net');

/**
 * Credentials
 */
define('TESTS_STORAGE_ACCOUNT_DEV',             'devstoreaccount1');
define('TESTS_STORAGE_KEY_DEV',                 'Eby8vdM02xNOcqFlqUwJPLlmEtlCDXJ1OUzFT50uSRZ6IFsuFq2UVErCz4I6tq/K1SZFPTOtr/KBHBeksoGMGw==');
define('TESTS_STORAGE_ACCOUNT_PROD',            'phptestsdk');
define('TESTS_STORAGE_KEY_PROD',                '');

/**
 * Blob storage tests
 */
define('TESTS_BLOB_RUNTESTS',                   true);
define('TESTS_BLOB_RUNONPROD',                  false);
define('TESTS_BLOB_RUNLARGEBLOB',               true);
define('TESTS_BLOB_CONTAINER_PREFIX',           'phpazuretestblob');
define('TESTS_BLOBSTREAM_CONTAINER_PREFIX',     'phpazureteststream');
define('TESTS_BLOBSA_CONTAINER_PREFIX',         'phpazuretestshared');

/**
 * Table storage tests
 */
define('TESTS_TABLE_RUNTESTS',                  true);
define('TESTS_TABLE_RUNONPROD',                 false);
define('TESTS_TABLE_TABLENAME_PREFIX',          'phpazuretesttable');

/**
 * Queue storage tests
 */
define('TESTS_QUEUE_RUNTESTS',                  true);
define('TESTS_QUEUE_RUNONPROD',                 false);
define('TESTS_QUEUE_PREFIX',                    'phpazuretestqueue');

/**
 * SessionHandler tests
 */
define('TESTS_SESSIONHANDLER_RUNTESTS',         true);
define('TESTS_SESSIONHANDLER_RUNONPROD',        false);
define('TESTS_SESSIONHANDLER_TABLENAME_PREFIX', 'phpazuretestsession');

/**
 * Diagnostics tests
 */
define('TESTS_DIAGNOSTICS_RUNTESTS',            true);
define('TESTS_DIAGNOSTICS_RUNONPROD',           false);
define('TESTS_DIAGNOSTICS_CONTAINER_PREFIX',    'phpazuretestdiag');

/**
 * Management tests
 */
define('TESTS_MANAGEMENT_RUNTESTS',             true);
define('TESTS_MANAGEMENT_CONTAINER',            'phpazuretestmgmt');
define('TESTS_MANAGEMENT_SERVICENAME',          'phptest-sdk');
define('TESTS_MANAGEMENT_SUBSCRIPTIONID',       '');
define('TESTS_MANAGEMENT_CERTIFICATEPASSWORD',  'phpazure');

/**
 * SQL Management tests
 */
define('TESTS_SQLMANAGEMENT_RUNTESTS',             true);
define('TESTS_SQLMANAGEMENT_SUBSCRIPTIONID',       '');
define('TESTS_SQLMANAGEMENT_CERTIFICATEPASSWORD',  'phpazure');

/**
 * PHPUnit Code Coverage / Test Report
 */
define('TESTS_GENERATE_REPORT',                 true);
define('TESTS_GENERATE_REPORT_TARGET',          '/path/to/target');