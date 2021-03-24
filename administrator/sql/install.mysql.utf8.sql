CREATE TABLE IF NOT EXISTS `#__act_building` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL  DEFAULT 0,
`checked_out` INT(11)  NOT NULL  DEFAULT 0,
`checked_out_time` DATETIME NOT NULL  DEFAULT "0000-00-00 00:00:00",
`created_by` INT(11)  NOT NULL  DEFAULT 0,
`modified_by` INT(11)  NOT NULL  DEFAULT 0,
`state` TINYINT(1)  NOT NULL  DEFAULT 1,
`building` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `field_mappings`, `content_history_options`, `rules`)
SELECT * FROM ( SELECT 'Building','com_act_building.building','{"special":{"dbtable":"#__act_building","key":"id","type":"Building","prefix":"Act_buildingTable"}}', CASE 
                                WHEN 'field_mappings' is null THEN ''
                                ELSE ''
                                END as field_mappings, '{"formFile":"administrator\/components\/com_act_building\/models\/forms\/building.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}', " ") AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_act_building.building')
) LIMIT 1;
