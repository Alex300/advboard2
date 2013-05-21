<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.update.first
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

if(ab_inBoardCat(ab_getCurrCategory())){
    // Если при редактировании объявления не позволено редактировать категорию
    // используем старую
    if (empty($_POST["rpagecat"])) $_POST["rpagecat"] = $row_page["page_cat"];
}