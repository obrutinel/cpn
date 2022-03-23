

<section id="ourhome">
   <div id="revo_main_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
       <div id="main-banner" class="rev_slider fullwidthabanner" data-version="5.4.1">
           <ul>
               <?php foreach ($data->slider as $slide) { ?>
               <li data-index="rs-<?=$slide->id?>" data-transition="fade" data-slotamount="default" data-easein="Power3.easeInOut" data-easeout="Power3.easeInOut" data-masterspeed="1200" data-fsmasterspeed="1200" class="rev_gradient">

                   <!-- MAIN IMAGE -->
                   <img src="<?=IMG_URL.$slide->image?>" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
                   <!-- LAYER NR. 1 -->
                   <div class="tp-caption tp-resizeme stitle" 
                     data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" 
                     data-y="['middle','middle','middle','middle']" data-voffset="['-65','-120','-120','-120']"
                     data-whitespace="normal" data-responsive_offset="on"
                     data-width="[1920,'none','none', 480]" data-type="text"
                     data-textalign="['center','center','center','center']" 
                     data-transform_idle="o:1;"
                     data-transform_in="x:-50px;opacity:0;s:2000;e:Power3.easeOut;" 
                     data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 
                     data-start="1000" data-splitin="none" data-splitout="none">
                       <h1 class="darkcolor"><?=nl2br($slide->titre)?></h1>
                   </div>

                   <?php if(!empty($slide->sous_titre)) { ?>
                   <div class="tp-caption tp-resizeme darkcolor ssubtitle" 
                      data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" 
                      data-y="['middle','middle','middle','middle']" data-voffset="['20','20','20','20']" 
                      data-whitespace="nowrap" data-responsive_offset="on"
                      data-width="['none','none','none','none']" data-type="text"
                      data-textalign="['center','center','center','center']" data-fontsize="['24','24','20','20']"
                      data-transform_idle="o:1;" 
                      data-transform_in="z:0;rX:0deg;rY:0;rZ:0;sX:2;sY:2;skX:0;skY:0;opacity:0;s:1000;e:Power2.easeOut;" 
                      data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 
                      data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                      data-start="1500" data-splitin="none" data-splitout="none">
                       <h4 class="darkcolor font-light text-center"><?=$slide->sous_titre?></h4>
                   </div>
                   <?php } ?>
                   <?php if(!empty($slide->link_url)) { ?>
                         <a class="tp-caption btn_common btn_primary tp-resizeme sbtn" href="<?=$slide->link_url?>"
                            data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['100','100','100','100']"
                            data-width="210" data-height="none"
                            data-whitespace="normal" data-type="button"
                            data-actions='' data-responsive_offset="on"
                            data-textAlign="['center','center','center','center']"
                            data-margintop="[0,0,0,0]" data-marginright="[0,0,0,0]"
                            data-marginbottom="[0,0,0,0]" data-marginleft="[0,0,0,0]"
                            data-frames='[{"delay":700,"speed":2000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:40px;","to":"o:1;fb:0;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"200","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;fb:0;"}]'
                            style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
                             <?=$slide->link_text?>
                        </a>
                   <?php } ?>
               </li>
               <?php } ?>

             </ul>
       </div>
   </div>
</section>

    <?php /* ?>
	<section class="full-screen center-block fading-banner-one" id="fading-banner">
		<div class="container">
			<div class="row padding_half">
				<div class="col-md-12">
					<div id="text-fading" class="owl-carousel text-center">
						<!-- TODO : classe "top120" si slider SANS bouton // "top80" si slider AVEC bouton  -->

                        <?php foreach ($data->slider as $slide) { ?>
                            <div class="item <?=(!empty($slide->link_url)?'top80':'top120')?>" style="background-image: url(<?=IMG_URL.$slide->image?>)">

                                <h2 class="text-capitalize font-xlight whitecolor">
                                    <span class="d-block slider-title"><?=$slide->titre?></span>
                                    <?php if(!empty($slide->sous_titre)) { ?>
                                        <span class="d-block slider-subtitle"><?=$slide->sous_titre?></span>
                                    <?php } ?>
                                </h2>
                                <?php if(!empty($slide->link_url)) { ?>
                                    <a href="<?=$slide->link_url?>" class="btn_common btn_secondry btn_hvrwhite"> <?=$slide->link_text?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>

					</div>
				</div>
			</div>
		</div>
	</section>
 <?php */ ?>

    <?php if(!empty($data->bloc)) { ?>
        <section id="about" class="padding ">
            <div class="container">
                <div class="row">
                    <?php if(!empty($data->bloc->image)) { ?>
                        <div class="col-md-5">
                            <img src="<?=IMG_URL.$data->bloc->image?>" class="img-fluid">
                        </div>
                        <div class="col-md-7 d-flex flex-column justify-content-center">
                            <h2 class="heading bottom35 darkcolor">
                                <?php if(!empty($data->bloc->titre) && empty($data->bloc->sous_titre)) { ?>
                                    <span><?=$data->bloc->titre?> </span>
                                <?php } elseif(empty($data->bloc->titre) && !empty($data->bloc->sous_titre)) { ?>
                                    <?=$data->bloc->sous_titre?>
                                <?php } elseif(!empty($data->bloc->titre) && !empty($data->bloc->sous_titre)) { ?>
                                    <span><?=$data->bloc->titre?> </span> <?=$data->bloc->sous_titre?>
                                <?php } ?>
                                <span class="divider-left"></span>
                            </h2>
                            <div class="bottom35"><?=$data->bloc->texte?></div>
                            <?php if(!empty($data->bloc->link_url)) { ?>
                                <p class="bottom0"><a class="btn_common btn_border" href="<?=$data->bloc->link_url?>"><?=$data->bloc->link_text?></a></p>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-5">
                            <img src="img/about.jpg" alt="À propos de CPN" class="img-fluid">
                        </div>
                        <div class="col-md-7 d-flex flex-column justify-content-center">
                            <h2 class="heading bottom35 darkcolor"><span>Qui </span> sommes-nous <span class="divider-left"></span></h2>
                            <p class="bottom35">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                            <p class="bottom0"><a class="btn_common btn_border" href="javascript:void(0)">En savoir +</a></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>
	
	<section id="course_all" class="padding-top padbottom45 bg_light">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="heading bottom35 darkcolor">
                        <?=$data->bloc_secteur->sous_titre?>
                        <span class="divider-center"></span>
                    </h2>
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
	
	<section id="partners" class="padding-top padbottom45">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="heading bottom35 darkcolor">
                        <?=$data->bloc_reference->sous_titre?>
                        <span class="divider-center"></span>
                    </h2>
				</div>
                <?php foreach ($data->logos as $logo) { ?>
                    <div class="col-sm-3">
                        <a href="<?=$logo->link_url?>" target="_blank" class="partner-link">
                            <img src="<?=IMG_URL.$logo->image?>" class="img-fluid" alt="<?=$logo->titre?>">
                        </a>
                    </div>
                <?php } ?>
			</div>
		</div>
	</section>