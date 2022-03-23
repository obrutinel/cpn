
    <section class="first-section sector-description mb-5">
        <div class="container">
            <div class="row">

                <div class="col-md-12 top20 project-details wow fadeInLaeft" data-wow-delay="300ms">
                    <h1 class="heading bottom30 darkcolor"><?=$data->titre?><span class="divider-left"></span></h1>
                    <?php if(!empty($data->sous_titre)) { ?>
                        <h2 class="sector-subtitle darkcolor">
                            <?=$data->sous_titre?>
                        </h2>
                    <?php } ?>
                    <?=$data->texte?>
                </div>

            </div>
        </div>
    </section>

    <?php if(!empty($data->ref_1)) { ?>		
		<?php foreach ($data->ref_1 as $ref) { ?>
		
			<?php
			
				$bloc = 6;
				if($ref->type == 'ref_1') $bloc = 3;
				if($ref->type == 'ref_2') $bloc = 2;
			?>
		
			<section class="mb-5 pt-4">
				<div class="container">

					<?php if(!empty($ref->titre)) { ?>
						<div class="row">
							<div class="col-sm-12 text-center wow fadeIn" data-wow-delay="300ms">
								<h2 class="heading service-heading heading_space darkcolor">
									<span><?=$ref->titre?></span>
									<span class="divider-center"></span>
								</h2>
							</div>
						</div>
					<?php } ?>
					
					<?php $data->ref_1_list = $Wagaia->getByParent($ref->id)->list; ?>
					<div class="cpngallery row">
						<?php foreach ($data->ref_1_list as $item) { ?>
							<div class="col-sm-<?=$bloc?>">
								<div class="cpngallery-item digital">
									<?php if(!empty($item->image)) { ?>
										<img src="<?=IMG_URL.$item->image?>" alt="<?=$item->titre?>" class="img-fluid">
									<?php } ?>
									<?php if(!empty($item->sous_titre)) { ?>
										<div class="macaron"><?=$item->sous_titre?></div>
									<?php } ?>
									<div class="cpng-caption text-center">
										<h3><?=$item->titre?></h3>
										<p><?=$item->intro?></p>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>

				</div>
			</section>
		<?php } ?>
    <?php } ?>

    <?php /*if(!empty($data->ref_2)) { ?>
        <section class="mb-5 pt-4">
            <div class="container">

                <?php if(!empty($data->ref_2[0]->titre)) { ?>
                    <div class="row">
                        <div class="col-sm-12 text-center wow fadeIn" data-wow-delay="300ms">
                            <h2 class="heading service-heading heading_space darkcolor">
                                <span><?=$data->ref_2[0]->titre?></span>
                                <span class="divider-center"></span>
                            </h2>
                        </div>
                    </div>
                <?php } ?>

                <div class="cpngallery row">
                    <?php foreach ($data->ref_2_list as $item) { ?>
                        <div class="col-sm-2">
                            <div class="cpngallery-item digital">
                                <?php if(!empty($item->image)) { ?>
                                    <img src="<?=IMG_URL.$item->image?>" alt="<?=$item->titre?>" class="img-fluid">
                                <?php } ?>
                                <div class="cpng-caption text-center">
                                    <h3><?=$item->titre?></h3>
                                    <p><?=$item->intro?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section>
    <?php }*/ ?>

    <section>
        <div class="container">
            <div class="col-md-12 text-right mb-5">
                <hr />
                <a class="btn_common btn_border" href="<?=getLink(4, false)?>">< Retour aux références</a>
            </div>
        </div>
    </section>
