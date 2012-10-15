<?xml version="1.0"?>
<!--
********************************************************************************
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
* + Redistributions of source code must retain the above copyright
* notice, this list of conditions and the following disclaimer.
*
* + Redistributions in binary form must reproduce the above
* copyright notice, this list of conditions and the following
* disclaimer in the documentation and/or other materials provided
* with the distribution.
*
* + Neither the name of ThoughtWorks, Inc., CruiseControl, nor the
* names of its contributors may be used to endorse or promote
* products derived from this software without specific prior
* written permission.
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
********************************************************************************
-->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:output method="html"
                indent="no"
                encoding="UTF-8"
                standalone="no" />

    <xsl:template match="/">
        <xsl:apply-templates select="." mode="header" />
    </xsl:template>

    <xsl:template match="/" mode="header">
        <xsl:variable name="modification.list" select="cruisecontrol/modifications/modification" />
        <xsl:variable name="project.name" select="cruisecontrol/info/property[@name='projectname']/@value" />
        <xsl:variable name="project.timestamp" select="cruisecontrol/info/property[@name='cctimestamp']/@value" />
        <xsl:variable name="project.buildname"
            select="substring(cruisecontrol/info/property[@name='logfile']/@value, 0, string-length(cruisecontrol/info/property[@name='logfile']/@value) - 3)" />


        <xsl:if test="cruisecontrol/build/@error">
            <h2>
                <xsl:text>BUILD FAILED</xsl:text>
            </h2>
            <dl>
                <dt>
                    <xsl:text>Ant Error Message:</xsl:text>
                </dt>
                <dd>
                    <xsl:value-of select="cruisecontrol/build/@error" />
                </dd>
            </dl>
        </xsl:if>

        <xsl:if test="not (cruisecontrol/build/@error)">
            <h2>
                <xsl:text>BUILD COMPLETE - </xsl:text>
                <xsl:value-of select="cruisecontrol/info/property[@name='label']/@value" />
            </h2>
        </xsl:if>
        <dl>
            <dt>
                <xsl:text>Date of build:</xsl:text>
            </dt>
            <dd>
                <xsl:value-of select="cruisecontrol/info/property[@name='builddate']/@value" />
            </dd>
            <dt>
                <xsl:text>Time to build:</xsl:text>
            </dt>
            <dd>
                <xsl:value-of select="cruisecontrol/build/@time" />
            </dd>
            <xsl:apply-templates select="$modification.list" mode="header">
                <xsl:sort select="date" order="descending" data-type="text" />
            </xsl:apply-templates>
        </dl>

        <ul style="clear:both;margin-top:30px;">
            <li>
                <a href="/cruisecontrol/artifacts/{$project.name}/{$project.timestamp}">Build Artifacts</a>
            </li>
            <li>
                <a href="/cruisecontrol/logs/{$project.name}/{$project.buildname}">XML Log File</a>
            </li>
        </ul>
    </xsl:template>

    <!-- Last Modification template -->
    <xsl:template match="modification" mode="header">
        <xsl:if test="position() = 1">
            <dt>
                <xsl:text>Last changed:</xsl:text>
            </dt>
            <dd>
                <xsl:value-of select="date" />
            </dd>
            <dt>
                <xsl:text>Last log entry:</xsl:text>
            </dt>
            <dd>
                <xsl:value-of select="comment" />
            </dd>
        </xsl:if>
    </xsl:template>

</xsl:stylesheet>