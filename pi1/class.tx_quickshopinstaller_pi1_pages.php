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
 *   69: class tx_quickshopinstaller_pi1_pages
 *
 *              SECTION: Main
 *   93:     public function main( )
 *
 *              SECTION: Create pages
 *  140:     private function pageCaddy( $pageUid, $sorting )
 *  178:     private function pageDelivery( $pageUid, $sorting )
 *  215:     private function pageLegalinfo( $pageUid, $sorting )
 *  252:     private function pageLibrary( $pageUid, $sorting )
 *  303:     private function pageLibraryFooter( $pageUid, $sorting )
 *  343:     private function pageLibraryHeader( $pageUid, $sorting )
 *  383:     private function pageProducts( $pageUid, $sorting )
 *  480:     private function pageTerms( $pageUid, $sorting )
 *  516:     private function pagesLibrary( $pageUid )
 *  542:     private function pagesLibraryRecords( $pageUid )
 *  570:     private function pagesLibrarySqlInsert( $pages )
 *  597:     private function pagesRoot( $pageUid )
 *  618:     private function pagesRootRecords( $pageUid )
 *
 *              SECTION: Sql
 *  669:     private function sqlInsert( $pages )
 *
 *              SECTION: ZZ
 *  704:     private function zz_countPages( $pageUid )
 *
 * TOTAL FUNCTIONS: 16
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
class tx_quickshopinstaller_pi1_pages
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_pages';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_pages.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'quickshop_installer';                      // The extension key.

  public $pObj = null;



 /***********************************************
  *
  * Main
  *
  **********************************************/

/**
 * main( ) :
 *
 * @return	void
 * @access public
 * @version 3.0.0
 * @since 1.0.0
 */
  public function main( )
  {
      // Prompt header
    $this->pObj->arrReport[ ] = '
      <h2>
       '.$this->pObj->pi_getLL('page_create_header').'
      </h2>';
      // Prompt header

      // Set the global vars for the root page
    $pageUid      = $GLOBALS['TSFE']->id;
    $pageTitle    = 'page_title_root';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $this->pObj->arr_pageUids[ $llPageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $llPageTitle;
      // Set the global vars for the root page

      // Get the latest uid from the püages table
    $pageUid = $this->pObj->zz_getMaxDbUid( 'pages' );

      // Create pages on the root level
    $pageUid = $this->pagesRoot( $pageUid );

      // Create pages within page library
    $pageUid = $this->pagesLibrary( $pageUid );

    return;
  }



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
    $pageTitle    = 'page_title_caddy';
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
              'module'        => 'caddy',
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
      $marker['###TITLE###'] = $this->pObj->pi_getLL( 'page_title_library' ) . ' > ' . $page['title'];
      $marker['###UID###']   = $page['uid'];
      $prompt = '
        <p>
          '.$this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'page_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
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

    $this->sqlInsert( $pages );

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



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * pagesRoot( ) :
 *
 * @param	array		$pages: page records
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function sqlInsert( $pages )
  {
    foreach( $pages as $page )
    {
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'pages', $page );
      $marker['###TITLE###'] = $page['title'];
      $marker['###UID###']   = $page['uid'];
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'page_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
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
 * @return	string		$csvResult  : pageUid, sorting
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