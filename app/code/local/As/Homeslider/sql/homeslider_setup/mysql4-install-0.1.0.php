<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('homeslider')};
CREATE TABLE {$this->getTable('homeslider')} (
  `homeslider_id` int(11) unsigned NOT NULL auto_increment,
  `first_title` varchar(255) NOT NULL default '',
  `second_title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `link` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`homeslider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 