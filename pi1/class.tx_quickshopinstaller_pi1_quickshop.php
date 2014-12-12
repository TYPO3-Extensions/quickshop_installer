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
 *   84: class tx_quickshopinstaller_pi1_quickshop
 *
 *              SECTION: Main
 *  108:     public function main( )
 *
 *              SECTION: Categories
 *  138:     private function categories( )
 *  179:     private function categoryBlue( $uid )
 *  207:     private function categoryBook( $uid )
 *  234:     private function categoryClothes( $uid )
 *  261:     private function categoryCup( $uid )
 *  288:     private function categoryGreen( $uid )
 *  316:     private function categoryRed( $uid )
 *
 *              SECTION: Records
 *  352:     private function recordBasecapBlue( $uid )
 *  400:     private function recordBasecapGreen( $uid )
 *  448:     private function recordBasecapRed( $uid )
 *  496:     private function recordBook( $uid )
 *  546:     private function recordCup( $uid )
 *  596:     private function recordPullover( $uid )
 *  643:     private function records( )
 *
 *              SECTION: Relations
 *  692:     private function relationBasecapBlueBlue( $sorting )
 *  712:     private function relationBasecapBlueClothes( $sorting )
 *  732:     private function relationBasecapGreenClothes( $sorting )
 *  752:     private function relationBasecapGreenGreen( $sorting )
 *  772:     private function relationBasecapRedClothes( $sorting )
 *  792:     private function relationBasecapRedRed( $sorting )
 *  812:     private function relationBook( $sorting )
 *  832:     private function relationCup( $sorting )
 *  852:     private function relationPullover( $sorting )
 *  871:     private function relations( )
 *
 *              SECTION: Sql
 *  927:     private function sqlInsert( $records, $table )
 *
 *              SECTION: ZZ
 *  987:     private function zz_counter( $uid )
 *
 * TOTAL FUNCTIONS: 27
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
class tx_quickshopinstaller_pi1_quickshop
{

  public $prefixId = 'tx_quickshopinstaller_pi1_quickshop';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_quickshop.php';  // Path to this script relative to the extension dir.
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
   * @since   0.0.1
   */
  public function main()
  {
    $records = array();

    $records = $this->categories();
    $this->sqlInsert( $records, 'tx_quickshop_categories' );

    $records = $this->records();
    $this->sqlInsert( $records, 'tx_quickshop_products' );

    $records = $this->relations();
    // #62036, 141004, dwildt, 1-
    //$this->sqlInsert( $records, 'tx_quickshop_products_category_mm' );
    // #62036, 141004, dwildt, 1+
    $this->sqlInsert( $records, 'tx_quickshop_mm' );
  }

  /*   * *********************************************
   *
   * Categories
   *
   * ******************************************** */

  /**
   * categories( )
   *
   * @return	array		$records : the fieldset records
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function categories()
  {
    $records = array();
    $uid = $this->pObj->zz_getMaxDbUid( 'tx_quickshop_categories' );

    // category book
    $uid = $uid + 1;
    $records[ $uid ] = $this->categoryBook( $uid );

    // category clothes
    $uid = $uid + 1;
    $records[ $uid ] = $this->categoryClothes( $uid );

    // category cup
    $uid = $uid + 1;
    $records[ $uid ] = $this->categoryCup( $uid );

    // category blue - depends on clothes
    $uid = $uid + 1;
    $records[ $uid ] = $this->categoryBlue( $uid );

    // category green - depends on clothes
    $uid = $uid + 1;
    $records[ $uid ] = $this->categoryGreen( $uid );

    // category red - depends on clothes
    $uid = $uid + 1;
    $records[ $uid ] = $this->categoryRed( $uid );

    return $records;
  }

  /**
   * categoryBlue( )
   *
   * @param	integer		$uid      : uid of the current fieldset
   * @return	array		$record   : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function categoryBlue( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_cat_title_blue';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'uid_parent' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];

    return $record;
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

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;

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

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;

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

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;

    return $record;
  }

  /**
   * categoryGreen( )
   *
   * @param	integer		$uid      : uid of the current fieldset
   * @return	array		$record   : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function categoryGreen( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_cat_title_green';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'uid_parent' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];

    return $record;
  }

  /**
   * categoryRed( )
   *
   * @param	integer		$uid      : uid of the current fieldset
   * @return	array		$record   : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function categoryRed( $uid )
  {
    $record = null;

    $llLabel = 'record_qs_cat_title_red';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'uid_parent' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];

    return $record;
  }

  /*   * *********************************************
   *
   * Records
   *
   * ******************************************** */

