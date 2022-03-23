<?php

use Wagaia\Lib;

if(!$db->is_table('wagaia_multiple_dates')) {

        $db->query("CREATE TABLE `wagaia_multiple_dates` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `date` DATE NOT NULL,
            `page_id` INT(10) UNSIGNED NOT NULL,
            `status` CHAR(1) NULL DEFAULT NULL,
            `stock` INT(10) NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `FK__wagaia_pages` FOREIGN KEY (`page_id`) REFERENCES `wagaia_pages` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
            )
            COLLATE='utf8_unicode_ci'
            ENGINE=InnoDB");

    }

if ($_POST) {

    if (isset($_POST['date-multiple-date'])) {

        $d_count = count($_POST['date-multiple-date']);
        $d_date = $_POST['date-multiple-date'];
        $d_status = $_POST['date-multiple-status'];
        $d_stock = $_POST['date-multiple-stock'];

        if($d_count > 1) {
         $db->query('delete from wagaia_multiple_dates where page_id='.$id);
         for($i=0; $i<($d_count-1); ++$i) {
            $db->query('insert into wagaia_multiple_dates (date, page_id, status, stock) values ("'.Lib::dateConvert($d_date[$i], 'd/m/Y', 'Y-m-d').'", "'.$id.'",  "'.$d_status[$i].'", "'.$d_stock[$i].'" )');
        }
    }
}
} else {

    //dump($identifiant);

    $dates_multiple = array();

    if (Lib::digital($identifiant)) {
        $dates_multiple = $db->select('select date, status, stock from wagaia_multiple_dates where page_id='.$identifiant." order by date");
    }

    //dump($dates_multiple);

    //dump($data); ?>

    <div class="col-xs-4 col-sm-4">
        <h3 class="header blue lighter smaller clear">
            <i class="ace-icon fa fa-calendar-o smaller-90"></i>
            DATES
        </h3>

        <table class="table" id="add-date-multiple">
            <caption>Ajouter une nouvelle date <i class="fa fa-plus-circle"></i></caption>

            <thead>
                <tr>
                    <th>Date</th>
                    <th>Statut</th>
                    <th class="stock">Stock</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($dates_multiple) {
                    foreach($dates_multiple as $d) { ?>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input class="form-control date-picker-multiple" type="text" name="date-multiple-date[]" data-date-format="dd/mm/yyyy" value="<?=Lib::date($d->date);?>" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="label label-success<?=!$d->status ? ' hidden' : null;?>">Activée</span>
                                <span class="label label-danger<?=$d->status ? ' hidden' : null;?>">Désactivée</span>
                                <input type="hidden" value="<?=$d->status;?>" name="date-multiple-status[]"/>
                            </td>
                            <td class="stock">
                             <input type="text" class="form-control text-center" value="<?=$d->stock;?>" name="date-multiple-stock[]"/>
                         </td>
                         <td>
                             <i class="delete fa fa-minus-circle"></i>
                             </td>
                         </tr>
                         <?php
                     }
                 }
                 ?>

             </tbody>
             <tfoot class="hidden">

                <tr>
                    <td>
                        <div class="input-group">
                            <input class="form-control date-picker-multiple" type="text" name="date-multiple-date[]" data-date-format="dd/mm/yyyy" value="" />
                            <span class="input-group-addon">
                                <i class="fa fa-calendar bigger-110"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <span class="label label-success">Activée</span>
                        <span class="label label-danger hidden">Désactivée</span>
                        <input type="hidden" value="1" name="date-multiple-status[]"/>
                    </td>
                    <td class="stock">
                     <input type="text" class="form-control text-center" value="1" name="date-multiple-stock[]"/>
                 </td>
                 <td>
                     <i class="delete fa fa-minus-circle"></i>
                     </td>
                 </tr>

             </tfoot>
         </table>


     </div>
     <script type="text/javascript">
        jQuery(function($) {

            var date_multiple = $('#add-date-multiple'),
            set_multiple_datepicker = function(selector) {
                $(selector).datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    language: 'fr'
                })
                .next().on(ace.click_event, function(){
                    $(this).prev().focus();
                });
            },
            set_mutltiple_datepicker_status = function() {
                date_multiple.find('span.label').off().on('click', function() {
                    var t = $(this), td = t.parent('td');
                    td.find('input').val(t.hasClass('label-success') ? 0 : 1).end().find('.label').toggleClass('hidden');
                });
            },
            delete_multiple_datepicker = function() {
                date_multiple.find('i.delete').off().on('click', function() {
                    $(this).parents('tr').remove();
                });
            };

            set_multiple_datepicker('.date-picker-multiple');
            set_mutltiple_datepicker_status(); //date_multiple.find('tbody span.label')
            delete_multiple_datepicker();

        // Ajouter une nouvelle ligne
            date_multiple.find('caption').click(function() {
                date_multiple.find('tfoot tr').clone().appendTo(date_multiple.find('tbody'));
                var last = date_multiple.find('tbody tr:last');
                set_multiple_datepicker(last.find('input.date-picker-multiple'));
                set_mutltiple_datepicker_status(last.find('span.label'));
                delete_multiple_datepicker()
            });
        });
    </script>

    <?php } ?>