<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="xml" encoding="UTF-8" indent="yes" cdata-section-elements="statement"/>
	<!--
      patch WURFL with overlay XML
      send comments, questions to roland guelle <roldriguez@users.sourceforge.net>
  -->
	<xsl:param name="file">patchfile.xml</xsl:param>
	<xsl:param name="patch_file" select="document($file,/wurfl_patch)"/>

	<xsl:template match="/">
		<wurfl>
			<xsl:copy-of select="/wurfl/version"/>
			<xsl:apply-templates select="/wurfl/devices"/>
		</wurfl>
	</xsl:template>

	<xsl:template match="devices">
		<xsl:copy>
			<xsl:apply-templates/>
			<xsl:if test="$patch_file/wurfl_patch/devices/device[not(@id = current()/device/@id)]">
				<xsl:comment> devices from patchfile <xsl:value-of select="$file"/> </xsl:comment>
				<xsl:apply-templates select="$patch_file/wurfl_patch/devices/device[not(@id = current()/device/@id)]">
					<xsl:with-param name="patch_overlay" select="$patch_file/none"/>
				</xsl:apply-templates>
			</xsl:if>
		</xsl:copy>
	</xsl:template>

	<!--
      patch devices
  -->
	<xsl:template match="device">
		<xsl:param name="patch_overlay" select="$patch_file"/>
		<xsl:variable name="patch" select="$patch_overlay/wurfl_patch/devices/device[@id = current()/@id]"/>
		<!--
			copy comments between current and preceding node
    -->
		<xsl:copy-of select="$patch/preceding-sibling::comment()[following-sibling::device[1]/@id = current()/@id]"/>
		<xsl:copy>
			<xsl:copy-of select="@*"/>
			<xsl:copy-of select="$patch/@*"/>
			<!--
	  	copy groups unknown in WURFL
      -->
			<xsl:apply-templates select="$patch/group[not(@id = current()/group/@id)]">
				<xsl:with-param name="patch" select="$patch"/>
			</xsl:apply-templates>
			<!--
	  	copy groups known in WURFL
      -->
			<xsl:apply-templates>
				<xsl:with-param name="patch" select="$patch"/>
			</xsl:apply-templates>
		</xsl:copy>
	</xsl:template>

	<!--
    group elements
  -->
	<xsl:template match="group">
		<!--
		select="." is only a fake
		if WURFL structure is broken (group as child of devices) XSL generate a 'Evaluating variable patch_group failed'
    -->
		<xsl:param name="patch" select="."/>
		<xsl:variable name="patch_group" select="$patch/group[@id = current()/@id]"/>
		<xsl:choose>
			<!--
	    	check if a patch is available
			-->
			<xsl:when test="$patch/group[@id = current()/@id]">
				<!--
	      copy comments between current and preceding node
	  -->
				<xsl:copy-of select="$patch_group/preceding-sibling::comment()[following-sibling::group[1]/@id = current()/@id]"/>
				<xsl:copy>
					<xsl:copy-of select="@*"/>
					<!--
		copy and overwrite patched attributes
	    -->
					<xsl:copy-of select="$patch_group/@*"/>
					<!--
						copy capabilities unknown in WURFL
	    		-->
					<xsl:apply-templates select="$patch_group/capability[not(@name = current()/capability/@name)]">
						<xsl:with-param name="patch" select="$patch_group"/>
					</xsl:apply-templates>
					<!--
						copy capabilities known in WURFL
	    			-->
					<xsl:apply-templates>
						<xsl:with-param name="patch" select="$patch_group"/>
					</xsl:apply-templates>
				</xsl:copy>
			</xsl:when>
			<xsl:otherwise>
				<!--
	      copy capabilities untouched
	  		-->
				<xsl:copy>
					<xsl:copy-of select="@*"/>
					<xsl:apply-templates>
						<xsl:with-param name="patch" select="$patch_group"/>
					</xsl:apply-templates>
				</xsl:copy>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<!--
      create capability
  -->
	<xsl:template match="capability">
		<xsl:param name="patch" select="."/>
		<xsl:copy-of select="$patch/capability[@name = current()/@name]/preceding-sibling::comment()[following-sibling::capability[1]/@name = current()/@name]"/>
		<xsl:copy>
			<xsl:copy-of select="@*"/>
			<xsl:copy-of select="$patch/capability[@name = current()/@name]/@*"/>
		</xsl:copy>
	</xsl:template>

	<!--
      copy elements
  -->
	<xsl:template match="*|@*|text()|comment()">
		<xsl:param name="patch"/>
		<xsl:copy>
			<xsl:apply-templates>
				<xsl:with-param name="patch" select="$patch"/>
			</xsl:apply-templates>
		</xsl:copy>
	</xsl:template>
</xsl:stylesheet>
