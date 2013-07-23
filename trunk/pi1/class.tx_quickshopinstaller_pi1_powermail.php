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
 *  114: class tx_quickshopinstaller_pi1_powermail
 *
 *              SECTION: Main
 *  147:     public function main( )
 *
 *              SECTION: Fields: billing address
 *  179:     private function fieldBillingaddressAddress( $uid, $sorting )
 *  210:     private function fieldBillingaddressCity( $uid, $sorting )
 *  241:     private function fieldBillingaddressCompany( $uid, $sorting )
 *  272:     private function fieldBillingaddressCountry( $uid, $sorting )
 *  303:     private function fieldBillingaddressFirstname( $uid, $sorting )
 *  366:     private function fieldBillingaddressLastname( $uid, $sorting )
 *  428:     private function fieldBillingaddressZip( $uid, $sorting )
 *
 *              SECTION: Fields: contact data
 *  467:     private function fieldContactdataEmail( $uid, $sorting )
 *  534:     private function fieldContactdataFax( $uid, $sorting )
 *  565:     private function fieldContactdataPhone( $uid, $sorting )
 *
 *              SECTION: Fields: delivery address
 *  604:     private function fieldDeliveryaddressAddress( $uid, $sorting )
 *  635:     private function fieldDeliveryaddressCity( $uid, $sorting )
 *  666:     private function fieldDeliveryaddressCompany( $uid, $sorting )
 *  697:     private function fieldDeliveryaddressCountry( $uid, $sorting )
 *  728:     private function fieldDeliveryaddressFirstname( $uid, $sorting )
 *  759:     private function fieldDeliveryaddressLastname( $uid, $sorting )
 *  790:     private function fieldDeliveryaddressZip( $uid, $sorting )
 *
 *              SECTION: Fields: order
 *  829:     private function fieldOrderNote( $uid, $sorting )
 *  894:     private function fieldOrderRevocation( $uid, $sorting )
 *  991:     private function fieldOrderSubmit( $uid, $sorting )
 * 1022:     private function fieldOrderTerms( $uid, $sorting )
 *
 *              SECTION: Controller
 * 1126:     private function fields( )
 * 1229:     private function fieldsSetLabelsAndValuesByVersion( )
 * 1265:     private function fieldsSetLabelsAndValuesByVersion1x( )
 * 1281:     private function fieldsSetLabelsAndValuesByVersion2x( )
 * 1299:     private function fieldsSetMarkerByVersion( $record, $method )
 * 1340:     private function fieldsSetMarkerByVersion1x( $record, $method )
 * 1358:     private function fieldsSetMarkerByVersion2x( $record, $method )
 * 1376:     private function fieldsSetTitleDeliveryByVersion( $llLabel )
 * 1416:     private function fieldsSetTitleDeliveryByVersion1x( $llLabel )
 * 1433:     private function fieldsSetTitleDeliveryByVersion2x( $llLabel )
 *
 *              SECTION: Fieldsets
 * 1466:     private function fieldsetBillingaddress( $uid, $sorting )
 * 1496:     private function fieldsetContactdata( $uid, $sorting )
 * 1526:     private function fieldsetDeliveryaddress( $uid, $sorting )
 * 1556:     private function fieldsetOrder( $uid, $sorting )
 * 1584:     private function fieldsets( )
 * 1620:     private function fieldsetsSetLabelsByVersion( )
 * 1656:     private function fieldsetsSetLabelsByVersion1x( )
 * 1671:     private function fieldsetsSetLabelsByVersion2x( )
 * 1686:     private function fieldsetsSetValuesByVersion( )
 * 1722:     private function fieldsetsSetValuesByVersion1x( )
 * 1735:     private function fieldsetsSetValuesByVersion2x( )
 *
 *              SECTION: Sql
 * 1758:     private function sqlInsert( $records, $table )
 *
 *              SECTION: forms
 * 1811:     private function formCaddyOrder( $uid )
 * 1837:     private function forms( )
 * 1877:     private function forms1x( )
 * 1892:     private function forms2x( )
 *
 *              SECTION: ZZ
 * 1922:     private function zz_counter( $uid )
 *
 * TOTAL FUNCTIONS: 49
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
class tx_quickshopinstaller_pi1_powermail
{
  public  $prefixId      = 'tx_quickshopinstaller_pi1_powermail';
  public  $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1_powermail.php';
  public  $extKey        = 'quickshop_installer';

