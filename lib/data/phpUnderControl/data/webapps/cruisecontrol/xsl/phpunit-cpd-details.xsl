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
  
  <xsl:variable name="project" select="/cruisecontrol/info/property[@name='projectname']/@value"/>
  
  <xsl:include href="./phpunit-pmd-summary.xsl" />
  <xsl:include href="./phphelper.xsl" />

  <xsl:template match="/">
    <xsl:apply-templates select="cruisecontrol/pmd"/>

    <script language="javascript" src="../js/shCore.js"></script>
    <script language="javascript" src="../js/shBrushPhp.js"></script>
    <script language="javascript">
      window.onload = function() {
        dp.SyntaxHighlighter.HighlightAll('code');
      }
    </script>
  </xsl:template>

  <xsl:template match="pmd">
    <xsl:variable name="total.error.count" select="count(file/violation)" />
    
    <h2>PHPUnit CPD</h2>
    
    <xsl:apply-templates select="." mode="rule-summary"/>
    <xsl:apply-templates select="//pmd-cpd/duplication" />
  </xsl:template>

  <xsl:template match="duplication">
    <table class="result" align="center">
      <colgroup>
        <col width="5%"/>
        <col width="10%"/>
        <col width="80%"/>
        <col width="5%"/>
      </colgroup>
      <thead>
        <tr><td colspan="4"><br/></td></tr>
        <tr>
          <th colspan="4">Duplication
          (Files: <xsl:value-of select="count(file)" />,
           Lines: <xsl:value-of select="@lines" />,
           Tokens: <xsl:value-of select="@tokens" />)</th>
        </tr>
      </thead>
      <tbody>
        <xsl:for-each select="file">
          <tr>
            <xsl:if test="position() mod 2 = 0">
              <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td></td>
            <td align="right" class="warning"><xsl:value-of select="@line" /></td>
            <td><xsl:value-of select="@path" /></td>
            <td></td>
          </tr>
        </xsl:for-each>
        <tr>
          <td colspan="1"> </td>
          <td colspan="3">
            <textarea name="code" class="php">
              <xsl:text>    </xsl:text>
              <xsl:value-of select="codefragment/text()" />
            </textarea>
          </td>
        </tr>
      </tbody>
    </table>

  </xsl:template>
</xsl:stylesheet>