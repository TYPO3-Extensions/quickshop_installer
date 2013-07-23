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
 *   58: class tx_quickshopinstaller_pi1_typoscript
 *
 *              SECTION: Main
 *   82:     public function main( )
 *
 *              SECTION: Records
 *  112:     private function recordCaddy( $uid )
 *  167:     private function recordRoot( $uid )
 *  197:     private function recordRootCaseAll( $uid )
 *  361:     private function recordRootCaseShopOnly( $uid )
 *  477:     private function records( )
 *
 *              SECTION: Sql
 *  510:     private function sqlInsert( $records )
 *
 * TOTAL FUNCTIONS: 7
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
class tx_quickshopinstaller_pi1_typoscript
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_typoscript';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_typoscript.php';  // Path to this script relative to the extension dir.
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
 * @since   3.0.0
 */
  public function main( )
  {
    $records = array( );

    $this->pObj->arrReport[ ] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'ts_create_header' ) . '
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
 * recordCaddy( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordCaddy( $uid )
  {
    $record = null;

    $strUid = sprintf( '%03d', $uid );

    $title    = 'page_title_caddy';
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    $this->pObj->arr_tsUids[ $title ] = $uid;
    $this->pObj->arr_tsTitles[ $uid ] = $title;

    $record['title']                = $llTitle;
    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']               = time( );
    $record['sorting']              = 256;
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file']  = $this->recordCaddyStaticFiles( );
    $record['constants']            = null;
    
      // Will set by consolidate->pageCaddyTyposcript
    //$record['config']               = '';
    $record['description'] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

/**
 * recordCaddyStaticFiles( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordCaddyStaticFiles( )
  {
    $staticFiles = null;
    
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
        $staticFiles = $this->recordCaddyStaticFilesPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $staticFiles = $this->recordCaddyStaticFilesPowermail2x( );
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
    
    return $staticFiles;
  }

/**
 * recordCaddyStaticFilesPowermail1x( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordCaddyStaticFilesPowermail1x( )
  {
    $staticFiles  = 'EXT:powermail/static/pi1/,' 
                  . 'EXT:powermail/static/css_fancy/,'
                  . 'EXT:caddy/static/powermail/1x/' 
                  ;

    return $staticFiles;
  }

/**
 * recordCaddyStaticFilesPowermail2x( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordCaddyStaticFilesPowermail2x( )
  {
      // 130721, dwildt: powermail 2.x without an ending slash!
    $staticFiles  = 'EXT:powermail/Configuration/TypoScript/Main,' 
                  . 'EXT:powermail/Configuration/TypoScript/CssFancy,'
                  . 'EXT:caddy/static/powermail/2x/,' 
                  . 'EXT:caddy/static/powermail/2x/css/,' 
                  ;

    return $staticFiles;
  }

/**
 * recordRoot( )
 *
 * @param	[type]		$$uid: ...
 * @return	array
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordRoot( $uid )
  {
    $strUid = sprintf( '%03d', $uid );
    $this->pObj->str_tsRoot = 'page_quickshop_' . $strUid;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $record = $this->recordRootCaseAll( $uid );
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_shop' ):
        $record = $this->recordRootCaseShopOnly( $uid );
        break;
    }
      // SWITCH : install case

    return $record;
  }

/**
 * recordRootCaseAll( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordRootCaseAll( $uid )
  {
    $record = null;

    $strUid = sprintf ('%03d', $uid);

    $title  = strtolower( $GLOBALS['TSFE']->page['title'] );
    $title  = str_replace( ' ', null, $title );
    $title  = 'page_' . $title . '_' . $strUid;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

    $record['title']                      = $title;
    $record['uid']                        = $uid;
    $record['pid']                        = $GLOBALS['TSFE']->id;
    $record['tstamp']                     = time( );
    $record['sorting']                    = 256;
    $record['crdate']                     = time( );
    $record['cruser_id']                  = $this->pObj->markerArray['###BE_USER###'];
    $record['sitetitle']                  = $this->pObj->markerArray['###WEBSITE_TITLE###'];
    $record['root']                       = 1;
    $record['clear']                      = 3;  // Clear all
    $record['include_static_file']        = 'EXT:css_styled_content/static/,' 
                                          . 'EXT:browser/static/,'
                                          . 'EXT:base_quickshop/static/,' 
                                          . $this->recordRootStaticFiles( )
                                          ;
    $record['includeStaticAfterBasedOn'] = 1;
    $record['constants'] = ''.
'
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.base_quickshop
  // plugin.caddy
  // plugin.quick_shop
  // plugin.tx_powermail

  // base_quickshop
plugin.base_quickshop {
  basic {
      // for baseURL
    host = ' . $this->pObj->markerArray['###HOST###'] . '/
  }
  pages {
    library {
      header = ' . $this->pObj->arr_pageUids[ 'page_title_library_header' ] . '
      footer = ' . $this->pObj->arr_pageUids[ 'page_title_library_footer' ] . '
    }
  }
}
  // base_quickshop

  // caddy
plugin.caddy {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'page_title_caddy' ] . '
    caddymini   = ' . $this->pObj->arr_pageUids[ 'page_title_caddy_caddymini' ] . '
    revocation  = ' . $this->pObj->arr_pageUids[ 'page_title_revocation' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'page_title_root' ] . '
    terms       = ' . $this->pObj->arr_pageUids[ 'page_title_terms' ] . '
  }
}
  // caddy

  // quick_shop
plugin.quick_shop {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'page_title_caddy' ] . '
    shipping    = ' . $this->pObj->arr_pageUids[ 'page_title_shipping' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'page_title_root' ] . '
  }
}
  // quick_shop

  // plugin.tx_powermail
  // This is for powermail 2.x and hasn\'t  an effect in powermail 1.x
plugin.tx_powermail {
  settings {
    javascript {
      powermailJQuery = 
      powermailJQueryUi = 
    }
  }
}
  // This is for powermail 2.x and hasn\'t  an effect in powermail 1.x
  // plugin.tx_powermail
';
    $record['config']                    = ''.
'
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // config
  // TYPO3-Browser: ajax page object I
  // TYPO3-Browser: ajax page object II



  // config
config {
  tx_realurl_enable  = 0
  //no_cache           = 1
  language           = ' . $GLOBALS['TSFE']->lang . '
  htmlTag_langKey    = ' . $GLOBALS['TSFE']->lang . '
}
  // config



  // TYPO3-Browser: ajax page object I

  // Add this snippet into the setup of the TypoScript
  // template of your page.
  // Use \'page\', if the name of your page object is \'page\'
  // (this is a default but there isn\'t any rule)

[globalString = GP:tx_browser_pi1|segment=single] || [globalString = GP:tx_browser_pi1|segment=list] || [globalString = GP:tx_browser_pi1|segment=searchform]
  page >
  page < plugin.tx_browser_pi1.javascript.ajax.page
[global]
  // TYPO3-Browser: ajax page object I



  // TYPO3-Browser: ajax page object II
  // In case of localisation: 
  // * Configure the id of sys_language in the Constant Editor. 
  // * Move in this line ...jQuery.default to ...jQuery.de (i.e.)
browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.' . $GLOBALS['TSFE']->lang . '
  // TYPO3-Browser: ajax page object II

';

    $record['description'] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

/**
 * recordRootCaseShopOnly( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordRootCaseShopOnly( $uid )
  {
    $record = null;

    $strUid = sprintf( '%03d', $uid );

    $title = strtolower( $GLOBALS['TSFE']->page['title'] );
    $title = str_replace( ' ', null, $title );
    $title = '+page_' . $title . '_' . $strUid;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

    $record['title']                      = $title;
    $record['uid']                        = $uid;
    $record['pid']                        = $GLOBALS['TSFE']->id;
    $record['tstamp']                     = time( );
    $record['sorting']                    = 256;
    $record['crdate']                     = time( );
    $record['cruser_id']                  = $this->pObj->markerArray['###BE_USER###'];
    $record['root']                       = 0;
    $record['clear']                      = 0;  // Clear nothing
    $record['include_static_file']        = 'EXT:css_styled_content/static/,' 
                                          . 'EXT:browser/static/,'
                                          . $this->recordRootStaticFiles( )
                                          ;
    $record['includeStaticAfterBasedOn']  = 0;
    $record['constants']           = ''.
'
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.caddy
  // plugin.quick_shop

  // caddy
plugin.caddy {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'page_title_caddy' ] . '
    caddymini   = ' . $this->pObj->arr_pageUids[ 'page_title_caddy_caddymini' ] . '
    revocation  = ' . $this->pObj->arr_pageUids[ 'page_title_revocation' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'page_title_root' ] . '
    terms       = ' . $this->pObj->arr_pageUids[ 'page_title_terms' ] . '
  }
}
  // caddy

  // quick_shop
plugin.quick_shop {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'page_title_caddy' ] . '
    shipping    = ' . $this->pObj->arr_pageUids[ 'page_title_shipping' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'page_title_root' ] . '
  }
}
  // quick_shop
';
    $record['config']                     = ''.
'config {
  //no_cache = 1
}
';

    $record['description'] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

/**
 * recordRootStaticFiles( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordRootStaticFiles( )
  {
    $staticFiles = null;
    
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
        $staticFiles = $this->recordRootStaticFilesPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $staticFiles = $this->recordRootStaticFilesPowermail2x( );
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
    
    return $staticFiles;
  }

/**
 * recordRootStaticFilesPowermail1x( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordRootStaticFilesPowermail1x( )
  {
    $staticFiles  = 'EXT:quick_shop/static/,'
                  . 'EXT:caddy/static/,' 
                  . 'EXT:caddy/static/css/,' 
                  . 'EXT:quick_shop/static/caddy/';

    return $staticFiles;
  }

/**
 * recordRootStaticFilesPowermail2x( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordRootStaticFilesPowermail2x( )
  {
    $staticFiles  = 'EXT:quick_shop/static/,'
                  . 'EXT:caddy/static/,' 
                  . 'EXT:caddy/static/css/,' 
                  . 'EXT:quick_shop/static/caddy/';

    return $staticFiles;
  }

/**
 * records( )
 *
 * @return	array		$records : the TypoScript records
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function records( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'sys_template' );

      // TypoScript for the root page
    $uid = $uid + 1;
    $records[$uid] = $this->recordRoot( $uid );

      // TypoScript for the caddy page
    $uid = $uid + 1;
    $records[$uid] = $this->recordCaddy( $uid );

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
 * @since   3.0.0
 */
  private function sqlInsert( $records )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $record, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'sys_template', $record );
      $error = $GLOBALS['TYPO3_DB']->sql_error( );      
      
      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( 'sys_template', $record );
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
      $marker['###TITLE###']     = $record['title'];
      $marker['###UID###']       = $record['uid'];
      $marker['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          '.$this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'ts_create_prompt' ).'
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
        // prompt
    }
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_typoscript.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_typoscript.php']);
}