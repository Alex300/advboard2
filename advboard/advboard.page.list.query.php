<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.query
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
    // Сортировка по прилепленным
	if ($cfg['plugin']['advboard']['allowSticky'] && $cfg['plugin']['advboard']['stickyExtraField'] != ''){
        $orderby = "page_{$cfg['plugin']['advboard']['stickyExtraField']} DESC, $orderby";
	}

    // Незарег видит только свои черновики
    if ($usr['id'] == 0){
        if (empty($_SESSION['advboard'])){
            $where['state'] = "page_state=0";
        }else{
            $where['state'] = "(page_state=0 OR page_state=2 AND page_id IN (".implode(', ', $_SESSION['advboard'])."))";
        }
    }

} // if (AN_ADV_BOARD){
