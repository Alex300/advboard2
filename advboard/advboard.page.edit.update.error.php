<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.update.error
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

if (ab_inBoardCat($rpage['page_cat'])){

    // Пересчитать период публикации объявления
    if($rpage['page_expire'] == 0){
        $period_exp = cot_import('rperiod_exp','P','INT');
        if ($period_exp > 0){
            $rpage['page_expire'] = $sys['now'] + $period_exp * 86400;
        }
    }

    // т.к. отсутствующие поля не обновляются
    if ($rpage['page_begin'] === 0) unset($rpage['page_begin']);
    if ($rpage['page_date'] === 0) unset($rpage['page_date']);
}
