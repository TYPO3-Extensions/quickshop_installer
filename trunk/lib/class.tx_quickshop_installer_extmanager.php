<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.quickshop/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Class provides methods for the extension manager.
*
* @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
* @package    TYPO3
* @subpackage    quickshop
* @version 2.1.1
* @since 2.1.1
*/


  /**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   53: class tx_quickshop_installer_extmanager
 *   74:     function initialPage()
 *  252:     private function add_installerPage()
 *  282:     private function add_installerPlugin()
 *  315:     private function add_installerTS()
 *  379:     private function get_installerPages()
 *  414:     private function get_maxUid($from_table)
 *
 * TOTAL FUNCTIONS: 6
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_quickshop_installer_extmanager
{
  var $int_pageUid  = null;
  var $str_llStatic = 'en';








  /**
 * initialPage(): Displays a prompt with the current state.
 *                If the user enabled the adding of the installer page,
 *                the installer page will be added in the database.
 *
 * @return	string		message wrapped in HTML
 * @since 1.0.0
 * @version 1.0.0
 */
  function initialPage()
  {
//.message-notice
//.message-information
//.message-ok
//.message-warning
//.message-error

    $str_prompt = null;
    // 120613, dwildt, 1-
    $confArr    = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['quickshop_installer']);
    // 120613, dwildt, 1+
var_export( $confArr, false );
var_export( $_POST, false );
var_export( $_GET, false );
$params = \TYPO3\CMS\Core\Utility\GeneralUtility::_POST();
var_export( $params, false );

//    $confArr    = $_POST['data'];
    
    //var_dump( $_POST['data'] );
    $llStatic   = $confArr['LLstatic'];



      /////////////////////////////////////////////////////////
      //
      // Default prompt

      // 120613, dwildt-
