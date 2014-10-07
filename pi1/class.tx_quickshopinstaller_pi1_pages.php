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
 *   71: class tx_quickshopinstaller_pi1_pages
 *
 *              SECTION: Main
 *   95:     public function main( )
 *
 *              SECTION: Create pages
 *  142:     private function pageQuickshopCaddy( $pageUid, $sorting )
 *  180:     private function pageQuickshopCaddyCaddymini( $pageUid, $sorting )
 *  220:     private function pageQuickshopDelivery( $pageUid, $sorting )
 *  257:     private function pageQuickshopLegalinfo( $pageUid, $sorting )
 *  294:     private function pageQuickshopLibrary( $pageUid, $sorting )
 *  345:     private function pageQuickshopLibraryFooter( $pageUid, $sorting )
 *  384:     private function pageQuickshopLibraryHeader( $pageUid, $sorting )
 *  423:     private function pageQuickshopItems( $pageUid, $sorting )
 *  519:     private function pageQuickshopRevocation( $pageUid, $sorting )
 *  557:     private function pageQuickshopTerms( $pageUid, $sorting )
 *  593:     private function pagesQuickshopLibrary( $pageUid )
 *  619:     private function pagesQuickshopLibraryRecords( $pageUid )
 *  647:     private function pagesQuickshopLibrarySqlInsert( $pages )
 *  674:     private function pagesQuickshop( $pageUid )
 *  695:     private function pagesQuickshopRecords( $pageUid )
 *
 *              SECTION: Sql
 *  752:     private function sqlInsert( $pages )
 *
 *              SECTION: ZZ
 *  803:     private function zz_countPages( $pageUid )
 *
 * TOTAL FUNCTIONS: 18
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
 * @return    void
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
    $pageTitle    = 'pageQuickshop_title';
      // 130723, dwildt, 1-
    //$llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;
      // Set the global vars for the root page

      // Get the latest uid from the pages table
    $pageUid = $this->pObj->zz_getMaxDbUid( 'pages' );

      // Create pages on the root level
    $pageUid = $this->pagesQuickshop( $pageUid );

      // Create pages within page library
    $pageUid = $this->pagesQuickshopLibrary( $pageUid );

    return;
  }



 /***********************************************
  *
  * Create pages
  *
  **********************************************/

