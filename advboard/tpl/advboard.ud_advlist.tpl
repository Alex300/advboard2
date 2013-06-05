<!-- BEGIN: MAIN -->

<!-- IF {PAGE_TOP_AJAX_DIV_ID} -->
<div id='{PAGE_TOP_AJAX_DIV_ID}'>
<!-- ENDIF -->

    <ul>
    <!-- BEGIN: PAGE_ROW -->
        <li>
            {PAGE_ROW_BEGIN} <a href="{PAGE_ROW_URL}">{PAGE_ROW_TITLE}</a> {PAGE_ROW_COMMENTS}
                <!-- IF {PHP.usr.id} > 0 AND ( {PAGE_ROW_OWNERID} == {PHP.usr.id} OR  {PHP.usr.isadmin} == 1 ) -->
                <!-- IF {PAGE_ROW_ADV_STATUS_LOCAL} != '' -->
                    <span class="italic small" style="color:#F00; font-weight: bold">* {PAGE_ROW_ADV_STATUS_LOCAL}.</span>
                    <!-- ENDIF -->

                    <!-- IF {PAGE_ROW_STATUS} != 'published' -->
                    <span class="italic small" style="color:#F00; font-weight: bold">{PAGE_ROW_LOCALSTATUS}</span>
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