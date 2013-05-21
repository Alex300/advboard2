<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.update.done
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

    // Очистить кеш
    // todo очистка кеша в одном файле с мультихуком
    if ($cache && $cfg['plugin']['advboard']['recentAdvCacheTime'] > 0) {
        /** @var Memcache_driver $ab_CacheDrv  */
        $ab_CacheDrv = ab_getCacheDrv();
        $cache_key = 'RECENT_ADVS';
        $advRealm = COT_DEFAULT_REALM;
        $ab_CacheDrv->remove($cache_key, $advRealm);
    }
    // /Очистить кеш

    $tmp = cot_import('rpagestate', 'P', 'INT');
    if ($tmp == 0){
        if (!$usr['isadmin'] && $cfg['page']['autovalidate'] && cot_auth('page', $rpage['page_cat'], '2')){
            $rpage['page_state'] = 0;

            $db->update($db_pages, array('page_state' => $rpage['page_state']),
                'page_id=?', array($id));

            // синхронизация счетчиков, а то муть получется
            $tmpCnt = cot_page_sync($rpage['page_cat']);
            $db->update($db_structure, array("structure_count" => (int)$tmpCnt),
                "structure_code='".$db->prep($rpage['page_cat'])."' AND structure_area='page'");
        }
    }
}