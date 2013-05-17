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
    <xsl:param name="cvsmodule" select="concat($project, '/source/src/')"/>
    <xsl:param name="pmd.warning.threshold" select="11"/>

    <xsl:variable name="project" select="/cruisecontrol/info/property[@name='projectname']/@value"/>
    <xsl:variable name="total.error.count" select="count(/cruisecontrol/pmd/file/violation)" />

    <xsl:include href="./phpunit-pmd-summary.xsl" />
    <xsl:include href="./phpunit-pmd-list.xsl" />
    <xsl:include href="./phphelper.xsl" />

    <xsl:template match="/">
        <h2>PHPUnit PMD</h2>
        <xsl:apply-templates select="cruisecontrol/pmd" mode="rule-summary"/>
        <xsl:apply-templates select="cruisecontrol/pmd" mode="phpunit-pmd-list"/>

        <table class="result" align="center">
            <colgroup>
                <col width="5%"></col>
                <col width="10%" style="padding-right:5px;"></col>
                <col width="80%"></col>
                <col width="5%"></col>
            </colgroup>
            <xsl:for-each select="/cruisecontrol/pmd/file[violation]">
                <xsl:sort data-type="number" order="descending" select="count(violation)"/>
                <xsl:apply-templates select="." mode="pmd-file"/>
            </xsl:for-each>
        </table>
    </xsl:template>

    <xsl:template match="file" mode="pmd-file">
        <xsl:variable name="javaclass">
          <xsl:call-template name="phpname">
            <xsl:with-param name="filename" select="@name"/>
          </xsl:call-template>
        </xsl:variable>
        <xsl:variable name="filename" select="translate(@name,'\','/')"/>
        <thead>
          <tr><td colspan="3"><br/></td></tr>
          <tr>
            <th colspan="3">
              <xsl:value-of select="$javaclass"/>
              (<xsl:value-of select="count(violation)"/>)
            </th>
            <th>
                Priority
            </th>
          </tr>
        </thead>
        <tbody>
          <xsl:for-each select="violation">
            <xsl:variable name="style">
              <xsl:choose>
                <xsl:when test="@priority &lt;= 2">error</xsl:when>
                <xsl:otherwise>warning</xsl:otherwise>
              </xsl:choose>
            </xsl:variable>
            <tr>
              <xsl:if test="position() mod 2 = 0">
                <xsl:attribute name="class">oddrow</xsl:attribute>
              </xsl:if>
              <td />
              <td class="{$style}" align="right">
                <xsl:call-template name="viewcvs">
                  <xsl:with-param name="file" select="$filename"/>
                  <xsl:with-param name="beginline" select="@beginline"/>
                  <xsl:with-param name="endline" select="@endline"/>
                </xsl:call-template>
              </td>
              <td>
                <xsl:value-of disable-output-escaping="no" select="."/>
              </td>
              <td align="center">
                <xsl:value-of select="@priority"/>
              </td>
            </tr>
          </xsl:for-each>
        </tbody>
    </xsl:template>

    <xsl:template name="viewcvs">
      <xsl:param name="file"/>
      <xsl:param name="beginline"/>
      <xsl:param name="endline"/>
      <xsl:choose>
        <xsl:when test="not($viewcvs.url)">
            <xsl:call-template name="lines">
              <xsl:with-param name="beginline" select="$beginline"/>
              <xsl:with-param name="endline" select="$endline"/>
            </xsl:call-template>
        </xsl:when>
        <xsl:otherwise>
          <a>
            <xsl:attribute name="href">
              <xsl:value-of select="concat($viewcvs.url, $cvsmodule)"/>
              <xsl:value-of select="substring-after($file, $cvsmodule)"/>
              <xsl:text>?annotate=HEAD#</xsl:text>
              <xsl:value-of select="$beginline"/>
            </xsl:attribute>
            <xsl:call-template name="lines">
              <xsl:with-param name="beginline" select="$beginline"/>
              <xsl:with-param name="endline" select="$endline"/>
            </xsl:call-template>
          </a>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:template>

    <xsl:template name="lines">
      <xsl:param name="beginline"/>
      <xsl:param name="endline"/>
      <xsl:choose>
        <xsl:when test="$beginline = $endline">
          <xsl:value-of select="$beginline"/>
        </xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="$beginline"/> - <xsl:value-of select="$endline"/>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:template>


</xsl:stylesheet>