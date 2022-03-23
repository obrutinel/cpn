<?php

use Wagaia\Tables;

if ($_POST) {

        $db->query(sprintf('update '.Tables::$pages . ' set icon=\''.$icone."' where id=%d", $id));

} else {

if (!$db->column(Tables::$pages,'icon')) {
            $db->query('ALTER TABLE '.Tables::$pages.' ADD COLUMN `icon` TEXT');
        } ?>


    <div class="row">

    <div class="col-xs-12 col-sm-12">
        <h3 class="header blue lighter smaller">
            <i class="ace-icon fa fa-calendar-o smaller-90"></i>
            Icône
        </h3>
        <div class="input-group" style="display: inline-flex;">
			<input data-placement="bottomRight" name="icone" autocomplete="off" placeholder="Cliquer pour sélectionner une icône" class="orm-control icp icp-auto" value="<?php echo $data->icon;?>" type="text" />
			<div class="btn btn-default action-create" style="display:none">Create instances</div>
			<span class="input-group-addon" style="width: 60px;font-size: 34px;padding: 10px;"></span> </div>
		</div>
    </div>
</div>

<?php } ?>
