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
 *   61: class tx_quickshopinstaller_pi1_content
 *
 *              SECTION: Main
 *   85:     public function main( )
 *
 *              SECTION: Records
 *  115:     private function pageQuickshopCaddy( $uid )
 *  145:     private function pageQuickshopDelivery( $uid )
 *  175:     private function pageQuickshopLibraryFooter( $uid )
 *  206:     private function pageQuickshopLibraryHeader( $uid )
 *  242:     private function pageQuickshopLegalinfo( $uid )
 *  272:     private function pageQuickshopRevocation( $uid )
 *  302:     private function pageQuickshopTerms( $uid )
 *  331:     private function pages( )
 *
 *              SECTION: Sql
 *  389:     private function sqlInsert( $records )
 *
 * TOTAL FUNCTIONS: 10
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
class tx_quickshopinstaller_pi1_content
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_content';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_content.php';  // Path to this script relative to the extension dir.
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
       ' . $this->pObj->pi_getLL( 'content_create_header' ) . '
      </h2>';

    $records = $this->pages( );
    $this->sqlInsert( $records );
  }



 /***********************************************
  *
  * Records
  *
  **********************************************/

/**
 * pageQuickshopCaddy( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function pageQuickshopCaddy( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_caddy_header' );
    $this->pObj->arr_contentUids['content_caddy_header'] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'html';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_caddy_bodytext');
    $record['sectionIndex'] = 0;

    return $record;
  }

/**
 * pageQuickshopDelivery( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopDelivery( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageQuickshopShipping_header' );
    $this->pObj->arr_contentUids['content_pageQuickshopShipping_header'] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageQuickshopShipping_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageQuickshopShipping_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryFooter( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryFooter( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageQuickshopLibraryFooter_header' );
    $this->pObj->arr_contentUids['content_pageQuickshopLibraryFooter_header']  = $uid;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryFooter_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 1;
    $record['CType']          = 'text';
    $record['header']         = $llHeader;
    $record['header_layout']  = 100; // hidden
    $record['bodytext']       = $this->pObj->pi_getLL('content_pageQuickshopLibraryFooter_bodytext');
    $record['sectionIndex']   = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryHeader( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryHeader( $uid )
  {
    $record = null;

      // Content for page header
    $pid      = $GLOBALS['TSFE']->id;
    $bodytext = $this->pObj->pi_getLL('content_pageQuickshopLibraryHeader_bodytext');
    $bodytext = str_replace('###PID###', $pid, $bodytext);

    $llHeader = $this->pObj->pi_getLL( 'content_pageQuickshopLibraryHeader_header' );
    $this->pObj->arr_contentUids['content_pageQuickshopLibraryHeader_header']  = $uid;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeader_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 1;
    $record['CType']          = 'text';
    $record['header']         = $llHeader;
    $record['header_layout']  = 100; // hidden
    $record['bodytext']       = $bodytext;
    $record['sectionIndex']   = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryHeaderLogo( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryHeaderLogo( $uid )
  {
    $record = null;

    $llLabel  = 'content_pageQuickshopLibraryHeaderLogo_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_contentUids[ $llLabel ] = $uid;

    $llLabel  = 'content_pageQuickshopLibraryHeaderLogo_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;
var_dump( __METHOD__, __LINE__, $this->pObj->arr_fileUids );

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderLogo_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 1;
    $record['CType']          = 'image';
    $record['header']         = $llTitle;
    $record['header_layout']  = 100; // hidden
    $record['image']          = $llImageWiTimestamp;
      // Will done by consolidation
    //$record['image_link']     = null;
    $record['imageorient']    = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryHeaderSlider01( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryHeaderSlider01( $uid )
  {
    $record = null;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider01_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_contentUids[ $llLabel ] = $uid;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider01_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderSlider_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 5;
    $record['CType']          = 'image';
    $record['header']         = $llTitle;
    $record['header_layout']  = 100; // hidden
    $record['image']          = $llImageWiTimestamp;
    $record['image_link']     = $this->pObj->pi_getLL( 'content_pageQuickshopLibraryHeaderSlider01_image_link' );
      // #i0002, 13-07-30, dwildt, 1+
    $record['image_zoom']     = 1;
    $record['imageorient']    = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryHeaderSlider02( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryHeaderSlider02( $uid )
  {
    $record = null;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider02_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_contentUids[ $llLabel ] = $uid;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider02_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderSlider_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 4;
    $record['CType']          = 'image';
    $record['header']         = $llTitle;
    $record['header_layout']  = 100; // hidden
    $record['image']          = $llImageWiTimestamp;
    $record['image_link']     = $this->pObj->pi_getLL( 'content_pageQuickshopLibraryHeaderSlider02_image_link' );
      // #i0002, 13-07-30, dwildt, 1+
    $record['image_zoom']     = 1;
    $record['imageorient']    = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryHeaderSlider03( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryHeaderSlider03( $uid )
  {
    $record = null;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider03_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_contentUids[ $llLabel ] = $uid;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider03_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderSlider_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 3;
    $record['CType']          = 'image';
    $record['header']         = $llTitle;
    $record['header_layout']  = 100; // hidden
    $record['image']          = $llImageWiTimestamp;
    $record['image_link']     = $this->pObj->pi_getLL( 'content_pageQuickshopLibraryHeaderSlider03_image_link' );
      // #i0002, 13-07-30, dwildt, 1+
    $record['image_zoom']     = 1;
    $record['imageorient']    = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryHeaderSlider04( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryHeaderSlider04( $uid )
  {
    $record = null;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider04_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_contentUids[ $llLabel ] = $uid;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider04_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderSlider_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 2;
    $record['CType']          = 'image';
    $record['header']         = $llTitle;
    $record['header_layout']  = 100; // hidden
    $record['image']          = $llImageWiTimestamp;
    $record['image_link']     = $this->pObj->pi_getLL( 'content_pageQuickshopLibraryHeaderSlider04_image_link' );
      // #i0002, 13-07-30, dwildt, 1+
    $record['image_zoom']     = 1;
    $record['imageorient']    = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryHeaderSlider05( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryHeaderSlider05( $uid )
  {
    $record = null;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider05_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_contentUids[ $llLabel ] = $uid;

    $llLabel  = 'content_pageQuickshopLibraryHeaderSlider05_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryHeaderSlider_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 1;
    $record['CType']          = 'image';
    $record['header']         = $llTitle;
    $record['header_layout']  = 100; // hidden
    $record['image']          = $llImageWiTimestamp;
    $record['image_link']     = $this->pObj->pi_getLL( 'content_pageQuickshopLibraryHeaderSlider05_image_link' );
      // #i0002, 13-07-30, dwildt, 1+
    $record['image_zoom']     = 1;
    $record['imageorient']    = 1;

    return $record;
  }

/**
 * pageQuickshopLibraryMenubelow( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLibraryMenubelow( $uid )
  {
    $record = null;

    $llLabel  = 'content_pageQuickshopLibraryMenubelow_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_contentUids[ $llLabel ] = $uid;

    $llLabel  = 'content_pageQuickshopLibraryMenubelow_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryMenubelow_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 1;
    $record['CType']          = 'image';
    $record['header']         = $llTitle;
    $record['header_layout']  = 100; // hidden
    $record['image']          = $llImageWiTimestamp;
    $record['image_link']     = $this->pObj->arr_pageUids[ 'pageQuickshopLibraryMenubelow_image_link' ];
      // #i0002, 13-07-30, dwildt, 1+
    $record['image_zoom']     = 1;
    $record['imageorient']    = 2;  // 2: left
    $record['spaceBefore']    = 60; // 2: left

    return $record;
  }

/**
 * pageQuickshopLegalinfo( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopLegalinfo( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageQuickshopLegalinfo_header' );
    $this->pObj->arr_contentUids['content_pageQuickshopLegalinfo_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageQuickshopLegalinfo_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageQuickshopLegalinfo_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageQuickshopRevocation( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopRevocation( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageQuickshopRevocation_header' );
    $this->pObj->arr_contentUids['content_pageQuickshopRevocation_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageQuickshopRevocation_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageQuickshopRevocation_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageQuickshopTerms( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageQuickshopTerms( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageQuickshopTerms_header' );
    $this->pObj->arr_contentUids['content_pageQuickshopTerms_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageQuickshopTerms_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageQuickshopTerms_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pages( )
 *
 * @return	array		$records : the plugin records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pages( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'tt_content' );

      // content for page delivery
    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopCaddy( $uid );

      // content for page delivery
    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopDelivery( $uid );

      // content for page revocation
    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopRevocation( $uid );

      // content for page terms
    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopTerms( $uid );

    if( $this->pObj->markerArray['###INSTALL_CASE###'] != 'install_all')
    {
      return $records;
    }

      // content for page legal
    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLegalinfo( $uid );

      // content for page library header
    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryHeader( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryHeaderLogo( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryHeaderSlider01( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryHeaderSlider02( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryHeaderSlider03( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryHeaderSlider04( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryHeaderSlider05( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryMenubelow( $uid );

      // content for page library footer
    $uid = $uid + 1;
    $records[$uid] = $this->pageQuickshopLibraryFooter( $uid );

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
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'content_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
        // prompt
    }
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_content.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_content.php']);
}