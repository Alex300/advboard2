<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.tags
Tags=page.list.tpl: {ADV_BOARD_LIST_RECENT_ADVS}
[END_COT_EXT]
==================== */
/**
 * Plugin Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

if (ab_inBoardCat($c)){

    // Получить корневые категории доски
    $adv_rootCats = explode(',', $cfg['plugin']['advboard']['rootCats']);
    foreach ($adv_rootCats as $key => $val){
        $adv_rootCats[$key] = trim($adv_rootCats[$key]);
        if (!isset($structure['page'][$adv_rootCats[$key]])) unset($adv_rootCats[$key]) ;
    }
    // Последние объявления
    if($cfg['plugin']['advboard']['recentAdvOn'] && in_array($c, $adv_rootCats)){
        $advCond = array();
        $advCond['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";
        $advCond['state'] = "(page_state=0)";

        if($cfg['plugin']['advboard']['recentAdvStick'] == 1){
            $advCond['sticky'] = "page_{$cfg['plugin']['advboard']['stickyExtraField']}=1";
        }

        $adv_recent_advs = ab_advList('advboard.advlist', $cfg['plugin']['advboard']['recentAdvNum'],
            'page_begin DESC', $advCond, $c, '', '', true, null);

        $t->assign(array(
            "ADV_BOARD_LIST_RECENT_ADVS" => $adv_recent_advs,
        ));
    }
}
