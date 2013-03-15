<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 *   94: class tx_quickshopinstaller_pi1 extends tslib_pibase
 *
 *              SECTION: Main
 *  152:     public function main( $content, $conf)
 *
 *              SECTION: Confirmation
 *  232:     private function confirmation()
 *
 *              SECTION: Create
 *  307:     private function create( )
 *  333:     private function createBeGroup()
 *  439:     private function createContent()
 *  581:     private function createFilesShop()
 *  638:     private function createPages( )
 *  655:     private function createPlugins( )
 *
 *              SECTION: Create records
 *  680:     private function createRecordsPowermail( )
 *  697:     private function createRecordsQuickshop( )
 * 1064:     private function createTyposcript( )
 *
 *              SECTION: Consolidate
 * 1086:     private function consolidatePageCurrent()
 * 1309:     private function consolidatePluginPowermail()
 * 1386:     private function consolidateTsWtCart()
 *
 *              SECTION: Extensions
 * 1528:     private function extensionCheck( )
 * 1593:     private function extensionCheckCaseBaseTemplate( )
 * 1632:     private function extensionCheckExtension( $key, $title )
 *
 *              SECTION: Html
 * 1673:     private function htmlReport( )
 *
 *              SECTION: Init
 * 1730:     private function initBoolTopLevel( )
 * 1771:     private function install( )
 * 1812:     private function installNothing( )
 *
 *              SECTION: Prompt
 * 1838:     private function promptCleanUp()
 *
 *              SECTION: ZZ
 * 1887:     private function zz_getCHash($str_params)
 * 1901:     public function zz_getMaxDbUid( $table )
 * 1928:     private function zz_getPathToIcons()
 * 1942:     private function zz_getFlexValues()
 *
 * TOTAL FUNCTIONS: 26
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Quick Shop Inmstaller' for the 'quickshop_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_quickshopinstaller
 * @version 3.0.0
 * @since 1.0.0
 */
class tx_quickshopinstaller_pi1 extends tslib_pibase
{
  public $prefixId      = 'tx_quickshopinstaller_pi1';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_quickshopinstaller_pi1.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'quickshop_installer';                      // The extension key.
  public $pi_checkCHash = true;


    // [array] The TypoScript configuration array
  public $conf           = false;

    // [boolean] true, if ther is any installation error.
  private $bool_error      = false;
    // [boolean]
  private $bool_topLevel    = null;
    // [array] The flexform array
  private $arr_piFlexform  = false;
    // [array] Array with the report items
  public  $arrReport       = false;
    // [array] Array with images, wrapped as HTML <img ...>
  public  $arr_icons       = false;

    // [array] Array with variables like group id, page ids ...
  public  $markerArray       = false;
    // [array] Uids of the current and the generated pages records. Titles are the keys.
  public  $arr_pageUids      = false;
    // [array] Titles of the current and the generated pages records. Uids are the keys.
  public  $arr_pageTitles    = false;
    // [array] Uids of the generated sys_templates records
  public  $arr_tsUids      = false;
    // [string] Title of the root TypoScript
  public  $str_tsRoot      = false;
    // [array] Uids of the generated tt_content records - here: plugins only
  public  $arr_pluginUids      = false;
    // [array] Uids of the generated records for different tables.
  public  $arr_recordUids      = false;
    // [array] Uids of the generated files with an timestamp
  public  $arr_fileUids      = false;
    // [array] Uids of the generated tt_content records - here: page content only
  public  $arr_contentUids      = false;

  public $str_tsWtCart = null;



 /***********************************************
  *
  * Main
  *
  **********************************************/

  /**
 * The main method of the PlugIn
 *
 * @param	string		$content: The PlugIn content
 * @param	array		$conf: The TypoScript configuration array
 * @return	The		content that is displayed on the website
 */
  public function main( $content, $conf)
  {
    unset( $content );

    $this->conf = $conf;

    $this->pi_loadLL();

      // Get values from the flexform
    $this->zz_getFlexValues();

      // Set the path to icons
    $this->zz_getPathToIcons();



      // SWITCH : What should installed?
    switch( $this->markerArray['###INSTALL_CASE###'] )
    {
      case( null ):
      case( 'disabled' ):
        if( ! $this->installNothing( ) )
        {
          $this->bool_error = true;
        }
        break;
      case( 'install_shop' ):
      case( 'install_all' ):
        if( ! $this->install( ) )
        {
          $this->bool_error = true;
        }
        break;
      default:
        $this->arrReport[ ] = '
          <p>
            switch in tx_quickshopinstaller_pi1::main has an undefined value: ' .
            $this->markerArray['###INSTALL_CASE###'].'
          </p>';
        $this->bool_error = true;
    }
      // SWITCH : What should installed?


      // SWITCH : error case
    switch( $this->bool_error )
    {
      case( true ):
        $str_result = '
          <div style="border:4px solid red;padding:2em;">
            <h1>
            ' . $this->pi_getLL( 'error_all_h1' ) . '
            </h1>
            ' . $this->htmlReport( ) . '
          </div>';
        break;
      case( false ):
      default:
        $str_result = $this->htmlReport( );
        break;
    }
      // SWITCH : error case

    return $this->pi_wrapInBaseClass( $str_result );
  }



