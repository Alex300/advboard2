<?php
/**
 * Plugin Advertisement Board
 *
 * Functions
 *
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('page', 'module');
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
/**
 * Определяем текущую категорию.
 * @throws Exception
 * @return string - код текущей категории
 */
function ab_getCurrCategory(){
	global $env, $pag, $c, $a, $row_page;


    static $currCat;

    if(!empty($currCat)) return $currCat;

    $ret = '';
    if ($env['location'] == 'list' || $env['location'] == 'pages'){
        $ret = (isset($pag['page_cat'])) ? $pag['page_cat'] : $c;
    }
    /** Сохранение страницы */
    if (!$ret && $env['location'] == 'pages' && ($a == 'update' || $a == 'add')){
        $ret = cot_import('rpagecat', 'P', 'TXT');
        if (!$ret && !empty($row_page['page_cat'])) $ret = $row_page['page_cat'];
    }


//    var_dump($ret);
//    var_dump($row_page);
//    var_dump($env['location']);
//    die;
    // Ето строго для отладки !!!
    if (!$ret) throw new Exception('Не могу определить категорию');

//    var_dump($ret);
//    die;

//	if ($location == 'Pages'){
//		$m = sed_import('m','G','ALP',24);
//		$a = sed_import('a','G','ALP',24);
//
//        if (empty($al) || $al == ''){
//            $al = sed_import('al','G','TXT');
//        }
//
//		if ($m == 'add' && empty($a)){
//			$ret = sed_import('c','G','ALP');
//		}elseif($m == 'add' && $a == 'add'){
//			$ret = sed_import('newpagecat','P','TXT');
//		}elseif($m == 'edit' && $a == 'update'){
//			$ret = sed_import('rpagecat','P','TXT');
//		}elseif(empty($pag['page_cat'])){
//            if (!empty($al)){
//				$sql = sed_sql_query("SELECT page_cat FROM $db_pages WHERE page_alias='".$al."' LIMIT 1");
//			}else{
//				$sql = sed_sql_query("SELECT page_cat FROM $db_pages WHERE page_id='$id'");
//			}
//			// Не определена категория для страницы. Такого не бывает
//            sed_die(sed_sql_numrows($sql)==0);
//			$tmp = sed_sql_fetchassoc($sql);
//			$ret = $tmp["page_cat"];
//		}else{
//			$ret = $pag['page_cat'];
//		}
//	}

    $currCat = $ret;

	return $ret;
}

/**
 * Находится ли категория в доске
 * @param bool|string $c - код категории
 * @return bool
 */
function ab_inBoardCat($c = false){
    global $cfg;

    if (empty($c)) return false;

    if (!isset($cfg['plugin']['advboard']['cats']) || !$cfg['plugin']['advboard']['cats']) ab_readBoardCats();
    if (empty($cfg['plugin']['advboard']['cats'])) return false;

    return in_array($c, $cfg['plugin']['advboard']['cats']);
}

/**
 * Все категории доски
 * @return array коды категорий магазина
 */
function ab_readBoardCats(){
    global $cfg, $structure;

    if(is_array($cfg['plugin']['advboard']['cats'])){
        reset($cfg['plugin']['advboard']['cats']);
        return $cfg['plugin']['advboard']['cats'];
    }

    // Получить вложенные категории
    $tmpCats = explode(',', $cfg['plugin']['advboard']['rootCats']);
    $cats = array();
    foreach ($tmpCats as $key => $val){
        $tmpCats[$key] = trim($tmpCats[$key]);
        if (!isset($structure['page'][$tmpCats[$key]])) continue;
        $cats = array_merge($cats, cot_structure_children('page', $tmpCats[$key], true, true, true, false));

    }
    $cats = array_unique($cats);
    reset($cats);
    $cfg['plugin']['advboard']['cats'] = $cats;

    return $cfg['plugin']['advboard']['cats'];
}

/**
 * Элементы списка для выбора периода размещения объявления
 */