//    $str_prompt = $str_prompt.'
//      <div class="typo3-message message-warning">
//        <div class="message-body">
//          ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptSaveTwice'). '
//        </div>
//      </div>
//    ';
      // 120613, dwildt-
      // Default prompt



      /////////////////////////////////////////////////////////
      //
      // Get installed installer pages

    $arr_installerPages = $this->get_installerPages();
      // Get installed installer pages



      /////////////////////////////////////////////////////////
      //
      // RETURN There is one installer page at least

    if( ! empty( $arr_installerPages ) )
    {
      $str_installerPages = implode(null, $arr_installerPages);
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptInstallPageExist'). '
          </div>
        </div>
      ';
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptInstallNextSteps'). '
          </div>
        </div>
      ';
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptDeleteInstallPage'). '
          </div>
        </div>
      ';
      $str_prompt = str_replace('###TITLE_UID###', $str_installerPages, $str_prompt);
      return $str_prompt;
    }
      // RETURN There is one installer page at least



      /////////////////////////////////////////////////////////
      //
      // RETURN There shouldn't install any installer page

    if(strtolower($confArr['installPage']) == 'no' OR empty($confArr['installPage']))
    {
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptEnableInstallPage'). '
          </div>
        </div>
      ';
      return $str_prompt;
    }
      // RETURN There shouldn't install any installer page



      /////////////////////////////////////////////////////////
      //
      // Language configuration

    switch($llStatic)
    {
      case($llStatic == 'German'):
        $this->str_llStatic = 'de';
        break;
      default:
        $this->str_llStatic = 'en';
    }
      // Language configuration



      /////////////////////////////////////////////////////////
      //
      // Insert page, TypoScript and plugin

    $this->add_installerPage();
    $this->add_installerTS();
    $this->add_installerPlugin();
      // Insert page, TypoScript and plugin



      /////////////////////////////////////////////////////////
      //
      // RETURN page was added succesfully

    $arr_installerPages = $this->get_installerPages();
    if(!empty($arr_installerPages))
    {
      $str_installerPages = implode(null, $arr_installerPages);
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptInstallPageAdded'). '
            ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptInstallNextSteps'). '
          </div>
        </div>
      ';
      $str_prompt = str_replace('###TITLE_UID###', $str_installerPages, $str_prompt);
      return $str_prompt;
    }
      // RETURN page was added succesfully



      /////////////////////////////////////////////////////////
      //
      // RETURN with an error

    $str_prompt = $str_prompt.'
      <div class="typo3-message message-error">
        <div class="message-body">
          ' . $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:promptError'). '
        </div>
      </div>
    ';
    return $str_prompt;
      // RETURN with an error
  }









  /**
 * add_installerPage(): Add a page with module 'quickshop_inst' to the root level
 *
 * @return	void
 * @since 1.0.0
 * @version 1.0.0
 */
  private function add_installerPage()
  {
    $table              = 'pages';
    $record             = null;
    $int_maxUid         = $this->get_maxUid($table);
    $this->int_pageUid  = $int_maxUid + 1;
    $record['uid']      = $this->int_pageUid;
    $record['title']    = $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:installPageTitle');
    $record['module']   = 'qs_inst';
    $record['sorting']  = '1000000000';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->INSERTquery( $table, $record ));
    //exit;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$record,$no_quote_fields=FALSE);
  }









  /**
 * add_installerPlugin(): Add the plugin
 *
 * @return	void
 * @since 1.0.0
 * @version 1.0.0
 */
  private function add_installerPlugin()
  {
    $table      = 'tt_content';
    $record     = null;
    $int_maxUid = $this->get_maxUid($table);
    $int_maxUid = $int_maxUid + 1;

    $record['uid']                 = $int_maxUid;
    $record['pid']                 = $this->int_pageUid;
    $record['CType']               = 'list';
    $record['header']              = $GLOBALS['LANG']->sL('LLL:EXT:quickshop_installer/lib/locallang.xml:installPluginTitle');
    $record['header_layout']       = '100';
    $record['list_type']           = 'quickshop_installer_pi1';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->INSERTquery( $table, $record ));
    //exit;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery( $table, $record );
  }









  /**
 * add_installerTS(): Add the TypoScript
 *
 * @return	void
 * @since 1.0.0
 * @version 1.0.0
 */
  private function add_installerTS()
  {
    $table      = 'sys_template';
    $record     = null;
    $int_maxUid = $this->get_maxUid($table);
    $int_maxUid = $int_maxUid + 1;

    $record['uid']                 = $int_maxUid;
    $record['pid']                 = $this->int_pageUid;
    $record['title']               = 'page_quickshopinstaller_' . sprintf('%03d', $int_maxUid);
    $record['root']                = '1';
    $record['clear']               = '3';
    $record['include_static_file'] = 'EXT:css_styled_content/static/';
    $record['config']              = '
config {
  baseURL            = ' . t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST') . '/
  language           = ' . $this->str_llStatic . '
  htmlTag_langKey    = ' . $this->str_llStatic . '
  metaCharset        = UTF-8
  tx_realurl_enable  = 0
  no_cache           = 1
}
page = PAGE
page {
  typeNum = 0
  10 = COA
  10 {
    10 = TEXT
    10 {
      value (
        <style type="text/css">
        body {
          background-image:url(typo3conf/ext/quickshop_installer/res/images/background.gif);
          background-repeat:no-repeat;
          background-position:center center;
          background-attachment:fixed;
        }
        </style>
)
    }
    20 < styles.content.get
  }
}
';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->INSERTquery($table,$record,$no_quote_fields=FALSE));
    //exit;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery( $table, $record );
  }









  /**
 * get_installerPages(): Get all pages with module = qs_inst AND not deleted
 *
 * @return	array		rows with installer pages
 * @since 1.0.0
 * @version 1.0.0
 */
  private function get_installerPages()
  {
    $rows           = null;
    $select_fields  = 'uid, title';
    $from_table     = 'pages';
    $where_clause   = 'deleted = 0 AND module = "qs_inst"';
    $groupBy        ='';
    $orderBy        ='';
    $limit          ='';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit);
    while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
    {
      $rows[] = '<li>' . $row['title'] . ' [uid: ' . $row['uid'] . ']</li>';
      //$params['items'][] = array($row['itemValue'], $row['itemKey']);
    }
    return $rows;
  }









  /**
 * get_maxUid(): Get the max uid of the given table
 *
 * @param	string		$from_table: the table
 * @return	int		max uid
 * @since 1.0.0
 * @version 1.0.0
 */
  private function get_maxUid($from_table)
  {
    $rows           = null;
    $select_fields  = 'max(uid) AS maxUid';
    $where_clause   = null;
    $groupBy        = null;
    $orderBy        = null;
    $limit          = null;
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit);
    $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
    return $row['maxUid'];
  }









}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/lib/class.tx_quickshop_installer_extmanager.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_installer/lib/class.tx_quickshop_installer_extmanager.php']);
}

?>
