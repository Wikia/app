-- PayPal Set EC requests
-- action=S
CREATE TABLE pp_tokens (
  ppt_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ppt_requested timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ppt_result smallint signed,
  ppt_respmsg varchar(255) DEFAULT NULL,
  ppt_correlationid char(13) DEFAULT NULL,
  ppt_responded timestamp NULL DEFAULT NULL,
  ppt_token char(20) DEFAULT NULL
) ENGINE=InnoDB;
CREATE UNIQUE INDEX ppt_token ON pp_tokens (ppt_token);

-- PayPal Get EC Details requests
-- action=G
CREATE TABLE pp_details (
  ppd_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ppd_token char(20) NOT NULL,
  ppd_requested timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ppd_result smallint signed DEFAULT NULL,
  ppd_respmsg varchar(255) DEFAULT NULL,
  ppd_correlationid char(13) DEFAULT NULL,
  ppd_responded timestamp NULL DEFAULT NULL,
  ppd_email varchar(127) DEFAULT NULL,
  ppd_payerstatus varchar(10) DEFAULT NULL,
  ppd_firstname varchar(25) DEFAULT NULL,
  ppd_lastname varchar(25) DEFAULT NULL,
  ppd_shiptoname varchar(32) DEFAULT NULL,
  ppd_shiptobusiness varchar(127) DEFAULT NULL,
  ppd_shiptostreet varchar(30) DEFAULT NULL,
  ppd_shiptostreet2 varchar(30) DEFAULT NULL,
  ppd_shiptocity varchar(40) DEFAULT NULL,
  ppd_shiptostate varchar(40) DEFAULT NULL,
  ppd_shiptozip varchar(16) DEFAULT NULL,
  ppd_shiptocountry char(2) DEFAULT NULL,
  ppd_custom varchar(256) DEFAULT NULL,
  ppd_phonenum char(20) DEFAULT NULL,
  ppd_billtoname varchar(32) DEFAULT NULL,
  ppd_street varchar(100) DEFAULT NULL,
  ppd_street2 varchar(100) DEFAULT NULL,
  ppd_city varchar(45) DEFAULT NULL,
  ppd_state varchar(45) DEFAULT NULL,
  ppd_zip varchar(10) DEFAULT NULL,
  ppd_countrycode char(4) DEFAULT NULL,
  ppd_addressstatus char(1) DEFAULT NULL,
  ppd_avsaddr char(1) DEFAULT NULL,
  ppd_avszip char(1) DEFAULT NULL,
  ppd_payerid char(13) DEFAULT NULL,
  ppd_note varchar(255) DEFAULT NULL
) ENGINE=InnoDB;
CREATE UNIQUE INDEX ppd_token ON pp_details (ppd_token);

-- PayPal Create Customer Billing Agreement requests
-- action=X
CREATE TABLE pp_agreements (
  ppa_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ppa_token char(20) NOT NULL,
  ppa_requested timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ppa_result smallint signed DEFAULT NULL,
  ppa_respmsg varchar(255) DEFAULT NULL,
  ppa_correlationid char(13) DEFAULT NULL,
  ppa_responded timestamp NULL DEFAULT NULL,
  ppa_pnref char(12) DEFAULT NULL,
  ppa_baid char(19) DEFAULT NULL,
  ppa_canceled timestamp NULL DEFAULT NULL
) ENGINE=InnoDB;
CREATE UNIQUE INDEX ppa_token ON pp_agreements (ppa_token);
CREATE INDEX ppa_baid ON pp_agreements (ppa_baid);

-- PayPal Do EC Payment requests
-- action=D
CREATE TABLE pp_payments (
  ppp_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ppp_baid char(19) NOT NULL,
  ppp_amount decimal(5,2) NOT NULL,
  ppp_requested timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ppp_result smallint signed DEFAULT NULL,
  ppp_respmsg varchar(255) DEFAULT NULL,
  ppp_correlationid char(13) DEFAULT NULL,
  ppp_responded timestamp NULL DEFAULT NULL,
  ppp_pnref char(12) DEFAULT NULL,
  ppp_ppref char(17) DEFAULT NULL,
  ppp_feeamt decimal(5,2) DEFAULT NULL,
  ppp_paymenttype varchar(11) DEFAULT NULL,
  ppp_pendingreason varchar(255) DEFAULT NULL
) ENGINE=InnoDB;
CREATE INDEX ppp_baid ON pp_payments (ppp_baid);

-- PayPal Create Recurring Profile
-- action=A
CREATE TABLE pp_profiles (
  pppr_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  pppr_baid char(19) NOT NULL,
  pppr_amount decimal(5,2) NOT NULL,
  pppr_retrynumdays smallint signed DEFAULT 0,
  pppr_startdate date,
  pppr_requested timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  pppr_result smallint signed DEFAULT NULL,
  pppr_respmsg varchar(255) DEFAULT NULL,
  pppr_profileid char(13) DEFAULT NULL,
  pppr_responded timestamp NULL DEFAULT NULL,
  pppr_rpref char(12) DEFAULT NULL,
  pppr_trxpnref char(12) DEFAULT NULL,
  pppr_trxresult smallint signed DEFAULT NULL,
  pppr_trxrespmsg varchar(255) DEFAULT NULL
) ENGINE=InnoDB;
CREATE INDEX pppr_baid ON pp_profiles (pppr_baid);
