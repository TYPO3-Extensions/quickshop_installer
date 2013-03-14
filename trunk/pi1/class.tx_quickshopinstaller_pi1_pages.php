<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 *  116: class tx_quickshopinstaller_pi1_pages extends tslib_pibase
 *
 *              SECTION: Main
 *  174:     public function main( $content, $conf)
 *
 *              SECTION: Confirmation
 *  257:     private function confirmation()
 *
 *              SECTION: Counter
 *  333:     private function zz_countPages( $pageUid )
 *
 *              SECTION: Create
 *  362:     private function create( )
 *  380:     private function createBeGroup()
 *  486:     private function createContent()
 *  628:     private function createFilesShop()
 *
 *              SECTION: Create pages
 *  695:     private function pageCaddy( $pageUid, $sorting )
 *  732:     private function pageDelivery( $pageUid, $sorting )
 *  769:     private function pageLegalinfo( $pageUid, $sorting )
 *  806:     private function pageLibrary( $pageUid, $sorting )
 *  857:     private function pageLibraryFooter( $pageUid, $sorting )
 *  895:     private function pageLibraryHeader( $pageUid, $sorting )
 *  933:     private function pageProducts( $pageUid, $sorting )
 * 1030:     private function pageTerms( $pageUid, $sorting )
 * 1065:     private function pages( )
 * 1097:     private function pagesLibrary( $pageUid )
 * 1123:     private function pagesLibraryRecords( $pageUid )
 * 1151:     private function pagesLibrarySqlInsert( $pages )
 * 1178:     private function pagesRoot( $pageUid )
 * 1199:     private function pagesRootRecords( $pageUid )
 * 1242:     private function pagesRootSqlInsert( $pages )
 *
 *              SECTION: Create plugins
 * 1275:     private function createPlugins()
 *
 *              SECTION: Create records
 * 1517:     private function createRecordsPowermail()
 * 2126:     private function createRecordsShop()
 *
 *              SECTION: Create TypoScript
 * 2494:     private function createTyposcript()
 *
 *              SECTION: Consolidate
 * 2801:     private function consolidatePageCurrent()
 * 3024:     private function consolidatePluginPowermail()
 * 3101:     private function consolidateTsWtCart()
 *
 *              SECTION: Extensions
 * 3243:     private function extensionCheck( )
 * 3308:     private function extensionCheckCaseBaseTemplate( )
 * 3347:     private function extensionCheckExtension( $key, $title )
 *
 *              SECTION: Html
 * 3388:     private function htmlReport( )
 *
 *              SECTION: Init
 * 3445:     private function initBoolTopLevel( )
 * 3486:     private function install( )
 * 3525:     private function installNothing( )
 *
 *              SECTION: Prompt
 * 3551:     private function promptCleanUp()
 *
 *              SECTION: ZZ
 * 3600:     private function zz_getCHash($str_params)
 * 3614:     private function zz_getMaxDbUid($table)
 * 3641:     private function zz_getPathToIcons()
 * 3655:     private function zz_getFlexValues()
 *
 * TOTAL FUNCTIONS: 41
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Quick Shop Inmstaller' for the 'quickshop_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_quickshopinstaller
 * @version 1.0.6
 */
class tx_quickshopinstaller_pi1_pages extends tslib_pibase
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_pages';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_pages.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'quickshop_installer';                      // The extension key.

  public $pObj = null;

  
  
 /***********************************************
  *
  * Create pages
  *
  **********************************************/

/**
 * pageCaddy( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageCaddy( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_cart';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pageDelivery( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageDelivery( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_shipping';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pageLegalinfo( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageLegalinfo( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_legalinfo';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pageLibrary( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageLibrary( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_library';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'library',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// QUICK SHOP INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

TCEMAIN {
  clearCacheCmd = pages
}

// QUICK SHOP INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pageLibraryFooter( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageLibraryFooter( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_library_footer';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'page_title_library';
    $llPidTitle   = $this->pObj->pi_getLL( $pidTitle );
    $pid          = $this->pObj->arr_pageUids[ $llPidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pageLibraryHeader( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageLibraryHeader( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_library_header';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'page_title_library';
    $llPidTitle   = $this->pObj->pi_getLL( $pidTitle );
    $pid          = $this->pObj->arr_pageUids[ $llPidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pageProducts( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageProducts( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_products';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'quickshop',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by QUICK SHOP INSTALLER at ' . $dateHumanReadable . ' -- BEGIN



  ////////////////////////////////////////////////////////////////////////
  //
  // INDEX
  // =====
  // TCAdefaults
  // TCEMAIN



  ////////////////////////////////////////////////////////////////////////
  //
  // TCAdefaults

  // Default values for new records
TCAdefaults {
    // Default values for organiser calendar
  tx_quickshop_products {
      // Width in Pixel
    imagewidth    = 200
      // 26: Beside text, left
    imageorient   =  26
      // 1: All images have 1 column
    imagecols     =   1
      // 1: Click enlarge is enabled
    image_zoom    =   1
      // 1: Every image get its own div-tag
    image_noRows  =   1
      // 1: reduced, 2: normal
    tax           =   2
  }
}
  // Default values for new records
  // TCAdefaults



  ////////////////////////////////////////////////////////////////////////
  //
  // TCEMAIN

TCEMAIN {
  clearCacheCmd = pages
}
  // TCEMAIN



// Created by QUICK SHOP INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

'
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pageTerms( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @param	string		$dateHumanReadable  : human readabel date
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageTerms( $pageUid, $sorting )
  {
    $pageTitle    = 'page_title_terms';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;

    return $page;
  }

/**
 * pages( ) :
 *
 * @return	void
 * @access public
 * @version 3.0.0
 * @since 1.0.0
 */
  public function pages( )
  {
      // Prompt header
    $this->pObj->arrReport[ ] = '
      <h2>
       '.$this->pObj->pi_getLL('page_create_header').'
      </h2>';
      // Prompt header

    $pageUid = $this->pObj->zz_getMaxDbUid( 'pages' );

      // Pages on the root level
    $pageUid = $this->pagesRoot( $pageUid );

      // Pages within page library
    $pageUid = $this->pagesLibrary( $pageUid );

    return;
  }

