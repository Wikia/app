// Author : ThomasV - License : GPL

/* add backlink to index page */
function pr_add_source() {
	$( '#ca-nstab-main' ).after( '<li id="ca-proofread-source"><span>' + proofreadpage_source_href + '</span></li>' );
}

jQuery( pr_add_source );