 /***********************************************
  *
  * Confirmation
  *
  **********************************************/

  /**
 * Shop will be installed - with or without template
 *
 * @param	string		$str_installCase: install_all or install_shop
 * @return	The		content that is displayed on the website
 */
  private function confirmation()
  {
    $boolConfirmation = false;

    // RETURN  if form is confirmed
    if($this->piVars['confirm'])
    {
      $boolConfirmation = true;
      return $boolConfirmation;
    }
    // RETURN  if form is confirmed



    // Get the cHash. Important in case of realUrl and no_cache=0
    $cHash_calc = $this->zz_getCHash('&tx_quickshopinstaller_pi1[confirm]=1');

    // Confirmation form
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('confirm_header').'
      </h2>
      <p>
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createBeGroup').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createPages').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createPlugins').'<br />
      ';
      if($this->markerArray['###INSTALL_CASE###'] == 'install_all')
      {
        $this->arrReport[] = '
          '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createContent').'<br />
        ';
      }
      $this->arrReport[] = '
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createTs').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createPowermail').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createProducts').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createFiles').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createContent').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_consolidate').'<br />
      </p>
      <div style="text-align:right">
        <form name="form_confirm" method="POST">
          <fieldset id="fieldset_confirm" style="border:1px solid #F66800;padding:1em;">
            <legend style="color:#F66800;font-weight:bold;padding:0 1em;">
              '.$this->pi_getLL('confirm_header').'
            </legend>
            <input type="hidden" name="tx_quickshopinstaller_pi1[confirm]" value="1" />
            <input type="hidden" name="cHash"                              value="'.$cHash_calc.'" />
            <input type="submit" name="submit" value=" '.$this->pi_getLL('confirm_button').' " />
          </fieldset>
        </form>
      </div>';
    // Confirmation form

    $boolConfirmation = false;
    return $boolConfirmation;
  }



 /***********************************************
  *
  * Create
  *
  **********************************************/

 /**
  * create( ) :
  *
  * @return	void
  * @access private
  * @version    3.0.0
  * @since      3.0.0
  */
  private function create( )
  {
    $this->createBeGroup();
    $this->createPages();
    $this->createTyposcript();
    $this->createPlugins();

    $this->arrReport[ ] = '
      <h2>
       ' . $this->pi_getLL( 'record_create_header' ) . '
      </h2>';

    $this->createRecordsPowermail();
    $this->createRecordsQuickshop();
    $this->createFilesShop();
var_dump(__METHOD__, __LINE__ );
return;
    $this->createContent();
  }

