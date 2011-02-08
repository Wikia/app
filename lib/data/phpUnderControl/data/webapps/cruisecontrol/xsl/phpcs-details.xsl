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
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="html"/>
  
  <xsl:param name="viewcvs.url"/>
  <xsl:param name="cvsmodule" select="concat(/cruisecontrol/info/property[@name='projectname']/@value, '/source/src/')"/>

  <xsl:variable name="total.error.count" select="count(/cruisecontrol/checkstyle/file/error)" />
  
  <xsl:key name="phpcs.files" match="/cruisecontrol/checkstyle/file" use="@name" />
  
  <xsl:include href="phpcs-list.xsl" />
  <xsl:include href="phpcs-summary.xsl" />
  <xsl:include href="phphelper.xsl" />

  <xsl:template match="/">

    <h2>PHPUnit CodeSniffer</h2>
    <xsl:apply-templates select="/cruisecontrol/checkstyle" mode="phpcs-summary"/>
    <xsl:apply-templates select="/cruisecontrol/checkstyle" mode="phpcs-list"/>

    <table class="result">
        <colgroup>
            <col width="5%"></col>
            <col width="5%"></col>
            <col width="90%"></col>
        </colgroup>
        <xsl:apply-templates select="/cruisecontrol/checkstyle" />
    </table>
  </xsl:template>
  
  <xsl:template match="checkstyle[file/error]">
    <xsl:apply-templates select="file[error]">
      <xsl:sort select="@name" />
    </xsl:apply-templates>
  </xsl:template>

  <xsl:template match="file">
    <xsl:variable name="filename" select="translate(@name,'\','/')"/>
    <xsl:variable name="javaclass">
      <xsl:call-template name="phpname">
        <xsl:with-param name="filename" select="$filename"/>
      </xsl:call-template>
    </xsl:variable>
    <thead>
      <tr>
        <td colspan="4"><br /></td>
      </tr>
      <tr>
        <th colspan="4">
          <a>
            <xsl:attribute name="name">
              <xsl:text>a</xsl:text>
              <xsl:value-of select="position()" /> 
            </xsl:attribute>
          </a> 
          <xsl:value-of select="$javaclass"/> 
          (<xsl:value-of select="count(error[@severity='error'])"/>
          / <xsl:value-of select="count(error)"/>)
        </th>
      </tr>
    </thead>
    <tbody>
      <xsl:for-each select="error">
        <tr>
          <xsl:if test="position() mod 2 = 0">
            <xsl:attribute name="class">oddrow</xsl:attribute>
          </xsl:if>
          <td></td>
          <td class="{@severity}" align="right">
            <xsl:call-template name="viewcvs">
              <xsl:with-param name="file" select="@name"/>
              <xsl:with-param name="line" select="@line"/>
              <xsl:with-param name="col" select="@column"/>
            </xsl:call-template>
          </td>
          <td><xsl:value-of select="@message"/></td>
          <td><xsl:value-of select="@source"/></td>
        </tr>
      </xsl:for-each>
    </tbody>
  </xsl:template>

  <xsl:template name="viewcvs">
    <xsl:param name="file"/>
    <xsl:param name="line"/>
    <xsl:param name="col"/>
    <xsl:choose>
      <xsl:when test="not($viewcvs.url)">
        <xsl:value-of select="$line"/>:<xsl:value-of select="$col"/>
      </xsl:when>
      <xsl:otherwise>
        <a>
          <xsl:attribute name="href">
            <xsl:value-of select="concat($viewcvs.url, $cvsmodule)"/>
            <xsl:value-of select="substring-after($file, $cvsmodule)"/>
            <xsl:text>?annotate=HEAD#</xsl:text>
            <xsl:value-of select="$line"/>
          </xsl:attribute>
          <xsl:value-of select="$line"/>
        </a>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

</xsl:stylesheet>
