<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="2.0">
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
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>
    <xsl:decimal-format decimal-separator="." grouping-separator="," />

    <xsl:variable name="indent.width" select="15" />

    <!--
        Root template
    -->
    <xsl:template match="/">
        <!-- Main table -->
        <table id="phpUnitDetails" class="result">
            <colgroup>
                <col width="10%"/>
                <col width="45%"/>
                <col width="25%"/>
                <col width="10%"/>
                <col width="10%"/>
            </colgroup>
            <thead>
                <tr>
                    <th colspan="3">Name</th>
                    <th>Status</th>
                    <th nowrap="nowrap">Time(s)</th>
                </tr>
            </thead>
            <!-- display test suites -->
            <xsl:apply-templates select="//testsuites/testsuite" />
        </table>
    </xsl:template>

    <!--
        Test Suite Template
        Construct TestSuite section
    -->
    <xsl:template match="testsuite">
        <tbody>
            <tr>
                <xsl:attribute name="class">
                    <xsl:call-template name="build.result" />
                    <xsl:text> phpUnitTestSuite</xsl:text>
                </xsl:attribute>
                <th class="phpUnitTestSuiteName" colspan="4">
                    <xsl:choose>
                        <xsl:when test="@fullPackage">
                            <xsl:value-of select="concat(@fullPackage, '::', @name)"/>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:value-of select="@name"/>
                        </xsl:otherwise>
                    </xsl:choose>
                </th>
                <th class="phpUnitTestSuiteTime">
                    <xsl:value-of select="format-number(@time,'0.000')"/>
                </th>
            </tr>

    <xsl:variable name="data.provider.prefix" select="concat(@name, '::')" />

    <xsl:for-each select="testcase|testsuite">
      <xsl:choose>
        <xsl:when test="name() = 'testcase'">
          <xsl:apply-templates select="." />
        </xsl:when>
        <xsl:otherwise>
          <xsl:choose>
            <xsl:when test="starts-with(@name, $data.provider.prefix)">
              <xsl:apply-templates select="." mode="data.provider" />
            </xsl:when>
            <xsl:otherwise>
              <xsl:apply-templates select="." />
            </xsl:otherwise>
          </xsl:choose>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:for-each>
    </tbody>
  </xsl:template>

  <!--
    Testcase template
    Construct testcase section
  -->
  <xsl:template match="testcase">
    <xsl:param name="sub.test" select="false" />
    <xsl:param name="line.indent" select="0" />

    <xsl:variable name="node.id" select="concat('node-', generate-id(.))" />

    <tr>
      <xsl:attribute name="class">
        <xsl:choose>
          <xsl:when test="error">
            <xsl:text>error </xsl:text>
            <xsl:call-template name="is.odd.or.even" />
          </xsl:when>
          <xsl:when test="failure">
            <xsl:text>failure </xsl:text>
            <xsl:call-template name="is.odd.or.even" />
          </xsl:when>
          <xsl:otherwise>
            <xsl:text>success </xsl:text>
            <xsl:call-template name="is.odd.or.even" />
          </xsl:otherwise>
        </xsl:choose>
      </xsl:attribute>
      <td colspan="3">
        <xsl:attribute name="style">
          <xsl:text>background-position:</xsl:text>
          <xsl:value-of select="$line.indent * $indent.width" />
          <xsl:text>px 0;text-indent:</xsl:text>
          <xsl:value-of select="$line.indent * $indent.width" />
          <xsl:text>px;</xsl:text>
        </xsl:attribute>
        <xsl:attribute name="class">
          <xsl:choose>
            <xsl:when test="error">
              <xsl:choose>
                <xsl:when test="error/@type = 'phpUnit_Framework_SkippedTestError'">
                  <xsl:text>skipped</xsl:text>
                </xsl:when>
                <xsl:when test="error/@type = 'phpUnit_Framework_IncompleteTestError'">
                  <xsl:text>unknown</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                  <xsl:text>error</xsl:text>
                </xsl:otherwise>
              </xsl:choose>
            </xsl:when>
            <xsl:when test="failure">
              <xsl:text>failure</xsl:text>
            </xsl:when>
            <xsl:otherwise>
              <xsl:text>success</xsl:text>
            </xsl:otherwise>
          </xsl:choose>
        </xsl:attribute>

        <xsl:if test="$sub.test">
          <xsl:text>#</xsl:text>
          <xsl:value-of select="position()" />
          <xsl:text> - </xsl:text>
        </xsl:if>
        <xsl:value-of select="@name"/>
        <xsl:call-template name="build.identifier" />
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="error">
            <xsl:variable name="link.label">
              <xsl:choose>
                <xsl:when test="error/@type = 'phpUnit_Framework_SkippedTestError' or
                                error/@type = 'phpUnit_Framework_IncompleteTestError'">
                  <xsl:text>Message</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                  <xsl:text>Error</xsl:text>
                </xsl:otherwise>
              </xsl:choose>
            </xsl:variable>
            <a href="#" onclick="$('{$node.id}').toggle(); return false;"><xsl:value-of select="$link.label" /> &#187;</a>
          </xsl:when>
          <xsl:when test="failure">
            <a href="#" onclick="$('{$node.id}').toggle(); return false;">Failure &#187;</a>
          </xsl:when>
          <xsl:otherwise>Success</xsl:otherwise>
        </xsl:choose>
      </td>
      <xsl:choose>
        <xsl:when test="not(failure|error)">
          <td>
            <xsl:value-of select="format-number(@time,'0.000')"/>
          </td>
        </xsl:when>
        <xsl:otherwise>
          <td/>
        </xsl:otherwise>
      </xsl:choose>
    </tr>
    <xsl:if test="./error or ./failure">
      <tr>
        <td></td>
        <td colspan="4">
          <span id="{$node.id}" class="testresults-output-div" style="display:none;">
            <xsl:choose>
              <xsl:when test="./error">
                <h3>Error:</h3>
                <pre><xsl:apply-templates select="error/text()" mode="newline-to-br"/></pre>
              </xsl:when>
              <xsl:otherwise>
                <h3>Failure:</h3>
                <pre><xsl:apply-templates select="failure/text()" mode="newline-to-br"/></pre>
              </xsl:otherwise>
            </xsl:choose>
          </span>
        </td>
      </tr>
    </xsl:if>
  </xsl:template>

  <!--
    TestSuite/TestCase template
    for @dataProvider tests.
  -->
  <xsl:template match="testsuite" mode="data.provider">
    <xsl:param name="line.indent" select="0" />
    <xsl:param name="odd.or.even" select="0" />

    <tr>
      <xsl:attribute name="class">
        <xsl:call-template name="is.odd.or.even" />
      </xsl:attribute>
      <td colspan="3">
        <xsl:attribute name="style">
          <xsl:text>background-position:</xsl:text>
          <xsl:value-of select="$line.indent * $indent.width" />
          <xsl:text>px 0;text-indent:</xsl:text>
          <xsl:value-of select="$line.indent * $indent.width" />
          <xsl:text>px;</xsl:text>
        </xsl:attribute>
        <xsl:attribute name="class">
          <xsl:call-template name="build.result" />
        </xsl:attribute>

        <xsl:value-of select="substring-after(@name, '::')" />
        <xsl:call-template name="build.identifier" />
      </td>
      <td>
          <xsl:choose>
              <xsl:when test="not(testcase/failure|testcase/error)">
                  <xsl:text>Success</xsl:text>
              </xsl:when>
              <xsl:otherwise>
                  <xsl:text>Failure / Error</xsl:text>
              </xsl:otherwise>
          </xsl:choose>
      </td>
      <td>
        <xsl:value-of select="format-number(@time,'0.000')"/>
      </td>
    </tr>
    <xsl:apply-templates select="testcase">
      <xsl:with-param name="sub.test" select="true()" />
      <xsl:with-param name="line.indent" select="$line.indent + 1" />
    </xsl:apply-templates>
    <xsl:apply-templates select="testsuite" mode="data.provider">
      <xsl:with-param name="line.indent" select="$line.indent + 1" />
    </xsl:apply-templates>
  </xsl:template>

  <xsl:template name="build.result">
    <xsl:choose>
      <xsl:when test=".//testcase/error">
        <xsl:text>error</xsl:text>
      </xsl:when>
      <xsl:when test=".//testcase/failure">
        <xsl:text>failure</xsl:text>
      </xsl:when>
      <xsl:otherwise>
        <xsl:text>success</xsl:text>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template name="build.identifier">
    <xsl:if test="@build">
      <em>
        <small>
          <xsl:text> - (build: </xsl:text>
          <strong><xsl:value-of select="@build" /></strong>
          <xsl:text>)</xsl:text>
        </small>
      </em>
    </xsl:if>
  </xsl:template>

  <xsl:template name="is.odd.or.even">
    <xsl:param name="c" select="1" />
    <xsl:param name="n" select="." />
    <xsl:choose>
      <xsl:when test="name($n) = 'testcase' and $n/preceding-sibling::*">
        <xsl:call-template name="is.odd.or.even">
          <xsl:with-param name="c" select="$c + 1" />
          <xsl:with-param name="n" select="$n/preceding-sibling::*[1]" />
        </xsl:call-template>
      </xsl:when>
      <xsl:when test="name($n) = 'testsuite' and $n/preceding-sibling::*">
        <!-- Get preceding node -->
        <xsl:variable name="preceding" select="$n/preceding-sibling::*[1]" />
        <!-- Count child nodes of preceding -->
        <xsl:variable name="child.count" select="count($preceding//testcase) +
                                                 count($preceding//testsuite)" />

        <xsl:call-template name="is.odd.or.even">
          <xsl:with-param name="c" select="$c + 1 + $child.count" />
          <xsl:with-param name="n" select="$preceding" />
        </xsl:call-template>
      </xsl:when>
      <xsl:when test="(name($n) = 'testcase' or name($n) = 'testsuite') and contains($n/../@name, '::')">
        <xsl:call-template name="is.odd.or.even">
          <xsl:with-param name="c" select="$c + 1" />
          <xsl:with-param name="n" select="$n/.." />
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:if test="$c mod 2 = 1">
          <xsl:text>oddrow </xsl:text>
        </xsl:if>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

</xsl:stylesheet>