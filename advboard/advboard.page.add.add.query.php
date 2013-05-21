<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.add.query
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 *    Checking Adv for publish status
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

if (ab_inBoardCat($rpage['page_cat'])){

    $tmp = cot_import('rpagestate', 'P', 'INT');
    if ($tmp == 0){
        if (!$auth['isadmin'] && $cfg['page']['autovalidate'] && cot_auth('page', $rpage['page_cat'], '2')){
            $rpage['page_state'] = 0;
            $db->query("UPDATE $db_structure SET structure_count=structure_count+1
                WHERE structure_area='page' AND structure_code = ?", $rpage['page_cat']);
            $cache && $cache->db->remove('structure', 'system');
        }
    }

    // Пересчитать период публикации объявления
    if($rpage['page_expire'] == 0){
        $period_exp = cot_import('rperiod_exp','P','INT');
        if ($period_exp > 0){
            $rpage['page_expire'] = $rpage['page_begin'] + $period_exp * 86400;
        }
    }
}