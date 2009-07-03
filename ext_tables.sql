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