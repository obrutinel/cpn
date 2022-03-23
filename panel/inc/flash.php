
    <?php if(!empty($_SESSION['error'])) { ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['error'] as $err) { ?>
                <?=$err?><br />
            <?php } ?>
        </div>
    <?php } ?>

    <?php if(!empty($_SESSION['success'])) { ?>
        <div class="alert alert-success">
            <?=$_SESSION['success']?>
        </div>
    <?php } ?>

    <?php if(!empty($_SESSION['info'])) { ?>
        <div class="alert alert-info">
            <?=$_SESSION['info']?>
        </div>
    <?php } ?>

    <?php if(!empty($_SESSION['flash'])) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?=$_SESSION['flash']['typ']?>">
                    <?php foreach($_SESSION['flash']['txt'] as $text) { ?>
                        <?=$text?><br />
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="clearfix"></div>

    <?php
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        unset($_SESSION['info']);
        unset($_SESSION['flash']);
    ?>


