<?php
/**
 * Plugin Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL.');

// Установка необходимых данных
if ($cache){
    // Не возможно установить 2 типа для одного ключа
//    $advRealm = COT_DEFAULT_REALM;
//    $cache->bind('page.add.add.done', 'RECENT_ADVS', $advRealm, COT_CACHE_TYPE_DB);
//    $cache->bind('page.add.add.done', 'RECENT_ADVS', $advRealm, COT_CACHE_TYPE_MEMORY);
//
//    $cache->bind('page.edit.update.done', 'RECENT_ADVS', $advRealm, COT_CACHE_TYPE_MEMORY);
//    $cache->bind('page.edit.update.done', 'RECENT_ADVS', $advRealm, COT_CACHE_TYPE_DB);
//
//    $cache->bind('comments.send.new', 'RECENT_ADVS', $advRealm, COT_CACHE_TYPE_MEMORY);
//    $cache->bind('comments.send.new', 'RECENT_ADVS', $advRealm, COT_CACHE_TYPE_DB);
}
