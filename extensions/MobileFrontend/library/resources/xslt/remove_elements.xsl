<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="xml" encoding="UTF-8" indent="yes"/>

	<!--
    roland: remove unnedeed groups from WURFL
    send comments, questions to roland guelle <roldriguez@users.sourceforge.net>
    create a groups file like:
    elements
      groups
        group ... /group
        ...
      /groups
      capabilities
        capability ... /capability
        ...
      /capabilities
    /elements
  -->
	<xsl:param name="file">remove_elements.xml</xsl:param>
	<xsl:param name="elements" select="document($file)"/>

	<xsl:template match="group">
		<xsl:if test="not(@id = $elements/elements/groups/group)">
			<xsl:copy>
				<xsl:apply-templates select="@* | node()"/>
			</xsl:copy>
		</xsl:if>
	</xsl:template>
	<xsl:template match="capability">
		<xsl:if test="not(@name = $elements/elements/capabilities/capability)">
			<xsl:copy>
				<xsl:apply-templates select="@* | node()"/>
			</xsl:copy>
		</xsl:if>
	</xsl:template>

	<xsl:template match="node() | @*">
		<xsl:copy>
			<xsl:apply-templates select="@* | node()"/>
		</xsl:copy>
	</xsl:template>
</xsl:stylesheet>
