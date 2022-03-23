<?php

use Wagaia\Tables;

if ($_POST) {

    if (!$db->column(Tables::$pages,'date')) {
            $db->query('ALTER TABLE '.Tables::$pages.' ADD COLUMN `date` TIMESTAMP NULL DEFAULT NULL');
        }

        $db->query(sprintf('update '.Tables::$pages . ' set date=\''.date('Y-m-d H:i:s', DateTime::createFromFormat('!d/m/Y', $date)->getTimestamp())."' where id=%d", $id));

} else {

?>

<div class="row">

    <div class="col-xs-4 col-sm-4">
        <h3 class="header blue lighter smaller">
            <i class="ace-icon fa fa-calendar-o smaller-90"></i>
            Date de publication
        </h3>
        <div class="input-group">
            <input class="form-control date-picker" name="date" id="id-date-picker-1" type="text" data-date-format="dd/mm/yyyy" value="<?= !empty($data->date) ? date('d/m/Y', strtotime($data->date)) : date('d/m/Y');?>" />
            <span class="input-group-addon">
                <i class="fa fa-calendar bigger-110"></i>
            </span>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function($) {
        //datepicker plugin
                //link
                $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    language: 'fr'
                });
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function(){
                    $(this).prev().focus();
                });
            });
        </script>
<?php } ?>