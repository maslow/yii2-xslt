<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:import href="../_common/lib.xsl"/>
    <xsl:template match="/">
        <html>
            <head>
                <xsl:copy-of select="$head_inner"/>
            </head>
            <body>
                <xsl:copy-of select="$header"/>
                <div>
                    <h3><xsl:value-of select="doc/model/page"/></h3>
                    <p>
                        <xsl:value-of select="doc/model/message"/>
                    </p>
                </div>
                <xsl:copy-of select="$footer"/>
                <xsl:copy-of select="$body_end"/>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>