-- MySQL dump 8.21
--
-- Host: localhost    Database: cdbspkgs
---------------------------------------------------------
-- Server version	3.23.49-log

--
-- Table structure for table 'packages'
--

DROP TABLE IF EXISTS packages;
CREATE TABLE packages (
  pkg_version varchar(100) NOT NULL default '',
  pkg_name varchar(100) NOT NULL default '',
  pkg_priority varchar(100) NOT NULL default '',
  pkg_section varchar(100) NOT NULL default '',
  pkg_maintainer varchar(100) NOT NULL default '',
  pkg_arch varchar(100) NOT NULL default '',
  pkg_size int(10) unsigned NOT NULL default '0',
  pkg_md5sum varchar(32) NOT NULL default '',
  pkg_installed_size int(11) NOT NULL default '0',
  pkg_filename tinytext NOT NULL,
  pkg_distro varchar(100) NOT NULL default '',
  PRIMARY KEY  (pkg_md5sum)
) TYPE=MyISAM;

--
-- Dumping data for table 'packages'
--

--
-- $Id: uddb.sql,v 1.1 2003/12/09 16:43:39 asg Exp $
--
