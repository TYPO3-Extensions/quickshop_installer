<?php

########################################################################
# Extension Manager/Repository config file for ext "quickshop_installer".
#
# Auto generated 07-02-2011 23:01
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Quick Shop Installer – one-click-installation for Quick Shop',
	'description' => ''
  . 'http://typo3-quick-shop.de/en/one-click/. '
  . 'The installer installs Quick Shop. This shop is optimised for desktops, tablets and smartphones. '
  . 'Quick Shop is e-commerce for small budget and small-scale enterprises. '
  . 'Manual: http://typo3-quick-shop.de/typo3conf/ext/quickshop_installer/doc/manual.pdf '
  ,
	'category' => 'plugin',
	'shy' => 0,
	'version' => '6.0.0',
	'dependencies' => 'browser,caddy,powermail,quick_shop',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Dirk Wildt (Die Netzmacher)',
	'author_email' => 'http://wildt.at.die-netzmacher.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'browser' => '',
			'caddy' => '',
			'powermail' => '',
			'quick_shop' => '',
			'typo3' => '4.5.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:28:{s:9:"ChangeLog";s:4:"df7f";s:12:"ext_icon.gif";s:4:"2501";s:17:"ext_localconf.php";s:4:"1028";s:14:"ext_tables.php";s:4:"9454";s:16:"locallang_db.xml";s:4:"f81f";s:14:"doc/manual.pdf";s:4:"d7a6";s:14:"doc/manual.sxw";s:4:"77ad";s:39:"pi1/class.tx_quickshopinstaller_pi1.php";s:4:"dea6";s:16:"pi1/flexform.xml";s:4:"4857";s:26:"pi1/flexform_locallang.php";s:4:"0083";s:27:"pi1/flexform_sheet_sDEF.xml";s:4:"1949";s:17:"pi1/locallang.xml";s:4:"12e5";s:37:"res/images/22x22/application-exit.png";s:4:"8369";s:42:"res/images/22x22/appointment-recurring.png";s:4:"84e7";s:34:"res/images/22x22/dialog-cancel.png";s:4:"9a5c";s:33:"res/images/22x22/dialog-close.png";s:4:"6063";s:33:"res/images/22x22/dialog-error.png";s:4:"4343";s:39:"res/images/22x22/dialog-information.png";s:4:"959e";s:36:"res/images/22x22/dialog-ok-apply.png";s:4:"a6e0";s:35:"res/images/22x22/dialog-warning.png";s:4:"0eab";s:29:"res/images/22x22/download.png";s:4:"1818";s:32:"res/images/22x22/edit-delete.png";s:4:"7dda";s:44:"res/images/products/book_###TIMESTAMP###.jpg";s:4:"d120";s:47:"res/images/products/capBlue_###TIMESTAMP###.jpg";s:4:"e170";s:48:"res/images/products/capGreen_###TIMESTAMP###.jpg";s:4:"837e";s:46:"res/images/products/capRed_###TIMESTAMP###.jpg";s:4:"00e8";s:43:"res/images/products/cup_###TIMESTAMP###.jpg";s:4:"e418";s:48:"res/images/products/pullover_###TIMESTAMP###.jpg";s:4:"e1ab";}',
	'suggests' => array(
	),
);

?>