/**
 * pagesLibrary( ) :
 *
 * @param	integer		$pageUid: current page uid
 * @return	integer		$pageUid: latest page uid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesLibrary( $pageUid )
  {
    if( $this->pObj->markerArray['###INSTALL_CASE###'] != 'install_all' )
    {
      return $pageUid;
    }

    $arrResult  = $this->pagesLibraryRecords( $pageUid );
    $pages      = $arrResult['pages'];
    $pageUid    = $arrResult['pageUid'];
    unset( $arrResult );

    $this->pagesLibrarySqlInsert( $pages );

    return $pageUid;
  }

/**
 * pagesLibraryRecords( ) :
 *
 * @param	integer		$pageUid    : current page uid
 * @return	array		$arrReturn  : array with elements pages and pageUid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesLibraryRecords( $pageUid )
  {
    $pages = array( );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageLibraryHeader( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageLibraryFooter( $pageUid, $sorting );

    $arrReturn  = array
                  (
                    'pages'   => $pages,
                    'pageUid' => $pageUid
                  );

    return $arrReturn;
  }

/**
 * pagesLibrary( ) :
 *
 * @param	array		$pages: page records
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesLibrarySqlInsert( $pages )
  {
    foreach( $pages as $page )
    {
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'pages', $page );
      $this->pObj->markerArray['###TITLE###'] = $this->pObj->pi_getLL( 'page_title_library' ) . ' > ' . $page['title'];
      $this->pObj->markerArray['###UID###']   = $page['uid'];
      $prompt = '
        <p>
          '.$this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'page_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[ ] = $prompt;
    }

    unset($pages);
  }

/**
 * pagesRoot( ) :
 *
 * @param	integer		$pageUid: current page uid
 * @return	integer		$pageUid: latest page uid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesRoot( $pageUid )
  {
    $arrResult  = $this->pagesRootRecords( $pageUid );
    $pages      = $arrResult['pages'];
    $pageUid    = $arrResult['pageUid'];
    unset( $arrResult );

    $this->pagesRootSqlInsert( $pages );

    return $pageUid;
  }

/**
 * pagesRootRecords( ) :
 *
 * @param	integer		$pageUid    : current page uid
 * @return	array		$arrReturn  : array with elements pages and pageUid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesRootRecords( $pageUid )
  {
    $pages = array( );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageCaddy( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageDelivery( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageTerms( $pageUid, $sorting );

    if( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' )
    {
      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageLegalinfo( $pageUid, $sorting );

      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageLibrary( $pageUid, $sorting );
    }

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageProducts( $pageUid, $sorting );

    $arrReturn  = array
                  (
                    'pages'   => $pages,
                    'pageUid' => $pageUid
                  );

    return $arrReturn;
  }

/**
 * pagesRoot( ) :
 *
 * @param	array		$pages: page records
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesRootSqlInsert( $pages )
  {
    foreach( $pages as $page )
    {
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'pages', $page );
      $this->pObj->markerArray['###TITLE###'] = $page['title'];
      $this->pObj->markerArray['###UID###']   = $page['uid'];
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'page_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[] = $prompt;
    }

    unset($pages);
  }

  
  
 /***********************************************
  *
  * ZZ
  *
  **********************************************/

/**
 * zz_countPages( ) :
 *
 * @param	integer		$pageUid    : current page uid
 * @return	string          $csvResult  : pageUid, sorting
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function zz_countPages( $pageUid )
  {
    static $counter = 0;

    $counter  = $counter + 1 ;
    $pageUid  = $pageUid + 1 ;
    $sorting  = 256 * $counter;

    $csvResult = $pageUid . ',' . $sorting;

    return $csvResult;
  }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_pages.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_pages.php']);
}