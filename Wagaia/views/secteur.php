
    <section class="first-section sector-description mb-1">
        <div class="container">
            <div class="row">

                <div class="col-md-<?=(empty($data->bloc_1)?12:7)?> top20 project-details wow fadeInLaeft" data-wow-delay="300ms">
                    <h1 class="heading bottom30 darkcolor"><?=$data->titre?><span class="divider-left"></span></h1>
                    <?php if(!empty($data->sous_titre)) { ?>
                        <h2 class="sector-subtitle darkcolor">
                            <?=$data->sous_titre?>
                        </h2>
                    <?php } ?>
                    <div class="content">
                        <?=$data->texte?>
                    </div>
                </div>

                <?php if(!empty($data->bloc_1)) { ?>
                    <div class="offset-md-1 col-md-4 top20 project-details skill wow fadeInRight" data-wow-delay="300ms">
                        <?php if(!empty($data->bloc_1[0]->titre)) { ?>
                            <h3 class="heading bottom30 darkcolor"><?=$data->bloc_1[0]->titre?><span class="divider-left"></span></h3>
                        <?php } ?>
                        <?php foreach ($data->bloc_1_list as $item) { ?>
                            <div class="project-table">
                                <div class="d-table-cell">
                                    <p class="icon-title darkcolor"><i class="fa fa-check" aria-hidden="true"></i></p>
                                </div>
                                <div class="d-table-cell">
                                    <p><?=$item->titre?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>

    <?php if(!empty($data->bloc_2)) { ?>
        <section class="mb-5 pt-4">
            <div class="container">

                <?php if(!empty($data->bloc_2[0]->titre)) { ?>
                    <div class="row">
                        <div class="col-sm-12 text-center wow fadeIn" data-wow-delay="300ms">
                            <h2 class="heading service-heading heading_space darkcolor">
                                <span><?=$data->bloc_2[0]->titre?></span>
                                <span class="divider-center"></span>
                            </h2>
                        </div>
                    </div>
                <?php } ?>

                <div class="cpngallery row">
                    <?php foreach ($data->bloc_2_list as $item) { ?>
                        <div class="col-sm-3">
                            <div class="cpngallery-item digital">
                                <?php if(!empty($item->image)) { ?>
                                    <img src="<?=IMG_URL.$item->image?>" alt="<?=$item->titre?>" class="img-fluid">
                                <?php } ?>
                                <div class="cpng-caption text-center">
                                    <h3><?=$item->titre?></h3>
                                    <p><?=$item->sous_titre?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section>
    <?php } ?>
	
    <?php if(!empty($data->bloc_4)) { ?>
        <section class="mb-5 pt-4">
            <div class="container">

                <?php if(!empty($data->bloc_4[0]->titre)) { ?>
                    <div class="row">
                        <div class="col-sm-12 text-center wow fadeIn" data-wow-delay="300ms">
                            <h2 class="heading service-heading heading_space darkcolor">
                                <span><?=$data->bloc_4[0]->titre?></span>
                                <span class="divider-center"></span>
                            </h2>
                        </div>
                    </div>
                <?php } ?>

                <div class="cpngallery row">
                    <?php foreach ($data->bloc_4_list as $item) { ?>
                        <div class="col-sm-3">
                            <div class="cpngallery-item digital">
                                <?php if(!empty($item->image)) { ?>
                                    <img src="<?=IMG_URL.$item->image?>" alt="<?=$item->titre?>" class="img-fluid">
                                <?php } ?>
                                <div class="cpng-caption text-center">
                                    <h3><?=$item->titre?></h3>
                                    <p><?=$item->sous_titre?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section>
    <?php } ?>
	
    <?php if(!empty($data->bloc_3)) { ?>
        <section id="gallery" class="services-sector mb-5 pt-4">
            <div class="container">

                <?php if(!empty($data->bloc_3[0]->titre)) { ?>
                    <div class="row">
                        <div class="col-sm-12 text-center wow fadeIn" data-wow-delay="300ms">
                            <h2 class="heading service-heading bottom30 darkcolor">
                                <span><?=$data->bloc_3[0]->titre?></span>
                                <span class="divider-center"></span>
                            </h2>
                        </div>
                    </div>
                <?php } ?>

                <div class="row">
                    <?php foreach ($data->bloc_3_list as $item) { ?>
                        <div class="col-sm-4">
                            <h3 class="sector-subtitle darkcolor"><?=$item->titre?></h3>
                            <div class="content">
                                <?=$item->texte?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>

    <section>
        <div class="container">
            <div class="col-md-12 text-right mb-5">
                <hr />
                <a class="btn_common btn_border" href="<?=getLink(3, false)?>">< Retour aux secteurs</a>
            </div>
        </div>
    </section>