  public  $pObj = null;

  private $fieldsLabelTable = null;
  private $fieldsValueType  = null;

  private $fieldsetsLabelForms  = null;
  private $fieldsetsLabelFields = null;
  private $fieldsetsLabelTable  = null;

  private $fieldsetsValueForm   = null;



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

    $records = $this->forms( );
    $this->sqlInsert( $records, 'tx_powermail_domain_model_forms' );

    $records = $this->fieldsets( );
    $this->sqlInsert( $records, $this->fieldsetsLabelTable );

    $records = $this->fields( );
    $this->sqlInsert( $records, $this->fieldsLabelTable );
  }



 /***********************************************
  *
  * Fields: billing address
  *
  **********************************************/

/**
 * fieldBillingaddressAddress( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldBillingaddressAddress( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_streetBilling' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_streetBilling' ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['sorting']    = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldBillingaddressCity( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldBillingaddressCity( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_locationBilling' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_locationBilling' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldBillingaddressCompany( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldBillingaddressCompany( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_companyBilling' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_companyBilling' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldBillingaddressCountry( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldBillingaddressCountry( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_countryBilling' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_countryBilling' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldBillingaddressFirstname( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldBillingaddressFirstname( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_firstnameBilling' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_firstnameBilling' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    $versionInt = $this->pObj->powermailVersionInt;
    switch( true )
    {
      case( $versionInt >= 1000000 && $versionInt < 2000000 ):
        $record['flexform']  = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
        break;
      case( $versionInt >= 2000000 && $versionInt < 3000000 ):
        $record['mandatory']    = true;
        $record['sender_name']  = true;
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is not 1.x and 2.x: ' . $versionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

/**
 * fieldBillingaddressLastname( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldBillingaddressLastname( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_surnameBilling' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_surnameBilling' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );
    $versionInt = $this->pObj->powermailVersionInt;
    switch( true )
    {
      case( $versionInt >= 1000000 && $versionInt < 2000000 ):
        $record['flexform']  = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
        break;
      case( $versionInt >= 2000000 && $versionInt < 3000000 ):
        $record['mandatory'] = true;
        $record['sender_name']  = true;
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is not 1.x and 2.x: ' . $versionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

/**
 * fieldBillingaddressZip( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldBillingaddressZip( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_zipBilling' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_zipBilling' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }



 /***********************************************
  *
  * Fields: contact data
  *
  **********************************************/

/**
 * fieldContactdataEmail( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldContactdataEmail( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_email' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_email' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_contactData' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    $versionInt = $this->pObj->powermailVersionInt;
    switch( true )
    {
      case( $versionInt >= 1000000 && $versionInt < 2000000 ):
        $record['flexform']  = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
                <field index="validate">
                    <value index="vDEF">validate-email</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
        break;
      case( $versionInt >= 2000000 && $versionInt < 3000000 ):
        $record['mandatory']    = true;
        $record['sender_email'] = true;
        $record['validation']   = true;
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is not 1.x and 2.x: ' . $versionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

/**
 * fieldContactdataFax( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldContactdataFax( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_fax' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_fax' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_contactData' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldContactdataPhone( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldContactdataPhone( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_phone' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_phone' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_contactData' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }



 /***********************************************
  *
  * Fields: delivery address
  *
  **********************************************/

