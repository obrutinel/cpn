<section class="first-section sector-description">
    <div class="container">
        <div class="row">

            <div class="col-md-12 top20 mb-4 project-details wow fadeInLaeft" data-wow-delay="300ms">
                <h1 class="heading bottom30 darkcolor"><?=$data->titre?><span class="divider-left"></span></h1>
				<div class="content">
					<?=$data->texte?>
				</div>				
            </div>

            <?php foreach($data->actualites as $actualite) { ?>
                    <div class="services-box heading_space col-sm-12">
                        <?php if(!empty($actualite->image)) { ?>
                            <div class="image bottom25">
                                <a href="<?=$actualite->nav_url?>">
                                    <img src="<?=IMG_URL.$actualite->image?>" alt="<?=$actualite->titre?>">
                                </a>
                            </div>
                        <?php } ?>
                        <h3 class="font-light2 darkcolor"><a href="<?=$actualite->nav_url?>"><?=$actualite->titre?></a></h3>
						<div class="date bottom10">
							<i class="fa fa-calendar"></i><?=date('d/m/Y', strtotime($actualite->date))?>
						</div>
                        <p class="bottom20"><?=$actualite->intro?></p>
                        <a href="<?=$actualite->nav_url?>" class="btn_common btn_border">En savoir +</a>
                    </div>

            <?php } ?>

        </div>
    </div>
</section>