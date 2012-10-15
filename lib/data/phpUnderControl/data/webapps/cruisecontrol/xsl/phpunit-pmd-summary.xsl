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
  
  <xsl:key name="rules" match="/cruisecontrol/pmd/file/violation" use="@rule" />

  <xsl:template match="pmd" mode="rule-summary">
    <p/>
    <table class="result" align="center">
      <colgroup>
        <col width="1%"></col>
        <col width="85%"></col>
        <col width="5%"></col>
        <col width="9%"></col>
      </colgroup>
      <thead>
        <tr>
          <th colspan="2">PHPUnit PMD rule</th>
          <th>Files</th>
          <th>Errors / Warnings</th>
        </tr>
      </thead>
      <tbody>
        <xsl:for-each select="file/violation[generate-id() = generate-id(key('rules', @rule)[1])]">
          <xsl:sort data-type="number" order="descending" select="count(key('rules', @rule))"/>

          <xsl:variable name="errorCount" select="count(key('rules', @rule))"/>
          <xsl:variable name="fileCount" select="count(../../file[violation/@rule=current()/@rule])"/>
          <tr>
            <xsl:if test="position() mod 2 = 1">
              <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td></td>
            <td>              
              <xsl:choose>
                <xsl:when test="@ruleset">
                  <xsl:value-of select="@ruleset"/>
                </xsl:when>
                <xsl:otherwise>
                  <xsl:text>PHPUnit PMD</xsl:text>
                </xsl:otherwise>
              </xsl:choose> / <xsl:value-of select="@rule"/></td>
            <td align="right"><xsl:value-of select="$fileCount"/></td>
            <td align="right"><xsl:value-of select="$errorCount"/></td>
          </tr>
        </xsl:for-each>
        <xsl:if test="count(/cruisecontrol/pmd-cpd/duplication) &gt; 0">
          <xsl:variable name="duplication.count" select="count(/cruisecontrol/pmd-cpd/duplication)" />
          <xsl:variable name="duplication.file.count" select="count(/cruisecontrol/pmd-cpd/duplication/file)" />
          <tr>
            <xsl:if test="count(file/violation[generate-id() = generate-id(key('rules', @rule)[1])]) mod 2 != 1">
              <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td></td>
            <td>PHPUnit CPD / CopyPasteDetection</td>
            <td align="right"><xsl:value-of select="$duplication.file.count" /></td>
            <td align="right"><xsl:value-of select="$duplication.count" /></td>
          </tr>
        </xsl:if>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td align="right"><xsl:value-of select="count(file[violation]) + count(/cruisecontrol/pmd-cpd/duplication/file[@path != /cruisecontrol/pmd/file[violation]/@name])"/></td>
          <td align="right"><xsl:value-of select="count(file/violation) + count(/cruisecontrol/pmd-cpd/duplication)"/></td>
        </tr>
      </tfoot>
    </table>
  </xsl:template>

</xsl:stylesheet>