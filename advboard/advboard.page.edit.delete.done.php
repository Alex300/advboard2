<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.delete.done
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

// todo очистка кеша в одном файле с мультихуком

if (ab_inBoardCat($rpage['page_cat'])){

    // Очистить кеш
    if ($cache && $cfg['plugin']['advboard']['recentAdvCacheTime'] > 0) {
        /** @var Memcache_driver $ab_CacheDrv  */
        $ab_CacheDrv = ab_getCacheDrv();
        $cache_key = 'RECENT_ADVS';
        $advRealm = COT_DEFAULT_REALM;
        $ab_CacheDrv->remove($cache_key, $advRealm);
    }
    // /Очистить кеш

}