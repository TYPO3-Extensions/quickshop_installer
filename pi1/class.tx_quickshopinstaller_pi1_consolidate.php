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
 *   78: class tx_quickshopinstaller_pi1_consolidate
 *
 *              SECTION: Main
 *  104:     public function main( )
 *
 *              SECTION: pages
 *  131:     private function pageQuickshopCaddy( )
 *  166:     private function pageQuickshopCaddyContentJss( )
 *  219:     private function pageQuickshopCaddyPluginCaddy( )
 *  392:     private function pageQuickshopCaddyPluginCaddyMini( )
 *  435:     private function pageQuickshopCaddyPluginPowermail( )
 *  475:     private function pageQuickshopCaddyPluginPowermail1x( )
 *  504:     private function pageQuickshopCaddyPluginPowermail2x( )
 *  594:     private function pageQuickshopCaddyTyposcript( )
 *  627:     private function pageQuickshopCaddyTyposcript1x( )
 *  695:     private function pageQuickshopCaddyTyposcript2x( )
 *  751:     private function pageQuickshop( )
 *  782:     private function pageQuickshopFileCopy( $timestamp )
 *  836:     private function pageQuickshopPluginInstallHide( )
 *  858:     private function pageQuickshopProperties( $timestamp )
 *  912:     private function pageQuickshopTyposcriptOtherHide( )
 *
 *              SECTION: Sql
 *  935:     private function sqlUpdateContent( $records, $pageTitle )
 *  950:     private function sqlUpdatePlugin( $records, $pageTitle )
 *  998:     private function powermailVersionAppendix( )
 * 1043:     private function sqlUpdatePages( $records, $pageTitle )
 * 1091:     private function sqlUpdateTyposcript( $records, $pageTitle )
 * 1138:     private function sqlUpdateTyposcriptOtherHide( )
 *
 *              SECTION: ZZ
 * 1193:     private function zz_getPowermailUid( $label )
 * 1234:     private function zz_getPowermailUid1x( $label )
 * 1250:     private function zz_getPowermailUid2x( $label )
 *
 * TOTAL FUNCTIONS: 25
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Quick Shop Inmstaller' for the 'quickshop_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_quickshopinstaller
 * @version 4.0.5
 * @since 3.0.0
 */
class tx_quickshopinstaller_pi1_consolidate
{
  public $prefixId      = 'tx_quickshopinstaller_pi1_consolidate';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_consolidate.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'quickshop_installer';                      // The extension key.

  public $pObj = null;

  private $powermailVersionAppendix = null;



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
 * @since   3.0.0
 */
  public function main( )
  {
    $this->pObj->arrReport[] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'consolidate_header' ) . '
      </h2>';

    $this->pageQuickshop( );
    $this->pageQuickshopCaddy( );
  }



 /***********************************************
  *
  * pages
  *
  **********************************************/