function ab_periodItems(){
    global $cfg;

    $period = array();
    $tmp = 0;
    while ($tmp <= $cfg['plugin']['advboard']['maxPeriod']){
        if ($tmp < 10) $tmp += 1;
        elseif ($tmp < 10) $tmp += 1;
        elseif ($tmp < 20) $tmp += 2;
        elseif ($tmp < 30) $tmp += 5;
        elseif ($tmp < 90) $tmp += 10;

        if ($tmp <= $cfg['plugin']['advboard']['maxPeriod']){
            $period[] = $tmp;
        }
    }

    if ($tmp < $cfg['plugin']['advboard']['maxPeriod']){
        $period[] = $cfg['plugin']['advboard']['maxPeriod'];
    }

    if ($cfg['plugin']['advboard']['periodOrder'] == 'desc'){
        rsort($period);
    }
    return $period;
}

/**
 * Проверяем e-mail
 * @param string $mail - проверяемый e-mail
 *
 * @return bool
 */
function ab_checkEmail($mail = ''){
    global $db_banlist, $db, $L;

    if ($mail == ''){
        $ret['msg'] = $L['advboard']['err_noemail'];
        return $ret;
    }

    // Проверяем бан-лист
    if (cot_plugin_active('banlist')){
        $sql = $db->query("SELECT banlist_reason, banlist_email FROM $db_banlist
            WHERE banlist_email LIKE'%".$db->prep($mail)."%'");
        if ($row = $sql->fetch()) {
            cot_error($L['aut_emailbanned']. $row['banlist_reason']);
            return false;
        }
        $sql->closeCursor();
    }

    if(!cot_check_email($mail)){
        cot_error($L['advboard']['err_wrongmail']);
        return false;
    }

    return true;
}

/**
 * Кол-во объявлений пользователя
 * @param int $userId
 * @param int $unvalidated 0 - только опубликованные, 1 - все
 * @param bool $cacheitem
 * @internal param array $cache
 * @return string
 */
function ab_userAdvCount($userId, $unvalidated = 0, $cacheitem = true){
    global $sys, $db_pages, $db;

    $userId = (int)$userId;

    $advcats = ab_readBoardCats();
    if (empty($advcats)) return 0;

    static $cache = array();

    if (!empty($cache[$userId][intval($unvalidated)])) return $cache[$userId][intval($unvalidated)];

    $where = array();

    if (!$unvalidated){
        $where['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";
        $where['state'] = "(page_state=0)";
    }
    $where['ownerid'] = 'page_ownerid = ' . $userId;
    $where['cat'] = "page_cat IN (".implode(", ", ab_quoteDbData($advcats)).")";

    $where = array_filter($where);
    $where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    $sql_page_count = "SELECT COUNT(*) FROM $db_pages as p $where";

    $params = array();

    $totallines = $db->query($sql_page_count, $params)->fetchColumn();


    $cacheitem && $cache[$userId][intval($unvalidated)] = $totallines;

    return $totallines;
}

/**
 * Экранирование данных для запроса
 * @static
 * @param mixed $data строка или массив строк для экранирования
 * @global CotDb $db
 * @return array|string
 */
 function ab_quoteDbData( $data ){
    global $db;

    if (is_string($data)) return $db->quote($data) ;

    if (!is_array($data)) return $data;

    $ret = array();
    foreach($data as $key => $str){
//            if (is_string($str)) $ret[$key] = $db->quote($str);
        if (!(strval(intval($ret[$key])) == $ret[$key])) $ret[$key] = $db->quote($str);
    }
    return $ret;
}

/**
 * Generates page list widget
 *   Доработанная Alex'ом функция от Seditio.By
 * @author Seditio.By, trustmaster, Alex
 *
 * @param  string  $tpl        Template code
 * @param  integer $items      Number of items to show. 0 - all items
 * @param  string  $order      Sorting order (SQL)
 * @param  string  $condition  Custom selection filter (SQL)
 * @param  string  $cat        Custom parent category code
 * @param  string  $blacklist  Category black list, semicolon separated
 * @param  string  $whitelist  Category white list, simicolon separated
 * @param  boolean $sub        Include subcategories TRUE/FALSE
 * @param  string  $pagination Pagination parameter name for the URL, e.g. 'pld'. Make sure it does not conflict with other paginations.
 * @param  boolean $noself     Exclude the current page from the rowset for pages.
 * @param array $url_params
 * @param bool $ajaxPagination
 * @param array $ajaxPagParams
 * @return string              Parsed HTML
 */
function ab_advList($tpl = 'advboard.advlist', $items = 0, $order = '', $condition = '', $cat = '', $blacklist = '', $whitelist = '',
        $sub = true, $pagination = 'pld', $noself = false, $url_params = array(), $ajaxPagination = false,
        $ajaxPagParams = array() )
{
    global $db, $db_pages, $db_users, $env, $structure;

    // Compile lists
    if (!empty($blacklist))
    {
        $bl = explode(';', $blacklist);
    }

    if (!empty($whitelist))
    {
        $wl = explode(';', $whitelist);
    }

    // Если не переданы категории, берем все категории доски объявлений
    $getDefaultCats = true;
    if (is_array($condition) && !empty($condition['cat'])) $getDefaultCats = false;
    if (is_string($condition) && mb_strpos($condition, 'page_cat') !== false) $getDefaultCats = false;
    if (!empty($cat) || !empty($blacklist) || !empty($whitelist)) $getDefaultCats = false;
    if ($getDefaultCats){
        $wl = ab_readBoardCats();
        $whitelist = implode(';', $wl);
    }

    // Get the cats
    $cats = array();
    if (empty($cat) && (!empty($blacklist) || !empty($whitelist)))
    {
        // All cats except bl/wl
        foreach ($structure['page'] as $code => $row)
        {
            if (!empty($blacklist) && !in_array($code, $bl)
                || !empty($whitelist) && in_array($code, $wl))
            {
                $cats[] = $code;
            }
        }
    }
    elseif (!empty($cat) && $sub)
    {
        // Specific cat
        $cats = cot_structure_children('page', $cat, $sub);
    }

    if (count($cats) > 0)
    {
        if (!empty($blacklist))
        {
            $cats = array_diff($cats, $bl);
        }

        if (!empty($whitelist))
        {
            $cats = array_intersect($cats, $wl);
        }

        $where_cat = "AND page_cat IN ('" . implode("','", $cats) . "')";
    }
    elseif (!empty($cat))
    {
        $where_cat = "AND page_cat = " . $db->quote($cat);
    }

    if (is_array($condition)) $condition = implode(' AND ', $condition);

    $where_condition = (empty($condition)) ? '' : "AND $condition";

    if ($noself && defined('COT_PAGES') && !defined('COT_LIST'))
    {
        global $id;
        $where_condition .= " AND page_id != $id";
    }

    // Get pagination number if necessary
    $items = (int)$items;
    if ($items > 0 && !empty($pagination))
    {
        list($pg, $d, $durl) = cot_import_pagenav($pagination, $items);
    }
    else
    {
        $d = 0;
    }

    // Display the items
    $t = new XTemplate(cot_tplfile($tpl, 'plug'));

    /* === Hook === */
    foreach (array_merge(cot_getextplugins('customnews.query'), cot_getextplugins('pagelist.query')) as $pl)
    {
        include $pl;
    }
    /* ===== */

    $totalitems = $db->query("SELECT COUNT(*)
		FROM $db_pages AS p $cns_join_tables
		WHERE page_state='0' $where_cat $where_condition")->fetchColumn();

    $sql_order = empty($order) ? '' : "ORDER BY $order";
    $sql_limit = ($items > 0) ? "LIMIT $d, $items" : '';

    $res = $db->query("SELECT p.*, u.* $cns_join_columns
		FROM $db_pages AS p
			LEFT JOIN $db_users AS u ON p.page_ownerid = u.user_id
			$cns_join_tables
		WHERE page_state='0' $where_cat $where_condition
		$sql_order $sql_limit");

    $jj = 1;

    while ($row = $res->fetch())
    {
        $t->assign(cot_generate_pagetags($row, "PAGE_ROW_"));

        $t->assign(array(
            'LIST_ROW_NUM'     => $jj,
            'LIST_ROW_ODDEVEN' => cot_build_oddeven($jj),
            'LIST_ROW_RAW'     => $row
        ));

        $t->assign(cot_generate_usertags($row, 'LIST_ROW_OWNER_'));

        /* === Hook === */
        foreach (cot_getextplugins('pagelist.loop') as $pl)
        {
            include $pl;
        }
        /* ===== */

        $t->parse("MAIN.PAGE_ROW");
        $jj++;
    }

    // Render pagination
    $url_area = defined('COT_PLUG') ? 'plug' : $env['ext'];
    if (empty($url_params)){
        if (defined('COT_LIST'))
        {
            global $list_url_path;
            $url_params = $list_url_path;
        }
        elseif (defined('COT_PAGES'))
        {
            global $al, $id, $pag;
            $url_params = empty($al) ? array('c' => $pag['page_cat'], 'id' => $id) :  array('c' => $pag['page_cat'], 'al' => $al);
        }
        else
        {
            $url_params = array();
        }
    }
    if($items > 0 && !empty($pagination)){
        $url_params[$pagination] = $durl;
        if ($ajaxPagination){
            $targetDivId = 'reload_'.$pagination;
            is_string($ajaxPagParams) ? parse_str($ajaxPagParams, $ajax_args) : $ajax_args = $ajaxPagParams;
            $ajax_args['e'] = 'advboard';
            $pagenav = cot_pagenav($url_area, $url_params, $d, $totalitems, $items, $pagination,  '', true, $targetDivId,
                'plug', $ajax_args);
        }else{
            $pagenav = cot_pagenav($url_area, $url_params, $d, $totalitems, $items, $pagination);
        }

        $t->assign(array(
            'PAGE_TOP_PAGINATION'  => $pagenav['main'],
            'PAGE_TOP_PAGEPREV'    => $pagenav['prev'],
            'PAGE_TOP_PAGENEXT'    => $pagenav['next'],
            'PAGE_TOP_FIRST'       => $pagenav['first'],
            'PAGE_TOP_LAST'        => $pagenav['last'],
            'PAGE_TOP_CURRENTPAGE' => $pagenav['current'],
            'PAGE_TOP_TOTALLINES'  => $totalitems,
            'PAGE_TOP_MAXPERPAGE'  => $items,
            'PAGE_TOP_TOTALPAGES'  => $pagenav['total'],
            'PAGE_AJAX' => COT_AJAX,
            'PAGE_TOP_USE_AJAX' => $ajaxPagination,
            'PAGE_TOP_AJAX_DIV_ID' => ($ajaxPagination && ! COT_AJAX) ? $targetDivId : ''
        ));
    }
    /* === Hook === */
    foreach (cot_getextplugins('pagelist.tags') as $pl)
    {
        include $pl;
    }
    /* ===== */

    $t->parse();

    return $t->text();
}

/**
 * @return bool|Db_cache_driver|Temporary_cache_driver
 */
function ab_getCacheDrv(){
    global $cache;

    if (!$cache) {
        return false;
    }elseif($cache->mem){
       return $cache->mem;
    }
    return $cache->db;
    //$this->_cacheLife = 86400/4; // check 4 time per day
}

/**
 * Рассылка уведомлений об истечении сроков публикации объявления
 */
function ab_sendExpNotify(){
	global $cfg, $sys, $usr, $adv_cats, $db, $db_pages, $db_users, $L;
	if (file_exists($cfg["plugins_dir"].DS.'advboard'.DS.'inc'.DS.'send.txt')){
		$an_adv_send = implode('', file($cfg["plugins_dir"].DS.'advboard'.DS.'inc'.DS.'send.txt') );
	}else{
		$an_adv_send = 0;
	}
	$tmp = getdate($sys['now']);
	$an_adv_today = mktime(0, 0, 0, $tmp["mon"], $tmp["mday"], $tmp["year"]);

    // Рассылаем раз в сутки
	if ($an_adv_today - $an_adv_send >= 86400){
		// Период за который рассылаем
		if ($an_adv_send == 0){
			// не разу не рассылали еще
			$an_adv_sendPer = $cfg['plugin']['advboard']['expNotifyPeriod'];
		}else{
			$an_adv_sendPer = floor( ($an_adv_today - $an_adv_send) / 86400 );
        }    
        // Уведомляем об истечении
        // Пока тупо шлем напоминание всем объявлениям у которых дата истечения 
        // Больше той, когда заходили последний раз, но меньше текущей минус <уведомить за>
        $stDay = $tmp["mday"] + $cfg['plugin']['advboard']['expNotifyPeriod'] - $an_adv_sendPer;
        $an_adv_st = mktime(0, 0, 0, $tmp["mon"], $stDay , $tmp["year"]);
        if ($an_adv_st < $sys['now']) $an_adv_st  = $sys['now'];

        $an_adv_end = mktime(0, 0, 0, $tmp["mon"], $tmp["mday"] + $cfg['plugin']['advboard']['expNotifyPeriod'], $tmp["year"]);
        
        $cats = ab_readBoardCats();

        $fields = array('p.page_id', 'p.page_title', 'p.page_desc', 'p.page_ownerid', 'p.page_expire', 
                'p.page_alias', 'p.page_cat', 'u.user_name', 'u.user_email');
        if ($cfg['plugin']['advboard']['gEmailExtraField']){
            $fields[] = 'page_'.$cfg['plugin']['advboard']['gEmailExtraField'];
        }
        $where = array(
            'p.page_ownerid=user_id',
            "p.page_expire >= {$an_adv_st}",
            "p.page_expire < {$an_adv_end}",
            '(page_state=0 OR page_state=2)',
        );
        if (count($cats)){
            $where['cat'] = "page_cat IN (".implode(', ', ab_quoteDbData($cats)).")";
        }
        $from = array($db_pages.' as p', $db_users.' as u');
        $sql = "SELECT ".implode(', ', $fields)." FROM ".implode(', ', $from)." WHERE ".implode(' AND ', $where)."";
        $sql = $db->query($sql);
        while ($adv = $sql->fetch()){
            if ($adv['page_ownerid'] == 0) continue;

            $urlParams = array('c' => $adv['page_cat']);
            if (!empty($adv['page_alias']) && $adv['page_alias'] != ''){
                $urlParams['al'] = $adv['page_alias'];
            }else{
                $urlParams['id'] = $adv['page_id'];
            }
            $adv_url = cot_url('page', $urlParams, '', true);
            if (!cot_url_check($adv_url)) $adv_url = COT_ABSOLUTE_URL . $adv_url;
            $my_advs = cot_url('plug', 'e=advboard', '', true);
            if (!cot_url_check($my_advs)) $my_advs = COT_ABSOLUTE_URL . $my_advs;

            $email_title = $L['advboard']['userExpNotifyTitle'].' - '.$cfg['mainurl'];
            $email_body = $L['advboard']['userExpNotify'];
            $email_body = str_replace('{USER_NAME}', $adv['user_name'], $email_body);
            $email_body = str_replace('{EXP_DATE}', cot_date('date_text', $adv['page_expire']), $email_body);
            $email_body = str_replace('{SITE_TITLE}', $cfg["maintitle"], $email_body);
            $email_body = str_replace('{SITE_URL}', $cfg["mainurl"], $email_body);
            $email_body = str_replace('{ADV_TITLE}', htmlspecialchars($adv["page_title"]), $email_body);
            $email_body = str_replace('{ADV_DESCRIPION}', $adv["page_desc"], $email_body);
            $email_body = str_replace('{ADV_URL}', $adv_url, $email_body);
            $email_body = str_replace('{MY_ADVS}', $my_advs, $email_body);
            $email = $adv["user_email"];

            if (empty($email) || $email == '') {
                $email = $adv['page_'.$cfg['plugin']['advboard']['gEmailExtraField']];
            }
            if (!empty($email) && $email != ''){
                cot_mail($email, $email_title, $email_body, '', false, null, true);
            }
        }
		
		file_put_contents($cfg["plugins_dir"].DS.'advboard'.DS.'inc'.DS.'send.txt', $an_adv_today);
	}
}

$advboard_copyr = '<p class="desc" style="text-align:center">powered by <a href="http://portal30.ru">Portal30.Ru</a></p>';
