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
 *   78: class tx_quickshopinstaller_pi1_quickshop
 *
 *              SECTION: Main
 *  102:     public function main( )
 *
 *              SECTION: Categories
 *  132:     private function categories( )
 *  161:     private function categoryBook( $uid )
 *  188:     private function categoryClothes( $uid )
 *  215:     private function categoryCup( $uid )
 *
 *              SECTION: Records
 *  250:     private function recordBasecapBlue( $uid )
 *  298:     private function recordBasecapGreen( $uid )
 *  346:     private function recordBasecapRed( $uid )
 *  394:     private function recordBook( $uid )
 *  442:     private function recordCup( $uid )
 *  490:     private function recordPullover( $uid )
 *  537:     private function records( )
 *
 *              SECTION: Relations
 *  586:     private function relationBasecapBlue( $sorting )
 *  606:     private function relationBasecapGreen( $sorting )
 *  626:     private function relationBasecapRed( $sorting )
 *  646:     private function relationBook( $sorting )
 *  666:     private function relationCup( $sorting )
 *  686:     private function relationPullover( $sorting )
 *  705:     private function relations( )
 *
 *              SECTION: Sql
 *  755:     private function sqlInsert( $records, $table )
 *
 *              SECTION: ZZ
 *  791:     private function zz_counter( $uid )
 *
 * TOTAL FUNCTIONS: 21
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
class tx_quickshopinstaller_pi1_quickshop
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_quickshop';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_quickshop.php';  // Path to this script relative to the extension dir.
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

    $records = $this->categories( );
    $this->sqlInsert( $records, 'tx_quickshop_categories' );

    $records = $this->records( );
    $this->sqlInsert( $records, 'tx_quickshop_products' );

    $records = $this->relations( );
    $this->sqlInsert( $records, 'tx_quickshop_products_category_mm' );
  }



 /***********************************************
  *
  * Categories
  *
  **********************************************/

/**
 * categories( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categories( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'tx_quickshop_categories' );

      // category book
    $uid = $uid + 1;
    $records[$uid] = $this->categoryBook( $uid );

      // category clothes
    $uid = $uid + 1;
    $records[$uid] = $this->categoryClothes( $uid );

      // category cup
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCup( $uid );

    return $records;
  }

/**
 * categoryBook( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryBook( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_cat_title_books';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }

/**
 * categoryClothes( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryClothes( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_cat_title_clothes';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }

/**
 * categoryCup( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCup( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_cat_title_cups';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }



 /***********************************************
  *
  * Records
  *
  **********************************************/