/**
 * pageQuickshopCaddy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddy( )
  {
    $records    = array( );
    $pageTitle  = $this->pObj->pi_getLL( 'pageQuickshopCaddy_title' );

      // Update the jss script
    $records    = $this->pageQuickshopCaddyContentJss( );
    $this->sqlUpdateContent( $records, $pageTitle );

      // Update the powermail plugin
    $records    = $this->pageQuickshopCaddyPluginPowermail( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the caddy plugin
    $records    = $this->pageQuickshopCaddyPluginCaddy( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the caddy plugin
    $records    = $this->pageQuickshopCaddyPluginCaddyMini( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the TypoScript
    $records    = $this->pageQuickshopCaddyTyposcript( );
    $this->sqlUpdateTyposcript( $records, $pageTitle );

  }

/**
 * pageQuickshopCaddyContentJss( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function pageQuickshopCaddyContentJss( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_contentUids['content_caddy_header'];

      // values
    $llHeader = $this->pObj->pi_getLL( 'content_caddy_header' );
      // values

    $pmFieldsetUid = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    switch( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $pmFieldsetHtmlId = 'tx-powermail-pi1_fieldset_' . $pmFieldsetUid;
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $pmFieldsetHtmlId = 'powermail_fieldset_' . $pmFieldsetUid;
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    $jssScript = $this->pObj->pi_getLL('content_caddy_bodytext');
    $jssScript = str_replace( '###POWERMAIL_FIELDSET_DELIVERYORDER_ADDRESS###', $pmFieldsetHtmlId, $jssScript );


    $records[$uid]['header']      = $llHeader;
    $records[$uid]['bodytext']    = $jssScript;

    return $records;
  }

/**
 * pageQuickshopCaddyPluginCaddy( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddyPluginCaddy( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'plugin_caddy_header' ];
    $pmX      = $this->powermailVersionAppendix( );

      // values
    $llHeader = $this->pObj->pi_getLL( 'plugin_caddy_header' );
      // values

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="note">
            <language index="lDEF">
                <field index="note">
                    <value index="vDEF">'
                      . $this->pObj->pi_getLL( 'plugin_caddy_note_note_' . $pmX ) .
                    '</value>
                </field>
            </language>
        </sheet>
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
                      . $this->zz_getPowermailUid( 'record_pm_field_title_email' ) .
                    '</value>
                </field>
                <field index="termsMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="revocationMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="invoiceMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="deliveryorderMode">
                    <value index="vDEF">all</value>
                </field>
            </language>
        </sheet>
        <sheet index="invoice">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_companyBilling' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_firstnameBilling' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_surnameBilling' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_streetBilling' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_zipBilling' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_locationBilling' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_countryBilling' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="deliveryorder">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_companyDelivery' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_firstnameDelivery' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_surnameDelivery' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_streetDelivery' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_zipDelivery' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_locationDelivery' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_countryDelivery' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="paths">
            <language index="lDEF">
                <field index="terms">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
                <field index="revocation">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';

    return $records;
  }

/**
 * pageQuickshopCaddyPluginCaddyMini( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddyPluginCaddyMini( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'plugin_caddymini_header' ];

      // values
    $llHeader   = $this->pObj->pi_getLL( 'plugin_caddymini_header' );
    $pidOfCaddy = $this->pObj->arr_pageUids[ 'pageQuickshopCaddy_title' ];
      // values

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="sdefPidCaddy">
                    <value index="vDEF">' . $pidOfCaddy . '</value>
                </field>
                <field index="sdefCaddyMode">
                    <value index="vDEF">woItems</value>
                </field>
                <field index="sdefDrs">
                    <value index="vDEF">0</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';

    return $records;
  }

/**
 * pageQuickshopCaddyPluginPowermail( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddyPluginPowermail( )
  {
    $records  = null;

    switch( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $records = $this->pageQuickshopCaddyPluginPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $records = $this->pageQuickshopCaddyPluginPowermail2x( );
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $records;
  }

/**
 * pageQuickshopCaddyPluginPowermail1x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddyPluginPowermail1x( )
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
 * pageQuickshopCaddyPluginPowermail2x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 4.0.5
 * @since   3.0.0
 */
  private function pageQuickshopCaddyPluginPowermail2x( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'plugin_powermail_header' ];

    $llHeader         = $this->pObj->pi_getLL( 'plugin_powermail_header' );
    $uidForm          = $this->pObj->arr_recordUids[ 'record_pm_form_title_caddyorder' ];
    $receiverSubject  = $this->pObj->pi_getLL( 'plugin_powermail_subject_r2x' );
    $receiverBody     = htmlspecialchars( $this->pObj->pi_getLL( 'plugin_powermail_body_r2x' ) );
    // #i0017, 140517, dwildt, 3-
    //list( $name, $domain) = explode( '@', $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    //unset( $name );
    //$senderEmail      = 'noreply@' . $domain;
    // #i0017, 140517, dwildt, 1+
    $senderEmail      = $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    $senderSubject    = $this->pObj->pi_getLL( 'plugin_powermail_subject_s2x' );
    $senderBody       = htmlspecialchars( $this->pObj->pi_getLL( 'plugin_powermail_body_s2x' ) );
    $thxBody          = htmlspecialchars( $this->pObj->pi_getLL('plugin_powermail_thanks2x') );

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="main">
            <language index="lDEF">
                <field index="settings.flexform.main.form">
                    <value index="vDEF">' . $uidForm . '</value>
                </field>
                <field index="settings.flexform.main.confirmation">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
        <sheet index="receiver">
            <language index="lDEF">
                <field index="settings.flexform.receiver.name">
                    <value index="vDEF">{billingaddressfirstname} {billingaddresslastname}</value>
                </field>
                <field index="settings.flexform.receiver.email">
                    <value index="vDEF">' . $senderEmail . '</value>
                </field>
                <field index="settings.flexform.receiver.subject">
                    <value index="vDEF">' . $receiverSubject . '</value>
                </field>
                <field index="settings.flexform.receiver.body">
                    <value index="vDEF">' . $receiverBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $receiverBody . '</value>
                </field>
            </language>
        </sheet>
        <sheet index="sender">
            <language index="lDEF">
                <field index="settings.flexform.sender.name">
                    <value index="vDEF">Quick Shop</value>
                </field>
                <field index="settings.flexform.sender.email">
                    <value index="vDEF">' . $senderEmail . '</value>
                </field>
                <field index="settings.flexform.sender.subject">
                    <value index="vDEF">' . $senderSubject . '</value>
                </field>
                <field index="settings.flexform.sender.body">
                    <value index="vDEF">' . $senderBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $senderBody . '</value>
                </field>
            </language>
        </sheet>
        <sheet index="thx">
            <language index="lDEF">
                <field index="settings.flexform.thx.body">
                    <value index="vDEF">' . $thxBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $thxBody . '</value>
                </field>
                <field index="settings.flexform.thx.redirect">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

    return $records;
  }

