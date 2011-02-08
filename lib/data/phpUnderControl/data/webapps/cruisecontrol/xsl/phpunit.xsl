<?xml version="1.0"?>
<!--********************************************************************************
 * CruiseControl, a Continuous Integration Toolkit
 * Copyright (c) 2001, ThoughtWorks, Inc.
 * 200 E. Randolph, 25th Floor
 * Chicago, IL 60601 USA
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *     + Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *
 *     + Redistributions in binary form must reproduce the above
 *       copyright notice, this list of conditions and the following
 *       disclaimer in the documentation and/or other materials provided
 *       with the distribution.
 *
 *     + Neither the name of ThoughtWorks, Inc., CruiseControl, nor the
 *       names of its contributors may be used to endorse or promote
 *       products derived from this software without specific prior
 *       written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE REGENTS OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ********************************************************************************-->
<xsl:stylesheet
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"
    xmlns:lxslt="http://xml.apache.org/xslt">

    <xsl:output method="html"/>

    <xsl:variable name="testsuite.list" select="//testsuite"/>
    <xsl:variable name="testsuite.error.count" select="count($testsuite.list/error)"/>
    <xsl:variable name="testcase.list" select="$testsuite.list/testcase"/>
    <xsl:variable name="testcase.error.list" select="$testcase.list/error"/>
    <xsl:variable name="testcase.failure.list" select="$testcase.list/failure"/>
    <xsl:variable name="totalErrorsAndFailures" select="count($testcase.error.list) + count($testcase.failure.list) + $testsuite.error.count"/>

  <xsl:template match="/" mode="unittests">
    <table class="result" align="center">
      <thead>
        <tr>
          <th colspan="4">
            Unit Tests: (<xsl:value-of select="count($testcase.list)"/>)
          </th>
        </tr>
      </thead>
      <tbody>
        <xsl:choose>
          <xsl:when test="count($testsuite.list) = 0">
            <tr>
              <td colspan="2">No Tests Run</td>
            </tr>
            <tr>
              <td colspan="2" class="error">This project doesn't have any tests</td>
            </tr>
          </xsl:when>
          <xsl:when test="$totalErrorsAndFailures = 0">
            <tr>
              <td colspan="2">All Tests Passed</td>
            </tr>
          </xsl:when>
        </xsl:choose>
        <xsl:apply-templates select="$testcase.error.list|$testcase.failure.list" mode="unittests"/>
        <tr><td colspan="2">&#160;</td></tr>
        <xsl:if test="$totalErrorsAndFailures > 0">

        </xsl:if>
      </tbody>
    </table>
  </xsl:template>

    <!-- UnitTest Errors -->
    <xsl:template match="error" mode="unittests">
      <tr>
        <xsl:if test="position() mod 2 = 1">
          <xsl:attribute name="class">oddrow</xsl:attribute>
        </xsl:if>
        <td width="50">
          <xsl:attribute name="class">
            <xsl:choose>
              <xsl:when test="@type = 'PHPUnit_Framework_SkippedTestError'">
                <xsl:text>skipped</xsl:text>
              </xsl:when>
              <xsl:when test="@type = 'PHPUnit_Framework_IncompleteTestError'">
                <xsl:text>unknown</xsl:text>
              </xsl:when>
              <xsl:otherwise>
                <xsl:text>error</xsl:text>
              </xsl:otherwise>
            </xsl:choose>
          </xsl:attribute>
          <xsl:choose>
            <xsl:when test="@type = 'PHPUnit_Framework_SkippedTestError'">
              <xsl:text>skipped</xsl:text>
            </xsl:when>
            <xsl:when test="@type = 'PHPUnit_Framework_IncompleteTestError'">
              <xsl:text>incomplete</xsl:text>
            </xsl:when>
            <xsl:otherwise>
              <xsl:text>error</xsl:text>
            </xsl:otherwise>
          </xsl:choose>
        </td>
        <td width="300">
            <a class="stealth" href="?tab=testResults">
                <xsl:value-of select="..//..//@name"/>::<xsl:value-of select="../@name"/>()
            </a>
        </td>
        <td class="unittests-data" colspan="2">
          <xsl:value-of select="..//..//@name"/>
        </td>
      </tr>
    </xsl:template>

    <!-- UnitTest Failures -->
    <xsl:template match="failure" mode="unittests">
        <tr>
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td class="failure" width="50">
                failure
            </td>
            <td width="300">
                <a class="stealth" href="?tab=testResults">
                    <xsl:value-of select="..//..//@name"/>::<xsl:value-of select="../@name"/>()
                </a>
            </td>
            <td class="unittests-data" colspan="2">
        
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>