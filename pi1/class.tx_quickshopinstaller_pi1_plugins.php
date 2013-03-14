<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   57: class tx_quickshopinstaller_pi1_plugins
 *
 *              SECTION: Main
 *   81:     public function main( )
 *
 *              SECTION: Records
 *  111:     private function recordBrowser( $uid )
 *  233:     private function recordCaddy( $uid )
 *  263:     private function recordPowermail( $uid )
 *  313:     private function records( )
 *
 *              SECTION: Sql
 *  350:     private function sqlInsert( $records )
 *
 * TOTAL FUNCTIONS: 6
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Quick Shop Inmstaller' for the 'quickshop_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_quickshopinstaller
 * @version 3.0.0
 * @since 3.0.0
 */
class tx_quickshopinstaller_pi1_plugins
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_plugins';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_plugins.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'quickshop_installer';                      // The extension key.

  public $pObj = null;



 /***********************************************
  *
  * Main
  *
  **********************************************/

/**
 * main( )
 *
 * @return	void
 * @access public
 * @version 3.0.0
 * @since   0.0.1
 */
  public function main( )
  {
    $records = array( );

    $this->pObj->arrReport[ ] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'plugin_create_header' ) . '
      </h2>';

    $records = $this->records( );
    $this->sqlInsert( $records );
  }



 /***********************************************
  *
  * Records
  *
  **********************************************/

/**
 * recordBrowser( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordBrowser( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_browser_header' );
    $this->pObj->arr_pluginUids[$llHeader] = $uid;

    $record['uid']           = $uid;
    $record['pid']           = $GLOBALS['TSFE']->id;
    $record['tstamp']        = time( );
    $record['crdate']        = time( );
    $record['cruser_id']     = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']       = 128;
    $record['CType']         = 'list';
    $record['header']        = $llHeader;
    $record['pages']         = $this->pObj->arr_pageUids[$this->pObj->pi_getLL( 'page_title_products' )];
    $record['header_layout'] = 100;  // hidden
    $record['list_type']     = 'browser_pi1';
    $record['sectionIndex']  = 1;
    $record['pi_flexform']   = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">Quick Shop</value>
                </field>
                <field index="limit">
                    <value index="vDEF">3</value>
                </field>
                <field index="navigation">
                    <value index="vDEF">3</value>
                </field>
            </language>
        </sheet>
        <sheet index="socialmedia">
            <language index="lDEF">
                <field index="enabled">
                    <value index="vDEF">enabled_wi_individual_template</value>
                </field>
                <field index="tablefieldTitle_list">
                    <value index="vDEF">tx_quickshop_products.title</value>
                </field>
                <field index="bookmarks_list">
                    <value index="vDEF">facebook,hype,twitter</value>
                </field>
                <field index="tablefieldTitle_single">
                    <value index="vDEF">tx_quickshop_products.title</value>
                </field>
                <field index="bookmarks_single">
                    <value index="vDEF">facebook,google,hype,live,misterwong,technorati,twitter,yahoomyweb</value>
                </field>
            </language>
        </sheet>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:quick_shop/res/v1.4/default.tmpl</value>
                </field>
                <field index="css.browser">
                    <value index="vDEF">ts</value>
                </field>
                <field index="css.jqui">
                    <value index="vDEF">smoothness</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">list_and_single</value>
                </field>
                <field index="ajaxChecklist">
                    <value index="vDEF">1</value>
                </field>
                <field index="list_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="single_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="list_on_single">
                    <value index="vDEF">single</value>
                </field>
            </language>
        </sheet>
        <sheet index="development">
            <language index="lDEF">
                <field index="handle_marker">
                    <value index="vDEF">remove_empty_markers</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

    return $record;
  }

/**
 * recordCaddy( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordCaddy( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_wtcart_header' );
    $this->pObj->arr_pluginUids[$llHeader] = $uid;

    $record['uid']           = $uid;
    $record['pid']           = $this->pObj->arr_pageUids[$this->pObj->pi_getLL( 'page_title_caddy ')];
    $record['tstamp']        = $timestamp;
    $record['crdate']        = $timestamp;
    $record['cruser_id']     = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']       = 256;
    $record['CType']         = 'list';
    $record['header']        = $llHeader;
    $record['list_type']     = 'wt_cart_pi1';
    $record['sectionIndex']  = 1;

    return $record;
  }

/**
 * recordPowermail( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordPowermail( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_powermail_header' );
    $this->pObj->arr_pluginUids[$llHeader] = $uid;

    $record['uid']                        = $uid;
    $record['pid']                        = $this->pObj->arr_pageUids[$this->pObj->pi_getLL( 'page_title_caddy' )];
    $record['tstamp']                     = $timestamp;
    $record['crdate']                     = $timestamp;
    $record['cruser_id']                  = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']                    = 512;
    $record['CType']                      = 'powermail_pi1';
    $record['header']                     = $llHeader;
    $record['header_layout']              = 100;  // hidden
    $record['list_type']                  = '';
    $record['sectionIndex']               = 1;
    $record['tx_powermail_title']         = 'order';
    $record['tx_powermail_recipient']     = $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'];
    $record['tx_powermail_subject_r']     = $this->pObj->markerArray['###MAIL_SUBJECT###'];
    $record['tx_powermail_subject_s']     = $this->pObj->markerArray['###MAIL_SUBJECT###'];
// Will updated by $this->consolidatePluginPowermail()
//    $record['tx_powermail_sender']        = $str_sender;
//    $record['tx_powermail_sendername']    = $str_sendername;
    $record['tx_powermail_confirm']       = 1;
    $record['tx_powermail_pages']         = false;
    $record['tx_powermail_multiple']      = 0;
    $record['tx_powermail_recip_table']   = 0;
    $record['tx_powermail_recip_id']      = false;
    $record['tx_powermail_recip_field']   = false;
    $record['tx_powermail_thanks']        = $this->pObj->pi_getLL('plugin_powermail_thanks');
    $record['tx_powermail_mailsender']    = '###POWERMAIL_TYPOSCRIPT_CART###' . "\n" . '###POWERMAIL_ALL###';
    $record['tx_powermail_mailreceiver']  = '###POWERMAIL_TYPOSCRIPT_CART###' . "\n" . '###POWERMAIL_ALL###';
    $record['tx_powermail_redirect']      = false;
    $record['tx_powermail_fieldsets']     = 4;
    $record['tx_powermail_users']         = 0;
    $record['tx_powermail_preview']       = 0;

    return $record;
  }

/**
 * records( )
 *
 * @return	array		$records : the plugin records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function records( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'tt_content' );

      // browser plugin
    $uid = $uid + 1;
    $records[$uid] = $this->recordBrowser( $uid );

      // caddy plugin
    $uid = $uid + 1;
    $records[$uid] = $this->recordCaddy( $uid );

      // powermail plugin
    $uid = $uid + 1;
    $records[$uid] = $this->recordPowermail( $uid );

    return $records;
  }



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * sqlInsert( )
 *
 * @param	array		$records : TypoScript records for pages
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlInsert( $records )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery( 'tt_content', $record ) );
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tt_content', $record );
      $marker['###HEADER###']     = $record['header'];
      $marker['###TITLE_PID###']  = '"' . $this->pObj->arr_pageTitles[$record['pid']] .
                                    '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'plugin_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
    }
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_plugins.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_plugins.php']);
}