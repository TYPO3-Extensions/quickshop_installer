<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2012 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 *  102: class tx_quickshopinstaller_pi1 extends tslib_pibase
 *
 *              SECTION: Main
 *  160:     public function main( $content, $conf)
 *
 *              SECTION: Confirmation
 *  243:     private function confirmation()
 *
 *              SECTION: Counter
 *  319:     private function countPages( $pageUid )
 *
 *              SECTION: Create
 *  348:     private function create( )
 *  366:     private function createBeGroup()
 *  472:     private function createContent()
 *  614:     private function createFilesShop()
 *
 *              SECTION: Create pages
 *  679:     private function createPages( )
 *
 *              SECTION: Create plugins
 *  707:     private function createPlugins()
 *
 *              SECTION: Create records
 *  949:     private function createRecordsPowermail()
 * 1558:     private function createRecordsShop()
 *
 *              SECTION: Create TypoScript
 * 1926:     private function createTyposcript()
 *
 *              SECTION: Consolidate
 * 2233:     private function consolidatePageCurrent()
 * 2456:     private function consolidatePluginPowermail()
 * 2533:     private function consolidateTsWtCart()
 *
 *              SECTION: Extensions
 * 2675:     private function extensionCheck( )
 * 2740:     private function extensionCheckCaseBaseTemplate( )
 * 2779:     private function extensionCheckExtension( $key, $title )
 *
 *              SECTION: Html
 * 2820:     private function htmlReport( )
 *
 *              SECTION: Init
 * 2877:     private function initBoolTopLevel( )
 * 2918:     private function install( )
 * 2957:     private function installNothing( )
 *
 *              SECTION: Prompt
 * 2983:     private function promptCleanUp()
 *
 *              SECTION: ZZ
 * 3032:     private function zz_getCHash($str_params)
 * 3046:     public function zz_getMaxDbUid( $table )
 * 3073:     private function zz_getPathToIcons()
 * 3087:     private function zz_getFlexValues()
 *
 * TOTAL FUNCTIONS: 27
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
 * @version 1.0.6
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
  private $arr_tsUids      = false;
    // [string] Title of the root TypoScript
  private $str_tsRoot      = false;
    // [array] Uids of the generated tt_content records - here: plugins only
  private $arr_pluginUids      = false;
    // [array] Uids of the generated records for different tables.
  private $arr_recordUids      = false;
    // [array] Uids of the generated files with an timestamp
  private $arr_fileUids      = false;
    // [array] Uids of the generated tt_content records - here: page content only
  private $arr_contentUids      = false;

  private $str_tsWtCart = null;



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
var_dump(__METHOD__, __LINE__ );
return;
    $this->createPlugins();
    $this->createRecordsPowermail();
    $this->createRecordsShop();
    $this->createFilesShop();
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
    $int_uid         = $this->zz_getMaxDbUid($table);
    // General values



    //////////////////////////////////////////////////////////////////////
    //
    // Content for page shipping

    $int_uid = $int_uid +1;
    $this->arr_contentUids[$this->pi_getLL('content_shipping_header')]  = $int_uid;

    $arr_content[$int_uid]['uid']          = $int_uid;
    $arr_content[$int_uid]['pid']          = $this->arr_pageUids[$this->pi_getLL('page_title_shipping')];
    $arr_content[$int_uid]['tstamp']       = $timestamp;
    $arr_content[$int_uid]['crdate']       = $timestamp;
    $arr_content[$int_uid]['cruser_id']    = $this->markerArray['###BE_USER###'];
    $arr_content[$int_uid]['sorting']      = 256 * 1;
    $arr_content[$int_uid]['CType']        = 'text';
    $arr_content[$int_uid]['header']       = $this->pi_getLL('content_shipping_header');
    $arr_content[$int_uid]['bodytext']     = $this->pi_getLL('content_shipping_bodytext');
    $arr_content[$int_uid]['sectionIndex'] = 1;
    // Content for page shipping



    //////////////////////////////////////////////////////////////////////
    //
    // Content for page terms

    $int_uid = $int_uid +1;
    $this->arr_contentUids[$this->pi_getLL('content_terms_header')]  = $int_uid;

    $arr_content[$int_uid]['uid']          = $int_uid;
    $arr_content[$int_uid]['pid']          = $this->arr_pageUids[$this->pi_getLL('page_title_terms')];
    $arr_content[$int_uid]['tstamp']       = $timestamp;
    $arr_content[$int_uid]['crdate']       = $timestamp;
    $arr_content[$int_uid]['cruser_id']    = $this->markerArray['###BE_USER###'];
    $arr_content[$int_uid]['sorting']      = 256 * 1;
    $arr_content[$int_uid]['CType']        = 'text';
    $arr_content[$int_uid]['header']       = $this->pi_getLL('content_terms_header');
    $arr_content[$int_uid]['bodytext']     = $this->pi_getLL('content_terms_bodytext');
    $arr_content[$int_uid]['sectionIndex'] = 1;
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

      $int_uid = $int_uid +1;
      $this->arr_contentUids[$this->pi_getLL('content_header_header')]  = $int_uid;

      $arr_content[$int_uid]['uid']           = $int_uid;
      $arr_content[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_library_header')];
      $arr_content[$int_uid]['tstamp']        = $timestamp;
      $arr_content[$int_uid]['crdate']        = $timestamp;
      $arr_content[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
      $arr_content[$int_uid]['sorting']       = 256 * 1;
      $arr_content[$int_uid]['CType']         = 'text';
      $arr_content[$int_uid]['header']        = $this->pi_getLL('content_header_header');
      $arr_content[$int_uid]['header_layout'] = 100;  // hidden
      $arr_content[$int_uid]['bodytext']      = $str_bodytext;
      $arr_content[$int_uid]['sectionIndex']  = 1;
      // Content for page header

      // Content for page footer
      $int_uid = $int_uid +1;
      $this->arr_contentUids[$this->pi_getLL('content_footer_header')]  = $int_uid;

      $arr_content[$int_uid]['uid']           = $int_uid;
      $arr_content[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_library_footer')];
      $arr_content[$int_uid]['tstamp']        = $timestamp;
      $arr_content[$int_uid]['crdate']        = $timestamp;
      $arr_content[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
      $arr_content[$int_uid]['sorting']       = 256 * 1;
      $arr_content[$int_uid]['CType']         = 'text';
      $arr_content[$int_uid]['header']        = $this->pi_getLL('content_footer_header');
      $arr_content[$int_uid]['header_layout'] = 100;  // hidden
      $arr_content[$int_uid]['bodytext']      = $this->pi_getLL('content_footer_bodytext');
      $arr_content[$int_uid]['sectionIndex']  = 1;
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
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('files_create_header').'
      </h2>';



    //////////////////////////////////////////////////////////////////////
    //
    // Copy product images to upload folder

    // General values
    $str_pathSrce = t3lib_extMgm::siteRelPath($this->extKey).'res/images/products/';
    $str_pathDest = 'uploads/tx_quickshop/';
    // General values

    foreach($this->arr_fileUids as $str_fileSrce => $str_fileDest)
    {
      $bool_success = copy($str_pathSrce.$str_fileSrce, $str_pathDest.$str_fileDest);
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
    }
    // Copy product images to upload folder

    return false;
  }



 /***********************************************
  *
  * Create pages
  *
  **********************************************/

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
      // Class with methods for get clean values
    require_once( 'class.tx_quickshopinstaller_pi1_pages.php' );
    $this->pages            = t3lib_div::makeInstance( 'tx_quickshopinstaller_pi1_pages' );
    $this->pages->pObj      = $this;

    $this->pages->pages( );
  }



 /***********************************************
  *
  * Create plugins
  *
  **********************************************/

  /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 * @version 2.1.0
 * @since   0.0.1
 */
  private function createPlugins()
  {
    $arr_plugin = array( );

    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('plugin_create_header').'
      </h2>';



      //////////////////////////////////////////////////////////////////////
      //
      // General values

    $timestamp       = time();
    $table           = 'tt_content';
    $no_quote_fields = false;
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin browser on root page

    $int_uid = $int_uid +1;
    $strUid = sprintf ('%03d', $int_uid);

    $this->arr_pluginUids[$this->pi_getLL('plugin_browser_header')]  = $int_uid;

    $arr_plugin[$int_uid]['uid']           = $int_uid;
    $arr_plugin[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_plugin[$int_uid]['tstamp']        = $timestamp;
    $arr_plugin[$int_uid]['crdate']        = $timestamp;
    $arr_plugin[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_plugin[$int_uid]['sorting']       = 128;
    $arr_plugin[$int_uid]['CType']         = 'list';
    $arr_plugin[$int_uid]['header']        = $this->pi_getLL('plugin_browser_header');
    $arr_plugin[$int_uid]['pages']         = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_plugin[$int_uid]['header_layout'] = 100;  // hidden
    $arr_plugin[$int_uid]['list_type']     = 'browser_pi1';
    $arr_plugin[$int_uid]['sectionIndex']  = 1;
    $arr_plugin[$int_uid]['pi_flexform']   = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">Quick Shop</value>
                </field>
                <field index="limit">
                    <value index="vDEF">3</value>
                </field>
                <field index="navigation">
                    <value index="vDEF">3</value>
                </field>
            </language>
        </sheet>
        <sheet index="socialmedia">
            <language index="lDEF">
                <field index="enabled">
                    <value index="vDEF">enabled_wi_individual_template</value>
                </field>
                <field index="tablefieldTitle_list">
                    <value index="vDEF">tx_quickshop_products.title</value>
                </field>
                <field index="bookmarks_list">
                    <value index="vDEF">facebook,hype,twitter</value>
                </field>
                <field index="tablefieldTitle_single">
                    <value index="vDEF">tx_quickshop_products.title</value>
                </field>
                <field index="bookmarks_single">
                    <value index="vDEF">facebook,google,hype,live,misterwong,technorati,twitter,yahoomyweb</value>
                </field>
            </language>
        </sheet>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:quick_shop/res/v1.4/default.tmpl</value>
                </field>
                <field index="css.browser">
                    <value index="vDEF">ts</value>
                </field>
                <field index="css.jqui">
                    <value index="vDEF">smoothness</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">list_and_single</value>
                </field>
                <field index="ajaxChecklist">
                    <value index="vDEF">1</value>
                </field>
                <field index="list_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="single_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="list_on_single">
                    <value index="vDEF">single</value>
                </field>
            </language>
        </sheet>
        <sheet index="development">
            <language index="lDEF">
                <field index="handle_marker">
                    <value index="vDEF">remove_empty_markers</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';
      // Plugin browser on root page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin wtcart on cart page

    $int_uid = $int_uid +1;
    $strUid = sprintf ('%03d', $int_uid);

    $this->arr_pluginUids[$this->pi_getLL('plugin_wtcart_header')]  = $int_uid;

    $arr_plugin[$int_uid]['uid']           = $int_uid;
    $arr_plugin[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_plugin[$int_uid]['tstamp']        = $timestamp;
    $arr_plugin[$int_uid]['crdate']        = $timestamp;
    $arr_plugin[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_plugin[$int_uid]['sorting']       = 256;
    $arr_plugin[$int_uid]['CType']         = 'list';
    $arr_plugin[$int_uid]['header']        = $this->pi_getLL('plugin_wtcart_header');
    $arr_plugin[$int_uid]['list_type']     = 'wt_cart_pi1';
    $arr_plugin[$int_uid]['sectionIndex']  = 1;
      // Plugin wtcart on cart page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin powermail on cart page

    $int_uid = $int_uid +1;
    $strUid = sprintf ('%03d', $int_uid);

    $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')]  = $int_uid;

    $arr_plugin[$int_uid]['uid']                        = $int_uid;
    $arr_plugin[$int_uid]['pid']                        = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_plugin[$int_uid]['tstamp']                     = $timestamp;
    $arr_plugin[$int_uid]['crdate']                     = $timestamp;
    $arr_plugin[$int_uid]['cruser_id']                  = $this->markerArray['###BE_USER###'];
    $arr_plugin[$int_uid]['sorting']                    = 512;
    $arr_plugin[$int_uid]['CType']                      = 'powermail_pi1';
    $arr_plugin[$int_uid]['header']                     = $this->pi_getLL('plugin_powermail_header');
    $arr_plugin[$int_uid]['header_layout']              = 100;  // hidden
    $arr_plugin[$int_uid]['list_type']                  = '';
    $arr_plugin[$int_uid]['sectionIndex']               = 1;
    $arr_plugin[$int_uid]['tx_powermail_title']         = 'order';
    $arr_plugin[$int_uid]['tx_powermail_recipient']     = $this->markerArray['###MAIL_DEFAULT_RECIPIENT###'];
    $arr_plugin[$int_uid]['tx_powermail_subject_r']     = $this->markerArray['###MAIL_SUBJECT###'];
    $arr_plugin[$int_uid]['tx_powermail_subject_s']     = $this->markerArray['###MAIL_SUBJECT###'];
// Will updated by $this->consolidatePluginPowermail()
//    $arr_plugin[$int_uid]['tx_powermail_sender']        = $str_sender;
//    $arr_plugin[$int_uid]['tx_powermail_sendername']    = $str_sendername;
    $arr_plugin[$int_uid]['tx_powermail_confirm']       = 1;
    $arr_plugin[$int_uid]['tx_powermail_pages']         = false;
    $arr_plugin[$int_uid]['tx_powermail_multiple']      = 0;
    $arr_plugin[$int_uid]['tx_powermail_recip_table']   = 0;
    $arr_plugin[$int_uid]['tx_powermail_recip_id']      = false;
    $arr_plugin[$int_uid]['tx_powermail_recip_field']   = false;
    $arr_plugin[$int_uid]['tx_powermail_thanks']        = $this->pi_getLL('plugin_powermail_thanks');
    $arr_plugin[$int_uid]['tx_powermail_mailsender']    = '###POWERMAIL_TYPOSCRIPT_CART###'."\n".'###POWERMAIL_ALL###';
    $arr_plugin[$int_uid]['tx_powermail_mailreceiver']  = '###POWERMAIL_TYPOSCRIPT_CART###'."\n".'###POWERMAIL_ALL###';
    $arr_plugin[$int_uid]['tx_powermail_redirect']      = false;
    $arr_plugin[$int_uid]['tx_powermail_fieldsets']     = 4;
    $arr_plugin[$int_uid]['tx_powermail_users']         = 0;
    $arr_plugin[$int_uid]['tx_powermail_preview']       = 0;
      // Plugin powermail on cart page



      //////////////////////////////////////////////////////////////////////
      //
      // INSERT all plugins

    foreach( $arr_plugin as $fields_values )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###HEADER###']    = $fields_values['header'];
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_plugin_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('plugin_create_prompt').'
        </p>';
      $str_plugin_prompt = $this->cObj->substituteMarkerArray($str_plugin_prompt, $this->markerArray);
      $this->arrReport[] = $str_plugin_prompt;
    }
    unset($arr_plugin);

      // INSERT all plugins

    return false;
  }



 /***********************************************
  *
  * Create records
  *
  **********************************************/

   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function createRecordsPowermail()
  {
    $arr_records = array( );

    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('record_create_header').'
      </h2>';



    //////////////////////////////////////////////////////////////////////
    //
    // General values for fieldsets

    $timestamp       = time();
    $table           = 'tx_powermail_fieldsets';
    $no_quote_fields = false;
    $int_uid         = $this->zz_getMaxDbUid($table);
    $max_uid         = $int_uid;
    // General values for fieldsets



    //////////////////////////////////////////////////////////////////////
    //
    // Powermail fieldsets records in page cart

    // Billing Address
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_billingAddress')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_fSets_title_billingAddress');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['tt_content']    = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $arr_records[$int_uid]['felder']        = '5';
    // Billing Address

    // Delivery Address
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_deliveryAddress')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_fSets_title_deliveryAddress');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['tt_content']    = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $arr_records[$int_uid]['felder']        = '5';
    // Delivery Address

    // Contact Data
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_contactData')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_fSets_title_contactData');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['tt_content']    = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $arr_records[$int_uid]['felder']        = '3';
    // Contact Data

    // Order
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_order')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_fSets_title_order');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['tt_content']    = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $arr_records[$int_uid]['felder']        = '5';
    // Order
    // Powermail fieldsets records in page cart



    //////////////////////////////////////////////////////////////////////
    //
    // INSERT fieldset records

    foreach( $arr_records as $fields_values )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $this->pi_getLL($table);
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
    // INSERT fieldset records



    //////////////////////////////////////////////////////////////////////
    //
    // General values for fields

    $timestamp       = time();
    $table           = 'tx_powermail_fields';
    $no_quote_fields = false;
    $int_uid         = $this->zz_getMaxDbUid($table);
    $max_uid         = $int_uid;
    // General values for fields



    //////////////////////////////////////////////////////////////////////
    //
    // Powermail fields records in page cart - for fieldset billing address

    // Surname
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_surnameBilling')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_surnameBilling');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_billingAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
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
    // Surname

    // First Name
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_firstnameBilling')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_firstnameBilling');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_billingAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
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
    // First Name

    // Street
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_streetBilling')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_streetBilling');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_billingAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
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
    // Street

    // Zip
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_zipBilling')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_zipBilling');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_billingAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
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
    // Zip

    // Location
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_locationBilling')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_locationBilling');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_billingAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
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
    // Location
    // Powermail fields records in page cart - for fieldset billing address



    //////////////////////////////////////////////////////////////////////
    //
    // Powermail fields records in page cart - for fieldset delivery address

    // Surname
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_surnameDelivery')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_surnameDelivery');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_deliveryAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
    // Surname

    // First Name
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_firstnameDelivery')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_firstnameDelivery');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_deliveryAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
    // First Name

    // Street
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_streetDelivery')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_streetDelivery');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_deliveryAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
    // Street

    // Zip
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_zipDelivery')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_zipDelivery');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_deliveryAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
    // Zip

    // Location
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_locationDelivery')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_locationDelivery');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_deliveryAddress')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
    // Location
    // Powermail fields records in page cart - for fieldset delivery address



    //////////////////////////////////////////////////////////////////////
    //
    // Powermail fields records in page cart - for fieldset contact

    // E-mail
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_email')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_email');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_contactData')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
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
    // E-mail

    // Phone
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_phone')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_phone');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_contactData')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
    // Phone

    // Fax
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_fax')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_fax');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_contactData')];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
    // Fax
    // Powermail fields records in page cart - for fieldset contact



    //////////////////////////////////////////////////////////////////////
    //
    // Powermail fields records in page cart - for fieldset order

    // Note
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_note')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_note');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_order')];
    $arr_records[$int_uid]['formtype']      = 'textarea';
    $arr_records[$int_uid]['flexform']      = ''.
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
    // Note

    // Payment
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_methodOfPayment')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_methodOfPayment');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_order')];
    $arr_records[$int_uid]['formtype']      = 'radio';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="options">
                    <value index="vDEF">'.$this->pi_getLL('phrases_powermail_payment').'</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
    // Payment

    // Shipping
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_methodOfShipping')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_methodOfShipping');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_order')];
    $arr_records[$int_uid]['formtype']      = 'radio';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="options">
                    <value index="vDEF">'.$this->pi_getLL('phrases_powermail_shipping').'</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
    // Shipping

    // Terms and Conditions
    $int_terms = $this->arr_pageUids[$this->pi_getLL('page_title_terms')];
    $str_terms = htmlspecialchars($this->pi_getLL('phrases_powermail_termsAccepted'));
    $str_terms = str_replace('###PID###', $int_terms, $str_terms);

    $int_uid = $int_uid +1;

    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_terms')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_terms');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_order')];
    $arr_records[$int_uid]['formtype']      = 'check';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="options">
                    <value index="vDEF">'.$str_terms.'</value>
                </field>
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
    // Terms and Conditions

    // Submit
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_pm_field_title_submit')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_submit');
    $arr_records[$int_uid]['sorting']       = 256 * ($int_uid - $max_uid);
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids[$this->pi_getLL('record_pm_fSets_title_order')];
    $arr_records[$int_uid]['formtype']      = 'submit';
    $arr_records[$int_uid]['flexform']      = '';
    // Submit
    // Powermail fields records in page cart - for fieldset order



    //////////////////////////////////////////////////////////////////////
    //
    // INSERT field records

    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $this->pi_getLL($table);
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
    // INSERT field records

    return false;
  }














   /**
 * Shop will be installed - with or without template
 *
 * @return	The		content that is displayed on the website
 */
  private function createRecordsShop()
  {
    $arr_records = array( );

    //////////////////////////////////////////////////////////////////////
    //
    // Categorie records in sysfolder products

    // General values
    $timestamp       = time();
    $table           = 'tx_quickshop_categories';
    $no_quote_fields = false;
    $dateHumanReadable        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
    // General values

    // Books
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_books')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_qs_cat_title_books');
    // Books

    // Clothes
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_clothes')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_qs_cat_title_clothes');
    // Clothes

    // Cups
    $int_uid = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_cups')]  = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']        = $timestamp;
    $arr_records[$int_uid]['crdate']        = $timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_qs_cat_title_cups');
    // Cups

    // Add records to database
    foreach( $arr_records as $fields_values )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $this->pi_getLL($table);
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
    // Add records to database

    // Categorie records in sysfolder products



    //////////////////////////////////////////////////////////////////////
    //
    // Product records in sysfolder products

    // General values
    $timestamp       = time();
    $table           = 'tx_quickshop_products';
    $no_quote_fields = false;
    $dateHumanReadable        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
    // General values

    // Book
    $int_uid   = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_book')]  = $int_uid;
    $str_image = $this->pi_getLL('record_qs_prod_image_book');
    $str_image = str_replace('###TIMESTAMP###', $timestamp, $str_image);
    $this->arr_fileUids[$this->pi_getLL('record_qs_prod_image_book')] = $str_image;
    $arr_records[$int_uid]['uid']            = $int_uid;
    $arr_records[$int_uid]['pid']            = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']         = $timestamp;
    $arr_records[$int_uid]['crdate']         = $timestamp;
    $arr_records[$int_uid]['cruser_id']      = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['sku']            = $this->pi_getLL('record_qs_prod_sku_book');
    $arr_records[$int_uid]['title']          = $this->pi_getLL('record_qs_prod_title_book');
    $arr_records[$int_uid]['short']          = $this->pi_getLL('record_qs_prod_short_book');
    $arr_records[$int_uid]['description']    = $this->pi_getLL('record_qs_prod_description_book');
    $arr_records[$int_uid]['category']       = 1;
    $arr_records[$int_uid]['price']          = $this->pi_getLL('record_qs_prod_price_book');
    $arr_records[$int_uid]['tax']            = $this->pi_getLL('record_qs_prod_tax_book');
    $arr_records[$int_uid]['in_stock']       = $this->pi_getLL('record_qs_prod_inStock_book');
    $arr_records[$int_uid]['image']          = $str_image;
    $arr_records[$int_uid]['caption']        = $this->pi_getLL('record_qs_prod_caption_book');
    $arr_records[$int_uid]['imageseo']       = $this->pi_getLL('record_qs_prod_caption_book');
    $arr_records[$int_uid]['imagewidth']     = '140';
      // 8: below, center
    $arr_records[$int_uid]['imageorient']    = '8';
    $arr_records[$int_uid]['imagecols']      = '1';
    $arr_records[$int_uid]['image_zoom']     = '1';
    $arr_records[$int_uid]['image_noRows']   = '1';
    // Book

    // Basecap Blue
    $int_uid   = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_capBlue')]  = $int_uid;
    $str_image = $this->pi_getLL('record_qs_prod_image_capBlue');
    $str_image = str_replace('###TIMESTAMP###', $timestamp, $str_image);
    $this->arr_fileUids[$this->pi_getLL('record_qs_prod_image_capBlue')] = $str_image;
    $arr_records[$int_uid]['uid']            = $int_uid;
    $arr_records[$int_uid]['pid']            = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']         = $timestamp;
    $arr_records[$int_uid]['crdate']         = $timestamp;
    $arr_records[$int_uid]['cruser_id']      = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['sku']            = $this->pi_getLL('record_qs_prod_sku_capBlue');
    $arr_records[$int_uid]['title']          = $this->pi_getLL('record_qs_prod_title_capBlue');
    $arr_records[$int_uid]['short']          = $this->pi_getLL('record_qs_prod_short_capBlue');
    $arr_records[$int_uid]['description']    = $this->pi_getLL('record_qs_prod_description_capBlue');
    $arr_records[$int_uid]['category']       = 1;
    $arr_records[$int_uid]['price']          = $this->pi_getLL('record_qs_prod_price_capBlue');
    $arr_records[$int_uid]['tax']            = $this->pi_getLL('record_qs_prod_tax_capBlue');
    $arr_records[$int_uid]['in_stock']       = $this->pi_getLL('record_qs_prod_inStock_capBlue');
    $arr_records[$int_uid]['image']          = $str_image;
    $arr_records[$int_uid]['caption']        = $this->pi_getLL('record_qs_prod_caption_capBlue');
    $arr_records[$int_uid]['imageseo']       = $this->pi_getLL('record_qs_prod_caption_capBlue');
    $arr_records[$int_uid]['imagewidth']     = '600';
      // 0: above, center
    $arr_records[$int_uid]['imageorient']    = '0';
    $arr_records[$int_uid]['imagecols']      = '1';
    $arr_records[$int_uid]['image_zoom']     = '1';
    $arr_records[$int_uid]['image_noRows']   = '1';
    // Basecap Blue

    // Basecap Green
    $int_uid   = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_capGreen')]  = $int_uid;
    $str_image = $this->pi_getLL('record_qs_prod_image_capGreen');
    $str_image = str_replace('###TIMESTAMP###', $timestamp, $str_image);
    $this->arr_fileUids[$this->pi_getLL('record_qs_prod_image_capGreen')] = $str_image;
    $arr_records[$int_uid]['uid']            = $int_uid;
    $arr_records[$int_uid]['pid']            = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']         = $timestamp;
    $arr_records[$int_uid]['crdate']         = $timestamp;
    $arr_records[$int_uid]['cruser_id']      = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['sku']            = $this->pi_getLL('record_qs_prod_sku_capGreen');
    $arr_records[$int_uid]['title']          = $this->pi_getLL('record_qs_prod_title_capGreen');
    $arr_records[$int_uid]['short']          = $this->pi_getLL('record_qs_prod_short_capGreen');
    $arr_records[$int_uid]['description']    = $this->pi_getLL('record_qs_prod_description_capGreen');
    $arr_records[$int_uid]['category']       = 1;
    $arr_records[$int_uid]['price']          = $this->pi_getLL('record_qs_prod_price_capGreen');
    $arr_records[$int_uid]['tax']            = $this->pi_getLL('record_qs_prod_tax_capGreen');
    $arr_records[$int_uid]['in_stock']       = $this->pi_getLL('record_qs_prod_inStock_capGreen');
    $arr_records[$int_uid]['image']          = $str_image;
    $arr_records[$int_uid]['caption']        = $this->pi_getLL('record_qs_prod_caption_capGreen');
    $arr_records[$int_uid]['imageseo']       = $this->pi_getLL('record_qs_prod_caption_capGreen');
    $arr_records[$int_uid]['imagewidth']     = '200';
      // 26: in text, left
    $arr_records[$int_uid]['imageorient']    = '26';
    $arr_records[$int_uid]['imagecols']      = '1';
    $arr_records[$int_uid]['image_zoom']     = '1';
    $arr_records[$int_uid]['image_noRows']   = '1';
    // Basecap Green

    // Basecap Red
    $int_uid   = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_capRed')]  = $int_uid;
    $str_image = $this->pi_getLL('record_qs_prod_image_capRed');
    $str_image = str_replace('###TIMESTAMP###', $timestamp, $str_image);
    $this->arr_fileUids[$this->pi_getLL('record_qs_prod_image_capRed')] = $str_image;
    $arr_records[$int_uid]['uid']            = $int_uid;
    $arr_records[$int_uid]['pid']            = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']         = $timestamp;
    $arr_records[$int_uid]['crdate']         = $timestamp;
    $arr_records[$int_uid]['cruser_id']      = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['sku']            = $this->pi_getLL('record_qs_prod_sku_capRed');
    $arr_records[$int_uid]['title']          = $this->pi_getLL('record_qs_prod_title_capRed');
    $arr_records[$int_uid]['short']          = $this->pi_getLL('record_qs_prod_short_capRed');
    $arr_records[$int_uid]['description']    = $this->pi_getLL('record_qs_prod_description_capRed');
    $arr_records[$int_uid]['category']       = 1;
    $arr_records[$int_uid]['price']          = $this->pi_getLL('record_qs_prod_price_capRed');
    $arr_records[$int_uid]['tax']            = $this->pi_getLL('record_qs_prod_tax_capRed');
    $arr_records[$int_uid]['in_stock']       = $this->pi_getLL('record_qs_prod_inStock_capRed');
    $arr_records[$int_uid]['image']          = $str_image;
    $arr_records[$int_uid]['caption']        = $this->pi_getLL('record_qs_prod_caption_capRed');
    $arr_records[$int_uid]['imageseo']       = $this->pi_getLL('record_qs_prod_caption_capRed');
    $arr_records[$int_uid]['imagewidth']     = '200';
      // 26: in text, left
    $arr_records[$int_uid]['imageorient']    = '26';
    $arr_records[$int_uid]['imagecols']      = '1';
    $arr_records[$int_uid]['image_zoom']     = '1';
    $arr_records[$int_uid]['image_noRows']   = '1';
    // Basecap Red

    // Cup
    $int_uid   = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_cup')]  = $int_uid;
    $str_image = $this->pi_getLL('record_qs_prod_image_cup');
    $str_image = str_replace('###TIMESTAMP###', $timestamp, $str_image);
    $this->arr_fileUids[$this->pi_getLL('record_qs_prod_image_cup')] = $str_image;
    $arr_records[$int_uid]['uid']            = $int_uid;
    $arr_records[$int_uid]['pid']            = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']         = $timestamp;
    $arr_records[$int_uid]['crdate']         = $timestamp;
    $arr_records[$int_uid]['cruser_id']      = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['sku']            = $this->pi_getLL('record_qs_prod_sku_cup');
    $arr_records[$int_uid]['title']          = $this->pi_getLL('record_qs_prod_title_cup');
    $arr_records[$int_uid]['short']          = $this->pi_getLL('record_qs_prod_short_cup');
    $arr_records[$int_uid]['description']    = $this->pi_getLL('record_qs_prod_description_cup');
    $arr_records[$int_uid]['category']       = 1;
    $arr_records[$int_uid]['price']          = $this->pi_getLL('record_qs_prod_price_cup');
    $arr_records[$int_uid]['tax']            = $this->pi_getLL('record_qs_prod_tax_cup');
    $arr_records[$int_uid]['in_stock']       = $this->pi_getLL('record_qs_prod_inStock_cup');
    $arr_records[$int_uid]['image']          = $str_image;
    $arr_records[$int_uid]['caption']        = $this->pi_getLL('record_qs_prod_caption_cup');
    $arr_records[$int_uid]['imageseo']       = $this->pi_getLL('record_qs_prod_caption_cup');
    $arr_records[$int_uid]['imagewidth']     = '200';
      // 26: in text, left
    $arr_records[$int_uid]['imageorient']    = '26';
    $arr_records[$int_uid]['imagecols']      = '1';
    $arr_records[$int_uid]['image_zoom']     = '1';
    $arr_records[$int_uid]['image_noRows']   = '1';
    // Cup

    // Pullover
    $int_uid   = $int_uid +1;
    $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_pullover')]  = $int_uid;
    $str_image = $this->pi_getLL('record_qs_prod_image_pullover');
    $str_image = str_replace('###TIMESTAMP###', $timestamp, $str_image);
    $this->arr_fileUids[$this->pi_getLL('record_qs_prod_image_pullover')] = $str_image;
    $arr_records[$int_uid]['uid']            = $int_uid;
    $arr_records[$int_uid]['pid']            = $this->arr_pageUids[$this->pi_getLL('page_title_products')];
    $arr_records[$int_uid]['tstamp']         = $timestamp;
    $arr_records[$int_uid]['crdate']         = $timestamp;
    $arr_records[$int_uid]['cruser_id']      = $this->markerArray['###BE_USER###'];
    $arr_records[$int_uid]['sku']            = $this->pi_getLL('record_qs_prod_sku_pullover');
    $arr_records[$int_uid]['title']          = $this->pi_getLL('record_qs_prod_title_pullover');
    $arr_records[$int_uid]['short']          = $this->pi_getLL('record_qs_prod_short_pullover');
    $arr_records[$int_uid]['description']    = $this->pi_getLL('record_qs_prod_description_pullover');
    $arr_records[$int_uid]['category']       = 1;
    $arr_records[$int_uid]['price']          = $this->pi_getLL('record_qs_prod_price_pullover');
    $arr_records[$int_uid]['tax']            = $this->pi_getLL('record_qs_prod_tax_pullover');
    $arr_records[$int_uid]['in_stock']       = $this->pi_getLL('record_qs_prod_inStock_pullover');
    $arr_records[$int_uid]['image']          = $str_image;
    $arr_records[$int_uid]['caption']        = $this->pi_getLL('record_qs_prod_caption_pullover');
    $arr_records[$int_uid]['imageseo']       = $this->pi_getLL('record_qs_prod_caption_pullover');
    $arr_records[$int_uid]['imagewidth']     = '200';
      // 17: in text, right
    $arr_records[$int_uid]['imageorient']    = '17';
    $arr_records[$int_uid]['imagecols']      = '1';
    $arr_records[$int_uid]['image_zoom']     = '1';
    $arr_records[$int_uid]['image_noRows']   = '1';
    // Pullover

    // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $this->pi_getLL($table);
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
    // Add records to database

    // Product records in sysfolder products



    //////////////////////////////////////////////////////////////////////
    //
    // MM relation products and categorie records in sysfolder products

    // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_quickshop_products_category_mm';

    // Books
    $int_uid   = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_book')];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_books')];
    $arr_records[$int_uid]['sorting']     = 1;
    // Books

    // Base caps
    $int_uid   = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_capBlue')];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_clothes')];
    $arr_records[$int_uid]['sorting']     = 1;
    $int_uid   = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_capGreen')];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_clothes')];
    $arr_records[$int_uid]['sorting']     = 1;
    $int_uid   = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_capRed')];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_clothes')];
    $arr_records[$int_uid]['sorting']     = 1;
    // Base caps

    // Cup
    $int_uid   = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_cup')];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_cups')];
    $arr_records[$int_uid]['sorting']     = 1;
    // Cup

    // Pullover
    $int_uid   = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids[$this->pi_getLL('record_qs_prod_title_pullover')];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids[$this->pi_getLL('record_qs_cat_title_clothes')];
    $arr_records[$int_uid]['sorting']     = 1;
    // Pullover

