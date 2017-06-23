--Yoog 20-04-2017
ALTER TABLE `t_komplain` ADD `response` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `ket`;
ALTER TABLE `t_komplain` CHANGE `status` `status` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'BARU';
