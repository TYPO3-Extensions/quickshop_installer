<?php

/* * *************************************************************
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
 * ************************************************************* */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   64: class tx_quickshopinstaller_pi1_typoscript
 *
 *              SECTION: Main
 *   88:     public function main( )
 *
 *              SECTION: Records
 *  118:     private function recordCaddy( $uid )
 *  157:     private function recordCaddyStaticFiles( )
 *  197:     private function recordCaddyStaticFilesPowermail1x( )
 *  215:     private function recordCaddyStaticFilesPowermail2x( )
 *  236:     private function recordRoot( $uid )
 *  266:     private function recordRootCaseAll( $uid )
 *  417:     private function recordRootCaseShopOnly( $uid )
 *  494:     private function recordRootStaticFiles( )
 *  534:     private function recordRootStaticFilesPowermail1x( )
 *  552:     private function recordRootStaticFilesPowermail2x( )
 *  570:     private function records( )
 *
 *              SECTION: Sql
 *  603:     private function sqlInsert( $records )
 *
 * TOTAL FUNCTIONS: 13
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
class tx_quickshopinstaller_pi1_typoscript
{

  public $prefixId = 'tx_quickshopinstaller_pi1_typoscript';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_typoscript.php';  // Path to this script relative to the extension dir.
  public $extKey = 'quickshop_installer';                      // The extension key.
  public $pObj = null;

  /*   * *********************************************
   *
   * Main
   *
   * ******************************************** */

  /**
   * main( )
   *
   * @return	void
   * @access public
   * @version 3.0.0
   * @since   3.0.0
   */
  public function main()
  {
    $records = array();

    $this->pObj->arrReport[] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'ts_create_header' ) . '
      </h2>';