//var_dump($this->arr_recordUids);
    // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
    }
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    //$this->markerArray['###TABLE###']   = $this->pi_getLL($table);
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
    // Add records to database

    // Categorie records in sysfolder products

    return false;
  }



 /***********************************************
  *
  * Create TypoScript
  *
  **********************************************/

/**
 * createTyposcript( )
 *
 * @return  void
 * @access  private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcript( )
  {
    $records = array( );

    $this->arrReport[ ] = '
      <h2>
       '.$this->pi_getLL('ts_create_header').'
      </h2>';

    $records = $this->createTyposcriptRecords( );
    $this->createTyposcriptSqlInsert( $records );
  }

/**
 * createTyposcriptRecordCaddy( )
 *
 * @return	array		$record : the TypoScript record
 * @access  private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcriptRecordCaddy( $uid )
  {
    $record = null;
    
    $strUid = sprintf( '%03d', $uid );

    $title = strtolower( $this->pi_getLL( 'page_title_caddy' ) );
    $title = str_replace( ' ', null, $title );
    $title = '+page_' . $title . '_' . $strUid;

    $this->str_tsWtCart = $title;
    $this->arr_tsUids[$this->str_tsWtCart]   = $uid;
    
    $record['title']               = $title;
    $record['uid']                 = $uid;
    $record['pid']                 = $this->arr_pageUids[$this->pi_getLL('page_title_caddy')];
    $record['tstamp']              = time( );
    $record['sorting']             = 256;
    $record['crdate']              = time( );
    $record['cruser_id']           = $this->markerArray['###BE_USER###'];
    $record['include_static_file'] = ''.
      'EXT:wt_cart/files/static/,' .
      'EXT:powermail/static/pi1/,' .
      'EXT:powermail/static/css_basic/';
    // See $this->consolidateTsWtCart()
    //$record['constants']           = '';
    $record['config']           = '
  //////////////////////////////////////////
  //
  // INDEX
  //
  // page
  // plugin.tx_powermail_pi1
  // plugin.tx_wtcart_pi1



  //////////////////////////////////////////
  //
  // page

page {
  includeCSS {
    // remove the cart default css
    file3456     >
  }
}
  // page



  //////////////////////////////////////////
  //
  // plugin.tx_powermail_pi1

plugin.tx_powermail_pi1 {
  email {
    sender_mail {
      sender {
        name {
          value = Quick Shop
        }
        email {
          value = ' . $this->markerArray['###MAIL_DEFAULT_RECIPIENT###'] . '
        }
      }
    }
  }
  _LOCAL_LANG {
    default {
      locallangmarker_confirmation_submit = Order without costs and without delivering!
    }
    de {
      locallangmarker_confirmation_submit = Kostenlos bestellen, nichts bekommen!
    }
  }
}
  // plugin.tx_powermail_pi1



  //////////////////////////////////////////
  //
  // plugin.tx_wtcart_pi1

plugin.tx_wtcart_pi1 {
  _LOCAL_LANG {
    default {
      wtcart_ll_sku = Produkt-ID
    }
    de {
      wtcart_ll_sku = Bestellnummer
    }
  }
}
  // plugin.tx_wtcart_pi1
';
    // Cart page

    return $record;
  }

/**
 * createTyposcriptRecordRoot( )
 *
 * @return	array
 * @access  private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcriptRecordRoot( $uid )
  {
    $strUid = sprintf( '%03d', $uid );
    $this->str_tsRoot = 'page_quickshop_' . $strUid;
    $this->arr_tsUids[$this->str_tsRoot] = $uid;

      // SWITCH : install case
    switch( true )
    {
      case( $this->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $record = $this->createTyposcriptRecordRootCaseAll( $uid );
        break;
      case( $this->markerArray['###INSTALL_CASE###'] == 'install_shop' ):
        $record = $this->createTyposcriptRecordRootCaseShop( $uid );
        break;
    }
      // SWITCH : install case
    
    return $record;
  }

/**
 * createTyposcriptRecordRootCaseAll( )
 *
 * @return	array		$record : the TypoScript record
 * @access  private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcriptRecordRootCaseAll( $uid )
  {
    $record = null;

    $strUid = sprintf ('%03d', $uid);

    $title  = strtolower( $GLOBALS['TSFE']->page['title'] );
    $title  = str_replace( ' ', null, $title );
    $title  = 'page_' . $title . '_' . $strUid;

    $this->str_tsRoot = $title;
    $this->arr_tsUids[$this->str_tsRoot] = $uid;

    $record['title']                = $title;
    $record['uid']                  = $uid;
    $record['pid']                  = $this->arr_pageUids[$this->pi_getLL( 'page_title_root' )];
    $record['tstamp']               = time( );
    $record['sorting']              = 256;
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->markerArray['###BE_USER###'];
    $record['sitetitle']            = $this->markerArray['###WEBSITE_TITLE###'];
    $record['root']                 = 1;
    $record['clear']                = 3;  // Clear all
    $record['include_static_file']  = '' .
      'EXT:css_styled_content/static/,EXT:base_quickshop/static/base_quickshop/,'.
      'EXT:browser/static/,EXT:quick_shop/static/';
    $record['includeStaticAfterBasedOn'] = 1;
    $record['config']                    = ''.
'config {
  baseURL            = ' . $this->markerArray['###HOST###'] . '/
  metaCharset        = UTF-8
  tx_realurl_enable  = 0
  no_cache           = 1
  language           = ' . $GLOBALS['TSFE']->lang . '
  htmlTag_langKey    = ' . $GLOBALS['TSFE']->lang . '
}


  ////////////////////////////////////////////////////////
  //
  // ajax page object

  // Add this snippet into the setup of the TypoScript
  // template of your page.
  // Use \'page\', if the name of your page object is \'page\'
  // (this is a default but there isn\'t any rule)

[globalString = GP:tx_browser_pi1|segment=single] || [globalString = GP:tx_browser_pi1|segment=list] || [globalString = GP:tx_browser_pi1|segment=searchform]
  page >
  page < plugin.tx_browser_pi1.javascript.ajax.page
[global]
  // ajax page object

  // TYPO3-Browser: ajax page object II. In case of localisation: Configure the id of sys_languagein the Constant Editor. Move in this line ...jQuery.default to ...jQuery.de (i.e.)
browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery

';

    $record['constants'] = ''.
'myConst {
  //host = '.$this->markerArray['###HOST###'].'/
  pages {
    quick_shop = ' . $this->arr_pageUids[$GLOBALS['TSFE']->page['title']] . '
    quick_shop {
      cart      = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_caddy' )] . '
      shipping  = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_shipping' )] . '
      terms     = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_terms' )] . '
      libraries = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_library' )].'
      libraries {
        header  = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_library_header' )].'
        footer  = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_library_footer' )].'
      }
    }
  }
  paths {
    res  = EXT:base_quickshop/res/
    html = EXT:base_quickshop/res/html/
    css  = EXT:base_quickshop/res/html/css/
  }
  files {
    html {
      template = index.html
      css      = basic.css
      favicon  = images/favicon.ico
    }
  }
  dims {
    header_image {
      maxW = 210
      maxH = 420
    }
  }
  words {
    // HTML a href title tag for menu item rootpage
    title_tag_quick_shop_page = ' . $this->pi_getLL( 'phrases_ts_titleTag_quickshop_page' ) . '
  }
}';
    $record['description'] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    $record['include_static_file'] = null .
      'EXT:css_styled_content/static/,EXT:base_quickshop/static/base_quickshop/,' .
      'EXT:browser/static/,EXT:quick_shop/static/';

    return $record;
  }

/**
 * createTyposcriptRecordRootCaseShopOnly( )
 *
 * @return	array		$record : the TypoScript record
 * @access  private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcriptRecordRootCaseShopOnly( $uid )
  {
    $record = null;
    
    $strUid = sprintf( '%03d', $uid );

    $title = strtolower( $GLOBALS['TSFE']->page['title'] );
    $title = str_replace( ' ', null, $title );
    $title = '+page_' . $title . '_' . $strUid;

    $this->str_tsRoot = $title;
    $this->arr_tsUids[$this->str_tsRoot] = $uid;

    $record['title']                      = $title;
    $record['uid']                        = $uid;
    $record['pid']                        = $this->arr_pageUids[$this->pi_getLL( 'page_title_root' )];
    $record['tstamp']                     = time( );
    $record['sorting']                    = 256;
    $record['crdate']                     = time( );
    $record['cruser_id']                  = $this->markerArray['###BE_USER###'];
    $record['root']                       = 0;
    $record['clear']                      = 0;  // Clear nothing
    $record['includeStaticAfterBasedOn']  = 0;
    $record['config']                     = ''.
'config {
  no_cache = 1
}
';
    $record['constants']           = ''.
'myConst {
  //host = '.$this->markerArray['###HOST###'].'/
  pages {
    quick_shop = ' . $this->arr_pageUids[$GLOBALS['TSFE']->page['title']] . '
    quick_shop {
      cart      = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_caddy' )] . '
      shipping  = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_shipping' )] . '
      terms     = ' . $this->arr_pageUids[$this->pi_getLL( 'page_title_terms' )] . '
    }
  }
  dims {
    header_image {
      maxW = 210
      maxH = 420
    }
  }
  words {
    // HTML a href title tag for menu item rootpage
    title_tag_quick_shop_page = ' . $this->pi_getLL( 'phrases_ts_titleTag_quickshop_page' ) . '
  }
}';

    $record['description'] = '// Created by QUICK SHOP INSTALLER at ' . date( 'Y-m-d G:i:s' );

    $record['include_static_file'] = null .
      'EXT:css_styled_content/static/,EXT:browser/static/,EXT:quick_shop/static/';

    return $record;
  }

/**
 * createTyposcriptRecords( )
 *
 * @return	array		$records : the TypoScript records
 * @access  private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcriptRecords( )
  {
    $records  = array( );
    $uid      = $this->zz_getMaxDbUid( 'sys_template' );
    
      // TypoScript for the root page
    $uid = $uid + 1;
    $records[$uid] = $this->createTyposcriptRecordRoot( $uid );
    
      // TypoScript for the caddy page
    $uid = $uid + 1;
    $records[$uid] = $this->createTyposcriptRecordCaddy( $uid );

    return $records;
  }

/**
 * createTyposcriptSqlInsert( )
 *
 * @param   array   $records : TypoScript records for pages
 * @return  void
 * @access  private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function createTyposcriptSqlInsert( $records )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $record, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'sys_template', $record );
      $marker['###TITLE###']     = $record['title'];
      $marker['###UID###']       = $record['uid'];
      $marker['###TITLE_PID###'] = '"' . $this->arr_pageTitles[$record['pid']] .
                                              '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          '.$this->arr_icons['ok'] . ' ' . $this->pi_getLL( 'ts_create_prompt' ).'
        </p>';
      $prompt = $this->cObj->substituteMarkerArray( $prompt, $marker );
      $this->arrReport[ ] = $prompt;
    }
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

    $int_uid = $GLOBALS['TSFE']->id;

    $arr_pages[$int_uid]['title']    = $this->pi_getLL('page_title_root');
    $arr_pages[$int_uid]['tstamp']   = $timestamp;
    $arr_pages[$int_uid]['module']   = null;
    $arr_pages[$int_uid]['nav_hide']      = 1;
    if($this->bool_topLevel)
    {
      $arr_pages[$int_uid]['is_siteroot'] = 1;
    }
    if(!$this->bool_topLevel)
    {
      $arr_pages[$int_uid]['is_siteroot'] = 0;
    }
    $arr_pages[$int_uid]['media']    = 'typo3_quickshop_'.$timestamp.'.jpg';
    $arr_pages[$int_uid]['TSconfig'] = '

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
    $int_uid         = $this->cObj->data['uid'];
    $where           = 'uid = '.$int_uid;
    $no_quote_fields = false;
    // General Values

    $arr_content[$int_uid]['tstamp'] = $timestamp;
    $arr_content[$int_uid]['hidden'] = 1;

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
      $int_uid         = $this->arr_tsUids[$this->str_tsRoot];
      $pid             = $GLOBALS['TSFE']->id;
      $where           = 'pid = '.$pid.' AND uid NOT LIKE '.$int_uid;
      $no_quote_fields = false;
      // General Values

      $arr_content[$int_uid]['tstamp'] = $timestamp;
      $arr_content[$int_uid]['hidden'] = 1;

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
    $int_uid         = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $where           = 'uid = '.$int_uid;
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

    $arr_plugin[$int_uid]['tstamp']                  = $timestamp;
    $arr_plugin[$int_uid]['tx_powermail_sender']     = $str_sender;
    $arr_plugin[$int_uid]['tx_powermail_sendername'] = $str_sendername;

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
    $int_uid         = $this->arr_tsUids[$this->str_tsWtCart];
    $where           = 'uid = '.$int_uid;
    $no_quote_fields = false;

    list($str_emailName) = explode('@', $this->markerArray['###MAIL_DEFAULT_RECIPIENT###']);
    $str_emailName       = $str_emailName.'@###DOMAIN###';
    // General Values


      //////////////////////////////////////////////////////////////////////
      //
      // UPDATE constants

    $arr_ts[$int_uid]['tstamp']    = $timestamp;
    $arr_ts[$int_uid]['constants'] = '
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