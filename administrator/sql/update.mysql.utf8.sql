
INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Building','com_act_building.building','{"special":{"dbtable":"#__act_building","key":"id","type":"Building","prefix":"Act_buildingTable"}}', '{"formFile":"administrator\/components\/com_act_building\/models\/forms\/building.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_act_building.building')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Building', 
	`table` = '{"special":{"dbtable":"#__act_building","key":"id","type":"Building","prefix":"Act_buildingTable"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_act_building\/models\/forms\/building.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_act_building.building');
