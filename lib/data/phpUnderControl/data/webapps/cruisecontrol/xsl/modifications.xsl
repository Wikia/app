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
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:output method="html"/>
    <xsl:variable name="modification.list" select="cruisecontrol/modifications/modification"/>
    <xsl:variable name="urlroot" select='"/cruisecontrol/buildresults/"'/>
    <xsl:variable name="currentlog"
            select="substring(cruisecontrol/info/property[@name='logfile']/@value, 0, string-length(cruisecontrol/info/property[@name='logfile']/@value) - 3)" />
    
    <xsl:key name="revkeys" match="cruisecontrol/modifications/modification" use="revision" />

    <xsl:template match="/" mode="modifications">
        <table class="result" align="center">
          <thead>
            <!-- Modifications -->
            <tr>
                <th class="modifications-sectionheader" colspan="6">
                    &#160;Modifications since last successful build:&#160;
                    <xsl:value-of select="count($modification.list)"/> Files in <xsl:value-of select="count(distinct-values(cruisecontrol/modifications/modification/revision))"/> Commits
                </th>
            </tr>
          </thead>
          <tbody>
            <xsl:apply-templates select="$modification.list" mode="modifications">
                <xsl:sort select="date" order="descending" data-type="text" />
                <xsl:sort select="following::revision" order="descending" data-type="text" />
            </xsl:apply-templates>
          </tbody>
        </table>
    </xsl:template>

    <!-- user defined variables for logging into ClearQuest -->
    <xsl:variable name="cqenabled">true</xsl:variable>
    <xsl:variable name="cqserver">localhost</xsl:variable>
    <xsl:variable name="cqschema">2003.06.00</xsl:variable>
    <xsl:variable name="cqdb">RBPRO</xsl:variable>
    <xsl:variable name="cqlogin">admin</xsl:variable>
    <xsl:variable name="cqpasswd">password</xsl:variable>

    <xsl:template match="modification[@type='activity']" mode="modifications">
        <xsl:variable name="cqrecurl">http://<xsl:value-of select="$cqserver"/>/cqweb/main?command=GenerateMainFrame&amp;service=CQ&amp;schema=<xsl:value-of select="$cqschema"/>&amp;contextid=<xsl:value-of select="$cqdb"/>&amp;entityID=<xsl:value-of select="revision"/>&amp;entityDefName=<xsl:value-of select="crmtype"/>&amp;username=<xsl:value-of select="$cqlogin"/>&amp;password=<xsl:value-of select="$cqpasswd"/></xsl:variable>
        <tr valign="top">
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td class="modifications-data">
                <xsl:value-of select="@type"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="user"/>
            </td>
            <td class="modifications-data">
                <xsl:if test="cqenabled">
                    &gt;<a href="{$cqrecurl}" target="_blank"><xsl:value-of select="revision"/></a>
                </xsl:if>
                <xsl:if test="not(cqenabled)">
                    <xsl:value-of select="revision"/>
                </xsl:if>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="date"/>
            </td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="modification[@type='contributor']" mode="modifications">
        <xsl:variable name="cqrecurl">http://<xsl:value-of select="$cqserver"/>/cqweb/main?command=GenerateMainFrame&amp;service=CQ&amp;schema=<xsl:value-of select="$cqschema"/>&amp;contextid=<xsl:value-of select="$cqdb"/>&amp;entityID=<xsl:value-of select="revision"/>&amp;entityDefName=<xsl:value-of select="crmtype"/>&amp;username=<xsl:value-of select="$cqlogin"/>&amp;password=<xsl:value-of select="$cqpasswd"/></xsl:variable>
        <tr valign="top">
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td class="modifications-data">
                <xsl:value-of select="@type"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="user"/>
            </td>
            <td align="right" class="modifications-data">
                <xsl:if test="cqenabled">
                    &gt;<a href="{$cqrecurl}" target="_blank"><xsl:value-of select="revision"/></a>
                </xsl:if>
                <xsl:if test="not(cqenabled)">
                    &gt;<xsl:value-of select="revision"/>
                </xsl:if>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="date"/>
            </td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="modification[@type='ucmdependency']" mode="modifications">
        <tr valign="top">
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>

            <td class="modifications-data">
                <xsl:value-of select="@type"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="user"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="revision"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="date"/>
            </td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
    </xsl:template>


    <!-- P4 changelist template
    <modification type="p4" revision="15">
       <revision>15</revision>
       <user>non</user>
       <client>non:all</client>
       <date>2002/05/02 10:10:10</date>
       <file action="add">
          <filename>myfile</filename>
          <revision>10</revision>
       </file>
    </modification>
    -->
    <xsl:template match="modification[@type='p4']" mode="modifications">
        <tr valign="top">
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td class="modifications-data">
                <xsl:value-of select="revision"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="user"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="client"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="date"/>
            </td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
        <xsl:if test="count(file) > 0">
            <tr valign="top">
                <xsl:if test="position() mod 2 = 1">
                    <xsl:attribute name="class">oddrow</xsl:attribute>
                </xsl:if>
                <td class="modifications-data" colspan="6">
                    <table align="right" cellpadding="1" cellspacing="0" border="0" width="95%">
                        <tr>
                            <td class="changelists-file-header" colspan="3">
                                &#160;Files affected by this changelist:&#160;
                                <xsl:value-of select="count(file)"/> Files in <xsl:value-of select="count(revkeys)"/> Commits
                            </td>
                        </tr>
                        <xsl:apply-templates select="file" mode="modifications"/>
                    </table>
                </td>
            </tr>
        </xsl:if>
    </xsl:template>

    <!-- used by P4 -->
    <xsl:template match="file" mode="modifications">
        <tr valign="top" >
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">changelists-file-oddrow</xsl:attribute>
            </xsl:if>

            <td class="changelists-file-spacer">
                &#160;
            </td>

            <td class="modifications-data">
                <b>
                    <xsl:value-of select="@action"/>
                </b>
            </td>
            <td class="modifications-data" width="100%">
                <xsl:value-of select="filename"/>&#160;
                <xsl:value-of select="revision"/>
            </td>
        </tr>
    </xsl:template>

    <!-- Modifications template for other SourceControls -->
    <xsl:template match="modification[file][@type!='p4']" mode="modifications">
        <tr>
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            
            <xsl:if test="position()=1 or (not(revision=following::revision) and following::revision>0) ">
                <td class="modifications-data">
                    <xsl:attribute name="rowspan"><xsl:value-of select="count(key('revkeys', revision))"/></xsl:attribute>
                    <xsl:value-of select="date"/> <br/> Revision: <xsl:value-of select="revision"/>
                </td>
                <td class="modifications-data">
                    <xsl:attribute name="rowspan"><xsl:value-of select="count(key('revkeys', revision))"/></xsl:attribute>
                    <xsl:value-of select="user"/>
                </td>
            </xsl:if>

            <td class="modifications-data">
                <xsl:value-of select="file/@action"/>
            </td>
            <td class="modifications-data">
                <xsl:if test="file/project">
                    <xsl:value-of select="file/project"/>
                    <!-- the following doesn't work with JDK 1.5.0, so it's disabled by default:
                    <xsl:value-of select="system-property('file.separator')"/>
                    -->
                    <xsl:value-of select="'/'"/>
                </xsl:if>

                <a href="?log={$currentlog}&amp;tab=changeset#{file/filename}.r{revision}">
                    <xsl:value-of select="file/filename"/>
                </a>
            </td>
            <xsl:if test="position()=1 or (not(revision=following::revision) and following::revision>0) ">
                <td class="modifications-data">
                    <xsl:attribute name="rowspan"><xsl:value-of select="count(key('revkeys', revision))"/></xsl:attribute>
                    <xsl:variable name="convertedComment">
                        <xsl:call-template name="newlineToHTML">
                            <xsl:with-param name="line">
                                <xsl:value-of select="comment"/>
                            </xsl:with-param>
                        </xsl:call-template>
                    </xsl:variable>
                    <xsl:copy-of select="$convertedComment"/>
                </td>
            </xsl:if>
        </tr>
        <xsl:variable name="rev" select="revision"/>
    </xsl:template>

    <xsl:template match="modification[file][@type='buildstatus']" mode="modifications">
        <tr>
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>

            <td class="modifications-data">
                <xsl:value-of select="file/@action"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="user"/>
            </td>
            <td class="modifications-data">
                <xsl:if test="file/project">
                    <xsl:value-of select="file/project"/>
                    <!-- the following doesn't work with JDK 1.5.0, so it's disabled by default:
                    <xsl:value-of select="system-property('file.separator')"/>
                    -->
                    <xsl:value-of select="'/'"/>
                </xsl:if>
                <xsl:for-each select="file/filename">
                        <xsl:variable name="thefile" select="substring(current(),1,string-length(current())-4)"/>
                        <xsl:variable name="theproject" select="../../comment"/>
                        <a href="{$urlroot}{$theproject}?log={$thefile}">
                                <xsl:copy-of select="$thefile"/>
                        </a>
                </xsl:for-each>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="date"/>
            </td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
    </xsl:template>

    <!-- Up to version 2.1.6 the modification set format did not
         include the file node -->
    <xsl:template match="modification" mode="modifications">
        <tr>
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">oddrow</xsl:attribute>
            </xsl:if>
            <td class="modifications-data">
                <xsl:value-of select="user"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="@type"/>
            </td>
            <td class="modifications-data">
                <xsl:if test="project">
                    <xsl:value-of select="project"/>
                    <!-- the following doesn't work with JDK 1.5.0, so it's disabled by default:
                    <xsl:value-of select="system-property('file.separator')"/>
                    -->
                    <xsl:value-of select="'/'"/>
                </xsl:if>
                <xsl:value-of select="filename"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="date"/>
            </td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
    </xsl:template>

    <!-- Used by CM Synergy -->
    <xsl:template match="modification[@type='ccmtask']" mode="modifications">
        <tr>
            <td class="modifications-sectionheader">Task</td>
            <td class="modifications-sectionheader">Owner</td>
            <td class="modifications-sectionheader">Release</td>
            <td class="modifications-sectionheader">Change Request(s)</td>
            <td class="modifications-sectionheader">Completion Date</td>
            <td class="modifications-sectionheader">Synopsis</td>
        </tr>
        <tr valign="top">
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">changelists-oddrow</xsl:attribute>
            </xsl:if>
            <xsl:if test="position() mod 2 = 0">
                <xsl:attribute name="class">changelists-evenrow</xsl:attribute>
            </xsl:if>
            <td class="modifications-data">
                <b><xsl:copy-of select="task"/></b>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="user"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="revision"/>
            </td>
            <td class="modifications-data">
                <xsl:apply-templates select="ccmcr" mode="modifications"/>
            </td>
            <td class="modifications-data">
                <xsl:value-of select="date"/>
            </td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
        <xsl:if test="count(ccmobject) > 0">
            <tr valign="top">
                <xsl:if test="position() mod 2 = 1">
                    <xsl:attribute name="class">changelists-oddrow</xsl:attribute>
                </xsl:if>
                <xsl:if test="position() mod 2 = 0">
                    <xsl:attribute name="class">changelists-evenrow</xsl:attribute>
                </xsl:if>
                <td class="modifications-data" colspan="6">
                    <table align="right" cellpadding="1" cellspacing="1" border="0" width="95%">
                        <tr>
                            <td class="changelists-file-header" colspan="7">
                                &#160;Objects associated with this task:&#160;
                                (<xsl:value-of select="count(ccmobject)"/>)
                            </td>
                        </tr>
                        <tr>
                            <td class="changelists-file-header">Object</td>
                            <td class="changelists-file-header">Version</td>
                            <td class="changelists-file-header">Type</td>
                            <td class="changelists-file-header">Instance</td>
                            <td class="changelists-file-header">Project</td>
                            <td class="changelists-file-header">Comment</td>
                        </tr>
                        <xsl:apply-templates select="ccmobject" mode="modifications"/>
                    </table>
                </td>
            </tr>
        </xsl:if>
    </xsl:template>
    <xsl:template match="ccmobject" mode="modifications">
        <tr valign="top" >
            <xsl:if test="position() mod 2 = 1">
                <xsl:attribute name="class">changelists-file-oddrow</xsl:attribute>
            </xsl:if>
            <xsl:if test="position() mod 2 = 0">
                <xsl:attribute name="class">changelists-file-evenrow</xsl:attribute>
            </xsl:if>
            <td class="modifications-data"><b><xsl:value-of select="name"/></b></td>
            <td class="modifications-data"><xsl:value-of select="version"/></td>
            <td class="modifications-data"><xsl:value-of select="type"/></td>
            <td class="modifications-data"><xsl:value-of select="instance"/></td>
            <td class="modifications-data"><xsl:value-of select="project"/></td>
            <td class="modifications-data">
                <xsl:variable name="convertedComment">
                    <xsl:call-template name="newlineToHTML">
                        <xsl:with-param name="line">
                            <xsl:value-of select="comment"/>
                        </xsl:with-param>
                    </xsl:call-template>
                </xsl:variable>
                <xsl:copy-of select="$convertedComment"/>
            </td>
        </tr>
    </xsl:template>
    <xsl:template match="ccmcr" mode="modifications">
        <xsl:if test="position() != 1">
            ,
        </xsl:if>
        <xsl:copy-of select="*"/>
    </xsl:template>

    <xsl:template match="/">
        <xsl:apply-templates select="." mode="modifications"/>
    </xsl:template>

    <xsl:template name="newlineToHTML">
        <xsl:param name="line"/>
        <xsl:choose>
            <xsl:when test="contains($line, '&#xA;')">
                <xsl:call-template name="hyperlink">
                    <xsl:with-param name="text">
                        <xsl:copy-of select="substring-before($line, '&#xA;')"/>
                    </xsl:with-param>
                </xsl:call-template>
                <br/>
                <xsl:call-template name="newlineToHTML">
                    <xsl:with-param name="line">
                        <xsl:copy-of select="substring-after($line, '&#xA;')"/>
                    </xsl:with-param>
                </xsl:call-template>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="hyperlink">
                    <xsl:with-param name="text">
                        <xsl:copy-of select="$line"/>
                    </xsl:with-param>
                </xsl:call-template>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    
    <xsl:template name="hyperlink">
        <xsl:param name="text"/>
        <xsl:choose>
            <xsl:when test="contains($text, 'http://')">
                <xsl:analyze-string select="$text" regex="http://[^ &lt;()]+">
                    <xsl:matching-substring>
                        <a target="_blank" href="{.}">
                            <xsl:value-of select="." />
                        </a>
                    </xsl:matching-substring>
                    <xsl:non-matching-substring>
                        <xsl:value-of select="." />
                    </xsl:non-matching-substring>
                </xsl:analyze-string>
            </xsl:when>
            <xsl:when test="contains(upper-case($text), 'BUG')">
                <xsl:analyze-string select="$text" regex="BUG\s?(\d+)" flags="i">
                    <xsl:matching-substring>
                        <a target="_blank" href="http://bugzilla.unister-gmbh.de/show_bug.cgi?id={regex-group(1)}">
                            Bug <xsl:value-of select="regex-group(1)" />
                        </a>
                    </xsl:matching-substring>
                    <xsl:non-matching-substring>
                        <xsl:value-of select="." />
                    </xsl:non-matching-substring>
                </xsl:analyze-string>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$text"/>
            </xsl:otherwise>
        </xsl:choose>
     </xsl:template>
</xsl:stylesheet>