  /**
   * recordBasecapBlue( )
   *
   * @param	integer		$uid      : uid of the current field
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
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
    $llImageWiTimestamp = str_replace( 'timestamp', time(), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'sku' ] = $this->pObj->pi_getLL( 'record_qs_prod_sku_capBlue' );
    $record[ 'short' ] = $this->pObj->pi_getLL( 'record_qs_prod_short_capBlue' );
    $record[ 'description' ] = $this->pObj->pi_getLL( 'record_qs_prod_description_capBlue' );
    $record[ 'category' ] = 1;
    $record[ 'price' ] = $this->pObj->pi_getLL( 'record_qs_prod_price_capBlue' );
    $record[ 'tax' ] = $this->pObj->pi_getLL( 'record_qs_prod_tax_capBlue' );
    $record[ 'stockquantity' ] = $this->pObj->pi_getLL( 'record_qs_prod_stockquantity_capBlue' );
    $record[ 'image' ] = $llImageWiTimestamp;
    $record[ 'caption' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_capBlue' );
    $record[ 'imageseo' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_capBlue' );
    $record[ 'imagewidth' ] = '600';
    // 0: above, center
    $record[ 'imageorient' ] = '0';
    $record[ 'imagecols' ] = '1';
    $record[ 'image_zoom' ] = '1';
    $record[ 'image_noRows' ] = '1';
    $record[ 'teaser_title' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_title_capBlue' );
    $record[ 'teaser_short' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_short_capBlue' );

    return $record;
  }

  /**
   * recordBasecapGreen( )
   *
   * @param	integer		$uid      : uid of the current field
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
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
    $llImageWiTimestamp = str_replace( 'timestamp', time(), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'sku' ] = $this->pObj->pi_getLL( 'record_qs_prod_sku_capGreen' );
    $record[ 'short' ] = $this->pObj->pi_getLL( 'record_qs_prod_short_capGreen' );
    $record[ 'description' ] = $this->pObj->pi_getLL( 'record_qs_prod_description_capGreen' );
    $record[ 'category' ] = 1;
    $record[ 'price' ] = $this->pObj->pi_getLL( 'record_qs_prod_price_capGreen' );
    $record[ 'tax' ] = $this->pObj->pi_getLL( 'record_qs_prod_tax_capGreen' );
    $record[ 'stockquantity' ] = $this->pObj->pi_getLL( 'record_qs_prod_stockquantity_capGreen' );
    $record[ 'image' ] = $llImageWiTimestamp;
    $record[ 'caption' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_capGreen' );
    $record[ 'imageseo' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_capGreen' );
    $record[ 'imagewidth' ] = '200';
    // 26: in text, left
    $record[ 'imageorient' ] = '26';
    $record[ 'imagecols' ] = '1';
    $record[ 'image_zoom' ] = '1';
    $record[ 'image_noRows' ] = '1';
    $record[ 'teaser_title' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_title_capGreen' );
    $record[ 'teaser_short' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_short_capGreen' );

    return $record;
  }

  /**
   * recordBasecapRed( )
   *
   * @param	integer		$uid      : uid of the current field
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
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
    $llImageWiTimestamp = str_replace( 'timestamp', time(), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'sku' ] = $this->pObj->pi_getLL( 'record_qs_prod_sku_capRed' );
    $record[ 'short' ] = $this->pObj->pi_getLL( 'record_qs_prod_short_capRed' );
    $record[ 'description' ] = $this->pObj->pi_getLL( 'record_qs_prod_description_capRed' );
    $record[ 'category' ] = 1;
    $record[ 'price' ] = $this->pObj->pi_getLL( 'record_qs_prod_price_capRed' );
    $record[ 'tax' ] = $this->pObj->pi_getLL( 'record_qs_prod_tax_capRed' );
    $record[ 'stockquantity' ] = $this->pObj->pi_getLL( 'record_qs_prod_stockquantity_capRed' );
    $record[ 'image' ] = $llImageWiTimestamp;
    $record[ 'caption' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_capRed' );
    $record[ 'imageseo' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_capRed' );
    $record[ 'imagewidth' ] = '200';
    // 26: in text, left
    $record[ 'imageorient' ] = '26';
    $record[ 'imagecols' ] = '1';
    $record[ 'image_zoom' ] = '1';
    $record[ 'image_noRows' ] = '1';
    $record[ 'teaser_title' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_title_capRed' );
    $record[ 'teaser_short' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_short_capRed' );

    return $record;
  }

  /**
   * recordBook( )
   *
   * @param	integer		$uid      : uid of the current field
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
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
    $llImageWiTimestamp = str_replace( 'timestamp', time(), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'sku' ] = $this->pObj->pi_getLL( 'record_qs_prod_sku_book' );
    $record[ 'short' ] = $this->pObj->pi_getLL( 'record_qs_prod_short_book' );
    $record[ 'description' ] = $this->pObj->pi_getLL( 'record_qs_prod_description_book' );
    $record[ 'category' ] = 1;
    $record[ 'price' ] = $this->pObj->pi_getLL( 'record_qs_prod_price_book' );
    $record[ 'tax' ] = $this->pObj->pi_getLL( 'record_qs_prod_tax_book' );
    $record[ 'stockquantity' ] = $this->pObj->pi_getLL( 'record_qs_prod_stockquantity_book' );
    $record[ 'image' ] = $llImageWiTimestamp;
    $record[ 'caption' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_book' );
    $record[ 'imageseo' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_book' );
    $record[ 'imagewidth' ] = '140';
    // 8: below, center
    $record[ 'imageorient' ] = '8';
    $record[ 'imagecols' ] = '1';
    $record[ 'image_zoom' ] = '1';
    $record[ 'image_noRows' ] = '1';
    $record[ 'quantity_min' ] = '0';
    $record[ 'quantity_max' ] = '3';
    $record[ 'teaser_title' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_title_book' );
    $record[ 'teaser_short' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_short_book' );

    return $record;
  }

  /**
   * recordCup( )
   *
   * @param	integer		$uid      : uid of the current field
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
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
    $llImageWiTimestamp = str_replace( 'timestamp', time(), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'sku' ] = $this->pObj->pi_getLL( 'record_qs_prod_sku_cup' );
    $record[ 'short' ] = $this->pObj->pi_getLL( 'record_qs_prod_short_cup' );
    $record[ 'description' ] = $this->pObj->pi_getLL( 'record_qs_prod_description_cup' );
    $record[ 'category' ] = 1;
    $record[ 'price' ] = $this->pObj->pi_getLL( 'record_qs_prod_price_cup' );
    $record[ 'tax' ] = $this->pObj->pi_getLL( 'record_qs_prod_tax_cup' );
    $record[ 'stockquantity' ] = $this->pObj->pi_getLL( 'record_qs_prod_stockquantity_cup' );
    $record[ 'image' ] = $llImageWiTimestamp;
    $record[ 'caption' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_cup' );
    $record[ 'imageseo' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_cup' );
    $record[ 'imagewidth' ] = '200';
    // 26: in text, left
    $record[ 'imageorient' ] = '26';
    $record[ 'imagecols' ] = '1';
    $record[ 'image_zoom' ] = '1';
    $record[ 'image_noRows' ] = '1';
    $record[ 'quantity_min' ] = '2';
    $record[ 'quantity_max' ] = '0';
    $record[ 'teaser_title' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_title_cup' );
    $record[ 'teaser_short' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_short_cup' );

    return $record;
  }

  /**
   * recordPullover( )
   *
   * @param	integer		$uid      : uid of the current field
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
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
    $llImageWiTimestamp = str_replace( 'timestamp', time(), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageQuickshopItems_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'title' ] = $llTitle;
    $record[ 'sku' ] = $this->pObj->pi_getLL( 'record_qs_prod_sku_pullover' );
    $record[ 'short' ] = $this->pObj->pi_getLL( 'record_qs_prod_short_pullover' );
    $record[ 'description' ] = $this->pObj->pi_getLL( 'record_qs_prod_description_pullover' );
    $record[ 'category' ] = 1;
    $record[ 'price' ] = $this->pObj->pi_getLL( 'record_qs_prod_price_pullover' );
    $record[ 'tax' ] = $this->pObj->pi_getLL( 'record_qs_prod_tax_pullover' );
    $record[ 'stockquantity' ] = $this->pObj->pi_getLL( 'record_qs_prod_stockquantity_pullover' );
    $record[ 'image' ] = $llImageWiTimestamp;
    $record[ 'caption' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_pullover' );
    $record[ 'imageseo' ] = $this->pObj->pi_getLL( 'record_qs_prod_caption_pullover' );
    $record[ 'imagewidth' ] = '200';
    // 17: in text, right
    $record[ 'imageorient' ] = '17';
    $record[ 'imagecols' ] = '1';
    $record[ 'image_zoom' ] = '1';
    $record[ 'image_noRows' ] = '1';
    $record[ 'teaser_title' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_title_pullover' );
    $record[ 'teaser_short' ] = $this->pObj->pi_getLL( 'record_qs_prod_teaser_short_pullover' );

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
  private function records()
  {
    $records = array();
    $uid = $this->pObj->zz_getMaxDbUid( 'tx_quickshop_products' );

    // record book
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordBook( $uid );

    // record basecap blue
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordBasecapBlue( $uid );

    // record basecap green
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordBasecapGreen( $uid );

    // record basecap red
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordBasecapRed( $uid );

    // record cup
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordCup( $uid );

    // record pullover
    $uid = $uid + 1;
    $records[ $uid ] = $this->recordPullover( $uid );

    return $records;
  }

  /*   * *********************************************
   *
   * Relations
   *
   * ******************************************** */