/**
 * recordBasecapBlue( )
 *
 * @param	integer		$uid      : uid of the current field
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordBasecapBlue( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_prod_title_capBlue';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_qs_prod_image_capBlue';
    $llImage = $this->pObj->pi_getLL( $llLabel );
    $llImage = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llLabel ] = $llImage;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['title']        = $llTitle;
    $record['sku']          = $this->pObj->pi_getLL('record_qs_prod_sku_capBlue');
    $record['short']        = $this->pObj->pi_getLL('record_qs_prod_short_capBlue');
    $record['description']  = $this->pObj->pi_getLL('record_qs_prod_description_capBlue');
    $record['category']     = 1;
    $record['price']        = $this->pObj->pi_getLL('record_qs_prod_price_capBlue');
    $record['tax']          = $this->pObj->pi_getLL('record_qs_prod_tax_capBlue');
    $record['in_stock']     = $this->pObj->pi_getLL('record_qs_prod_inStock_capBlue');
    $record['image']        = $llImage;
    $record['caption']      = $this->pObj->pi_getLL('record_qs_prod_caption_capBlue');
    $record['imageseo']     = $this->pObj->pi_getLL('record_qs_prod_caption_capBlue');
    $record['imagewidth']   = '600';
      // 0: above, center
    $record['imageorient']  = '0';
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordBasecapGreen( )
 *
 * @param	integer		$uid      : uid of the current field
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordBasecapGreen( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_prod_title_capGreen';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_qs_prod_image_capGreen';
    $llImage = $this->pObj->pi_getLL( $llLabel );
    $llImage = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llLabel ] = $llImage;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['title']        = $llTitle;
    $record['sku']          = $this->pObj->pi_getLL('record_qs_prod_sku_capGreen');
    $record['short']        = $this->pObj->pi_getLL('record_qs_prod_short_capGreen');
    $record['description']  = $this->pObj->pi_getLL('record_qs_prod_description_capGreen');
    $record['category']     = 1;
    $record['price']        = $this->pObj->pi_getLL('record_qs_prod_price_capGreen');
    $record['tax']          = $this->pObj->pi_getLL('record_qs_prod_tax_capGreen');
    $record['in_stock']     = $this->pObj->pi_getLL('record_qs_prod_inStock_capGreen');
    $record['image']        = $llImage;
    $record['caption']      = $this->pObj->pi_getLL('record_qs_prod_caption_capGreen');
    $record['imageseo']     = $this->pObj->pi_getLL('record_qs_prod_caption_capGreen');
    $record['imagewidth']   = '200';
      // 26: in text, left
    $record['imageorient']  = '26';
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordBasecapRed( )
 *
 * @param	integer		$uid      : uid of the current field
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordBasecapRed( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_prod_title_capRed';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_qs_prod_image_capRed';
    $llImage = $this->pObj->pi_getLL( $llLabel );
    $llImage = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llLabel ] = $llImage;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['title']        = $llTitle;
    $record['sku']          = $this->pObj->pi_getLL('record_qs_prod_sku_capRed');
    $record['short']        = $this->pObj->pi_getLL('record_qs_prod_short_capRed');
    $record['description']  = $this->pObj->pi_getLL('record_qs_prod_description_capRed');
    $record['category']     = 1;
    $record['price']        = $this->pObj->pi_getLL('record_qs_prod_price_capRed');
    $record['tax']          = $this->pObj->pi_getLL('record_qs_prod_tax_capRed');
    $record['in_stock']     = $this->pObj->pi_getLL('record_qs_prod_inStock_capRed');
    $record['image']        = $llImage;
    $record['caption']      = $this->pObj->pi_getLL('record_qs_prod_caption_capRed');
    $record['imageseo']     = $this->pObj->pi_getLL('record_qs_prod_caption_capRed');
    $record['imagewidth']   = '200';
      // 26: in text, left
    $record['imageorient']  = '26';
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordBook( )
 *
 * @param	integer		$uid      : uid of the current field
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordBook( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_prod_title_book';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_qs_prod_image_book';
    $llImage = $this->pObj->pi_getLL( $llLabel );
    $llImage = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llLabel ] = $llImage;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['title']        = $llTitle;
    $record['sku']          = $this->pObj->pi_getLL('record_qs_prod_sku_book');
    $record['short']        = $this->pObj->pi_getLL('record_qs_prod_short_book');
    $record['description']  = $this->pObj->pi_getLL('record_qs_prod_description_book');
    $record['category']     = 1;
    $record['price']        = $this->pObj->pi_getLL('record_qs_prod_price_book');
    $record['tax']          = $this->pObj->pi_getLL('record_qs_prod_tax_book');
    $record['in_stock']     = $this->pObj->pi_getLL('record_qs_prod_inStock_book');
    $record['image']        = $llImage;
    $record['caption']      = $this->pObj->pi_getLL('record_qs_prod_caption_book');
    $record['imageseo']     = $this->pObj->pi_getLL('record_qs_prod_caption_book');
    $record['imagewidth']   = '140';
      // 8: below, center
    $record['imageorient']  = '8';
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordCup( )
 *
 * @param	integer		$uid      : uid of the current field
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordCup( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_prod_title_cup';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_qs_prod_image_cup';
    $llImage = $this->pObj->pi_getLL( $llLabel );
    $llImage = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llLabel ] = $llImage;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['title']        = $llTitle;
    $record['sku']          = $this->pObj->pi_getLL('record_qs_prod_sku_cup');
    $record['short']        = $this->pObj->pi_getLL('record_qs_prod_short_cup');
    $record['description']  = $this->pObj->pi_getLL('record_qs_prod_description_cup');
    $record['category']     = 1;
    $record['price']        = $this->pObj->pi_getLL('record_qs_prod_price_cup');
    $record['tax']          = $this->pObj->pi_getLL('record_qs_prod_tax_cup');
    $record['in_stock']     = $this->pObj->pi_getLL('record_qs_prod_inStock_cup');
    $record['image']        = $llImage;
    $record['caption']      = $this->pObj->pi_getLL('record_qs_prod_caption_cup');
    $record['imageseo']     = $this->pObj->pi_getLL('record_qs_prod_caption_cup');
    $record['imagewidth']   = '200';
      // 26: in text, left
    $record['imageorient']  = '26';
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordPullover( )
 *
 * @param	integer		$uid      : uid of the current field
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordPullover( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_prod_title_pullover';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_qs_prod_image_pullover';
    $llImage = $this->pObj->pi_getLL( $llLabel );
    $llImage = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llLabel ] = $llImage;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'page_title_products' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['title']        = $llTitle;
    $record['sku']          = $this->pObj->pi_getLL('record_qs_prod_sku_pullover');
    $record['short']        = $this->pObj->pi_getLL('record_qs_prod_short_pullover');
    $record['description']  = $this->pObj->pi_getLL('record_qs_prod_description_pullover');
    $record['category']     = 1;
    $record['price']        = $this->pObj->pi_getLL('record_qs_prod_price_pullover');
    $record['tax']          = $this->pObj->pi_getLL('record_qs_prod_tax_pullover');
    $record['in_stock']     = $this->pObj->pi_getLL('record_qs_prod_inStock_pullover');
    $record['image']        = $llImage;
    $record['caption']      = $this->pObj->pi_getLL('record_qs_prod_caption_pullover');
    $record['imageseo']     = $this->pObj->pi_getLL('record_qs_prod_caption_pullover');
    $record['imagewidth']   = '200';
      // 17: in text, right
    $record['imageorient']  = '17';
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * records( )
 *
 * @return	array		$records : the records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function records( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'tx_quickshop_products' );

      // record book
    $uid = $uid + 1;
    $records[$uid] = $this->recordBook( $uid );

      // record basecap blue
    $uid = $uid + 1;
    $records[$uid] = $this->recordBasecapBlue( $uid );

      // record basecap green
    $uid = $uid + 1;
    $records[$uid] = $this->recordBasecapGreen( $uid );

      // record basecap red
    $uid = $uid + 1;
    $records[$uid] = $this->recordBasecapRed( $uid );

      // record cup
    $uid = $uid + 1;
    $records[$uid] = $this->recordCup( $uid );

      // record pullover
    $uid = $uid + 1;
    $records[$uid] = $this->recordPullover( $uid );

    return $records;
  }



 /***********************************************
  *
  * Relations
  *
  **********************************************/