/**
 * Shop will be installed - with or without template
 *
 * @param	string		$str_installCase: install_all or install_shop
 * @return	The		content that is displayed on the website
 */
  private function createBeGroup()
  {

    $this->markerArray['###GROUP_TITLE###'] = 'quick_shop';

    //////////////////////////////////////////////////////////////////////
    //
    // There is a group available

    $select_fields = '`uid`, `title`';
    $from_table    = '`be_groups`';
    $where_clause  = '`hidden` = 0 AND `deleted` = 0 AND `title` = "quick_shop"';
    $groupBy       = '';
    $orderBy       = '';
    $limit         = '0,1';
    $uidIndexField = '';

    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField);
    if(is_array($rows) && count($rows) > 0)
    {
      $group_uid   = $rows[0]['uid'];
      $group_title = $rows[0]['title'];
    }

    if($group_uid)
    {
      $this->markerArray['###GROUP_TITLE###'] = $group_title;
      $this->markerArray['###GROUP_UID###']   = $group_uid;

      $str_grp_prompt = '
        <h2>
         '.$this->pi_getLL('grp_ok_header').'
        </h2>
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('grp_ok_prompt').'
        </p>';
      $str_grp_prompt = $this->cObj->substituteMarkerArray($str_grp_prompt, $this->markerArray);
      $this->arrReport[] = $str_grp_prompt;
      return false;
    }
    // There is a group available



    //////////////////////////////////////////////////////////////////////
    //
    // There isn't any group available

    $timestamp = time();

    $table                    = '`be_groups`';
    $fields_values            = array( );
    $fields_values['uid']     = null;
    $fields_values['pid']     = 0;
    $fields_values['tstamp']  = $timestamp;
    $fields_values['title']   = 'quick_shop';
    $fields_values['crdate']  = $timestamp;
    $no_quote_fields          = false;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
    // There isn't any group available

    $where_clause  = '`hidden` = 0 AND `deleted` = 0 AND `title` = "quick_shop" AND `crdate` = '.$timestamp.' AND `tstamp` = '.$timestamp;

    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField);
    if(is_array($rows) && count($rows) > 0)
    {
      $group_title = $rows[0]['title'];
      $group_uid   = $rows[0]['uid'];
    }

    if($group_uid)
    {
      $this->markerArray['###GROUP_TITLE###'] = $group_title;
      $this->markerArray['###GROUP_UID###']   = $group_uid;

      $str_grp_prompt = '
        <h2>
         '.$this->pi_getLL('grp_create_header').'
        </h2>
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('grp_create_prompt').'
        </p>';
      $str_grp_prompt = $this->cObj->substituteMarkerArray($str_grp_prompt, $this->markerArray);
      $this->arrReport[] = $str_grp_prompt;
      return false;
    }

    $this->markerArray['###GROUP_UID###'] = false;

    $str_grp_prompt = '
      <h2>
       '.$this->pi_getLL('grp_warn_header').'
      </h2>
      <p>
        '.$this->arr_icons['warn'].' '.$this->pi_getLL('grp_warn_prompt').'
      </p>';
    $str_grp_prompt = $this->cObj->substituteMarkerArray($str_grp_prompt, $this->markerArray);
    $this->arrReport[] = $str_grp_prompt;
    return false;
  }

   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function createContent()
  {
    $arr_content = array( );

    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('content_create_header').'
      </h2>';



    //////////////////////////////////////////////////////////////////////
    //
    // General values

    $timestamp       = time();
    $table           = 'tt_content';
    $no_quote_fields = false;
    $uid         = $this->zz_getMaxDbUid($table);
    // General values



    //////////////////////////////////////////////////////////////////////
    //
    // Content for page shipping

    $uid = $uid +1;
    $this->arr_contentUids[$this->pi_getLL('content_shipping_header')]  = $uid;

    $arr_content[$uid]['uid']          = $uid;
    $arr_content[$uid]['pid']          = $this->arr_pageUids[$this->pi_getLL('page_title_shipping')];
    $arr_content[$uid]['tstamp']       = $timestamp;
    $arr_content[$uid]['crdate']       = $timestamp;
    $arr_content[$uid]['cruser_id']    = $this->markerArray['###BE_USER###'];
    $arr_content[$uid]['sorting']      = 256 * 1;
    $arr_content[$uid]['CType']        = 'text';
    $arr_content[$uid]['header']       = $this->pi_getLL('content_shipping_header');
    $arr_content[$uid]['bodytext']     = $this->pi_getLL('content_shipping_bodytext');
    $arr_content[$uid]['sectionIndex'] = 1;
    // Content for page shipping



    //////////////////////////////////////////////////////////////////////
    //
    // Content for page terms

    $uid = $uid +1;
    $this->arr_contentUids[$this->pi_getLL('content_terms_header')]  = $uid;

    $arr_content[$uid]['uid']          = $uid;
    $arr_content[$uid]['pid']          = $this->arr_pageUids[$this->pi_getLL('page_title_terms')];
    $arr_content[$uid]['tstamp']       = $timestamp;
    $arr_content[$uid]['crdate']       = $timestamp;
    $arr_content[$uid]['cruser_id']    = $this->markerArray['###BE_USER###'];
    $arr_content[$uid]['sorting']      = 256 * 1;
    $arr_content[$uid]['CType']        = 'text';
    $arr_content[$uid]['header']       = $this->pi_getLL('content_terms_header');
    $arr_content[$uid]['bodytext']     = $this->pi_getLL('content_terms_bodytext');
    $arr_content[$uid]['sectionIndex'] = 1;
    // Content for page terms



    //////////////////////////////////////////////////////////////////////
    //
    // Content for pages header and footer

    if($this->markerArray['###INSTALL_CASE###'] == 'install_all')
    {
      // Content for page header
      $int_root     = $GLOBALS['TSFE']->id;
      //$str_bodytext = htmlspecialchars($this->pi_getLL('content_header_bodytext'));
      $str_bodytext = $this->pi_getLL('content_header_bodytext');
      $str_bodytext = str_replace('###PID###', $int_root, $str_bodytext);

      $uid = $uid +1;
      $this->arr_contentUids[$this->pi_getLL('content_header_header')]  = $uid;

      $arr_content[$uid]['uid']           = $uid;
      $arr_content[$uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_library_header')];
      $arr_content[$uid]['tstamp']        = $timestamp;
      $arr_content[$uid]['crdate']        = $timestamp;
      $arr_content[$uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
      $arr_content[$uid]['sorting']       = 256 * 1;
      $arr_content[$uid]['CType']         = 'text';
      $arr_content[$uid]['header']        = $this->pi_getLL('content_header_header');
      $arr_content[$uid]['header_layout'] = 100;  // hidden
      $arr_content[$uid]['bodytext']      = $str_bodytext;
      $arr_content[$uid]['sectionIndex']  = 1;
      // Content for page header

      // Content for page footer
      $uid = $uid +1;
      $this->arr_contentUids[$this->pi_getLL('content_footer_header')]  = $uid;

      $arr_content[$uid]['uid']           = $uid;
      $arr_content[$uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_library_footer')];
      $arr_content[$uid]['tstamp']        = $timestamp;
      $arr_content[$uid]['crdate']        = $timestamp;
      $arr_content[$uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
      $arr_content[$uid]['sorting']       = 256 * 1;
      $arr_content[$uid]['CType']         = 'text';
      $arr_content[$uid]['header']        = $this->pi_getLL('content_footer_header');
      $arr_content[$uid]['header_layout'] = 100;  // hidden
      $arr_content[$uid]['bodytext']      = $this->pi_getLL('content_footer_bodytext');
      $arr_content[$uid]['sectionIndex']  = 1;
      // Content for page footer
    }
    // Content for pages header and footer



    //////////////////////////////////////////////////////////////////////
    //
    // INSERT content records

    foreach($arr_content as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###HEADER###']    = $fields_values['header'];
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_content_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('content_create_prompt').'
        </p>';
      $str_content_prompt = $this->cObj->substituteMarkerArray($str_content_prompt, $this->markerArray);
      $this->arrReport[] = $str_content_prompt;
    }
    unset($arr_content);
    // INSERT content records

    return false;
  }

   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function createFilesShop()
  {
    $this->arrReport[ ] = '
      <h2>
       '.$this->pi_getLL('files_create_header').'
      </h2>';



    //////////////////////////////////////////////////////////////////////
    //
    // Copy product images to upload folder

    // General values
    $str_pathSrce = t3lib_extMgm::siteRelPath( $this->extKey ) . 'res/images/products/';
    $str_pathDest = 'uploads/tx_quickshop/';
    // General values

    foreach( $this->arr_fileUids as $str_fileSrce => $str_fileDest )
    {
      $bool_success = copy( $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest );
      if( $bool_success )
      {
        $this->markerArray['###DEST###'] = $str_fileDest;
        $this->markerArray['###PATH###'] = $str_pathDest;
        $str_file_prompt = '
          <p>
            '.$this->arr_icons['ok'].' '.$this->pi_getLL('files_create_prompt').'
          </p>';
        $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
        $this->arrReport[] = $str_file_prompt;
      }
      if (!$bool_success)
      {
        $this->markerArray['###SRCE###'] = $str_pathSrce.$str_fileSrce;
        $this->markerArray['###DEST###'] = $str_pathDest.$str_fileDest;
        $str_file_prompt = '
          <p>
            '.$this->arr_icons['warn'].' '.$this->pi_getLL('files_create_prompt_error').'
          </p>';
        $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
        $this->arrReport[] = $str_file_prompt;
      }
    }
    // Copy product images to upload folder

    return false;
  }

/**
 * createPages( ) :
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function createPages( )
  {
    require_once( 'class.tx_quickshopinstaller_pi1_pages.php' );
    $this->pages        = t3lib_div::makeInstance( 'tx_quickshopinstaller_pi1_pages' );
    $this->pages->pObj  = $this;

    $this->pages->main( );
  }

/**
 * createPlugins( ) :
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function createPlugins( )
  {
    require_once( 'class.tx_quickshopinstaller_pi1_plugins.php' );
    $this->plugins       = t3lib_div::makeInstance( 'tx_quickshopinstaller_pi1_plugins' );
    $this->plugins->pObj = $this;

    $this->plugins->main( );
  }



 /***********************************************
  *
  * Create records
  *
  **********************************************/

/**
 * createRecordsPowermail( ) :
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function createRecordsPowermail( )
  {
    require_once( 'class.tx_quickshopinstaller_pi1_powermail.php' );
    $this->powermail       = t3lib_div::makeInstance( 'tx_quickshopinstaller_pi1_powermail' );
    $this->powermail->pObj = $this;

    $this->powermail->main( );
  }

/**
 * createRecordsQuickshop( ) :
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function createRecordsQuickshop( )
  {
    require_once( 'class.tx_quickshopinstaller_pi1_quickshop.php' );
    $this->quickshop       = t3lib_div::makeInstance( 'tx_quickshopinstaller_pi1_quickshop' );
    $this->quickshop->pObj = $this;

    $this->quickshop->main( );
  }

/**
 * createTyposcript( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcript( )
  {
    require_once( 'class.tx_quickshopinstaller_pi1_typoscript.php' );
    $this->typoscript       = t3lib_div::makeInstance( 'tx_quickshopinstaller_pi1_typoscript' );
    $this->typoscript->pObj = $this;

    $this->typoscript->main( );
  }



 /***********************************************
  *
  * Consolidate
  *
  **********************************************/

   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function consolidatePageCurrent()
  {
    $arr_pages    = array( );
    $arr_content  = array( );

    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('consolidate_header').'
      </h2>';



    //////////////////////////////////////////////////////////////////////
    //
    // General Values

    $dateHumanReadable        = date('Y-m-d G:i:s');
    $timestamp       = time();
    $table           = 'pages';
    $where           = 'uid = '.$GLOBALS['TSFE']->id;
    $no_quote_fields = false;
    // General Values



    //////////////////////////////////////////////////////////////////////
    //
    // UPDATE TSconfig and media

    $uid = $GLOBALS['TSFE']->id;

    $arr_pages[$uid]['title']    = $this->pi_getLL('page_title_root');
    $arr_pages[$uid]['tstamp']   = $timestamp;
    $arr_pages[$uid]['module']   = null;
    $arr_pages[$uid]['nav_hide']      = 1;
    if($this->bool_topLevel)
    {
      $arr_pages[$uid]['is_siteroot'] = 1;
    }
    if(!$this->bool_topLevel)
    {
      $arr_pages[$uid]['is_siteroot'] = 0;
    }
    $arr_pages[$uid]['media']    = 'typo3_quickshop_'.$timestamp.'.jpg';
    $arr_pages[$uid]['TSconfig'] = '

// QUICK SHOP INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

TCEMAIN {
  permissions {
    // '.$this->markerArray['###GROUP_UID###'].': '.$this->markerArray['###GROUP_TITLE###'].'
    groupid = '.$this->markerArray['###GROUP_UID###'].'
    group   = show,edit,delete,new,editcontent
  }
}

// QUICK SHOP INSTALLER at ' . $dateHumanReadable . ' -- END

';

    // UPDATE
    foreach( $arr_pages as $fields_values )
    {
      //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
      // Message
      $this->markerArray['###FIELD###']     = 'title, media, TSconfig';
      $this->markerArray['###TITLE_PID###'] = '"'.$GLOBALS['TSFE']->page['title'].'" (uid '.$GLOBALS['TSFE']->id.')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_page').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
      // Message
    }
    unset($arr_pages);
    // UPDATE

    // UPDATE TSconfig and media



      //////////////////////////////////////////////////////////////////////
      //
      // Copy header image to upload folder

      // General values
    $str_fileSrce = 'quick_shop_header_image_210px.jpg';
    $str_fileDest = 'typo3_quickshop_'.$timestamp.'.jpg';
      // 100911, dwildt, #9686
      //$str_pathSrce = t3lib_extMgm::siteRelPath('base_quickshop').'res/images/';
    $str_pathSrce = t3lib_extMgm::siteRelPath('quick_shop').'res/images/';
    $str_pathDest = 'uploads/media/';
      // General values

    // Copy
    $bool_success = copy($str_pathSrce.$str_fileSrce, $str_pathDest.$str_fileDest);
    // Copy

    // Message
    if ($bool_success)
    {
      $this->markerArray['###DEST###'] = $str_fileDest;
      $this->markerArray['###PATH###'] = $str_pathDest;
      $str_file_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('files_create_prompt').'
        </p>';
      $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
      $this->arrReport[] = $str_file_prompt;
    }
    if (!$bool_success)
    {
      $this->markerArray['###SRCE###'] = $str_pathSrce.$str_fileSrce;
      $this->markerArray['###DEST###'] = $str_pathDest.$str_fileDest;
      $str_file_prompt = '
        <p>
          '.$this->arr_icons['warn'].' '.$this->pi_getLL('files_create_prompt_error').'
        </p>';
      $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
      $this->arrReport[] = $str_file_prompt;
    }
    // Message
    // Copy product images to upload folder



    //////////////////////////////////////////////////////////////////////
    //
    // Hide the installer plugin

    // General Values
    $timestamp       = time();
    $table           = 'tt_content';
    $uid         = $this->cObj->data['uid'];
    $where           = 'uid = '.$uid;
    $no_quote_fields = false;
    // General Values

    $arr_content[$uid]['tstamp'] = $timestamp;
    $arr_content[$uid]['hidden'] = 1;

    foreach( $arr_content as $fields_values )
    {
      //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
      // Message
      $this->markerArray['###FIELD###']     = '"hidden"';
      $this->markerArray['###TITLE###']     = '"'.$this->pi_getLL('plugin_powermail_header').'"';
      $this->markerArray['###TITLE_PID###'] = '"'.$GLOBALS['TSFE']->page['title'].'" (uid '.$GLOBALS['TSFE']->id.')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_content').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
      // Message
    }
    unset($arr_content);
    // UPDATE sender and sendername



    //////////////////////////////////////////////////////////////////////
    //
    // Hide other Templates in case of install_all

    // Root page: install_all
// #9686
//    if($this->markerArray['###INSTALL_CASE###'] == 'install_all')
//    {
      // General Values
      unset($arr_content);
      $timestamp       = time();
      $table           = 'sys_template';
      $uid         = $this->arr_tsUids[$this->str_tsRoot];
      $pid             = $GLOBALS['TSFE']->id;
      $where           = 'pid = '.$pid.' AND uid NOT LIKE '.$uid;
      $no_quote_fields = false;
      // General Values

      $arr_content[$uid]['tstamp'] = $timestamp;
      $arr_content[$uid]['hidden'] = 1;

      foreach($arr_content as $fields_values)
      {
        //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
        // Message
        $this->markerArray['###TITLE_PID###'] = '"'.$GLOBALS['TSFE']->page['title'].'" (uid '.$GLOBALS['TSFE']->id.')';
        $str_consolidate_prompt = '
          <p>
            '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_template').'
          </p>';
        $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
        $this->arrReport[] = $str_consolidate_prompt;
        // Message
      }
      unset($arr_content);
//    }
    // Hide other Templates in case of install_all

    return false;

  }












   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function consolidatePluginPowermail()
  {
    $arr_plugin = array( );
//    $this->arrReport[] = '
//      <h2>
//       '.$this->pi_getLL('consolidate_header').'
//      </h2>';



    //////////////////////////////////////////////////////////////////////
    //
    // General Values

    $timestamp       = time();
    $table           = 'tt_content';
    $uid         = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $where           = 'uid = '.$uid;
    $no_quote_fields = false;
    // General Values


    //////////////////////////////////////////////////////////////////////
    //
    // UPDATE sender and sendername

    $str_sender     = ''.
      'uid'.$this->arr_recordUids[$this->pi_getLL('record_pm_field_title_email')];
    $str_sendername = ''.
      'uid'.$this->arr_recordUids[$this->pi_getLL('record_pm_field_title_firstnameBilling')].
      ','.
      'uid'.$this->arr_recordUids[$this->pi_getLL('record_pm_field_title_surnameBilling')];

    $arr_plugin[$uid]['tstamp']                  = $timestamp;
    $arr_plugin[$uid]['tx_powermail_sender']     = $str_sender;
    $arr_plugin[$uid]['tx_powermail_sendername'] = $str_sendername;

    foreach( $arr_plugin as $fields_values )
    {
      //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
      // Message
      $this->markerArray['###FIELD###']     = '"tx_powermail_sender, tx_powermail_sendername"';
      $this->markerArray['###TITLE###']     = '"'.$this->pi_getLL('plugin_powermail_header').'"';
      $this->markerArray['###TITLE_PID###'] = '"'.$this->pi_getLL('page_title_caddy').'" (uid '.$this->arr_pageUids[$this->pi_getLL('page_title_caddy')].')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_content').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
      // Message
    }
    unset($arr_plugin);
    // UPDATE sender and sendername

    return false;

  }












   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 * @version 1.0.5
 */
  private function consolidateTsWtCart()
  {
    $arr_ts = array( );
//    $this->arrReport[] = '
//      <h2>
//       '.$this->pi_getLL('consolidate_header').'
//      </h2>';



    //////////////////////////////////////////////////////////////////////
    //
    // General Values

    $timestamp       = time();
    $table           = 'sys_template';
    $uid         = $this->arr_tsUids[$this->str_tsWtCart];
    $where           = 'uid = '.$uid;
    $no_quote_fields = false;

    list($str_emailName) = explode('@', $this->markerArray['###MAIL_DEFAULT_RECIPIENT###']);
    $str_emailName       = $str_emailName.'@###DOMAIN###';
    // General Values


      //////////////////////////////////////////////////////////////////////
      //
      // UPDATE constants

    $arr_ts[$uid]['tstamp']    = $timestamp;
    $arr_ts[$uid]['constants'] = '
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
    uid = '.$this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')].'
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
    noreply  = '.$str_emailName.'
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
    foreach( $arr_ts as $fields_values )
    {
      //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
      // Message
      $this->markerArray['###FIELD###']     = '"constants"';
      $this->markerArray['###TITLE###']     = '"'.$this->str_tsWtCart.'"';
      $this->markerArray['###TITLE_PID###'] = '"'.$this->pi_getLL('page_title_caddy').'" (uid '.$this->arr_pageUids[$this->pi_getLL('page_title_caddy')].')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_content').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
      // Message
    }
    unset($arr_ts);
      // UPDATE constants

    return false;

  }



 /***********************************************
  *
  * Extensions
  *
  **********************************************/

