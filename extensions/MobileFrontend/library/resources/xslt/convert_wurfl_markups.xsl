<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:func="http://exslt.org/functions" xmlns:my="my://7val.sv" version="1.0" extension-element-prefixes="func my">
	<xsl:output method="xml" encoding="UTF-8" indent="yes"/>
	<!--
    roland: convert new markup names to old
    send comments, questions to roland guelle <roldriguez@users.sourceforge.net>
  -->
	<xsl:template match="group[@id='markup']">
		<group id="markup">
			<xsl:text>
    </xsl:text>
			<xsl:comment> old markup names </xsl:comment>
			<xsl:text>
    </xsl:text>
			<xsl:for-each select="capability">
				<xsl:call-template name="old_markup"/>
			</xsl:for-each>
		</group>
	</xsl:template>
	<xsl:template match="node() | @*">
		<xsl:copy>
			<xsl:apply-templates select="@* | node()"/>
		</xsl:copy>
	</xsl:template>
	<xsl:template name="old_markup">
		<capability>
			<xsl:attribute name="name">
				<xsl:value-of select="my:attributes(@name)"/>
			</xsl:attribute>
			<xsl:attribute name="value">
				<xsl:value-of select="my:attributes(@value)"/>
			</xsl:attribute>
		</capability>
		<xsl:text>
    </xsl:text>
	</xsl:template>
	<func:function name="my:attributes">
		<xsl:param name="value"/>
		<xsl:choose>
			<xsl:when test="$value = 'wml_1_1'">
				<func:result select="'wml_11'"/>
			</xsl:when>
			<xsl:when test="$value = 'wml_1_2'">
				<func:result select="'wml_12'"/>
			</xsl:when>
			<xsl:when test="$value = 'wml_1_3'">
				<func:result select="'wml_13'"/>
			</xsl:when>
			<xsl:when test="$value = 'wmlscript_1_0'">
				<func:result select="'wmlscript10'"/>
			</xsl:when>
			<xsl:when test="$value = 'wmlscript_1_1'">
				<func:result select="'wmlscript11'"/>
			</xsl:when>
			<xsl:when test="$value = 'wmlscript_1_2'">
				<func:result select="'wmlscript12'"/>
			</xsl:when>
			<xsl:when test="$value = 'wmlscript_1_3'">
				<func:result select="'wmlscript13'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_wi_w3_xhtmlbasic'">
				<func:result select="'xhtml_basic'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_wi_oma_xhtmlmp_1_0'">
				<func:result select="'xhtml_mobileprofile'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_wi_imode_html_1'">
				<func:result select="'chtml_1'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_wi_imode_html_2'">
				<func:result select="'chtml_2'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_wi_imode_html_3'">
				<func:result select="'chtml_3'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_wi_imode_html_4'">
				<func:result select="'chtml_4'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_wi_imode_html_5'">
				<func:result select="'chtml_5'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_web_3_2'">
				<func:result select="'html32'"/>
			</xsl:when>
			<xsl:when test="$value = 'html_web_4_0'">
				<func:result select="'html40'"/>
			</xsl:when>
			<xsl:otherwise>
				<func:result select="$value"/>
			</xsl:otherwise>
		</xsl:choose>
	</func:function>
</xsl:stylesheet>
