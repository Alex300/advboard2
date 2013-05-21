<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=message.first
[END_COT_EXT]
==================== */
/**
 * Plugin AN Advertisement Board
 *     Вывести сообщение "Объявлеие добавлено и отправлено на модерацию"
 * @package Advertisement board plugin for Cotonti Siena
 * @author Alex - Studio Portal30
 * @copyright Portal30 2011-2012 http://portal30.ru
 */

defined('COT_CODE') or die('Wrong URL');

// Добавлено объявление, которое ушло в очередь на модерацию
// После добавления страницы, отправляем на страницу категории доски
// в которую и было добавлено объявление
if ($msg == 300){
	$do = cot_import('do','G','ALP');
    $c = cot_import('c', 'G', 'TXT'); // cat code
	if ($do == 'advpageadded' || $do == 'advpageedited'){
		$rd = '5';
		$ru = cot_url('page', 'c='.$c);
	}
}
