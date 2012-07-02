-- Version 1.0.2 to 1.1: Index for receiver_email field is too small, enlarge it
ALTER TABLE notificator DROP PRIMARY KEY,
                        ADD PRIMARY KEY (page_id, rev_id, receiver_email(255));