    $records = $this->records();
    $this->sqlInsert( $records );
  }

  /*   * *********************************************
   *
   * Records
   *
   * ******************************************** */

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

    $title = 'pageQuickshopCaddy_title';
    $llTitle = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle = str_replace( ' ', null, $llTitle );
    $llTitle = '+page_' . $llTitle . '_' . $strUid;

    $this->pObj->arr_tsUids[ $title ] = $uid;
    $this->pObj->arr_tsTitles[ $uid ] = $title;

    $record[ 'title' ] = $llTitle;
    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'sorting' ] = 256;
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'include_static_file' ] = $this->recordCaddyStaticFiles();
    $record[ 'constants' ] = null;

    // Will set by consolidate->pageQuickshopCaddyTyposcript
    //$record['config']               = '';
    $record[ 'description' ] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

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
  private function recordCaddyStaticFiles()
  {
    $staticFiles = null;

    switch ( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $staticFiles = $this->recordCaddyStaticFilesPowermail1x();
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $staticFiles = $this->recordCaddyStaticFilesPowermail2x();
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
  private function recordCaddyStaticFilesPowermail1x()
  {
    $staticFiles = 'EXT:powermail/static/pi1/'
            . ',EXT:powermail/static/css_fancy/'
            . ',EXT:caddy/Configuration/TypoScript/Powermail/1x/'
    ;

    return $staticFiles;
  }

  /**
   * recordCaddyStaticFilesPowermail2x( )
   *
   * @return	string		$staticFiles  : the list of static files
   * @access private
   * @version 6.0.0
   * @since   3.0.0
   */
  private function recordCaddyStaticFilesPowermail2x()
  {
    // 130721, dwildt: powermail 2.x without an ending slash!
    $staticFiles = 'EXT:powermail/Configuration/TypoScript/Main'
            . ',EXT:caddy/Configuration/TypoScript/Powermail/2x/'
            . ',EXT:caddy/Configuration/TypoScript/Powermail/2x/Foundation_5x/'
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
    $this->pObj->arr_tsUids[ $this->pObj->str_tsRoot ] = $uid;

    // SWITCH : install case
    switch ( true )
    {
      case( $this->pObj->markerArray[ '###INSTALL_CASE###' ] == 'install_all' ):
        $record = $this->recordRootCaseAll( $uid );
        break;
      case( $this->pObj->markerArray[ '###INSTALL_CASE###' ] == 'install_shop' ):
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
   * @version 6.0.9
   * @since   3.0.0
   */
  private function recordRootCaseAll( $uid )
  {
    $record = null;

    $strUid = sprintf( '%03d', $uid );

    $title = strtolower( $GLOBALS[ 'TSFE' ]->page[ 'title' ] );
    $title = str_replace( ' ', null, $title );
    $title = 'page_' . $title . '_' . $strUid;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[ $this->pObj->str_tsRoot ] = $uid;

    $record[ 'title' ] = $title;
    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $GLOBALS[ 'TSFE' ]->id;
    $record[ 'tstamp' ] = time();
    $record[ 'sorting' ] = 256;
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sitetitle' ] = $this->pObj->markerArray[ '###WEBSITE_TITLE###' ];
    $record[ 'root' ] = 1;
    $record[ 'clear' ] = 3;  // Clear all
    $record[ 'include_static_file' ] = ''
            . $this->recordRootStaticFiles()
            . ',EXT:base_quickshop/Configuration/TypoScript/'
            . ',EXT:quick_shop/Configuration/TypoScript/62037/'
            . ',EXT:quick_shop/Configuration/TypoScript/Caddy/'
    ;
    $record[ 'includeStaticAfterBasedOn' ] = 1;
    $record[ 'constants' ] = '' .
            '
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.base_quickshop
  // plugin.caddy
  // plugin.quick_shop
  // plugin.tx_browser_pi1
  // plugin.tx_powermail
  // plugin.tx_seodynamictag

  // base_quickshop
plugin.base_quickshop {
  client {
    name = TYPO3 Quick Shop Installer
  }
    // for baseURL
  host = ' . $this->pObj->markerArray[ '###HOST###' ] . '/
  pages {
    root = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ] . '
    root {
      caddymini = ' . $this->pObj->arr_pageUids[ 'pageQuickshopCaddyCaddymini_title' ] . '
      libraries {
        footer = ' . $this->pObj->arr_pageUids[ 'pageQuickshopLibraryFooter_title' ] . '
        //header = ' . $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeader_title' ] . '
        header {
          logo = ' . $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderLogo_title' ] . '
          slider {
            content = ' . $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderSlider_title' ] . '
          }
        }
        menu {
          topbar = ' . $this->pObj->arr_pageUids[ 'pageQuickshopLibraryMenu_title' ] . '
          bottom = ' . $this->pObj->arr_pageUids[ 'pageQuickshopLibraryMenubelow_title' ] . '
        }
      }
    }
  }
}
  // base_quickshop

  // caddy
plugin.caddy {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ] . '
    caddymini   = ' . $this->pObj->arr_pageUids[ 'pageQuickshopCaddyCaddymini_title' ] . '
    revocation  = ' . $this->pObj->arr_pageUids[ 'pageQuickshopRevocation_title' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ] . '
    terms       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopTerms_title' ] . '
  }
  url {
    showUid = itemUid
  }
}
  // caddy

  // quick_shop
plugin.quick_shop {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ] . '
    items       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ] . '
    shipping    = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShipping_title' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ] . '
  }
}
  // quick_shop

  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
  frameworks {
    foundation {
      templating {
        components {
          navigation {
            topbar {
              name = TYPO3 Quick Shop
            }
          }
        }
      }
    }
  }
  navigation {
    showUid = itemUid
  }
}
  // plugin.tx_browser_pi1

  // plugin.tx_powermail
  // This is for powermail 2.x and hasn\'t any effect in powermail 1.x
plugin.tx_powermail {
  settings {
    javascript {
      powermailJQuery =
      powermailJQueryUi =
    }
  }
}
  // This is for powermail 2.x and hasn\'t any effect in powermail 1.x
  // plugin.tx_powermail

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|itemUid > 0] && [globalVar = TSFE:id = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ] . '
    }
  }
}
  // plugin.tx_seodynamictag