/**
 * extensionCheck( ) :  Checks whether needed extensions are installed.
 *                      Result will stored in the global $arrReport.
 *
 * @return	void
 * @access private
 * @version   3.0.0
 * @since     1.0.0
 */
  private function extensionCheck( )
  {
    $success = true;

      // RETURN  if form is confirmed
    if( $this->piVars['confirm'] )
    {
      return $success;
    }
      // RETURN  if form is confirmed

      // Header
    $this->arrReport[ ] = '
      <h2>
       '.$this->pi_getLL('ext_header').'
      </h2>
      ';
      // Header

    if( ! $this->extensionCheckCaseBaseTemplate( ) )
    {
      $success = false;
    }

    $key    = 'browser';
    $title  = 'Browser - TYPO3 without PHP';
    if( ! $this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key    = 'caddy';
    $title  = 'Caddy - your shopping cart';
    if( ! $this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key    = 'powermail';
    $title  = 'Powermail';
    if( ! $this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key    = 'quick_shop';
    $title  = 'Quick Shop';
    if( ! $this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    return $success;

  }

/**
 * extensionCheckCaseBaseTemplate( ) :  Checks whether needed extensions are installed.
 *                      Result will stored in the global $arrReport.
 *
 * @return	void
 * @access private
 * @version   3.0.0
 * @since     1.0.0
 */
  private function extensionCheckCaseBaseTemplate( )
  {
    $success = true;
      // RETURN : base template should not installed
    if( $this->markerArray['###INSTALL_CASE###'] != 'install_all' )
    {
      return $success;
    }
      // RETURN : base template should not installed

    $key    = 'automaketemplate';
    $title  = 'Template Auto-parser';
    if( ! $this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key    = 'base_quickshop';
    $title  = 'Quick Shop - Template';
    if( ! $this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    return $success;
  }

/**
 * extensionCheckExtension( )  : Checks wether an extension ist installed or not.
 *                                Returns true in case of installtion.
 *                                Writes result in the global $arrReport.
 *
 * @param	string		$key    : extension key
 * @param	string		$title  : extension title
 * @return	boolean
 * @access private
 * @version   3.0.0
 * @since     1.0.0
 */
  private function extensionCheckExtension( $key, $title )
  {
    $boolInstalled  = null;
    $titleWiKey     = $title . ' (' . $key . ')';

      // RETURN : extension is installed
    if( t3lib_extMgm::isLoaded( $key ) )
    {
      $this->arrReport[ ] = '
        <p>
        ' . $this->arr_icons['ok'] . ' ' . $titleWiKey . ' ' . $this->pi_getLL( 'ext_ok' ) .'
        </p>';
      $boolInstalled = true;
      return $boolInstalled;
    }
      // RETURN : extension is installed

      // RETURN : extension isn't installed
    $this->arrReport[ ] = '
      <p>
        ' . $this->arr_icons['error'] . $this->pi_getLL( 'ext_error' ) . '<br />
        ' . $this->arr_icons['info']  . $this->pi_getLL( 'ext_help' )  . ' ' . $titleWiKey . '
      </p>';
    $boolInstalled = false;
    return $boolInstalled;
      // RETURN : extension isn't installed
  }



 /***********************************************
  *
  * Html
  *
  **********************************************/

/**
 * htmlReport( )
 *
 * @return	string
 */
  private function htmlReport( )
  {
      // RETURN : error, there isn't any report
    if( ! is_array( $this->arrReport ) )
    {
      $prompt = '
        <h1>
          No Report
        </h1>
        <p>
          This is a mistake!
        </p>';
      return $prompt;
    }
      // RETURN : error, there isn't any report

    $arrPrompt = array( );
    if( ! $this->bool_error )
    {
      if( ! $this->piVars['confirm'] )
      {
        $arrPrompt[ ] = '
          <h1>
            ' . $this->pi_getLL('begin_h1') . '
          </h1>';
      }
      if( $this->piVars['confirm'] )
      {
        $arrPrompt[ ] = '
          <h1>
            ' . $this->pi_getLL( 'end_h1' ) . '
          </h1>';
      }
    }
    $arrPrompt  = array_merge( $arrPrompt, $this->arrReport );
    $prompt = implode( null, $arrPrompt );

    return $prompt;
  }



 /***********************************************
  *
  * Init
  *
  **********************************************/

/**
 * initBoolTopLevel(): If current page is on the top level, $this->bool_topLevel will become true.
 *                      If not, false.
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 2.1.1
 */
  private function initBoolTopLevel( )
  {
    $select_fields  = 'pid';
    $from_table     = 'pages';
    $where_clause   = 'uid = ' . $GLOBALS['TSFE']->id;
    $groupBy        = null;
    $orderBy        = null;
    $limit          = null;
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit);
    $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

    if($row['pid'] < 1)
    {
      $this->bool_topLevel = true;
    }
    if($row['pid'] >= 1)
    {
      $this->bool_topLevel = false;
    }
  }



 /***********************************************
  *
  * Install
  *
  **********************************************/

 /**
  * install( ) :
  *
  * @return	boolean     $success  : true
  * @access     private
  * @version    3.0.0
  * @since      1.0.0
  */

  //http://forge.typo3.org/issues/9632
  //private function install($str_installCase)
  private function install( )
  {
    $success = true;

    // RETURN if there is any problem with dependencies
    if( ! $this->extensionCheck( ) )
    {
      $success = false;
      return $success;
    }
    // RETURN if there is any problem with dependencies

    $bool_confirm = $this->confirmation();
    if( ! $bool_confirm )
    {
      $success = true;
      return $success;
    }

      // 120613, dwildt, 1+
    $this->initBoolTopLevel();
    $this->create( );
var_dump(__METHOD__, __LINE__ );
return $success;
    $this->consolidatePageCurrent();
    $this->consolidatePluginPowermail();
    $this->consolidateTsWtCart();

    $this->promptCleanUp();

    return $success;
  }

 /**
  * installNothing( ) : Write a prompt to the global $arrReport
  *
  * @return	boolean		$success  : true
  * @access private
  * @version    3.0.0
  * @since      1.0.0
  */
  private function installNothing( )
  {
    $success = false;

    $this->arrReport[] = '
      <p>
        '.$this->arr_icons['warn'].$this->pi_getLL('plugin_warn').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('plugin_help').'
      </p>';

    return $success;
  }



 /***********************************************
  *
  * Prompt
  *
  **********************************************/

   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function promptCleanUp()
  {
    // Get the cHash. Important in case of realUrl and no_cache=0
    $cHash_calc = $this->zz_getCHash(false);

    $lConfCObj['typolink.']['parameter']         = $GLOBALS['TSFE']->id;
    $lConfCObj['typolink.']['additionalParams']  = '&cHash='.$cHash_calc;
    $lConfCObj['typolink.']['returnLast']        = 'url';
    // Set the TypoScript configuration array

    // Set the URL (wrap the Link)


    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('end_header').'
      </h2>
      <p>
       '.$this->arr_icons['info'].$this->pi_getLL('end_reloadBe_prompt').'<br />
       '.$this->arr_icons['info'].$this->pi_getLL('end_deletePlugin_prompt').'
      </p>
      <div style="text-align:right;">
        <form name="form_confirm" method="POST">
          <fieldset id="fieldset_confirm" style="border:1px solid #F66800;padding:1em;">
            <legend style="color:#F66800;font-weight:bold;padding:0 1em;">
              '.$this->pi_getLL('end_header').'
            </legend>
            <input type="hidden" name="cHash"  value="'.$cHash_calc.'" />
            <input type="submit" name="submit" value=" '.$this->pi_getLL('end_button').' " />
          </fieldset>
        </form>
      </div>
      ';
  }



 /***********************************************
  *
  * ZZ
  *
  **********************************************/

/**
 * Calculate the cHash md5 value
 *
 * @param	string		$str_params: URL parameter string like &tx_browser_pi1[showUid]=12&&tx_browser_pi1[cat]=1
 * @return	string		$cHash_md5: md5 value like d218cfedf9
 */
  private function zz_getCHash($str_params)
  {
    $cHash_array  = t3lib_div::cHashParams($str_params);
    $cHash_md5    = t3lib_div::shortMD5(serialize($cHash_array));

    return $cHash_md5;
  }

/**
 * zz_getMaxDbUid( )
 *
 * @param	string		$table      : the table
 * @return	integer		$int_maxUid : max uid in given table
 */
  public function zz_getMaxDbUid( $table )
  {
    $int_maxUid = false;

    $select_fields = 'max(`uid`) AS "uid"';
    $from_table    = '`'.$table.'`';
    $where_clause  = '';
    $groupBy       = '';
    $orderBy       = '';
    $limit         = '';
    $uidIndexField = '';

    //var_dump($GLOBALS['TYPO3_DB']->SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField));
    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField);

    if(is_array($rows) && count($rows) > 0)
    {
      $int_maxUid = $rows[0]['uid'];
    }
    return $int_maxUid;
  }

   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function zz_getPathToIcons()
  {
    $pathToIcons = t3lib_extMgm::siteRelPath($this->extKey).'/res/images/22x22/';
    $this->arr_icons['error'] = '<img width="22" height="22" src="'.$pathToIcons.'dialog-error.png"> ';
    $this->arr_icons['warn']  = '<img width="22" height="22" src="'.$pathToIcons.'dialog-warning.png"> ';
    $this->arr_icons['ok']    = '<img width="22" height="22" src="'.$pathToIcons.'dialog-ok-apply.png"> ';
    $this->arr_icons['info']  = '<img width="22" height="22" src="'.$pathToIcons.'dialog-information.png"> ';
  }

   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function zz_getFlexValues()
  {
      // Set defaults
      // 120613, dwildt+
    $this->markerArray['###WEBSITE_TITLE###']           = 'TYPO3 Quick Shop';
    $this->markerArray['###MAIL_SUBJECT###']            = 'TYPO3 Quick Shop - Confirmation';
    $this->markerArray['###MAIL_DEFAULT_RECIPIENT###']  = 'mail@my-domain.com';
      // 120613, dwildt+
      // Set defaults

      // Init methods for pi_flexform
    $this->pi_initPIflexForm();

      // Get values from the flexform
    $this->arr_piFlexform = $this->cObj->data['pi_flexform'];

    if( is_array( $this->arr_piFlexform ) )
    {
      foreach( ( array ) $this->arr_piFlexform['data']['sDEF']['lDEF'] as $key => $arr_value )
      {
        $this->markerArray['###'.strtoupper( $key ).'###'] = $arr_value['vDEF'];
      }
    }


    // Set the URL
    if(!isset($this->markerArray['###URL###']))
    {
      $this->markerArray['###HOST###'] = t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST');
    }
    if(!$this->markerArray['###HOST###'])
    {
      $this->markerArray['###HOST###'] = t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST');
    }
    // Set the URL

  }










}













if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/pi1/class.tx_quickshopinstaller_pi1.php']);
}