/**
 * fieldDeliveryaddressAddress( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldDeliveryaddressAddress( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->fieldsSetTitleDeliveryByVersion( 'record_pm_field_title_streetDelivery' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_streetDelivery' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldDeliveryaddressCity( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldDeliveryaddressCity( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->fieldsSetTitleDeliveryByVersion( 'record_pm_field_title_locationDelivery' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_locationDelivery' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldDeliveryaddressCompany( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldDeliveryaddressCompany( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->fieldsSetTitleDeliveryByVersion( 'record_pm_field_title_companyDelivery' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_companyDelivery' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldDeliveryaddressCountry( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldDeliveryaddressCountry( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->fieldsSetTitleDeliveryByVersion( 'record_pm_field_title_countryDelivery' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_countryDelivery' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldDeliveryaddressFirstname( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldDeliveryaddressFirstname( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->fieldsSetTitleDeliveryByVersion( 'record_pm_field_title_firstnameDelivery' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_firstnameDelivery' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldDeliveryaddressLastname( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldDeliveryaddressLastname( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->fieldsSetTitleDeliveryByVersion( 'record_pm_field_title_surnameDelivery' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_surnameDelivery' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldDeliveryaddressZip( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldDeliveryaddressZip( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->fieldsSetTitleDeliveryByVersion( 'record_pm_field_title_zipDelivery' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_zipDelivery' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ];
    $record[ $this->fieldsLabelType ]  = $this->fieldsValueType;
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }



 /***********************************************
  *
  * Fields: order
  *
  **********************************************/

/**
 * fieldOrderNote( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldOrderNote( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_note' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_note' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_order' ];
    $record[ $this->fieldsLabelType ]  = 'textarea';
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    $versionInt = $this->pObj->powermailVersionInt;
    switch( true )
    {
      case( $versionInt >= 1000000 && $versionInt < 2000000 ):
        $record['flexform']  = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="cols">
                    <value index="vDEF">50</value>
                </field>
                <field index="rows">
                    <value index="vDEF">5</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
        break;
      case( $versionInt >= 2000000 && $versionInt < 3000000 ):
          // Nothing
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is not 1.x and 2.x: ' . $versionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

/**
 * fieldOrderRevocation( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function fieldOrderRevocation( $uid, $sorting )
  {
    $record = null;

    $int_revocation = $this->pObj->arr_pageUids[ 'page_title_revocation' ];

      // phrases_powermail_revocationAccepted in dependence of Powermail 1.x or 2.x
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
        $str_revocation = htmlspecialchars( $this->pObj->pi_getLL('phrases_powermail_revocationAccepted1x') );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $str_revocation = $this->pObj->pi_getLL('phrases_powermail_revocationAccepted2x');
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
      // phrases_powermail_revocationAccepted in dependence of Powermail 1.x or 2.x

    $str_revocation = str_replace('###PID###', $int_revocation, $str_revocation);

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_revocation' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_revocation' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_order' ];
    $record[ $this->fieldsLabelType ]  = 'check';
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    $versionInt = $this->pObj->powermailVersionInt;
    switch( true )
    {
      case( $versionInt >= 1000000 && $versionInt < 2000000 ):
        $record['flexform']  = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="options">
                    <value index="vDEF">' . $str_revocation . '</value>
                </field>
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
        break;
      case( $versionInt >= 2000000 && $versionInt < 3000000 ):
        $record['mandatory']  = true;
        $record['settings']   = $str_revocation;
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is not 1.x and 2.x: ' . $versionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

/**
 * fieldOrderSubmit( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldOrderSubmit( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_submit' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_submit' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_order' ];
    $record[ $this->fieldsLabelType ]  = 'submit';
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    return $record;
  }

/**
 * fieldOrderTerms( )
 *
 * @param	integer		$uid      : uid of the current field
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldOrderTerms( $uid, $sorting )
  {
    $record = null;

    $int_terms = $this->pObj->arr_pageUids[ 'page_title_terms' ];

      // phrases_powermail_termsAccepted in dependence of Powermail 1.x or 2.x
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
        $str_terms = htmlspecialchars( $this->pObj->pi_getLL('phrases_powermail_termsAccepted1x') );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $str_terms = $this->pObj->pi_getLL('phrases_powermail_termsAccepted2x');
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
      // phrases_powermail_termsAccepted in dependence of Powermail 1.x or 2.x

    $str_terms = str_replace('###PID###', $int_terms, $str_terms);

    $llTitle = $this->pObj->pi_getLL( 'record_pm_field_title_terms' );
    $this->pObj->arr_recordUids[ 'record_pm_field_title_terms' ] = $uid;

    $record['uid']       = $uid;
    $record['pid']       = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']    = time( );
    $record['crdate']    = time( );
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['title']     = $llTitle;
    $record['sorting']   = $sorting;
    $record[ $this->fieldsLabelFieldset ]  = $this->pObj->arr_recordUids[ 'record_pm_fSets_title_order' ];
    $record[ $this->fieldsLabelType ]  = 'check';
    $record               = $this->fieldsSetMarkerByVersion( $record, __METHOD__ );

    $versionInt = $this->pObj->powermailVersionInt;
    switch( true )
    {
      case( $versionInt >= 1000000 && $versionInt < 2000000 ):
        $record['flexform']  = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="options">
                    <value index="vDEF">' . $str_terms . '</value>
                </field>
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
        break;
      case( $versionInt >= 2000000 && $versionInt < 3000000 ):
        $record['mandatory']  = true;
        $record['settings']   = $str_terms;
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is not 1.x and 2.x: ' . $versionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }



 /***********************************************
  *
  * Controller
  *
  **********************************************/