';

    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $html5conf = 'doctype                                 = xhtml_strict';
        break;
      default:
        $html5conf = 'doctype                                 = html5
xmlprologue                             = none';
        break;
    }

    switch ($GLOBALS['TSFE']->lang)
    {
      case('de'):
        $localeAll = 'de_DE';
        break;
      default:
        $localeAll = 'en_GB';
        break;
    }

    $record[ 'config' ] = '' .
            '
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // config
  // plugin.tx_browser_pi1
  // TYPO3-Browser: ajax page object I
  // TYPO3-Browser: ajax page object II



  // config
config {
  admPanel                                = 1
  baseURL                                 = ' . t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST') . '/
  disablePrefixComment                    = 1
  ' . $html5conf . '
  htmlTag_langKey                         = ' . $GLOBALS['TSFE']->lang . '
  language                                = ' . $GLOBALS['TSFE']->lang . '
  locale_all                              = ' . $localeAll . '
  metaCharset                             = UTF-8
  //no_cache                                = 1
  spamProtectEmailAddresses               = 5
  spamProtectEmailAddresses_atSubst       = <span style="display:none;">spamfilter</span><span class="dummy">@</span>
  spamProtectEmailAddresses_lastDotSubst  = <span style="display:none;">spamfilter</span><span class="dummy">.</span>
  tx_realurl_enable                       = 0
  xhtml_cleaning                          = all
}
  // config

  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
    // Don\'t display any order box
  displayList.selectBox_orderBy.display = 0
}
  // plugin.tx_browser_pi1

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
browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.' . $GLOBALS[ 'TSFE' ]->lang . '
  // TYPO3-Browser: ajax page object II

';

    $record[ 'description' ] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

  /**
   * recordRootCaseShopOnly( )
   *
   * @param	[type]		$$uid: ...
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 6.0.9
   * @since   3.0.0
   */
  private function recordRootCaseShopOnly( $uid )
  {
    $record = null;

    $strUid = sprintf( '%03d', $uid );

    $title = strtolower( $GLOBALS[ 'TSFE' ]->page[ 'title' ] );
    $title = str_replace( ' ', null, $title );
    $title = '+page_' . $title . '_' . $strUid;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[ $this->pObj->str_tsRoot ] = $uid;

    $record[ 'title' ] = $title;
    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $GLOBALS[ 'TSFE' ]->id;
    $record[ 'tstamp' ] = time();
    $record[ 'sorting' ] = 256;
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'root' ] = 0;
    $record[ 'clear' ] = 0;  // Clear nothing
    $record[ 'include_static_file' ] = ''
            . $this->recordRootStaticFiles()
            //. ',EXT:base_quickshop/Configuration/TypoScript/'
            . ',EXT:quick_shop/Configuration/TypoScript/62037/'
            . ',EXT:quick_shop/Configuration/TypoScript/Caddy/'
    ;
    $record[ 'includeStaticAfterBasedOn' ] = 0;
    $record[ 'constants' ] = '' .
            '
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.caddy
  // plugin.quick_shop
  // plugin.tx_browser_pi1
  // plugin.tx_powermail
  // plugin.tx_seodynamictag

  // caddy
plugin.caddy {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ] . '
    caddymini   = ' . $this->pObj->arr_pageUids[ 'pageQuickshopCaddyCaddymini_title' ] . '
    revocation  = ' . $this->pObj->arr_pageUids[ 'pageQuickshopRevocation_title' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ] . '
    terms       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopTerms_title' ] . '
  }
  url {
    showUid = itemUid
  }
}
  // caddy

  // quick_shop
