<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */
/**
 * Plugin Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('advboard', 'plug');
require_once cot_langfile('advboard');

if ( $env['location'] != 'administration'){
    ab_sendExpNotify();

    // Последние объявления
    if($cfg['plugin']['advboard']['recentAdvGlobalOn'] && cot_module_active('page')){

        // Получить ссылку на объект драйвера кеша
        /** @var Memcache_driver $ab_CacheDrv  */
        $ab_CacheDrv = ab_getCacheDrv();
        $cache_key = 'RECENT_ADVS';
        $advRealm = COT_DEFAULT_REALM; // Для поддержки автозагрузки из кеша для db-кеша

        if ($cache && $cfg['plugin']['advboard']['recentAdvCacheTime'] > 0) {
            // Для теста очистить кеш
//            $ab_CacheDrv->remove($cache_key, $advRealm);
            // Для Memcache не работает автозагрузка из кеша
            if (empty($RECENT_ADVS)){
//                echo "Грузим из кеша<br />";
                $RECENT_ADVS = $ab_CacheDrv->get($cache_key, $advRealm);
            }else{
//                echo "Загружено автоматически из кеша<br />";
            }

        }

        if(empty($RECENT_ADVS)){
//            echo "NO Cache";

            $advCond = array();
            $advCond['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";
            $advCond['state'] = "(page_state=0)";

            if($cfg['plugin']['advboard']['recentAdvGlobalStick'] == 1){
                $advCond['sticky'] = "page_{$cfg['plugin']['advboard']['stickyExtraField']}=1";
            }

            $RECENT_ADVS = ab_advList('advboard.advlist', $cfg['plugin']['advboard']['recentAdvGlobalNum'],
                'page_begin DESC', $advCond, '', '', '', true, null);

            if ($cache && $cfg['plugin']['advboard']['recentAdvCacheTime'] > 0){
                $ab_CacheTime = intval($cfg['plugin']['advboard']['recentAdvCacheTime'] * 60 * 60);
                $ab_CacheDrv->store($cache_key, $RECENT_ADVS, $advRealm, $ab_CacheTime); // 2 Недели
            }
        }else{
//            echo "From Cache";
//            var_dump($RECENT_ADVS);
        }

    }

}

