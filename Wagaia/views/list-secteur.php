<section class="first-section sector-description">
    <div class="container">
        <div class="row">

            <div class="col-md-12 top20 mb-4 project-details wow fadeInLaeft" data-wow-delay="300ms">
                <h1 class="heading bottom30 darkcolor"><?=$data->titre?><span class="divider-left"></span></h1>
            </div>

            <?php foreach ($data->secteurs as $secteur) { ?>
                <div class=" col-md-4 col-lg-4 equalheight">
                    <div class="services-box heading_space wow fadeIn text-center" data-wow-delay="400ms">
                        <?php if(!empty($secteur->image)) { ?>
                            <div class="image bottom25">
                                <a href="<?=$secteur->nav_url?>">
                                    <img src="<?=IMG_URL.$secteur->image?>" alt="<?=$secteur->titre?>">
                                </a>
                            </div>
                        <?php } ?>
                        <h3 class="bottom10 font-light2 darkcolor">
                            <a href="<?=$secteur->nav_url?>"><?=$secteur->titre?></a>
                        </h3>
                        <p class="bottom20"><?=$secteur->sous_titre?></p>
                        <a class="btn_common btn_border" href="<?=$secteur->nav_url?>">Découvrir</a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>