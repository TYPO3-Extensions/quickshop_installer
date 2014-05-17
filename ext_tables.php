<?php
if (!defined ('TYPO3_MODE'))  die ('Access denied.');



    ///////////////////////////////////////////////////////////
    //
    // INDEX

    // Plugin general configuration
    // Plugin 1 configuration
    // Add pagetree icons



    ///////////////////////////////////////////////////////////
    //
    // Plugin general configuration

  t3lib_div::loadTCA('tt_content');
    // Plugin general configuration



    ///////////////////////////////////////////////////////////
    //
    // Plugin 1 configuration

  $TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages,recursive';
    // Remove the default tt_content fields layout, select_key, pages and recursive.
  $TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';
    // Display the field pi_flexform
  t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/pi1/flexform.xml');
    // Register our file with the flexform structure
  t3lib_extMgm::addPlugin(array('LLL:EXT:quickshop_installer/pi1/locallang.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1', 'EXT:quickshop_installer/ext_icon.gif'),'list_type');
    // Add the Flexform to the Plugin List
    // Plugin 1 configuration



    ////////////////////////////////////////////////////////////////////////////
    //
    // Add pagetree icons

  $TCA['pages']['columns']['module']['config']['items'][] =
    array('Quick Shop: Installer', 'qs_inst', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon.gif');
  //$ICON_TYPES['org_inst'] =
  //  array('icon' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icons/ext_icon_blink.gif');
  t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-qs_inst', '../typo3conf/ext/quickshop_installer/ext_icon.gif');
    // Add pagetree icons

?>
