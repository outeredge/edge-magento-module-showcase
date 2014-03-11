<?php

$installer = $this;
$installer->startSetup();

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('showcase/showcase')};
    CREATE TABLE {$this->getTable('showcase/showcase')} (
        `id` int(11) NOT NULL auto_increment,
        `title` text NOT NULL,
        `description` text NOT NULL default '',
        `date` datetime NOT NULL,
        `thumbnail` text NOT NULL default '',
        `image` text NOT NULL default '',
        `url_key` varchar(255) NOT NULL,
        `products` varchar(255) NULL default NULL,
        PRIMARY KEY (id),
        UNIQUE (url_key)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->endSetup();