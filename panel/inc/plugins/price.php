<?php

use Wagaia\Tables;

    if ($_POST) {

        if (!$db->column(Tables::$pages,'price')) {
            $db->query('ALTER TABLE '.Tables::$pages.' ADD COLUMN `price` DECIMAL(5,2) NULL');
        }

        $db->query(sprintf('update '.Tables::$pages . ' set price=\''.$price."' where id=%d", $id));

    } else { ?>
        <div class="col-xs-2 col-sm-2">
            <h3 class="header blue lighter smaller">
                <i class="ace-icon fa fa-money smaller-90"></i>
                <?php if(!empty($price_title) && array_key_exists($type, $price_title)) {
                    echo $price_title[$type];
                } else {
                    echo 'Prix';
                } ?>
            </h3>
            <div class="input-group">
                <input class="form-control" name="price" type="text" value="<?= $data->price;?>" />

            </div>
        </div>
    </div>
    <?php  }
 ?>