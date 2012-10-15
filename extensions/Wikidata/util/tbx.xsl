<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<xsl:param name="siteUrl"/>
	
	<xsl:template match="/">
		<martif type="TBX" xml:lang="en">
		    <martifHeader>
		        <fileDesc>
		            <titleStmt>
		                <title>Wikidata Terms</title>
		            </titleStmt>
		            <sourceDesc>
		                <p>from an OmegaWiki termbase</p>
		            </sourceDesc>
		        </fileDesc>
		        <encodingDesc>
		            <p type="DCSName">SYSTEM "TBXDCSv05b.xml"</p>
		        </encodingDesc>
		    </martifHeader>
		    <text>
		    	<body>
		    		<xsl:apply-templates/>
		  		</body>
		  	</text>
		</martif>
	</xsl:template>
	
	<xsl:template match="/wikidata/body/defined-meaning">
		<xsl:variable name="dmid" select="@defined-meaning-id"/>
		<termEntry>
			<xsl:attribute name="id">
				<xsl:value-of select="$dmid" />
			</xsl:attribute>
			<xref type="externalCrossReference">
				<xsl:attribute name="target">
					<xsl:for-each select="expression">
						<xsl:value-of select="$siteUrl"/><xsl:value-of select="@defined-meaning-defining-expression"/> (<xsl:value-of select="$dmid"/>)
					</xsl:for-each>
				</xsl:attribute>
			</xref>
			<xsl:for-each select="defined-meaning-attributes/relations-list/relations">
				<xsl:if test="relation-type/@defined-meaning-id='3'">
					<descrip type="subjectField"><xsl:value-of select="other-defined-meaning/@defined-meaning-label"/></descrip>
				</xsl:if>
			</xsl:for-each>
			<xsl:for-each select="definition/translated-text-list/translated-text">
				<xsl:variable name="language" select="@language"/>
				<langSet>
					<xsl:attribute name="xml:lang">
						<xsl:value-of select="$language" />
					</xsl:attribute>
					<descripGrp>
						<descrip type="definition"><xsl:value-of select="." /></descrip>
					</descripGrp>
					<ntig>
						<xsl:for-each select="../../../synonyms-translations-list/synonyms-translations/expression[@language=$language]">
							<termGrp>
								<term><xsl:value-of select="." /></term>
								<xsl:for-each select="../object-attributes/option-attribute-values-list/option-attribute-values">
									<xsl:if test="option-attribute[@defined-meaning-id='358760']">
										<termNote type="partOfSpeech"><xsl:value-of select="option-attribute-option/@defined-meaning-label"/></termNote>
									</xsl:if>
								</xsl:for-each>
							</termGrp>
						</xsl:for-each>
					</ntig>
				</langSet>
			</xsl:for-each>
		</termEntry>
	</xsl:template>
</xsl:stylesheet>