/**
 * fields( )
 *
 * @return	array		$records : the plugin records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fields( )
  {
    $records  = array( );

    $this->fieldsSetLabelsAndValuesByVersion( );

    $uid      = $this->pObj->zz_getMaxDbUid( $this->fieldsLabelTable );

      // field billing address company
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldBillingaddressCompany( $uid, $sorting );

      // field billing address first name
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldBillingaddressFirstname( $uid, $sorting );

      // field billing address surname
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldBillingaddressLastname( $uid, $sorting );

      // field billing address address
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldBillingaddressAddress( $uid, $sorting );

      // field billing address zip
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldBillingaddressZip( $uid, $sorting );

      // field billing address city
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldBillingaddressCity( $uid, $sorting );

      // field billing address country
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldBillingaddressCountry( $uid, $sorting );

      // field delivery address company
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldDeliveryaddressCompany( $uid, $sorting );

      // field delivery address first name
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldDeliveryaddressFirstname( $uid, $sorting );

      // field delivery address surname
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldDeliveryaddressLastname( $uid, $sorting );

      // field delivery address address
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldDeliveryaddressAddress( $uid, $sorting );

      // field delivery address zip
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldDeliveryaddressZip( $uid, $sorting );

      // field delivery address city
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldDeliveryaddressCity( $uid, $sorting );

      // field delivery address country
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldDeliveryaddressCountry( $uid, $sorting );

      // field contact data e-mail
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldContactdataEmail( $uid, $sorting );

      // field contact data phone
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldContactdataPhone( $uid, $sorting );

      // field contact data fax
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldContactdataFax( $uid, $sorting );

      // field order note
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldOrderNote( $uid, $sorting );

      // field order terms
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldOrderTerms( $uid, $sorting );

      // field order revocation
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldOrderRevocation( $uid, $sorting );

      // field order submit
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldOrderSubmit( $uid, $sorting );

    return $records;
  }

/**
 * fieldsSetLabelsAndValuesByVersion( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetLabelsAndValuesByVersion( )
  {
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
        $this->fieldsSetLabelsAndValuesByVersion1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $this->fieldsSetLabelsAndValuesByVersion2x( );
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
  }

/**
 * fieldsSetLabelsAndValuesByVersion1x( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetLabelsAndValuesByVersion1x( )
  {
    $this->fieldsLabelFieldset  = 'fieldset';
    $this->fieldsLabelTable     = 'tx_powermail_fields';
    $this->fieldsLabelType      = 'formtype';
    $this->fieldsValueType      = 'text';
  }

/**
 * fieldsSetLabelsAndValuesByVersion2x( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetLabelsAndValuesByVersion2x( )
  {
    $this->fieldsLabelFieldset  = 'pages';
    $this->fieldsLabelTable     = 'tx_powermail_domain_model_fields';
    $this->fieldsLabelType      = 'type';
    $this->fieldsValueType      = 'input';
  }

/**
 * fieldsSetMarkerByVersion( )
 *
 * @param	array		$record : current record
 * @param	string		$method : calling method like tx_quickshopinstaller_pi1_powermail::fieldBillingaddressAddress
 * @return	array		$record : handled record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetMarkerByVersion( $record, $method )
  {
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
        $record = $this->fieldsSetMarkerByVersion1x( $record, $method );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $record = $this->fieldsSetMarkerByVersion2x( $record, $method );
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

    return $record;
  }

/**
 * fieldsSetMarkerByVersion1x( )  : Does nothing. Powermail 1x doesn't know marker
 *                                  Returns the record
 *
 * @param	array		$record : current record
 * @param	string		$method : calling method like tx_quickshopinstaller_pi1_powermail::fieldBillingaddressAddress
 * @return	array		$record : current record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetMarkerByVersion1x( $record, $method )
  {
      // Powermail 1x doesn't know any marker
    unset( $method );
    return $record;
  }

/**
 * fieldsSetMarkerByVersion2x( )  : adds fields own_marker_select and marker to the given record.
 *                                  Returns the record
 *
 * @param	array		$record : current record
 * @param	string		$method : calling method like tx_quickshopinstaller_pi1_powermail::fieldBillingaddressAddress
 * @return	array		$record : the handled record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetMarkerByVersion2x( $record, $method )
  {
    list( $prefix, $marker ) = explode( '::field', $method );
    unset( $prefix );
    $record['own_marker_select']  = true;
    $record['marker']             = strtolower( $marker );
    return $record;
  }

/**
 * fieldsSetTitleDeliveryByVersion( )
 *
 * @param	string		$$llLabel : the label in the locallang file
 * @return	string		$llValue  : the localised value
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetTitleDeliveryByVersion( $llLabel )
  {
    $llValue = null;
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
        $llValue = $this->fieldsSetTitleDeliveryByVersion1x( $llLabel );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $llValue = $this->fieldsSetTitleDeliveryByVersion2x( $llLabel );
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

    return $llValue;
  }

/**
 * fieldsSetTitleDeliveryByVersion1x( )  :
 *
 * @param	string		$$llLabel : the label in the locallang file
 * @return	string		$llValue  : the localised value
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetTitleDeliveryByVersion1x( $llLabel )
  {
    $llValue = $this->pObj->pi_getLL( $llLabel );

    return $llValue;
  }


/**
 * fieldsSetTitleDeliveryByVersion2x( )  :
 *
 * @param	string		$$llLabel : the label in the locallang file
 * @return	string		$llValue  : the localised value
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsSetTitleDeliveryByVersion2x( $llLabel )
  {

//    $llAppendix2x = $this->pObj->pi_getLL( 'phrases_pm_fields_delivery_appendix2x' );
//    $llValue      = $this->pObj->pi_getLL( $llLabel )
//                  . $llAppendix2x
//                  ;
    $llPrependix2x  = $this->pObj->pi_getLL( 'phrases_pm_fields_delivery_prependix2x' );
    $llValue        = $llPrependix2x
                    . $this->pObj->pi_getLL( $llLabel )
                    ;

    return $llValue;
  }



 /***********************************************
  *
  * Fieldsets
  *
  **********************************************/