  /**
   * relationBasecapBlueBlue( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationBasecapBlueBlue( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capBlue' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_blue' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationBasecapBlueClothes( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationBasecapBlueClothes( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capBlue' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationBasecapGreenClothes( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationBasecapGreenClothes( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capGreen' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationBasecapGreenGreen( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationBasecapGreenGreen( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capGreen' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_green' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationBasecapRedClothes( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationBasecapRedClothes( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capRed' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationBasecapRedRed( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationBasecapRedRed( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capRed' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_red' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationBook( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationBook( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_book' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_books' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationCup( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationCup( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_cup' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_cups' ];
    $record[ 'sorting' ] = $sorting;

    return $record;
  }

  /**
   * relationPullover( )
   *
   * @param	integer		$sorting  : sorting value
   * @return	array		$record   : the field record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function relationPullover( $sorting )
  {
    $record = null;

    $record[ 'table_local' ] = 'tx_quickshop_products';
    $record[ 'table_foreign' ] = 'tx_quickshop_categories';
    $record[ 'uid_local' ] = $this->pObj->arr_recordUids[ 'record_qs_prod_title_pullover' ];
    $record[ 'uid_foreign' ] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record[ 'sorting' ] = $sorting;

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
  private function relations()
  {
    $records = array();
    $uid = $this->pObj->zz_getMaxDbUid( 'tx_powermail_fields' );

    // record book
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationBook( $sorting );

    // record basecap blue
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationBasecapBlueClothes( $sorting );
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationBasecapBlueBlue( $sorting );

    // record basecap green
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationBasecapGreenClothes( $sorting );
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationBasecapGreenGreen( $sorting );

    // record basecap red
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationBasecapRedClothes( $sorting );
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationBasecapRedRed( $sorting );

    // record cup
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationCup( $sorting );

    // record pullover
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[ $uid ] = $this->relationPullover( $sorting );

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
   * @param	[type]		$table: ...
   * @return	void
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function sqlInsert( $records, $table )
  {
    foreach ( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery( $table, $record ) );
      $GLOBALS[ 'TYPO3_DB' ]->exec_INSERTquery( $table, $record );
      $error = $GLOBALS[ 'TYPO3_DB' ]->sql_error();

      if ( $error )
      {
        $query = $GLOBALS[ 'TYPO3_DB' ]->INSERTquery( $table, $record );
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
                . '   See: System > Install > Import action > Database analyzer [Compare current database with spezifications]<br />' . PHP_EOL
                . '4. Remove installed pages.<br />' . PHP_EOL
                . '5. Reload this page.' . PHP_EOL
                . '</div>' . PHP_EOL
        ;
        die( $prompt );
      }

      // CONTINUE : pid is empty, no prompt
      if ( empty( $record[ 'pid' ] ) )
      {
        continue;
      }
      // CONTINUE : pid is empty, no prompt
      // prompt
      $pageTitle = $this->pObj->arr_pageTitles[ $record[ 'pid' ] ];
      $pageTitle = $this->pObj->pi_getLL( $pageTitle );
      $marker[ '###TITLE###' ] = $record[ 'title' ];
      $marker[ '###TABLE###' ] = $this->pObj->pi_getLL( $table );
      $marker[ '###TITLE_PID###' ] = '"' . $pageTitle . '" (uid ' . $record[ 'pid' ] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons[ 'ok' ] . ' ' . $this->pObj->pi_getLL( 'record_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[] = $prompt;
      // prompt
    }
  }

  /*   * *********************************************
   *
   * ZZ
   *
   * ******************************************** */

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

    $counter = $counter + 1;
    $uid = $uid + 1;
    $sorting = 256 * $counter;

    $csvResult = $uid . ',' . $sorting;

    return $csvResult;
  }

}

if ( defined( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_quickshop.php' ] )
{
  include_once($TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_quickshop.php' ]);
}