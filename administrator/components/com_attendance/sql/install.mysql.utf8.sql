
CREATE TABLE IF NOT EXISTS `#__sched_dates` (
  `date_val` date NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sched_events` (
  `event_name` varchar(80) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` int(11) NOT NULL,
  `event_type` int(11) NOT NULL,
  `event_location` int(11) NOT NULL,
  `event_owner` int(11) NOT NULL,
  `event_respond_by` datetime NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `event_name` (`event_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sched_event_mand_grps` (
  `event_id` varchar(10) NOT NULL,
  `group_id` varchar(10) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sched_event_types` (
  `event_type_name` varchar(40) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_type_UID` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sched_locations` (
  `loc_name` varchar(40) NOT NULL,
  `loc_address_1` varchar(80) NOT NULL,
  `loc_address_2` varchar(80) NOT NULL,
  `loc_city` varchar(40) NOT NULL,
  `loc_state` varchar(20) NOT NULL,
  `loc_zip` int(5) NOT NULL,
  `loc_country` varchar(40) NOT NULL,
  `loc_phone` varchar(20) NOT NULL,
  `loc_note` text NOT NULL,
  `loc_website` varchar(1056) NOT NULL,
  `loc_maplink` varchar(1056) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jom2_sched_responses` (
  `rsvp_reason` int(11) NOT NULL,
  `rsvp_status` tinyint(1) NOT NULL,
  `rsvp_event` int(11) NOT NULL,
  `rsvp_user` int(11) NOT NULL,
  `rsvp_details` varchar(155) NOT NULL,
  `rsvp_date_submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rsvp_review_status` int(11) NOT NULL,
  `rsvp_date_reviewed` datetime NOT NULL,
  `rsvp_reviewd_by_user` int(11) NOT NULL,
  `rsvp_active` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_user` varchar(15) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_user` (`event_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__sched_review_statuses` (
  `review_status_name` varchar(40) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sched_rsvp_reasons` (
  `reason_name` varchar(40) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sched_times` (
  `time_val` varchar(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sched_views` (
  `view_name` varchar(40) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