/**
 * pageQuickshopCaddy( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopCaddy( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopCaddy_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopCaddyCaddymini( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopCaddyCaddymini( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopCaddyCaddymini_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageQuickshopCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

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
              'module'        => 'caddymini',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'nav_hide'      => 1
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopDelivery( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopDelivery( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopShipping_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLegalinfo( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopLegalinfo( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLegalinfo_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLibrary( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopLibrary( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLibrary_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLibraryFooter( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopLibraryFooter( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLibraryFooter_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageQuickshopLibrary_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLibraryHeader( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopLibraryHeader( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLibraryHeader_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageQuickshopLibrary_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLibraryHeaderLogo( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.1.0
 * @since 3.1.0
 */
  private function pageQuickshopLibraryHeaderLogo( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLibraryHeaderLogo_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageQuickshopLibraryHeader_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLibraryHeaderSlider( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.1.0
 * @since 3.1.0
 */
  private function pageQuickshopLibraryHeaderSlider( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLibraryHeaderSlider_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageQuickshopLibraryHeader_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLibraryMenu( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopLibraryMenu( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLibraryMenu_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageQuickshopLibrary_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopLibraryMenubelow( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.1.0
 * @since 3.1.0
 */
  private function pageQuickshopLibraryMenubelow( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopLibraryMenubelow_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageQuickshopLibrary_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopItems( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopItems( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopItems_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopRevocation( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopRevocation( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopRevocation_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopShop( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @param    string        $dateHumanReadable  : human readabel date
 * @return    array        $page               : current page record
 * @access private
 * @version 6.0.0
 * @since 6.0.0
 */
  private function pageQuickshopShop( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopShop_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pageQuickshopTerms( ) :
 *
 * @param    integer        $pageUid            : uid of the current page
 * @param    integer        $sorting            : sorting value
 * @param    string        $dateHumanReadable  : human readabel date
 * @return    array        $page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageQuickshopTerms( $pageUid, $sorting )
  {
    $pageTitle    = 'pageQuickshopTerms_title';
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

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ]   = $pageTitle;

    return $page;
  }

/**
 * pagesQuickshopLibrary( ) :
 *
 * @param    integer        $pageUid: current page uid
 * @return    integer        $pageUid: latest page uid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesQuickshopLibrary( $pageUid )
  {
    if( $this->pObj->markerArray['###INSTALL_CASE###'] != 'install_all' )
    {
      return $pageUid;
    }

    $arrResult  = $this->pagesQuickshopLibraryRecords( $pageUid );
    $pages      = $arrResult['pages'];
    $pageUid    = $arrResult['pageUid'];
    unset( $arrResult );

    $this->pagesQuickshopLibrarySqlInsert( $pages );

    return $pageUid;
  }

/**
 * pagesQuickshopLibraryRecords( ) :
 *
 * @param    integer        $pageUid    : current page uid
 * @return    array        $arrReturn  : array with elements pages and pageUid
 * @access private
 * @version 6.0.0
 * @since 1.0.0
 */
  private function pagesQuickshopLibraryRecords( $pageUid )
  {
    $pages = array( );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopLibraryFooter( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopLibraryHeader( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopLibraryHeaderLogo( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopLibraryHeaderSlider( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopLibraryMenu( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopLibraryMenubelow( $pageUid, $sorting );

    $arrReturn  = array
                  (
                    'pages'   => $pages,
                    'pageUid' => $pageUid
                  );

    return $arrReturn;
  }

/**
 * pagesQuickshopLibrary( ) :
 *
 * @param    array        $pages: page records
 * @return    void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesQuickshopLibrarySqlInsert( $pages )
  {
    foreach( $pages as $page )
    {
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'pages', $page );
      $marker['###TITLE###'] = $this->pObj->pi_getLL( 'pageQuickshopLibrary_title' ) . ' > ' . $page['title'];
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
 * pagesQuickshop( ) :
 *
 * @param    integer        $pageUid: current page uid
 * @return    integer        $pageUid: latest page uid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesQuickshop( $pageUid )
  {
    $arrResult  = $this->pagesQuickshopRecords( $pageUid );
    $pages      = $arrResult['pages'];
    $pageUid    = $arrResult['pageUid'];
    unset( $arrResult );

    $this->sqlInsert( $pages );

    return $pageUid;
  }

/**
 * pagesQuickshopRecords( ) :
 *
 * @param    integer        $pageUid    : current page uid
 * @return    array        $arrReturn  : array with elements pages and pageUid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pagesQuickshopRecords( $pageUid )
  {
    $pages = array( );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopShop( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopCaddy( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopCaddyCaddymini( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopDelivery( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopRevocation( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopTerms( $pageUid, $sorting );

    if( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' )
    {
      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageQuickshopLegalinfo( $pageUid, $sorting );

      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageQuickshopLibrary( $pageUid, $sorting );
    }

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageQuickshopItems( $pageUid, $sorting );

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
 * pagesQuickshop( ) :
 *
 * @param    array        $pages: page records
 * @return    void
 * @access private
 * @version 6.0.0
 * @since 1.0.0
 */
  private function sqlInsert( $pages )
  {
    foreach( $pages as $page )
    {
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'pages', $page );
      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( 'pages', $page );
        // #i0018, 141004, dwildt
        $prompt = '<div style="border:1em solid red;margin:1em;padding:2em;">' . PHP_EOL
                . 'SQL-ERROR<br />' . PHP_EOL
                . 'query: ' . $query . '.<br />' . PHP_EOL
                . 'error: ' . $error . '.<br />' . PHP_EOL
                . 'Sorry for the trouble.<br />' . PHP_EOL
                . 'TYPO3-Quick-Shop-Installer<br />' . PHP_EOL
                . __METHOD__ . ' (' . __LINE__ . ')' . PHP_EOL
                . '</div>' . PHP_EOL
                . '<div style="border:1em solid blue;margin:1em;padding:2em;">' . PHP_EOL
                . 'HELP<br />' . PHP_EOL
                . '1. Please save the installer plugin again. Probably the SQL error is solved.<br />' . PHP_EOL
                . '2. Reload this page.<br />' . PHP_EOL
                . '3. If error occurs again, please update your database. <br />' . PHP_EOL
                . '   See: System > Install > Import action > Database analyzer [Compare current databse with spezifications]<br />' . PHP_EOL
                . '4. Remove installed pages.<br />' . PHP_EOL
                . '5. Reload this page.' . PHP_EOL
                . '</div>' . PHP_EOL
        ;
        die( $prompt );
      }

        // prompt
      $marker['###TITLE###'] = $page['title'];
      $marker['###UID###']   = $page['uid'];
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'page_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[] = $prompt;
        // prompt
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
 * @param    integer        $pageUid    : current page uid
 * @return    string        $csvResult  : pageUid, sorting
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