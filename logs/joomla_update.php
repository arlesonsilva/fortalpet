#
#<?php die('Forbidden.'); ?>
#Date: 2014-07-19 19:48:24 UTC
#Software: Joomla Platform 13.1.0 Stable [ Curiosity ] 24-Apr-2013 00:00 GMT

#Fields: datetime	priority	category	message
2014-07-19T19:48:24+00:00	INFO	update	Finalising installation.
2014-07-19T19:48:24+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__users` DROP KEY `usertype`;.
2014-07-19T19:48:24+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__session` DROP KEY `whosonline`;.
2014-07-19T19:48:24+00:00	INFO	update	Ran query from file 3.0.0. Query text: DROP TABLE IF EXISTS `#__update_categories`;.
2014-07-19T19:48:25+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__contact_details` DROP `imagepos`;.
2014-07-19T19:48:25+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__content` DROP COLUMN `title_alias`;.
2014-07-19T19:48:25+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__content` DROP COLUMN `sectionid`;.
2014-07-19T19:48:25+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__content` DROP COLUMN `mask`;.
2014-07-19T19:48:25+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__content` DROP COLUMN `parentid`;.
2014-07-19T19:48:26+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__newsfeeds` DROP COLUMN `filename`;.
2014-07-19T19:48:26+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__weblinks` DROP COLUMN `sid`;.
2014-07-19T19:48:26+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__weblinks` DROP COLUMN `date`;.
2014-07-19T19:48:26+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__weblinks` DROP COLUMN `archived`;.
2014-07-19T19:48:26+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__weblinks` DROP COLUMN `approved`;.
2014-07-19T19:48:27+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__menu` DROP COLUMN `ordering`;.
2014-07-19T19:48:27+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__session` DROP COLUMN `usertype`;.
2014-07-19T19:48:27+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__users` DROP COLUMN `usertype`;.
2014-07-19T19:48:27+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__updates` DROP COLUMN `categoryid`;.
2014-07-19T19:48:28+00:00	INFO	update	Ran query from file 3.0.0. Query text: UPDATE `#__extensions` SET protected = 0 WHERE `name` = 'com_search' OR `name` =.
2014-07-19T19:48:28+00:00	INFO	update	Ran query from file 3.0.0. Query text: DELETE FROM `#__extensions` WHERE `extension_id` = 800;.
2014-07-19T19:48:28+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__assets` ENGINE=InnoDB;.
2014-07-19T19:48:28+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__associations` ENGINE=InnoDB;.
2014-07-19T19:48:28+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banners` ENGINE=InnoDB;.
2014-07-19T19:48:29+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banner_clients` ENGINE=InnoDB;.
2014-07-19T19:48:29+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banner_tracks` ENGINE=InnoDB;.
2014-07-19T19:48:29+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__categories` ENGINE=InnoDB;.
2014-07-19T19:48:29+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__contact_details` ENGINE=InnoDB;.
2014-07-19T19:48:30+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__content` ENGINE=InnoDB;.
2014-07-19T19:48:30+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__content_frontpage` ENGINE=InnoDB;.
2014-07-19T19:48:30+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__content_rating` ENGINE=InnoDB;.
2014-07-19T19:48:30+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__core_log_searches` ENGINE=InnoDB;.
2014-07-19T19:48:31+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__extensions` ENGINE=InnoDB;.
2014-07-19T19:48:31+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_filters` ENGINE=InnoDB;.
2014-07-19T19:48:31+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links` ENGINE=InnoDB;.
2014-07-19T19:48:31+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms0` ENGINE=InnoDB;.
2014-07-19T19:48:31+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms1` ENGINE=InnoDB;.
2014-07-19T19:48:32+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms2` ENGINE=InnoDB;.
2014-07-19T19:48:32+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms3` ENGINE=InnoDB;.
2014-07-19T19:48:32+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms4` ENGINE=InnoDB;.
2014-07-19T19:48:32+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms5` ENGINE=InnoDB;.
2014-07-19T19:48:33+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms6` ENGINE=InnoDB;.
2014-07-19T19:48:33+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms7` ENGINE=InnoDB;.
2014-07-19T19:48:33+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms8` ENGINE=InnoDB;.
2014-07-19T19:48:33+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_terms9` ENGINE=InnoDB;.
2014-07-19T19:48:33+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_termsa` ENGINE=InnoDB;.
2014-07-19T19:48:34+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_termsb` ENGINE=InnoDB;.
2014-07-19T19:48:34+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_termsc` ENGINE=InnoDB;.
2014-07-19T19:48:35+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_termsd` ENGINE=InnoDB;.
2014-07-19T19:48:35+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_termse` ENGINE=InnoDB;.
2014-07-19T19:48:35+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_links_termsf` ENGINE=InnoDB;.
2014-07-19T19:48:35+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_taxonomy` ENGINE=InnoDB;.
2014-07-19T19:48:35+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_taxonomy_map` ENGINE=InnoDB;.
2014-07-19T19:48:36+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_terms` ENGINE=InnoDB;.
2014-07-19T19:48:36+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_terms_common` ENGINE=InnoDB;.
2014-07-19T19:48:36+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_types` ENGINE=InnoDB;.
2014-07-19T19:48:36+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__languages` ENGINE=InnoDB;.
2014-07-19T19:48:37+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__menu` ENGINE=InnoDB;.
2014-07-19T19:48:37+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__menu_types` ENGINE=InnoDB;.
2014-07-19T19:48:37+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__messages` ENGINE=InnoDB;.
2014-07-19T19:48:38+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__messages_cfg` ENGINE=InnoDB;.
2014-07-19T19:48:38+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__modules` ENGINE=InnoDB;.
2014-07-19T19:48:38+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__modules_menu` ENGINE=InnoDB;.
2014-07-19T19:48:38+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__newsfeeds` ENGINE=InnoDB;.
2014-07-19T19:48:38+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__overrider` ENGINE=InnoDB;.
2014-07-19T19:48:39+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__redirect_links` ENGINE=InnoDB;.
2014-07-19T19:48:39+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__schemas` ENGINE=InnoDB;.
2014-07-19T19:48:39+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__session` ENGINE=InnoDB;.
2014-07-19T19:48:39+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__template_styles` ENGINE=InnoDB;.
2014-07-19T19:48:40+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__updates` ENGINE=InnoDB;.
2014-07-19T19:48:40+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__update_sites` ENGINE=InnoDB;.
2014-07-19T19:48:40+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__update_sites_extensions` ENGINE=InnoDB;.
2014-07-19T19:48:40+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__users` ENGINE=InnoDB;.
2014-07-19T19:48:40+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__usergroups` ENGINE=InnoDB;.
2014-07-19T19:48:41+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__user_notes` ENGINE=InnoDB;.
2014-07-19T19:48:41+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__user_profiles` ENGINE=InnoDB;.
2014-07-19T19:48:41+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__user_usergroup_map` ENGINE=InnoDB;.
2014-07-19T19:48:41+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__viewlevels` ENGINE=InnoDB;.
2014-07-19T19:48:42+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__weblinks` ENGINE=InnoDB;.
2014-07-19T19:48:42+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__weblinks` ADD COLUMN `version` int(10) unsigned NOT NULL DEFAULT.
2014-07-19T19:48:42+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__weblinks` ADD COLUMN `images` text NOT NULL;.
2014-07-19T19:48:42+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__newsfeeds` ADD COLUMN `description` text NOT NULL;.
2014-07-19T19:48:42+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__newsfeeds` ADD COLUMN `version` int(10) unsigned NOT NULL DEFAUL.
2014-07-19T19:48:43+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__newsfeeds` ADD COLUMN `hits` int(10) unsigned NOT NULL DEFAULT '.
2014-07-19T19:48:43+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__newsfeeds` ADD COLUMN `images` text NOT NULL;.
2014-07-19T19:48:43+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__contact_details` ADD COLUMN `version` int(10) unsigned NOT NULL .
2014-07-19T19:48:43+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__contact_details` ADD COLUMN `hits` int(10) unsigned NOT NULL DEF.
2014-07-19T19:48:44+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banners` ADD COLUMN `created_by` int(10) unsigned NOT NULL DEFAU.
2014-07-19T19:48:44+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banners` ADD COLUMN `created_by_alias` varchar(255) NOT NULL DEF.
2014-07-19T19:48:44+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banners` ADD COLUMN `modified` datetime NOT NULL DEFAULT '0000-0.
2014-07-19T19:48:44+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banners` ADD COLUMN `modified_by` int(10) unsigned NOT NULL DEFA.
2014-07-19T19:48:45+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__banners` ADD COLUMN `version` int(10) unsigned NOT NULL DEFAULT .
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__categories` ADD COLUMN `version` int(10) unsigned NOT NULL DEFAU.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: UPDATE  `#__assets` SET name=REPLACE( name, 'com_user.notes.category','com_users.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: UPDATE  `#__categories` SET extension=REPLACE( extension, 'com_user.notes.catego.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_terms` ADD COLUMN `language` char(3) NOT NULL DEFAULT '';.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_tokens` ADD COLUMN `language` char(3) NOT NULL DEFAULT ''.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: ALTER TABLE `#__finder_tokens_aggregate` ADD COLUMN `language` char(3) NOT NULL .
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: INSERT INTO `#__extensions` 	(`name`, `type`, `element`, `folder`, `client_id`, .
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: INSERT INTO `#__template_styles` (`template`, `client_id`, `home`, `title`, `par.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: UPDATE `#__template_styles` SET home = (CASE WHEN (SELECT count FROM (SELECT cou.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: UPDATE `#__template_styles` SET home = 0 WHERE template = 'bluestork';.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.0. Query text: UPDATE `#__update_sites` SET location = 'http://update.joomla.org/language/trans.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.0.3. Query text: ALTER TABLE `#__associations` CHANGE `id` `id` INT(11) NOT NULL COMMENT 'A refer.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.1.0. Query text: -- -- Table structure for table `#__content_types` --  CREATE TABLE IF NOT EXIST.
2014-07-19T19:48:46+00:00	INFO	update	Ran query from file 3.1.0. Query text: -- -- Dumping data for table `#__content_types` --  INSERT INTO `#__content_type.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.0. Query text: CREATE TABLE IF NOT EXISTS `#__contentitem_tag_map` (   `type_alias` varchar(255.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.0. Query text: CREATE TABLE IF NOT EXISTS `#__tags` (   `id` int(10) unsigned NOT NULL AUTO_INC.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.0. Query text: -- -- Dumping data for table `#__tags` --  INSERT INTO `#__tags` (`id`, `parent_.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.0. Query text: -- -- Table structure for table `#__ucm_base` --  CREATE TABLE IF NOT EXISTS `#_.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.0. Query text: CREATE TABLE IF NOT EXISTS `#__ucm_content` (   `core_content_id` int(10) unsign.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.0. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.0. Query text: INSERT INTO `#__menu` (`menutype`, `title`, `alias`, `note`, `path`, `link`, `ty.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__content","key.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__weblinks","ke.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__contact_detai.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__newsfeeds","k.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__users","key":.
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__categories",".
2014-07-19T19:48:47+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__categories",".
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__categories",".
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__categories",".
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `table` = '{"special":{"dbtable":"#__tags","key":".
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.2. Query text: UPDATE `#__content_types` SET `field_mappings` = '{"common":{"core_content_item_.
2014-07-19T19:48:48+00:00	INFO	update	Ran query from file 3.1.4. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: /* Core 3.2 schema updates */  ALTER TABLE `#__content_types` ADD COLUMN `conten.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `rules`, `f.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__extensions` SET `params` = '{"template_positions_display":"0","upload.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__extensions` SET `params` = '{"lineNumbers":"1","lineWrapping":"1","ma.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__menu` (`menutype`, `title`, `alias`, `note`, `path`, `link`, `ty.
2014-07-19T19:48:49+00:00	INFO	update	Ran query from file 3.2.0. Query text: ALTER TABLE `#__modules` ADD COLUMN `asset_id` INT(10) UNSIGNED NOT NULL DEFAULT.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.0. Query text: CREATE TABLE `#__postinstall_messages` (   `postinstall_message_id` bigint(20) u.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.0. Query text: CREATE TABLE IF NOT EXISTS `#__ucm_history` (   `version_id` int(10) unsigned NO.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.0. Query text: ALTER TABLE `#__users` ADD COLUMN `otpKey` varchar(1000) NOT NULL DEFAULT '' COM.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.0. Query text: ALTER TABLE `#__users` ADD COLUMN `otep` varchar(1000) NOT NULL DEFAULT '' COMME.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.0. Query text: CREATE TABLE IF NOT EXISTS `#__user_keys` (   `id` int(10) unsigned NOT NULL AUT.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.0. Query text: /* Update bad params for two cpanel modules */  UPDATE `#__modules` SET `params`.
2014-07-19T19:48:50+00:00	INFO	update	Ran query from file 3.2.1. Query text: DELETE FROM `#__postinstall_messages` WHERE `title_key` = 'PLG_USER_JOOMLA_POSTI.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.2-2013-12-22. Query text: ALTER TABLE `#__update_sites` ADD COLUMN `extra_query` VARCHAR(1000) DEFAULT '';.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.2-2013-12-22. Query text: ALTER TABLE `#__updates` ADD COLUMN `extra_query` VARCHAR(1000) DEFAULT '';.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.2-2013-12-28. Query text: UPDATE `#__menu` SET `component_id` = (SELECT `extension_id` FROM `#__extensions.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.2-2014-01-08. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.2-2014-01-15. Query text: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.2-2014-01-18. Query text: /* Update updates version length */ ALTER TABLE `#__updates` MODIFY `version` va.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.2-2014-01-23. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-07-19T19:48:51+00:00	INFO	update	Ran query from file 3.2.3-2014-02-20. Query text: UPDATE `#__extensions` ext1, `#__extensions` ext2 SET ext1.`params` =  ext2.`par.
2014-07-19T19:48:52+00:00	INFO	update	Ran query from file 3.3.0-2014-02-16. Query text: ALTER TABLE `#__users` ADD COLUMN `requireReset` tinyint(4) NOT NULL DEFAULT 0 C.
2014-07-19T19:48:52+00:00	INFO	update	Ran query from file 3.3.0-2014-04-02. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-07-19T19:48:52+00:00	INFO	update	Deleting removed files and folders.
2014-09-05T19:15:44+00:00	INFO	update	COM_JOOMLAUPDATE_UPDATE_LOG_DELETE_FILES
2014-10-01T08:36:02+00:00	INFO 127.0.0.1	update	COM_JOOMLAUPDATE_UPDATE_LOG_DELETE_FILES
2014-10-28T19:33:27+00:00	INFO 127.0.0.1	update	Update started by user Super User (516). Old version is 3.3.5.
2014-10-28T19:33:27+00:00	INFO 127.0.0.1	update	Downloading update file from https://github.com/joomla/joomla-cms/releases/download/3.3.6/Joomla_3.3.5_to_3.3.6-Stable-Patch_Package.zip.
2014-10-28T19:33:30+00:00	INFO 127.0.0.1	update	File Joomla_3.3.5_to_3.3.6-Stable-Patch_Package.zip successfully downloaded.
2014-10-28T19:33:30+00:00	INFO 127.0.0.1	update	Starting installation of new version.
2014-10-28T19:35:50+00:00	INFO 127.0.0.1	update	COM_JOOMLAUPDATE_UPDATE_LOG_DELETE_FILES
