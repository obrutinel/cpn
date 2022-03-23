<section class="first-section sector-description">
    <div class="container">
        <div class="row">

            <article class="media top60 mb-3">
				 <?php if(!empty($data->image)) { ?>
					<div class="col-md-4">
						<img class="mr-3 img-fluid" src="<?=IMG_URL.$data->image?>">
					</div>
				<?php } ?>
                <div class="media-body">
                    <h1 class="heading bottom30 darkcolor mb-3"><?=$data->titre?><span class="divider-left"></span></h1>
                    <div class="date mb-4">
                        <i class="fa fa-calendar"></i><?=date('d/m/Y', strtotime($data->date))?>
                    </div>
                    <div class="content">
                        <?php if(!empty($data->intro)) { ?>
                            <?=$data->intro?>
                            <br /><br />
                        <?php } ?>
                        <?=$data->texte?>
                    </div>
                </div>
            </article>

            <div class="col-md-12 text-right mb-5">
                <hr />
                <a class="btn_common btn_border" href="<?=getLink(5, false)?>">< Retour aux actualités</a>
            </div>

        </div>
    </div>
</section>