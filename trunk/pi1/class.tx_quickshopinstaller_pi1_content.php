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
 *   58: class tx_quickshopinstaller_pi1_content
 *
 *              SECTION: Main
 *   82:     public function main( )
 *
 *              SECTION: Records
 *  112:     private function pageDelivery( $uid )
 *  142:     private function pageLibraryFooter( $uid )
 *  172:     private function pageLibraryHeader( $uid )
 *  207:     private function pageTerms( $uid )
 *  236:     private function pages( )
 *
 *              SECTION: Sql
 *  282:     private function sqlInsert( $records )
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
 * pageDelivery( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageDelivery( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_shipping_header' );
    $this->pObj->arr_contentUids['content_shipping_header'] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_shipping' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_shipping_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageLibraryFooter( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageLibraryFooter( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_footer_header' );
    $this->pObj->arr_contentUids['content_footer_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_library_footer' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_footer_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageLibraryHeader( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageLibraryHeader( $uid )
  {
    $record = null;

      // Content for page header
    $pid      = $GLOBALS['TSFE']->id;
    $bodytext = $this->pObj->pi_getLL('content_header_bodytext');
    $bodytext = str_replace('###PID###', $pid, $bodytext);

    $llHeader = $this->pObj->pi_getLL( 'content_header_header' );
    $this->pObj->arr_contentUids['content_header_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_library_header' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $bodytext;
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageTerms( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageTerms( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_terms_header' );
    $this->pObj->arr_contentUids['content_terms_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_terms' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_terms_bodytext');
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
    $records[$uid] = $this->pageDelivery( $uid );

      // content for page terms
    $uid = $uid + 1;
    $records[$uid] = $this->pageTerms( $uid );

    if( $this->pObj->markerArray['###INSTALL_CASE###'] != 'install_all')
    {
      return $records;
    }

      // content for page library header
    $uid = $uid + 1;
    $records[$uid] = $this->pageLibraryHeader( $uid );

      // content for page library footer
    $uid = $uid + 1;
    $records[$uid] = $this->pageLibraryFooter( $uid );

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
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'content_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
    }
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_content.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_content.php']);
}