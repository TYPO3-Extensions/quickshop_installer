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
class tx_quickshopinstaller_pi1_consolidation
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_consolidation';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_consolidation.php';  // Path to this script relative to the extension dir.
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
    $this->pObj->arrReport[] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'consolidate_header' ) . '
      </h2>';

    $this->pageRoot( );
    $this->pageCaddy( );
  }



 /***********************************************
  *
  * pages
  *
  **********************************************/

/**
 * pageCaddy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageCaddy( )
  {
    $records    = array( );
    $pageTitle  = $this->pObj->pi_getLL( 'page_title_caddy' );

      // Update the powermail plugin
    $records    = $this->pageCaddyPluginPowermail( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the wt_cart plugin
    $records    = $this->pageCaddyPluginWtcart( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

  }

/**
 * pageCaddyPluginPowermail( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageCaddyPluginPowermail( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'plugin_powermail_header' ];

      // values
    $llHeader       = $this->pObj->pi_getLL( 'plugin_powermail_header' );
    $uidEmail       = $this->pObj->arr_recordUids[ 'record_pm_field_title_email' ];
    $customerEmail  = ' uid' . $uidEmail;
    $uidFirstname   = $this->pObj->arr_recordUids[ 'record_pm_field_title_firstnameBilling' ];
    $uidSurname     = $this->pObj->arr_recordUids[ 'record_pm_field_title_surnameBilling' ];
    $customerName = 'uid' . $uidFirstname . ',uid' . $uidSurname;
      // values
    
    $records[$uid]['header']                  = $llHeader;
    $records[$uid]['tx_powermail_sender']     = $customerEmail;
    $records[$uid]['tx_powermail_sendername'] = $customerName;

    return $records;
  }

/**
 * pageCaddyPluginWtcart( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageCaddyPluginWtcart( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_tsUids[ $this->pObj->str_tsWtCart ];

      // values
    $llTitle          = $this->pObj->pi_getLL( 'plugin_wtcart_header' );
    list( $noreply )  = explode( '@', $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    $noreply          = $noreply . '@###DOMAIN###';
      // values
    
    $records[$uid]['header']    = $llTitle;
    $records[$uid]['constants'] = '
  ////////////////////////////////
  //
  // INDEX
  //
  // plugin.wtcart
  // plugin.powermail



  ////////////////////////////////
  //
  // plugin.wtcart

plugin.wtcart {
  gpvar {
    qty  = tx_quick_shop_qty
    puid = tx_browser_pi1|showUid
  }
  db {
    table = tx_quickshop_products
    min   = quantity_min
    max   = quantity_max
    sku   = sku
  }
  powermailContent {
    uid = ' . $this->pObj->arr_pluginUids[ 'plugin_powermail_header' ] . '
  }
  debug = 0
}
  // plugin.wtcart



  ////////////////////////////////
  //
  // plugin.powermail

plugin.powermail {
  allow {
    email2receiver = 1
    email2sender   = 1
  }
  email {
    noreply  = ' . $noreply . '
  }
  format {
    datetime = %H:%M %d.%m.%Y
    format {
      .date  = %d.%m.%Y
    }
  }
  label {
    allowTags =
  }
  clear {
    session = 1
  }
  hiddenfields {
    show = 1,1,1,1,1
  }
  field {
    checkboxJS = 1
  }
  _LOCAL_LANG {
    de {
      locallangmarker_confirmation_submit = Bestellung abschicken
    }
  }
}
  // plugin.powermail
';

    return $records;
  }

/**
 * pageRoot( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageRoot( )
  {
    $records    = array( );
    $timestamp  = time();
    $pageTitle  = $GLOBALS['TSFE']->page['title'];

      // Update page properties
    $records = $this->pageRootProperties( $timestamp );
    $this->sqlUpdatePages( $records, $pageTitle );

      // Copy header image
    $this->pageRootFileCopy( $timestamp );

      // Hide the installer plugin
    $records    = $this->pageRootPluginInstallHide( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Hide the TypoScript template
    $this->pageRootTyposcriptOtherHide( );
    $this->sqlUpdateTyposcriptOtherHide( );
  }

/**
 * pageRootFileCopy( )
 *
 * @param	integer		$timestamp  : current time
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageRootFileCopy( $timestamp )
  {
      // Files
    $str_fileSrce = 'quick_shop_header_image_210px.jpg';
    $str_fileDest = 'typo3_quickshop_' . $timestamp . '.jpg';

      // Paths
    $str_pathSrce = t3lib_extMgm::siteRelPath( 'quick_shop' ) . 'res/images/';
    $str_pathDest = 'uploads/media/';

      // Copy
    $success = copy( $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest );

      // SWICTH : prompt depending on success
    switch( $success )
    {
      case( ! $success ):
        $this->pObj->markerArray['###SRCE###'] = $str_pathSrce . $str_fileSrce;
        $this->pObj->markerArray['###DEST###'] = $str_pathDest . $str_fileDest;
        $prompt = '
          <p>
            '.$this->pObj->arr_icons['warn'].' '.$this->pObj->pi_getLL('files_create_prompt_error').'
          </p>';
        $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
        $this->pObj->arrReport[ ] = $prompt;
        break;
      case( $success ):
      default:
        $this->pObj->markerArray['###DEST###'] = $str_fileDest;
        $this->pObj->markerArray['###PATH###'] = $str_pathDest;
        $prompt = '
          <p>
            '.$this->pObj->arr_icons['ok'].' '.$this->pObj->pi_getLL('files_create_prompt').'
          </p>';
        $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
        $this->pObj->arrReport[ ] = $prompt;
        break;
    }
      // SWICTH : prompt depending on success
  }

/**
 * pageRootPluginInstallHide( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageRootPluginInstallHide( )
  {
    $records = null;

    $uid    = $this->pObj->cObj->data['uid'];
    $header = $this->pObj->cObj->data['header'];

    $records[$uid]['header'] = $header;
    $records[$uid]['hidden'] = 1;

    return $records;
  }

/**
 * pageRootProperties( )
 *
 * @param	integer		$timestamp  : current time
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageRootProperties( $timestamp )
  {
    $records = null;

    $uid          = $GLOBALS['TSFE']->id;
    $is_siteroot  = null;
    $groupUid     = $this->pObj->markerArray['###GROUP_UID###'];
    $groupTitle   = $this->pObj->markerArray['###GROUP_TITLE###'];

      // SWITCH : siteroot depends on toplevel 
    switch( $this->pObj->bool_topLevel )
    {
      case( true ):
        $is_siteroot = 1;
        break;
      case( false ):
      default:
        $is_siteroot = 0;
        break;
    }
      // SWITCH : siteroot depends on toplevel 

    $records[$uid]['title']       = $this->pObj->pi_getLL( 'page_title_root' );
    $records[$uid]['nav_hide']    = 1;
    $records[$uid]['is_siteroot'] = $is_siteroot;
    $records[$uid]['media']       = 'typo3_quickshop_' . $timestamp . '.jpg';
    $records[$uid]['TSconfig']    = '

// QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' ) . ' -- BEGIN

TCEMAIN {
  permissions {
    // ' . $groupUid . ': ' . $groupTitle . '
    groupid = ' . $groupUid . '
    group   = show,edit,delete,new,editcontent
  }
}

// QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' ) . ' -- END

';

    return $records;
  }

/**
 * pageRootTyposcriptOtherHide( )
 *
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageRootTyposcriptOtherHide( )
  {
    // Do nothing
  }



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * sqlInsert( )
 *
 * @param	array		$records  : TypoScript records for pages
 * @param	string		$table    : name of the current table
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

/**
 * sqlUpdatePlugin( )
 *
 * @param	array		$records  : TypoScript records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlUpdatePlugin( $records, $pageTitle )
  {
    $table = 'tt_content';
    
    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );
      $csvFields  = str_replace( 'header,', null, $csvFields );

      var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );
      
      $this->pObj->markerArray['###FIELD###']     = $csvFields;
      $this->pObj->markerArray['###TITLE###']     = '"' . $record['header'] . '"';
      $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_content' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[ ] = $prompt; 
    }
  }

/**
 * sqlUpdatePages( )
 *
 * @param	array		$records  : TypoScript records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlUpdatePages( $records, $pageTitle )
  {
    $table = 'pages';
    
    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );

      var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );
      
      $this->pObj->markerArray['###FIELD###']     = $csvFields;
      $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_page' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[ ] = $prompt; 
    }
  }

/**
 * sqlUpdateTyposcript( )
 *
 * @param	array		$records  : TypoScript records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlUpdateTyposcript( $records, $pageTitle )
  {
    $table = 'sys_template';
    
    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );
      $csvFields  = str_replace( 'header,', null, $csvFields );

      var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );
      
      $this->pObj->markerArray['###FIELD###']     = $csvFields;
      $this->pObj->markerArray['###TITLE###']     = '"' . $record['header'] . '"';
      $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_content' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[ ] = $prompt; 
    }
  }

/**
 * sqlUpdateTyposcriptOtherHide( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlUpdateTyposcriptOtherHide( )
  {
    $pageTitle = $GLOBALS['TSFE']->page['title'];
    
    $table = 'sys_template';
    
    $record = array( 'hidden' => 1 );

    $uid    = $this->arr_tsUids[ $this->str_tsRoot ];
    $pid    = $GLOBALS['TSFE']->id;
    $where  = 'pid = ' . $pid . ' AND uid NOT LIKE ' . $uid;

    var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
    $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );

    $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
    $prompt = '
      <p>
        ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_template' ) . '
      </p>';
    $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
    $this->pObj->arrReport[ ] = $prompt; 
  }
  
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_consolidation.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_consolidation.php']);
}