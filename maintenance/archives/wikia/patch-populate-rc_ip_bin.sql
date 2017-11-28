-- SUS-3079: Populate rc_ip_bin column

UPDATE /*$wgDBPrefix*/recentchanges
  SET rc_ip_bin = IFNULL(INET6_ATON(`rc_user_text`), '') WHERE rc_ip_bin = '' AND rc_user = 0;