/**
 * relationBasecapBlue( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapBlue( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capBlue' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBasecapGreen( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapGreen( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capGreen' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBasecapRed( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapRed( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capRed' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBook( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBook( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_book' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_books' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationCup( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCup( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_cup' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_cups' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationPullover( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationPullover( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_pullover' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relations( )
 *
 * @return	array		$records : the relation records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relations( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'tx_powermail_fields' );

      // record book
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBook( $sorting );

      // record basecap blue
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapBlue( $sorting );

      // record basecap green
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapGreen( $sorting );

      // record basecap red
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapRed( $sorting );

      // record cup
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationCup( $sorting );

      // record pullover
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationPullover( $sorting );

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
 * @param	[type]		$table: ...
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlInsert( $records, $table )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery( $table, $record ) );
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( $table, $record );
      $marker['###TITLE###']      = $record['title'];
      $marker['###TABLE###']      = $this->pObj->pi_getLL( $table );
      $marker['###TITLE_PID###']  = '"' . $this->pObj->arr_pageTitles[$record['pid']] .
                                    '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'record_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
    }
  }



 /***********************************************
  *
  * ZZ
  *
  **********************************************/

/**
 * zz_counter( ) :
 *
 * @param	integer		$uid        : current record uid
 * @return	string		$csvResult  : uid, sorting
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function zz_counter( $uid )
  {
    static $counter = 0;

    $counter  = $counter + 1 ;
    $uid      = $uid + 1 ;
    $sorting  = 256 * $counter;

    $csvResult = $uid . ',' . $sorting;

    return $csvResult;
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_quickshop.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_quickshop.php']);
}