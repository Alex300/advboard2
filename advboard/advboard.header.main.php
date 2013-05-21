<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

if($env['location'] != administration && $cfg['plugin']['advboard']['rssToHeader'] == 1){
    require_once cot_langfile('advboard');

    // Получить вложенные категории
    $adv_cats = false;
    if (trim($cfg['plugin']['advboard']['rootCats']) != ''){
        $adv_cats = explode(',', trim($cfg['plugin']['advboard']['rootCats']));
    }
    if (is_array($adv_cats)){
        foreach ($adv_cats as $advcat) {
            $advCatTitle = htmlspecialchars($structure['page'][$advcat]['title']);
//            var_dump($advCatTitle);
//            $adv_rss = cot_url('rss', 'id='.$advcat);
//            if (!cot_url_check($adv_rss)) $adv_rss = COT_ABSOLUTE_URL . $adv_rss;
            $bl_rss = COT_ABSOLUTE_URL . "index.php?e=rss&c=pages&id={$advcat}";
            $out['head_head'] .= "\n".'<link rel="alternate" type="application/rss+xml" title="'.$L['advboard']['RSS_feed']
                .$advCatTitle.'" href="'.$adv_rss.'" />';
        }

    }
}
