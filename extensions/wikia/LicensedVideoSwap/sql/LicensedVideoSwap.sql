create table youtube_swap (
  id            integer primary key auto_increment,
  orig_title    varchar(255) not null,
  swap_title    varchar(255),
  is_swapped    boolean,
  exact_match   boolean,
  user_id       integer,
  date          datetime on update current_timestamp,
  index (orig_title, is_swapped, exact_match),
  index (user_id),
  index (swap_title)
);
