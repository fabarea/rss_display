#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_rssdisplay_feed tinytext NOT NULL,
	tx_rssdisplay_descriptiondisplay int(11) DEFAULT '0' NOT NULL,
	tx_rssdisplay_quantity int(11) DEFAULT '0' NOT NULL,
	tx_rssdisplay_descriptionlength int(11) DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tx_rssdisplay_cache (
    id int(11) unsigned NOT NULL auto_increment,
    identifier varchar(250) DEFAULT '' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    content mediumblob,
    lifetime int(11) unsigned DEFAULT '0' NOT NULL,
    PRIMARY KEY (id),
    KEY cache_id (identifier)
) ENGINE=InnoDB;
