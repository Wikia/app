-- Schema for Wikimania extension
-- TODO/FIXME: Get rid of the icky icky enums and sets.

-- Primary registration table
CREATE TABLE /*_*/registration (
	-- Unique row id, for sorting and such
	reg_id unsigned int not null primary key auto_increment,

	-- A unique registration identifier, probably something md5()'d
	reg_code varchar(255) not null,

	-- Timestamp registration was submitted
	reg_timestamp varbinary(16),

	-- Current status of the registration, see WikimaniaRegistration::getPossibleStatuses()
	reg_status varchar(12) not null,

	-- First name
	reg_fname varchar(255) not null,

	-- Last name
	reg_lname varchar(255) not null,

	-- Gender (male, female, decline)
	reg_sex varchar(8) not null,

	-- Country of residence
	reg_country varchar(4) not null,

	-- Wiki ID info
	reg_wiki_id varchar(255) not null,
	reg_wiki_language varchar(12) not null,
	reg_wiki_project varchar(12) not null,

	-- E-mail address
	reg_email varchar(255) not null,

	-- How the name on the badge will be shown, as a string
	reg_showname varchar(255) not null,
	reg_shirt_size enum('XXS','XS','S','M','L','XL','XXL','XXXL') not null,
	reg_shirt_color enum('W','B') not null,
	reg_food_preference enum('','1','2','3') not null,
	reg_food_other varchar(255),
	reg_discount_code varchar(16),
	reg_attendance_cost decimal(10,2) not null,
	reg_accommodation_cost decimal(10,2) not null,
	reg_vat_cost decimal(10,2) not null,
	reg_cost_total decimal(10,2) not null,
	reg_currency varchar(4) not null,
	reg_paypal tinyint(1) not null,
	reg_cost_paid decimal(10,2) not null
) /**$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/reg_code ON /*_*/registrations (reg_code);

-- Table to handle passport information
CREATE TABLE /*_*/registration_passports (
	-- Just a primary key
	rp_id unsigned int not null primary key auto_increment,

	-- Tied to a specific registration
	rp_reg_id unsigned int not null,

	-- Nationality on passport
	rp_nationality varchar(4),

	-- Passport ID
	rp_passport varchar(30),

	-- Issuing date
	rp_passport_valid varbinary(16),

	-- Issuing city
	rp_passport_issued varchar(255),

	-- Birthday
	rp_birthday varbinary(16),

	-- Country of birth
	rp_countryofbirth varchar(4),

	-- Home address
	rp_homeaddress blob,

	-- Any additional considerations
	rp_visa_description blob
) /**$wgDBTableOptions*/;

-- Table to handle date(s) people register for
CREATE TABLE /*_*/registration_dates (
	rd_id unsigned int not null primary key auto_increment,
	rd_reg_id unsigned int not null,
	rd_date varbinary(16) not null
) /**$wgDBTableOptions*/;

-- Table to handle hotel reservations
CREATE TABLE /*_*/registration_hotels (
	rh_id unsigned int not null primary key auto_increment,
	rh_reg_id unsigned int not null,
	rh_hotel varchar(255) not null,
	rh_date varbinary(16) not null,
	rh_occupancy int(1) not null,
	rh_partner varchar(255),
	rh_notes blob
) /**$wgDBTableOptions*/;

-- Table to handle languages a registrant can communicate in
CREATE TABLE /*_*/registration_languages (
	rl_reg_id unsigned int not null,
	rl_lang varchar(32),
	rl_level enum('1','2','3','4'),

	PRIMARY KEY(rl_reg_id, rl_lang)
)/**$wgDBTableOptions*/;