plugin.quick_shop {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ] . '
    items       = ' . $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ] . '
    shipping    = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShipping_title' ] . '
    shop        = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ] . '
  }
}
  // quick_shop

  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
  navigation {
    showUid = itemUid
  }
}
  // plugin.tx_browser_pi1

  // plugin.tx_powermail
  // This is for powermail 2.x and hasn\'t any effect in powermail 1.x
plugin.tx_powermail {
  settings {
    javascript {
      powermailJQuery =
      powermailJQueryUi =
    }
  }
}
  // This is for powermail 2.x and hasn\'t any effect in powermail 1.x
  // plugin.tx_powermail

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|itemUid > 0] && [globalVar = TSFE:id = ' . $this->pObj->arr_pageUids[ 'pageQuickshopShop_title' ] . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record[ 'config' ] = '' .
            '
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // config
  // plugin.tx_browser_pi1

  // config
config {
  //no_cache = 1
}
  // config

  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
    // Don\'t display any order box
  displayList.selectBox_orderBy.display = 0
}
  // plugin.tx_browser_pi1

';

    $record[ 'description' ] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

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
  private function recordRootStaticFiles()
  {
    $staticFiles = null;

    switch ( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $staticFiles = $this->recordRootStaticFilesPowermail1x();
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $staticFiles = $this->recordRootStaticFilesPowermail2x();
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
   * @version 6.0.0
   * @since   3.0.0
   */
  private function recordRootStaticFilesPowermail1x()
  {
    $staticFiles = $this->recordRootStaticFilesPowermail2x();
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
  private function recordRootStaticFilesPowermail2x()
  {
    $staticFiles = 'EXT:css_styled_content/static/'
            . ',EXT:browser/Configuration/TypoScript/Foundation/Framework/'
            . ',EXT:browser/Configuration/TypoScript/Foundation/Framework/page/jss/modernizr/'
            . ',EXT:browser/Configuration/TypoScript/'
            . ',EXT:browser/Configuration/TypoScript/Foundation/Templating/'
            . ',EXT:caddy/Configuration/TypoScript/Basis/'
            . ',EXT:caddy/Configuration/TypoScript/Css/orange/'
            . ',EXT:caddy/Configuration/TypoScript/Foundation/5x/'
            . ',EXT:caddy/Configuration/TypoScript/Foundation/5x/Css/'
            . ',EXT:caddy/Configuration/TypoScript/Properties/de/'
    ;

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
  private function records()
  {
    $records = array();
    $uid = $this->pObj->zz_getMaxDbUid( 'sys_template' );

    // TypoScript for the root page
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordRoot( $uid );

    // TypoScript for the caddy page
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordCaddy( $uid );

    return $records;
  }

  /*   * *********************************************
   *
   * Sql
   *
   * ******************************************** */

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
    foreach ( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $record, $no_quote_fields));
      $GLOBALS[ 'TYPO3_DB' ]->exec_INSERTquery( 'sys_template', $record );
      $error = $GLOBALS[ 'TYPO3_DB' ]->sql_error();

      if ( $error )
      {
        $query = $GLOBALS[ 'TYPO3_DB' ]->INSERTquery( 'sys_template', $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                'query: ' . $query . '.<br />' . PHP_EOL .
                'error: ' . $error . '.<br />' . PHP_EOL .
                'Sorry for the trouble.<br />' . PHP_EOL .
                'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

      // prompt
      $pageTitle = $this->pObj->arr_pageTitles[ $record[ 'pid' ] ];
      $pageTitle = $this->pObj->pi_getLL( $pageTitle );
      $marker[ '###TITLE###' ] = $record[ 'title' ];
      $marker[ '###UID###' ] = $record[ 'uid' ];
      $marker[ '###TITLE_PID###' ] = '"' . $pageTitle . '" (uid ' . $record[ 'pid' ] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons[ 'ok' ] . ' ' . $this->pObj->pi_getLL( 'ts_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[] = $prompt;
      // prompt
    }
  }

}

if ( defined( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_typoscript.php' ] )
{
  include_once($TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_typoscript.php' ]);
}