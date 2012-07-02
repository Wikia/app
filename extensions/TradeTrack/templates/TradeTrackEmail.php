<?php
class TradeTrackEmail extends QuickTemplate { public function execute() { ?>

<?php
    /**
     * Note that this email does NOT use i18n.  The email template is in English.
     *
     * The reason for this is that the people who will be recieving these emails
     * expect them in English, and MediaWiki will happily translate it to French
     * if the user submitting the trademark request is doing so in French.
     *
  	 * Hence, English here.
  	 *
     */

?>

  A new request to utilize a Wikimedia trademark has arrived.

    Purpose: <?php echo $this->data['tData']['purpose'] ?>
    
    <?php if ( $this->data['tData']['agreementType'] ) { ?>Agreement Type: <?php echo $this->data['tData']['agreementType'] ?><?php } ?>

    Usage: <?php echo $this->data['tData']['usage'] ?>
  
    Marks:<?php foreach ( $this->data['tData']['TRADEMARK_LIST'] as $trademark ) {
        if ( ( isset( $this->data['tData']['trademarks'] ) )
                     &&  ( in_array( $trademark, $this->data['tData']['trademarks'] ) ) ) {
      	  echo wfMsg( "tradetrack-which-$trademark" );
      	  if ( $trademark == 'other' ) {
      	    echo $this->data['tData']['otherval'];
      	  }
      	}
    } ?>
    
    Mailing Address:
    <?php echo $this->data['tData']['mailingaddress'] ?>
  
    Name:  <?php echo $this->data['tData']['name'] ?>
    
    Organization Name: <?php echo $this->data['tData']['orgname'] ?>
    
    Email: <?php echo $this->data['tData']['email'] ?>
    
    Phone: <?php echo $this->data['tData']['phone'] ?>
  
<?php } }