/**
 * fieldsetBillingaddress( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldsetBillingaddress( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_fSets_title_billingAddress' );
    $this->pObj->arr_recordUids[ 'record_pm_fSets_title_billingAddress' ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['sorting']    = $sorting;
    $record[$this->fieldsetsLabelForms] = $this->fieldsetsValueForm;
    $record[$this->fieldsetsLabelFields]     = '7';

    return $record;
  }

/**
 * fieldsetContactdata( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the fieldset record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldsetContactdata( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_fSets_title_contactData' );
    $this->pObj->arr_recordUids[ 'record_pm_fSets_title_contactData' ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['sorting']    = $sorting;
    $record[$this->fieldsetsLabelForms] = $this->fieldsetsValueForm;
    $record[$this->fieldsetsLabelFields]     = '3';

    return $record;
  }

/**
 * fieldsetDeliveryaddress( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the fieldset record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldsetDeliveryaddress( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_fSets_title_deliveryAddress' );
    $this->pObj->arr_recordUids[ 'record_pm_fSets_title_deliveryAddress' ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['sorting']    = $sorting;
    $record[$this->fieldsetsLabelForms] = $this->fieldsetsValueForm;
    $record[$this->fieldsetsLabelFields]     = '7';

    return $record;
  }

/**
 * fieldsetOrder( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the fieldset record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldsetOrder( $uid, $sorting )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_fSets_title_order' );
    $this->pObj->arr_recordUids[ 'record_pm_fSets_title_order' ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['sorting']    = $sorting;
    $record[$this->fieldsetsLabelForms] = $this->fieldsetsValueForm;
    $record[$this->fieldsetsLabelFields]     = '3';

    return $record;
  }

/**
 * fieldsets( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function fieldsets( )
  {
    $records  = array( );

    $this->fieldsetsSetLabelsByVersion( );
    $this->fieldsetsSetValuesByVersion( );

    $uid      = $this->pObj->zz_getMaxDbUid( $this->fieldsetsLabelTable );

      // fieldset billing address
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldsetBillingaddress( $uid, $sorting );

      // fieldset delivery address
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldsetDeliveryaddress( $uid, $sorting );

      // fieldset contact data
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldsetContactdata( $uid, $sorting );

      // fieldset order
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->fieldsetOrder( $uid, $sorting );

    return $records;
  }

/**
 * fieldsetsSetLabelsByVersion( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsetsSetLabelsByVersion( )
  {
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
        $this->fieldsetsSetLabelsByVersion1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $this->fieldsetsSetLabelsByVersion2x( );
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
  }

/**
 * fieldsetsSetLabelsByVersion1x( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsetsSetLabelsByVersion1x( )
  {
    $this->fieldsetsLabelForms  = 'tt_content';
    $this->fieldsetsLabelFields = 'felder';
    $this->fieldsetsLabelTable  = 'tx_powermail_fieldsets';
  }

/**
 * fieldsetsSetLabelsByVersion2x( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsetsSetLabelsByVersion2x( )
  {
    $this->fieldsetsLabelForms  = 'forms';
    $this->fieldsetsLabelFields = 'fields';
    $this->fieldsetsLabelTable  = 'tx_powermail_domain_model_pages';
  }

/**
 * fieldsetsSetValuesByVersion( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsetsSetValuesByVersion( )
  {
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
        $this->fieldsetsSetValuesByVersion1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $this->fieldsetsSetValuesByVersion2x( );
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
  }

/**
 * fieldsetsSetValuesByVersion1x( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsetsSetValuesByVersion1x( )
  {
    $this->fieldsetsValueForm = $this->pObj->arr_pluginUids[ 'plugin_powermail_header' ];
  }

/**
 * fieldsetsSetValuesByVersion2x( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function fieldsetsSetValuesByVersion2x( )
  {
    $this->fieldsetsValueForm = $this->pObj->arr_recordUids[ 'record_pm_form_title_caddyorder' ];
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
    foreach( ( array ) $records as $record )
    {
      //var_dump(__METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->INSERTquery( $table, $record ) );
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( $table, $record );
      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( $table, $record );
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
      $marker['###TITLE###']      = $record['title'];
      $marker['###TABLE###']      = $this->pObj->pi_getLL( $table );
      $marker['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'record_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
        // prompt
    }
  }



 /***********************************************
  *
  * forms
  *
  **********************************************/

/**
 * formCaddyOrder( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function formCaddyOrder( $uid )
  {
    $record = null;

    $llTitle = $this->pObj->pi_getLL( 'record_pm_form_title_caddyorder' );
    $this->pObj->arr_recordUids[ 'record_pm_form_title_caddyorder' ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'page_title_caddy' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['pages']      = 4; // Number of fieldsets/pages

    return $record;
  }

/**
 * forms( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function forms( )
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
        $records = $this->forms1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $records = $this->forms2x( );
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
 * forms1x( ) : Return nothing: Powermail 1x doesn't know any form
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function forms1x( )
  {
    $records = null;

    return $records;
  }

/**
 * forms2x( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function forms2x( )
  {
    $records  = array( );

    $uid      = $this->pObj->zz_getMaxDbUid( 'tx_powermail_domain_model_forms' );

      // fieldset billing address
    $uid = $uid + 1;
    $records[$uid] = $this->formCaddyOrder( $uid );

    return $records;
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



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_powermail.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1_powermail.php']);
}