-- This column is needed for the delete image feature!
ALTER TABLE `mw_gallery` ADD `oldcat` VARCHAR( 255 ) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL;