#
# Table structure for table 'tx_nhttnewsevents_application'
#
CREATE TABLE tx_nhttnewsevents_application (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	forename tinytext,
	surname tinytext,
	email tinytext,
	institution tinytext,
	comment text,
	attendance tinytext,
	ttnews_uid int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tt_news'
#
CREATE TABLE tt_news (
	tx_nhttnewsevents_hide_in_list tinyint(3) DEFAULT '0' NOT NULL,
	tx_nhttnewsevents_start int(11) DEFAULT '0' NOT NULL,
	tx_nhttnewsevents_end int(11) DEFAULT '0' NOT NULL,
	tx_nhttnewsevents_enable_application tinyint(3) DEFAULT '0' NOT NULL,
	tx_nhttnewsevents_application_until int(11) DEFAULT '0' NOT NULL,
	tx_nhttnewsevents_organizer_email tinytext,
	tx_nhttnewsevents_max_attendees int(11) DEFAULT '0' NOT NULL,
	tx_nhttnewsevents_max_attendees_application int(11) DEFAULT '0' NOT NULL,
	tx_nhttnewsevents_left_openings_warning_limit int(11) DEFAULT '0' NOT NULL
);