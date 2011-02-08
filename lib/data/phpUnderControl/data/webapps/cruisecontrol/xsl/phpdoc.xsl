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
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/TR/html4/strict.dtd" >

  <xsl:output method="html"/>

  <xsl:variable name="phpdoc.tasklist" 
                select="/cruisecontrol/build//target[@name='phpdoc']/task[@name='exec']"/>

  <xsl:template match="/" mode="phpdoc">
    <xsl:variable name="phpdoc.error.messages" 
                  select="$phpdoc.tasklist/message[
                            contains(text(), 'ERROR in') or 
                            contains(text(), 'ERROR:')
                          ]" />
    <xsl:variable name="phpdoc.warn.messages" 
                  select="$phpdoc.tasklist/message[
                            contains(text(), 'WARNING in') or 
                            contains(text(), 'WARNING:')
                          ]" />
    <xsl:variable name="total.errorMessage.count" 
                  select="count($phpdoc.warn.messages) + 
                          count($phpdoc.error.messages)" />

    <xsl:if test="$total.errorMessage.count > 0">
      <table class="result" align="center">
        <thead>
          <tr>
            <th>
              <xsl:text>phpdoc Errors / Warnings: (</xsl:text>
              <xsl:value-of select="count($phpdoc.error.messages)"/>
              <xsl:text> / </xsl:text>
              <xsl:value-of select="count($phpdoc.warn.messages)" />
              <xsl:text>)</xsl:text>
            </th>
          </tr>
        </thead>
        <xsl:if test="count($phpdoc.error.messages) > 0">
          <tbody>
            <xsl:for-each select="$phpdoc.error.messages">
              <tr>
                <xsl:if test="position() mod 2 = 1">
                  <xsl:attribute name="class">oddrow</xsl:attribute>
                </xsl:if>
                <td class="error">
                  <xsl:value-of select="text()"/>
                </td>
              </tr>
            </xsl:for-each>
          </tbody>
        </xsl:if>
      </table>
    </xsl:if>
  </xsl:template>

  <xsl:template match="/">
    <xsl:apply-templates select="." mode="phpdoc"/>
  </xsl:template>
  
</xsl:stylesheet>
