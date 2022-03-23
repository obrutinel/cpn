
    <section class="first-section sector-description mb-5">
        <div class="container">
            <div class="row">

                <div class="col-md-12 top20 project-details wow fadeInLaeft mb-5" data-wow-delay="300ms">
                    <h1 class="heading bottom30 darkcolor"><?=$data->titre?><span class="divider-left"></span></h1>
                    <?=$data->texte?>
                </div>

                <div class="col-md-8">
                    <?php include(ABSPATH.'Wagaia/views/form/form-contact.php'); ?>

                    <?php if(!$success) { ?>
                        <form method="POST">

                            <div class="form-group">
                                <input type="text" class="form-control"  name="nom" value="<?=$_POST['nom']?>" placeholder="Votre nom *">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="mail" value="<?=$_POST['mail']?>" placeholder="Votre email *">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" name="message" placeholder="Votre message *"><?=$_POST['message']?></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="g-recaptcha" data-sitekey="<?=SITE_KEY?>"></div>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        <button type="submit" class="btn_common btn_border">ENVOYER</button>
                                        <br /><small class="mt-2"><i>* Champs obligatoires</i></small>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Consentement à venir
                                    </label>
                                </div>
                            </div>-->
                        </form>
                    <?php } ?>
                </div>

                <?php if(!empty($data->intro)) { ?>
                    <div class="col-md-4">
                        <?=$data->intro?>
                    </div>
                <?php } ?>

            </div>

            <?php if(!empty($data->sous_titre)) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <hr />
                        <h2 class="sector-subtitle darkcolor">
                            <?=$data->sous_titre?>
                        </h2>
                    </div>
                </div>
            <?php } ?>

        </div>
    </section>