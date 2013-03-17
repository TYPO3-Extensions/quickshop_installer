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
 *   66: class tx_quickshopinstaller_pi1_consolidate
 *
 *              SECTION: Main
 *   90:     public function main( )
 *
 *              SECTION: pages
 *  117:     private function pageCaddy( )
 *  144:     private function pageCaddyPluginCaddy( )
 *  273:     private function pageCaddyPluginPowermail( )
 *  302:     private function pageCaddyTyposcript( )
 *  353:     private function pageRoot( )
 *  384:     private function pageRootFileCopy( $timestamp )
 *  433:     private function pageRootPluginInstallHide( )
 *  455:     private function pageRootProperties( $timestamp )
 *  508:     private function pageRootTyposcriptOtherHide( )
 *
 *              SECTION: Sql
 *  531:     private function sqlInsert( $records, $table )
 *  560:     private function sqlUpdatePlugin( $records, $pageTitle )
 *  596:     private function sqlUpdatePages( $records, $pageTitle )
 *  630:     private function sqlUpdateTyposcript( $records, $pageTitle )
 *  664:     private function sqlUpdateTyposcriptOtherHide( )
 *
 * TOTAL FUNCTIONS: 15
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
class tx_quickshopinstaller_pi1_consolidate
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_consolidate';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_consolidate.php';  // Path to this script relative to the extension dir.
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

      // Update the caddy plugin
    $records    = $this->pageCaddyPluginCaddy( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the TypoScript
    $records    = $this->pageCaddyTyposcript( );
    $this->sqlUpdateTyposcript( $records, $pageTitle );

  }

/**
 * pageCaddyPluginCaddy( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageCaddyPluginCaddy( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'plugin_caddy_header' ];

      // values
    $llHeader = $this->pObj->pi_getLL( 'plugin_caddy_header' );
      // values

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="origin">
            <language index="lDEF">
                <field index="order">
                    <value index="vDEF">3972</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">83</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">216</value>
                </field>
                <field index="min">
                    <value index="vDEF">3</value>
                </field>
                <field index="max">
                    <value index="vDEF">10</value>
                </field>
            </language>
        </sheet>
        <sheet index="email">
            <language index="lDEF">
                <field index="customerEmail">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_email' ] .
                    '</value>
                </field>
                <field index="termsMode">
                    <value index="vDEF">customer</value>
                </field>
                <field index="invoiceMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="deliveryorderMode">
                    <value index="vDEF">vendor</value>
                </field>
            </language>
        </sheet>
        <sheet index="invoice">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_companyBilling' ] .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_firstnameBilling' ] .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_surnameBilling' ] .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_streetBilling' ] .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_zipBilling' ] .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_locationBilling' ] .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_countryBilling' ] .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="deliveryorder">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_companyDelivery' ] .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_firstnameDelivery' ] .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_surnameDelivery' ] .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_streetDelivery' ] .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_zipDelivery' ] .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_locationDelivery' ] .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->pObj->arr_recordUids[ 'record_pm_field_title_countryDelivery' ] .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="paths">
            <language index="lDEF">
                <field index="terms">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-invoice.pdf</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-invoice.pdf</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-invoice.pdf</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';

    return $records;
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
    $customerEmail  = 'uid' . $uidEmail;
    $uidFirstname   = $this->pObj->arr_recordUids[ 'record_pm_field_title_firstnameBilling' ];
    $uidSurname     = $this->pObj->arr_recordUids[ 'record_pm_field_title_surnameBilling' ];
    $customerName   = 'uid' . $uidFirstname . ',uid' . $uidSurname;
      // values

    $records[$uid]['header']                  = $llHeader;
    $records[$uid]['tx_powermail_sender']     = $customerEmail;
    $records[$uid]['tx_powermail_sendername'] = $customerName;

    return $records;
  }

/**
 * pageCaddyTyposcript( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageCaddyTyposcript( )
  {
    $records = null;

    $title  = 'page_title_caddy';
    $uid    = $this->pObj->arr_tsUids[ $title ];

    $strUid = sprintf( '%03d', $uid );
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    list( $noreply, $domain ) = explode( '@', $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    $noreply                  = 'noreply@' . $domain;


    $records[$uid]['title']   = $llTitle;
    $records[$uid]['config']  = '
plugin.tx_powermail_pi1 {
  email {
    sender_mail {
      sender {
        name {
          value = Quick Shop
        }
        email {
          value = ' . $noreply . '
        }
      }
    }
  }
  _LOCAL_LANG {
    default {
      locallangmarker_confirmation_submit = Test Quick Shop without commitment!
    }
    de {
      locallangmarker_confirmation_submit = Quick Shop unverbindlich testen!
    }
  }
}';
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
    $str_pathSrceAbs  = t3lib_extMgm::extPath( 'quick_shop' ) . 'res/images/';
    $str_pathSrce     = t3lib_extMgm::siteRelPath( 'quick_shop' ) . 'res/images/';
    $str_pathDest     = 'uploads/media/';

//    if( ! file_exists( $str_pathSrceAbs . $str_fileSrce ) )
//    {
//var_dump( __METHOD__, __LINE__, $str_pathSrceAbs . $str_fileSrce, 0 );
//    }
      // Copy
    $success = copy( $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest );
//var_dump( __METHOD__, __LINE__, $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest, $success );
      // SWICTH : prompt depending on success
    switch( $success )
    {
      case( false ):
        $this->pObj->markerArray['###SRCE###'] = $str_pathSrce . $str_fileSrce;
        $this->pObj->markerArray['###DEST###'] = $str_pathDest . $str_fileDest;
        $prompt = '
          <p>
            '.$this->pObj->arr_icons['warn'].' '.$this->pObj->pi_getLL('files_create_prompt_error').'
          </p>';
        $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
        $this->pObj->arrReport[ ] = $prompt;
        break;
      case( true ):
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
    $records[$uid]['module']      = null;
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

      //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
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

//      var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
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

      //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
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

    $uid    = $this->pObj->arr_tsUids[ $this->pObj->str_tsRoot ];
    $pid    = $GLOBALS['TSFE']->id;
    $where  = 'pid = ' . $pid . ' AND uid NOT LIKE ' . $uid;

    //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
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



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_consolidate.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_consolidate.php']);
}