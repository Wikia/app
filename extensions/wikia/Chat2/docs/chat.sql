# Author: Sean Colombo
# Date: 20110224
#
# To crank out this prototype faster, we're going to implement the chat with
# in-memory MySQL tables to start (then we'll probably have to move to something
# like a memcached solution since the amount of reading/writing to these tables
# probably can't scale well on MySQL).
####

# A chat (aka: a chat room).
DROP TABLE IF EXISTS chat;
CREATE TABLE chat(
	chat_id INT(11) NOT NULL AUTO_INCREMENT,
	city_id INT(11) NOT NULL, # the wikicities.city_id of the wiki where this chat was created

	chat_name VARCHAR(255) NOT NULL,
	chat_topic BLOB, # like an IRC 'topic' that appears as a banner when you log in.

	UNIQUE KEY(city_id, chat_name),
	PRIMARY KEY(chat_id)
); # not in-memory. It's an okay user-experience if users don't have a long chat-history but a really bad one if they have to re-create their chatrooms.

# A record of a specific user in a specific chat.
DROP TABLE IF EXISTS chat_user;
CREATE TABLE chat_user (
	chat_id INT(11),

	chat_user_name VARCHAR(255), # the value from user.user_name
	chat_user_joinedOn DATETIME,
	chat_user_lastUpdate TIMESTAMP, # last time an update was sent TO them

	UNIQUE KEY(chat_id, chat_user_name)
);

# If someone leaves, we need to hold a record of that for a little while.
DROP TABLE IF EXISTS chat_recent_parts;
CREATE TABLE chat_recent_parts (
	chat_id INT(11),
	chat_user_name VARCHAR(255),
	chat_recent_parts_timestamp TIMESTAMP,
	chat_recent_parts_wasKicked TINYINT(1) DEFAULT 0, # set to non-zero if the user was kicked

	UNIQUE KEY(chat_id, chat_user_name)
);


DROP TABLE IF EXISTS chat_message;
CREATE TABLE chat_message(
	chat_id INT(11),
	chat_user_name VARCHAR(255), # the person who sent the message

	chat_message_timestamp TIMESTAMP, # when the message was recorded
	chat_message_body VARCHAR(255), # easy enough to crank up to BLOB if we decide that's better later.
	
	KEY(chat_id, chat_message_timestamp)
);
