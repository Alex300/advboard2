<!-- BEGIN: MAIN -->

<!-- IF {PAGE_TOP_AJAX_DIV_ID} -->
<div id='{PAGE_TOP_AJAX_DIV_ID}'>
<!-- ENDIF -->

    <ul>
    <!-- BEGIN: PAGE_ROW -->
        <li>
            {LIST_ROW_BEGIN} <a href="{LIST_ROW_URL}">{LIST_ROW_TITLE}</a> {LIST_ROW_COMMENTS}
                <!-- IF {PHP.usr.id} > 0 AND ( {LIST_ROW_OWNERID} == {PHP.usr.id} OR  {PHP.usr.isadmin} == 1 ) -->
                <!-- IF {LIST_ROW_ADV_STATUS_LOCAL} != '' -->
                    <span class="italic small" style="color:#F00; font-weight: bold">* {LIST_ROW_ADV_STATUS_LOCAL}.</span>
                    <!-- ENDIF -->

                    <!-- IF {LIST_ROW_STATUS} != 'published' -->
                    <span class="italic small" style="color:#F00; font-weight: bold">{LIST_ROW_LOCALSTATUS}</span>
                    <!-- ENDIF -->
                <!-- ENDIF -->
        </li>
    <!-- END: PAGE_ROW -->
    </ul>

    <!-- IF {PAGE_TOP_PAGINATION} -->
    <div class="pagination">
        {PAGE_TOP_PAGEPREV} {PAGE_TOP_PAGINATION} {PAGE_TOP_PAGENEXT}
    </div>
    <!-- ENDIF -->

<!-- IF {PAGE_TOP_AJAX_DIV_ID} -->
</div>
<!-- ENDIF -->

<!-- END: MAIN -->