/**
 * pageQuickshopCaddyTyposcript( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddyTyposcript( )
  {
    $records = null;

    $pmX = $this->powermailVersionAppendix( );
    switch( true )
    {
      case( $pmX == '1x' ):
        $records = $this->pageQuickshopCaddyTyposcript1x( );
        break;
      case( $pmX == '2x' ):
        $records = $this->pageQuickshopCaddyTyposcript2x( );
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is neither 1x nor 2x. Internal: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $records;
  }

/**
 * pageQuickshopCaddyTyposcript1x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddyTyposcript1x( )
  {
    $records = null;

    $title  = 'pageQuickshopCaddy_title';
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

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $records[$uid]['config']  = $records[$uid]['config'] . '

  // Don\'t display the mini caddy
page.10.subparts.menue.10 >
';
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_shop' ):
        // Do nothing
        break;
    }
      // SWITCH : install case

    return $records;
  }

/**
 * pageQuickshopCaddyTyposcript2x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopCaddyTyposcript2x( )
  {
    $records = null;

    $title  = 'pageQuickshopCaddy_title';
    $uid    = $this->pObj->arr_tsUids[ $title ];

    $strUid = sprintf( '%03d', $uid );
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    $records[$uid]['title']   = $llTitle;
    $records[$uid]['config']  = '
plugin.tx_powermail {
  _LOCAL_LANG {
    default {
        // Next button will be empty in Powermail 2.x
      //confirmation_next = Order without commitment
    }
    de {
        // Next button will be empty in Powermail 2.x
      //confirmation_next = Unverbindlich testen
    }
  }
}
';

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $records[$uid]['config']  = $records[$uid]['config'] . '

  // Don\'t display the mini caddy
page.10.subparts.menue.10 >
';
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_shop' ):
        // Do nothing
        break;
    }
      // SWITCH : install case


    return $records;
  }

/**
 * pageQuickshop( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshop( )
  {
    $records    = array( );
    $timestamp  = time();
    $pageTitle  = $GLOBALS['TSFE']->page['title'];

      // Update page properties
    $records = $this->pageQuickshopProperties( $timestamp );
    $this->sqlUpdatePages( $records, $pageTitle );

      // Copy header image
    $this->pageQuickshopFileCopy( $timestamp );

      // Hide the installer plugin
    $records    = $this->pageQuickshopPluginInstallHide( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Hide the TypoScript template
    $this->pageQuickshopTyposcriptOtherHide( );
    $this->sqlUpdateTyposcriptOtherHide( );
  }

/**
 * pageQuickshopFileCopy( )
 *
 * @param	integer		$timestamp  : current time
 * @return	void
 * @access private
 * @version 4.0.5
 * @since   3.0.0
 */
  private function pageQuickshopFileCopy( $timestamp )
  {
      // Files
    $str_fileSrce = 'quick_shop_header_image_190px.gif';
    $str_fileDest = 'typo3_quickshop_' . $timestamp . '.gif';

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
 * pageQuickshopPluginInstallHide( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopPluginInstallHide( )
  {
    $records = null;

    $uid    = $this->pObj->cObj->data['uid'];
    $header = $this->pObj->cObj->data['header'];

    $records[$uid]['header'] = $header;
    $records[$uid]['hidden'] = 1;

    return $records;
  }

/**
 * pageQuickshopProperties( )
 *
 * @param	integer		$timestamp  : current time
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopProperties( $timestamp )
  {
    $records = null;

    $uid          = $GLOBALS['TSFE']->id;
    $is_siteroot  = null;
    $groupUid     = $this->pObj->markerArray['###GROUP_UID###'];
    $groupTitle   = $this->pObj->markerArray['###GROUP_TITLE###'];

      // #i0010, 130925, dwildt, 12-
//      // SWITCH : siteroot depends on toplevel
//    switch( $this->pObj->bool_topLevel )
//    {
//      case( true ):
//        $is_siteroot = 1;
//        break;
//      case( false ):
//      default:
//        $is_siteroot = 0;
//        break;
//    }
//      // SWITCH : siteroot depends on toplevel
      // #i0010, 130925, dwildt, 12-

      // #i0010, 130925, dwildt, 11+
      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $is_siteroot                = 1;
        $records[$uid]['nav_title'] = null;
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_shop' ):
        $is_siteroot                = 0;
        $records[$uid]['nav_title'] = $this->pObj->pi_getLL( 'pageQuickshop_titleNav' );
        break;
    }
      // SWITCH : install case
      // #i0010, 130925, dwildt, 11+

    $records[$uid]['title']       = $this->pObj->pi_getLL( 'pageQuickshop_title' );
    $records[$uid]['nav_hide']    = 0;
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
 * pageQuickshopTyposcriptOtherHide( )
 *
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageQuickshopTyposcriptOtherHide( )
  {
    // Do nothing
  }



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * sqlUpdateContent( )
 *
 * @param	array		$records  : tt_content records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function sqlUpdateContent( $records, $pageTitle )
  {
    $this->sqlUpdatePlugin( $records, $pageTitle );
  }

/**
 * sqlUpdatePlugin( )
 *
 * @param	array		$records  : tt_content records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function sqlUpdatePlugin( $records, $pageTitle )
  {
    $table = 'tt_content';

    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );
      $csvFields  = str_replace( 'header, ', null, $csvFields );

      //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );

      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

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
 * powermailVersionAppendix( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function powermailVersionAppendix( )
  {
    if( $this->powermailVersionAppendix !== null )
    {
      return $this->powermailVersionAppendix;
    }

    switch( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $this->powermailVersionAppendix = '1x';
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $this->powermailVersionAppendix = '2x';
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $this->powermailVersionAppendix;
  }

/**
 * sqlUpdatePages( )
 *
 * @param	array		$records  : TypoScript records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
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

      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

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
 * @since   3.0.0
 */
  private function sqlUpdateTyposcript( $records, $pageTitle )
  {
    $table = 'sys_template';

    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );
      $csvFields  = str_replace( 'title, ', null, $csvFields );

      //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );

      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }
      $this->pObj->markerArray['###FIELD###']     = $csvFields;
      $this->pObj->markerArray['###TITLE###']     = '"' . $record['title'] . '"';
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
 * @since   3.0.0
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

    $error = $GLOBALS['TYPO3_DB']->sql_error( );

    if( $error )
    {
      $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
      $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                'query: ' . $query . '.<br />' . PHP_EOL .
                'error: ' . $error . '.<br />' . PHP_EOL .
                'Sorry for the trouble.<br />' . PHP_EOL .
                'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
              __METHOD__ . ' (' . __LINE__ . ')';
      die( $prompt );
    }

    $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
    $prompt = '
      <p>
        ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_template' ) . '
      </p>';
    $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
    $this->pObj->arrReport[ ] = $prompt;
  }



 /***********************************************
  *
  * ZZ
  *
  **********************************************/

/**
 * zz_getPowermailUid( )
 *
 * @param	string		$label        : label for the powermail field
 * @return	string		$powermailUid : uid of the powermail field record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zz_getPowermailUid( $label )
  {
    $powermailUid = null;

    switch( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $powermailUid = $this->zz_getPowermailUid1x( $label );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $powermailUid = $this->zz_getPowermailUid2x( $label );
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $powermailUid;
  }

/**
 * zz_getPowermailUid1x( )
 *
 * @param	string		$label        : label for the powermail field
 * @return	string		$powermailUid : uid of the powermail field record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zz_getPowermailUid1x( $label )
  {
    $powermailUid = $this->pObj->arr_recordUids[ $label ];

    return $powermailUid;
  }

/**
 * zz_getPowermailUid2x( )
 *
 * @param	string		$label        : label for the powermail field
 * @return	string		$powermailUid : uid of the powermail field record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zz_getPowermailUid2x( $label )
  {
    $powermailUid = 'tx_powermail_domain_model_fields_'
                  . $this->pObj->arr_recordUids[ $label ];

    return $powermailUid;
  }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_consolidate.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_consolidate.php']);
}