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
  
  <xsl:key name="sources" match="/cruisecontrol/checkstyle/file/error" use="@source" />

  <xsl:template match="checkstyle" mode="phpcs-summary">
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
          <th colspan="2">PHP CodeSniffer violation</th>
          <th>Files</th>
          <th>Errors</th>
        </tr>
      </thead>
      <tbody>
        <xsl:for-each select="file/error[generate-id() = generate-id(key('sources', @source)[1])]">
          <xsl:sort data-type="number" order="descending" select="count(key('sources', @source))"/>
          <xsl:variable name="errorCount" select="count(key('sources', @source))"/>
          <xsl:variable name="fileCount" select="count(../../file[error/@source=current()/@source])"/>
          <tr>
            <xsl:if test="position() mod 2 = 1">
              <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td></td>
            <td>              
                <xsl:value-of select="@source"/>
            </td>
            <td align="right"><xsl:value-of select="$fileCount"/></td>
            <td align="right"><xsl:value-of select="$errorCount"/></td>
          </tr>
        </xsl:for-each>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td align="right"><xsl:value-of select="count(file[error])"/></td>
          <td align="right"><xsl:value-of select="count(file/error)"/></td>
        </tr>
      </tfoot>
    </table>
  </xsl:template>

</xsl:stylesheet>