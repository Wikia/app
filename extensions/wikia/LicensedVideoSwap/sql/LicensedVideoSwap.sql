CREATE TABLE IF NOT EXISTS video_swap (
  id            integer primary key auto_increment,
  orig_title    varchar(255) not null,
  swap_title    varchar(255),
  is_swapped    boolean,
  exact_match   boolean,
  user_id       integer,
  updated_at    timestamp DEFAULT current_timestamp,
  index (orig_title, is_swapped, exact_match),
  index (user_id),
  index (swap_title),
  index (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
