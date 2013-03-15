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
 *   58: class tx_qsinstaller_pi1_typoscript
 *
 *              SECTION: Main
 *   82:     public function main( )
 *
 *              SECTION: Records
 *  112:     private function recordCaddy( $uid )
 *  223:     private function recordRoot( $uid )
 *  253:     private function recordRootCaseAll( $uid )
 *  368:     private function recordRootCaseShopOnly( $uid )
 *  435:     private function records( )
 *
 *              SECTION: Sql
 *  468:     private function sqlInsert( $records )
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
class tx_qsinstaller_pi1_typoscript
{
  public $prefixId      = 'tx_qsinstaller_pi1_typoscript';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_qsinstaller_pi1_typoscript.php';  // Path to this script relative to the extension dir.
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
 * @since   0.0.1
 */
  private function recordCaddy( $uid )
  {
    $record = null;

    $strUid = sprintf( '%03d', $uid );

    $title = strtolower( $this->pObj->pi_getLL( 'page_title_caddy' ) );
    $title = str_replace( ' ', null, $title );
    $title = '+page_' . $title . '_' . $strUid;

    $this->pObj->str_tsWtCart = $title;
    $this->pObj->arr_tsUids[$this->pObj->str_tsWtCart] = $uid;

    $record['title']               = $title;
    $record['uid']                 = $uid;
    $record['pid']                 = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']              = time( );
    $record['sorting']             = 256;
    $record['crdate']              = time( );
    $record['cruser_id']           = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = ''.
      'EXT:wt_cart/files/static/,' .
      'EXT:powermail/static/pi1/,' .
      'EXT:powermail/static/css_basic/';
    // See $this->consolidateTsWtCart()
    //$record['constants']           = '';
    $record['config']           = '
  //////////////////////////////////////////
  //
  // INDEX
  //
  // page
  // plugin.tx_powermail_pi1
  // plugin.tx_wtcart_pi1



  //////////////////////////////////////////
  //
  // page

page {
  includeCSS {
    // remove the cart default css
    file3456     >
  }
}
  // page



  //////////////////////////////////////////
  //
  // plugin.tx_powermail_pi1

plugin.tx_powermail_pi1 {
  email {
    sender_mail {
      sender {
        name {
          value = Quick Shop
        }
        email {
          value = ' . $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] . '
        }
      }
    }
  }
  _LOCAL_LANG {
    default {
      locallangmarker_confirmation_submit = Order without costs and without delivering!
    }
    de {
      locallangmarker_confirmation_submit = Kostenlos bestellen, nichts bekommen!
    }
  }
}
  // plugin.tx_powermail_pi1



  //////////////////////////////////////////
  //
  // plugin.tx_wtcart_pi1

plugin.tx_wtcart_pi1 {
  _LOCAL_LANG {
    default {
      wtcart_ll_sku = Produkt-ID
    }
    de {
      wtcart_ll_sku = Bestellnummer
    }
  }
}
  // plugin.tx_wtcart_pi1
';
    // Cart page

    return $record;
  }

/**
 * recordRoot( )
 *
 * @param	[type]		$$uid: ...
 * @return	array
 * @access private
 * @version 3.0.0
 * @since   0.0.1
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
        $record = $this->recordRootCaseShop( $uid );
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
 * @since   0.0.1
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

    $record['title']                = $title;
    $record['uid']                  = $uid;
    $record['pid']                  = $GLOBALS['TSFE']->id;
    $record['tstamp']               = time( );
    $record['sorting']              = 256;
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['sitetitle']            = $this->pObj->markerArray['###WEBSITE_TITLE###'];
    $record['root']                 = 1;
    $record['clear']                = 3;  // Clear all
    $record['include_static_file']  = '' .
      'EXT:css_styled_content/static/,EXT:base_quickshop/static/base_quickshop/,'.
      'EXT:browser/static/,EXT:quick_shop/static/';
    $record['includeStaticAfterBasedOn'] = 1;
    $record['config']                    = ''.
'config {
  baseURL            = ' . $this->pObj->markerArray['###HOST###'] . '/
  metaCharset        = UTF-8
  tx_realurl_enable  = 0
  no_cache           = 1
  language           = ' . $GLOBALS['TSFE']->lang . '
  htmlTag_langKey    = ' . $GLOBALS['TSFE']->lang . '
}


  ////////////////////////////////////////////////////////
  //
  // ajax page object

  // Add this snippet into the setup of the TypoScript
  // template of your page.
  // Use \'page\', if the name of your page object is \'page\'
  // (this is a default but there isn\'t any rule)

[globalString = GP:tx_browser_pi1|segment=single] || [globalString = GP:tx_browser_pi1|segment=list] || [globalString = GP:tx_browser_pi1|segment=searchform]
  page >
  page < plugin.tx_browser_pi1.javascript.ajax.page
[global]
  // ajax page object

  // TYPO3-Browser: ajax page object II. In case of localisation: Configure the id of sys_languagein the Constant Editor. Move in this line ...jQuery.default to ...jQuery.de (i.e.)
browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery

';

    $record['constants'] = ''.
'myConst {
  //host = '.$this->pObj->markerArray['###HOST###'].'/
  pages {
    quick_shop = ' . $this->pObj->arr_pageUids[ $GLOBALS['TSFE']->page['title'] ] . '
    quick_shop {
      cart      = ' . $this->pObj->arr_pageUids[ 'page_title_caddy' ] . '
      shipping  = ' . $this->pObj->arr_pageUids[ 'page_title_shipping' ] . '
      terms     = ' . $this->pObj->arr_pageUids[ 'page_title_terms' ] . '
      libraries = ' . $this->pObj->arr_pageUids[ 'page_title_library' ] . '
      libraries {
        header  = ' . $this->pObj->arr_pageUids[ 'page_title_library_header' ] . '
        footer  = ' . $this->pObj->arr_pageUids[ 'page_title_library_footer' ] . '
      }
    }
  }
  paths {
    res  = EXT:base_quickshop/res/
    html = EXT:base_quickshop/res/html/
    css  = EXT:base_quickshop/res/html/css/
  }
  files {
    html {
      template = index.html
      css      = basic.css
      favicon  = images/favicon.ico
    }
  }
  dims {
    header_image {
      maxW = 210
      maxH = 420
    }
  }
  words {
    // HTML a href title tag for menu item rootpage
    title_tag_quick_shop_page = ' . $this->pObj->pi_getLL( 'phrases_ts_titleTag_quickshop_page' ) . '
  }
}';
    $record['description'] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    $record['include_static_file'] = null .
      'EXT:css_styled_content/static/,EXT:base_quickshop/static/base_quickshop/,' .
      'EXT:browser/static/,EXT:quick_shop/static/';

    return $record;
  }

/**
 * recordRootCaseShopOnly( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
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
    $record['includeStaticAfterBasedOn']  = 0;
    $record['config']                     = ''.
'config {
  no_cache = 1
}
';
    $record['constants']           = ''.
'myConst {
  //host = '.$this->pObj->markerArray['###HOST###'].'/
  pages {
    quick_shop = ' . $this->pObj->arr_pageUids[ $GLOBALS['TSFE']->page['title'] ] . '
    quick_shop {
      cart      = ' . $this->pObj->arr_pageUids[ 'page_title_caddy' ] . '
      shipping  = ' . $this->pObj->arr_pageUids[ 'page_title_shipping' ] . '
      terms     = ' . $this->pObj->arr_pageUids[ 'page_title_terms' ] . '
    }
  }
  dims {
    header_image {
      maxW = 210
      maxH = 420
    }
  }
  words {
    // HTML a href title tag for menu item rootpage
    title_tag_quick_shop_page = ' . $this->pObj->pi_getLL( 'phrases_ts_titleTag_quickshop_page' ) . '
  }
}';

    $record['description'] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    $record['include_static_file'] = null .
      'EXT:css_styled_content/static/,EXT:browser/static/,EXT:quick_shop/static/';

    return $record;
  }

/**
 * records( )
 *
 * @return	array		$records : the TypoScript records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
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
 * @since   0.0.1
 */
  private function sqlInsert( $records )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $record, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'sys_template', $record );
      $marker['###TITLE###']     = $record['title'];
      $marker['###UID###']       = $record['uid'];
      $marker['###TITLE_PID###'] = '"' . $this->pObj->arr_pageTitles[$record['pid']] .
                                   '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          '.$this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'ts_create_prompt' ).'
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
    }
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_qsinstaller_pi1_typoscript.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_qsinstaller_pi1_typoscript.php']);
}