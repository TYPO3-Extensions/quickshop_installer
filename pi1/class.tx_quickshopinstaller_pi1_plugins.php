<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013-2014 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 *   60: class tx_quickshopinstaller_pi1_plugins
 *
 *              SECTION: Main
 *   84:     public function main( )
 *
 *              SECTION: Records
 *  113:     private function records( )
 *  146:     private function browser( $uid )
 *  273:     private function caddy( $uid )
 *  306:     private function caddymini( $uid )
 *  339:     private function powermail( $uid )
 *  378:     private function powermail1x( $uid )
 *  434:     private function powermail2x( $uid )
 *
 *              SECTION: Sql
 *  474:     private function sqlInsert( $records )
 *
 * TOTAL FUNCTIONS: 9
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Quick Shop Inmstaller' for the 'quickshop_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_quickshopinstaller
 * @version 6.0.0
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
    $records[$uid] = $this->browser( $uid );

      // caddy plugin
    $uid = $uid + 1;
    $records[$uid] = $this->caddy( $uid );

      // mini caddy plugin
    $uid = $uid + 1;
    $records[$uid] = $this->caddymini( $uid );

      // powermail plugin
    $uid = $uid + 1;
    $records[$uid] = $this->powermail( $uid );

    return $records;
  }

/**
 * browser( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 6.0.0
 * @since   0.0.1
 */
  private function browser( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_browser_header' );
    $this->pObj->arr_pluginUids['plugin_browser_header'] = $uid;

    $myComment  = htmlspecialchars( $this->pObj->pi_getLL( 'plugin_browser_mycomment' ) );

    $record['uid']           = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ];
    $record['tstamp']        = time( );
    $record['crdate']        = time( );
    $record['cruser_id']     = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']       = 128;
    $record['CType']         = 'list';
    $record['header']        = $llHeader;
    $record['pages']         = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
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
                    <value index="vDEF">2</value>
                </field>
            </language>
        </sheet>
        <sheet index="socialmedia">
            <language index="lDEF">
                <field index="enabled">
                    <value index="vDEF">enabled_wi_individual_template</value>
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
                    <value index="vDEF">62037</value>
                </field>
                <field index="myComment">
                    <value index="vDEF">' . $myComment . '</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:browser/Resources/Private/Templates/HTML/Foundation/main_01.html</value>
                </field>
                <field index="css.browser">
                    <value index="vDEF">ts</value>
                </field>
                <field index="css.jqui">
                    <value index="vDEF">z_none</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="jquery_library">
                    <value index="vDEF">none</value>
                </field>
                <field index="jquery_ui">
                    <value index="vDEF">no</value>
                </field>
                <field index="jquery_plugins.t3browser">
                    <value index="vDEF">ts</value>
                </field>
                <field index="browser_libraries">
                    <value index="vDEF">typoscript</value>
                </field>
                <field index="mode">
                    <value index="vDEF">disabled</value>
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
 * caddy( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function caddy( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_caddy_header' );
    $this->pObj->arr_pluginUids['plugin_caddy_header'] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256;
    $record['CType']        = 'list';
    $record['header']       = $llHeader;
    $record['list_type']    = 'caddy_pi1';
    $record['sectionIndex'] = 1;
// Will updated by consolidate->pageQuickshopCaddyPluginCaddy
//    $record['pi_flexform']  = '';

    return $record;
  }

/**
 * caddymini( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.5
 * @since   3.0.5
 * @internal  #i0007
 */
  private function caddymini( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_caddymini_header' );
    $this->pObj->arr_pluginUids['plugin_caddymini_header'] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageQuickshopCaddyCaddymini_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256;
    $record['CType']        = 'list';
    $record['header']       = $llHeader;
    $record['header_layout']  = 100; // hidden
    $record['list_type']    = 'caddy_pi3';
    $record['sectionIndex'] = 1;
// Will updated by consolidate->pageQuickshopCaddyPluginCaddy
//    $record['pi_flexform']  = '';

    return $record;
  }

/**
 * powermail( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function powermail( $uid )
  {
    switch( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $record = $this->powermail1x( $uid );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $record = $this->powermail2x( $uid );
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

/**
 * powermail1x( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function powermail1x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_powermail_header' );
    $this->pObj->arr_pluginUids['plugin_powermail_header'] = $uid;

    $emailRecipient = $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###']
                    . PHP_EOL
                    . 'Quick Shop'
                    ;

    $record['uid']                        = $uid;
    $record['pid']                        = $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ];
    $record['tstamp']                     = time( );
    $record['crdate']                     = time( );
    $record['cruser_id']                  = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']                    = 512;
    $record['CType']                      = 'powermail_pi1';
    $record['header']                     = $llHeader;
    $record['header_layout']              = 100;  // hidden
    $record['list_type']                  = '';
    $record['sectionIndex']               = 1;
    $record['tx_powermail_title']         = 'quickshop';
    $record['tx_powermail_recipient']     = $emailRecipient;
    $record['tx_powermail_subject_r']     = $this->pObj->pi_getLL( 'plugin_powermail_subject_r1x' );
    $record['tx_powermail_subject_s']     = $this->pObj->pi_getLL( 'plugin_powermail_subject_s1x' );
// Will updated by consolidate->pageQuickshopCaddyPluginPowermail
//    $record['tx_powermail_sender']        = $str_sender;
//    $record['tx_powermail_sendername']    = $str_sendername;
    $record['tx_powermail_confirm']       = 1;
    $record['tx_powermail_pages']         = null;
    $record['tx_powermail_multiple']      = 0;
    $record['tx_powermail_recip_table']   = 0;
    $record['tx_powermail_recip_id']      = null;
    $record['tx_powermail_recip_field']   = null;
    $record['tx_powermail_thanks']        = $this->pObj->pi_getLL( 'plugin_powermail_thanks1x' );
    $record['tx_powermail_mailsender']    = $this->pObj->pi_getLL( 'plugin_powermail_body_s1x' );
    $record['tx_powermail_mailreceiver']  = $this->pObj->pi_getLL( 'plugin_powermail_body_r1x' );
    $record['tx_powermail_redirect']      = null;
    $record['tx_powermail_fieldsets']     = 4;
    $record['tx_powermail_users']         = 0;
    $record['tx_powermail_preview']       = 0;

    return $record;
  }

/**
 * powermail2x( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function powermail2x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'plugin_powermail_header' );
    $this->pObj->arr_pluginUids['plugin_powermail_header'] = $uid;

    $record['uid']                        = $uid;
    $record['pid']                        = $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ];
    $record['tstamp']                     = time( );
    $record['crdate']                     = time( );
    $record['cruser_id']                  = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']                    = 512;
    $record['CType']                      = 'list';
    $record['header']                     = $llHeader;
    $record['header_layout']              = 100;  // hidden
    $record['list_type']                  = 'powermail_pi1';
// Will updated by consolidate->pageQuickshopCaddyPluginPowermail
//    $record['pi_flexform']              = null;

    return $record;
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
      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( 'tt_content', $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

        // prompt
      $pageTitle = $this->pObj->arr_pageTitles[$record['pid']];
      $pageTitle = $this->pObj->pi_getLL( $pageTitle );
      $marker['###HEADER###']     = $record['header'];
      $marker['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'plugin_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
        // prompt
    }
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_plugins.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_plugins.php']);
}