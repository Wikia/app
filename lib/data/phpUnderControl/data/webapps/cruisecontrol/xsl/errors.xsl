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
    version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns="http://www.w3.org/TR/html4/strict.dtd" >

  <xsl:output method="html"/>

  <xsl:variable name="tasklist" select="/cruisecontrol/build//target/task"/>

  <xsl:template match="/" mode="errors">
    <xsl:variable name="error.messages" select="$tasklist/message[@priority='error' and (../../target/@name != 'php-codesniffer' or text() != 'Result: 1')]"/>
    <xsl:variable name="error.messages.count" select="count($error.messages)" />
    <xsl:variable name="warn.messages" select="$tasklist/message[@priority='warn']"/>
    <xsl:variable name="warn.messages.count" select="count($warn.messages)" />
    
    <xsl:variable name="total.errorMessage.count" select="$warn.messages.count + $error.messages.count"/>

    <xsl:if test="$total.errorMessage.count > 0">
      <table class="result">
        <thead>
          <tr>
            <th>
              Errors / Warnings: (<xsl:value-of select="$error.messages.count"/>
              /
              <xsl:value-of select="$warn.messages.count"/>)
            </th>
          </tr>
        </thead>
        <tbody>
          <xsl:if test="$error.messages.count > 0">
            <tr>
              <td>
                <pre class="error">
                  <xsl:apply-templates select="$error.messages" mode="errors"/>
                </pre>
              </td>
            </tr>
          </xsl:if>
          <xsl:if test="$warn.messages.count > 0">
            <tr>
              <td>
                <pre>
                  <xsl:apply-templates select="$warn.messages" mode="errors"/>
                </pre>
              </td>
            </tr>
          </xsl:if>
        </tbody>
      </table>
    </xsl:if>
  </xsl:template>

  <xsl:template match="message[@priority='error']" mode="errors">
    <xsl:value-of select="text()"/>
    <xsl:if test="count(./../message[@priority='error']) != position()">
      <br class="none"/>
    </xsl:if>
  </xsl:template>

  <xsl:template match="message[@priority='warn']" mode="errors">
    <xsl:if test="not(starts-with(text(),'cvs update'))">
      <xsl:value-of select="text()"/><br class="none"/>
    </xsl:if>
  </xsl:template>

  <xsl:template match="/">
    <xsl:apply-templates select="." mode="errors"/>
  </xsl:template>
  
</xsl:stylesheet>