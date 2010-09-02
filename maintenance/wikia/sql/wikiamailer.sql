
CREATE DATABASE wikia_mailer;
use wikia_mailer;

CREATE TABLE IF NOT EXISTS mail (
       id INT PRIMARY KEY AUTO_INCREMENT,
       created DATETIME NOT NULL, # when we sent it from apache
       src VARCHAR(255) NOT NULL,            
       dst VARCHAR(255) NOT NULL,
       hdr TEXT NOT NULL,
       msg TEXT NOT NULL,
       city_id INT NOT NULL,
       locked_by VARCHAR(255),  # which sender has it    
       locked DATETIME,         # when the sender grabbed it
       transmitted DATETIME,    # when we sent it to the outsideworld
       is_bounce BOOL NOT NULL DEFAULT FALSE,
       is_error BOOL NOT NULL DEFAULT FALSE,
       is_spam BOOL NOT NULL DEFAULT FALSE,
       error_status VARCHAR(255),
       error_msg VARCHAR(255),
       opened DATETIME,
       clicked DATETIME,
       INDEX(dst),
       INDEX(city_id),
       INDEX(locked_by),
       INDEX(transmitted),
       INDEX(locked)
);
