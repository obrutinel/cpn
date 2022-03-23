<?php

use Wagaia\Tables;
use Wagaia\Access;
use Wagaia\Lib;
use Symfony\Component\HttpFoundation\Request;
use Stringy\Stringy as S;


if ($_POST) {

	/* -------------------------------------
    *   Traite les suppressions en mode AJAX
    * ------------------------------------- */

	if (isset($_POST['ajax'])) {

		require_once('../../vendor/autoload.php');

		extract($_POST);
		$json_response = [];

		Lib::json($json_response);

	} else {

		/*-------------------------------
		* Traite la requête $_POST
		* ----------------------------- */
		
		
		/*if ($type && $type == 'adherent') {
			
			$db->query("DELETE FROM wagaia_adherent WHERE page_id = ".$_POST['id']);
			$db->query("DELETE FROM wagaia_adherent_contact WHERE page_id = ".$_POST['id']);
			$db->query("DELETE FROM wagaia_adherent_production WHERE page_id = ".$_POST['id']);
			$db->query("DELETE FROM wagaia_adherent_commercialisation WHERE page_id = ".$_POST['id']);
			
			if(!empty($_POST['entreprise'])) {
					
				$sql = "INSERT INTO wagaia_adherent (page_id, raison_sociale, forme_juridique, siret, adresse_1, adresse_2, cp_ville, gps, telephone, mail_contact, site_internet)
							VALUES (
								".$_POST['id'].",
								'".$db->escape($_POST['entreprise']['raison_sociale'])."',
								'".$db->escape($_POST['entreprise']['forme_juridique'])."',
								'".$db->escape($_POST['entreprise']['siret'])."',
								'".$db->escape($_POST['entreprise']['adresse_1'])."',
								'".$db->escape($_POST['entreprise']['adresse_2'])."',
								'".$db->escape($_POST['entreprise']['cp_ville'])."',
								'".$db->escape($_POST['entreprise']['gps'])."',
								'".$db->escape($_POST['entreprise']['telephone'])."',
								'".$db->escape($_POST['entreprise']['mail_contact'])."',
								'".$db->escape($_POST['entreprise']['site_internet'])."'
							)";
				
				$db->query($sql);
					
			}
			
			
			if(!empty($_POST['contact'])) {
				foreach($_POST['contact'] as $k => $v) {
					
					$sql = "INSERT INTO wagaia_adherent_contact (page_id, num, statut, nom, tel, mail)
								VALUES (
									".$_POST['id'].",
									".$k.",
									'".$db->escape($v['statut'])."',
									'".$db->escape($v['nom'])."',
									'".$db->escape($v['tel'])."',
									'".$db->escape($v['mail'])."'
								)";
					
					$db->query($sql);
					
				}		
			}
			

			if(!empty($_POST['production'])) {
					
				$sql = "INSERT INTO wagaia_adherent_production (page_id, chiffre_affaire, volume_production, volume_principaux, produit_1, produit_2, produit_3, produit_4, produit_5, produit_6)
							VALUES (
								".$_POST['id'].",
								'".$db->escape($_POST['production']['chiffre_affaire'])."',
								'".$db->escape($_POST['production']['volume_production'])."',
								'".$db->escape($_POST['production']['volume_principaux'])."',
								'".$db->escape($_POST['production']['produit_1'])."',
								'".$db->escape($_POST['production']['produit_2'])."',
								'".$db->escape($_POST['production']['produit_3'])."',
								'".$db->escape($_POST['production']['produit_4'])."',
								'".$db->escape($_POST['production']['produit_5'])."',
								'".$db->escape($_POST['production']['produit_6'])."'
							)";
				
				$db->query($sql);
					
			}
			
			if(!empty($_POST['commercialisation'])) {
					
				$sql = "INSERT INTO wagaia_adherent_commercialisation (page_id, circuit_de_vente, export, france_gms, france_grossiste, region, marque, qualite, magasin_de_vente, agrement_marque, developpement_durable, vente_en_ligne, ouverture)
							VALUES (
								".$_POST['id'].",
								'".$db->escape($_POST['commercialisation']['circuit_de_vente'])."',
								'".$db->escape($_POST['commercialisation']['export'])."',
								'".$db->escape($_POST['commercialisation']['france_gms'])."',
								'".$db->escape($_POST['commercialisation']['france_grossiste'])."',
								'".$db->escape($_POST['commercialisation']['region'])."',
								'".$db->escape($_POST['commercialisation']['marque'])."',
								'".$db->escape($_POST['commercialisation']['qualite'])."',
								'".$db->escape($_POST['commercialisation']['magasin_de_vente'])."',
								'".$db->escape($_POST['commercialisation']['agrement_marque'])."',
								'".$db->escape($_POST['commercialisation']['developpement_durable'])."',
								'".$db->escape($_POST['commercialisation']['vente_en_ligne'])."',
								'".$db->escape($_POST['commercialisation']['ouverture'])."'
							)";
				
				$db->query($sql);
					
			}
			
			if(!empty($_POST['entreprise']['raison_sociale'])) $url = S::create($_POST['id'].'-adherent-'.$_POST['entreprise']['raison_sociale'])->slugify();
			else $url = $_POST['id'].'-adherent';
			
			$db->query("UPDATE wagaia_pages_data SET nav_url = '".$url."' WHERE page_id = ".$_POST['id']);
			
		}*/
		
		
		// Fichiers par correspondants
		/*if ($type && $type == 'download') {

			// On efface toutes associations utilisateurs / téléchargements
			$db->query("delete from ".Tables::$users_files . " where page_id=".$id);

			$query = null;

			// Prendre les utilisateurs par groupe
			// Si un groupe est sélectionné, alors tous ses membres sont concernés
			if (isset($groups)) {
				foreach($groups as $group) {
					$db->query("insert into ".Tables::$users_files . " (group_id, page_id) values(".$group.", ".$id.") ");
				}

				// Puisqu'on a enregistré déjà les groupes pour la page, on va les récupérer pour trouver les utilisateurs
				$query.= "(select concat_ws(' ', first_name, last_name) as name, email from ".Tables::$users ." where groupe in (select group_id from ".Tables::$users_files ." where page_id={$id}))";
			}

			// Prendre les utilisateurs individuels
			if (isset($users)) {
				foreach($users as $user) {
					$db->query("insert into ".Tables::$users_files . " (user_id, page_id) values(".$user.", ".$id.") ");
				}

				// Unir aves les groupes
				if (isset($groups)) {
					$query.= " UNION ";
				}
				$query.= "(select concat_ws(' ', first_name, last_name) as name, email from ".Tables::$users ." where id in(".implode(',', $users)."))";
			}

			if ($query) {
				$users = $db->select($query);
			}
		}*/

	}
		
/*
|---------------------------------------------
| AFFICHAGES
|---------------------------------------------
*/
} else {
	
	/*if ($type == 'download') {

		$users = (new Access())->index();
		$user_files = array_keys($db->select("select user_id from ".Tables::$users_files ." where page_id=".$identifiant . ' and user_id !=0', 'user_id'));
		$group_files = array_keys($db->select("select group_id from ".Tables::$users_files ." where page_id=".$identifiant . ' and group_id !=0', 'group_id'));
		//dump($user_files);dump($group_files);

		$groups = $db->select("select a.id, titre, (select count(b.id) from ". Tables::$users ." b where b.groupe=a.id) as count from ".Tables::$pages . " a where type='group'" ,'id');

		foreach($groups as $g) {
			$g->users = $db->select("select concat_ws(' ', first_name, last_name) name, title, id from ". Tables::$users ." where groupe=".$g->id);
		}

		?>

		<div class="col-sm-12 gallery" id="users">
			<h3 class="header blue lighter smaller clear">
				<i class="ace-icon fa fa-users smaller-90"></i>
				Attributions correspondants
			</h3>
			<?php

			if (!empty($groups)) {

				$count = count($groups);

				$limit = 5;

				if($count > 20) {
					$limit = 10;
				} elseif($count > 80) {
					$limit = 20;
				}
				$i = 0;?>

				<ul>
					<li>
						<input id="all-users" type="checkbox" name="all_users" value="0" <?= (empty($user_files) && empty($group_files)) ? 'checked' : null;?> /> Tous</li>
						<?php
						foreach($groups as $group) { ?>

						<li>
							<input type="checkbox" name="groups[]" value="<?=$group->id;?>" <?=$group_files && in_array($group->id, $group_files) ? 'checked' : null;?> /> <span><?=$group->titre . " ({$group->count}";?> correspondants)</span>
								<?php
								if ($group->count > 0) { ?>
									<ul class="subgroup" style="display: none;">
									<?php
									foreach($group->users as $user) { ?>
										<li>
											<input type="checkbox" name="users[]" value="<?=$user->id;?>" <?=$user_files && in_array($user->id, $user_files) ? 'checked' : null;?> /> <?=$user->name . (!empty($user->title) ? ', '. $user->title : null);?>
										</li>
										<?php
									} ?>
									</ul>
								<?php
								} ?>
						</li>
						<?php
						++$i;
						if ($i >= $limit) {
							$count = $count - $limit;
							if ($count > 0) { ?>
						</ul>
						<ul>
							<?php
						}
						$i = 0;
					}
				} ?>
			</ul>
			<?php
		}

		session_notification('file_users');
		
	}*/
	
	
	/*if ($type == 'adherent') {
		
		$adherent = $db->get("SELECT * FROM wagaia_adherent WHERE page_id = ".$data->id);
		$adherentContact = $db->select("SELECT * FROM wagaia_adherent_contact WHERE page_id = ".$data->id);
		$adherentProduction = $db->get("SELECT * FROM wagaia_adherent_production WHERE page_id = ".$data->id);
		$adherentCommercialisation = $db->get("SELECT * FROM wagaia_adherent_commercialisation WHERE page_id = ".$data->id);
		
	
	?>
		
		<div class="row">
		
			<div class="col-xs-12 col-sm-6 widget-container-col" id="widget-container-col-7">
				<div class="widget-box">
					<div class="widget-header widget-header-flat">
						<h5 class="widget-title">Entreprise</h5>
					</div>

					<div class="widget-body">
						<div class="widget-main">
						
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="raison_sociale"> Raison sociale : </label>
								<div class="col-sm-9">
									<input type="text" id="raison_sociale" name="entreprise[raison_sociale]" placeholder="" value="<?=$adherent->raison_sociale?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="forme_juridique"> Forme juridique : </label>
								<div class="col-sm-9">
									<input type="text" id="forme_juridique" name="entreprise[forme_juridique]" placeholder="" value="<?=$adherent->forme_juridique?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>					
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="adresse_1"> Adresse 1 : </label>
								<div class="col-sm-9">
									<input type="text" id="adresse_1" name="entreprise[adresse_1]" placeholder="" value="<?=$adherent->adresse_1?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="adresse_2"> Adresse 2 : </label>
								<div class="col-sm-9">
									<input type="text" id="adresse_2" name="entreprise[adresse_2]" placeholder="" value="<?=$adherent->adresse_2?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="cp_ville"> CP / Ville : </label>
								<div class="col-sm-9">
									<input type="text" id="cp_ville" name="entreprise[cp_ville]" placeholder="" value="<?=$adherent->cp_ville?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="gps"> Coordonnées GPS : </label>
								<div class="col-sm-9">
									<input type="text" id="gps" name="entreprise[gps]" placeholder="" value="<?=$adherent->gps?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="telephone"> Téléphone : </label>
								<div class="col-sm-9">
									<input type="text" id="telephone" name="entreprise[telephone]" placeholder="" value="<?=$adherent->telephone?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>	
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="mail_contact"> Email de contact : </label>
								<div class="col-sm-9">
									<input type="text" id="mail_contact" name="entreprise[mail_contact]" placeholder="" value="<?=$adherent->mail_contact?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="site_internet"> Site internet : </label>
								<div class="col-sm-9">
									<input type="text" id="site_internet" name="entreprise[site_internet]" placeholder="" value="<?=$adherent->site_internet?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-6 widget-container-col" id="widget-container-col-7">
				<div class="widget-box">
					<div class="widget-header widget-header-flat">
						<h5 class="widget-title">Contacts</h5>
					</div>

					<div class="widget-body">
						<div class="widget-main">
						
							<div class="form-group">
								<div class="row">
									<div class="col-md-2">
										<span>Président</span>
										<input type="hidden" name="contact[1][statut]" value="Président" />
									</div>
									<div class="col-md-10">
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="nom_prenom_1"> Nom & prénom : </label>
											<div class="col-sm-9">
												<input type="text" id="nom_prenom_1" name="contact[1][nom]" placeholder="" value="<?=$adherentContact[0]->nom?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="tel_1"> Tél : </label>
											<div class="col-sm-9">
												<input type="text" id="tel_1" name="contact[1][tel]" placeholder="" value="<?=$adherentContact[0]->tel?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="mail_1"> Mail : </label>
											<div class="col-sm-9">
												<input type="text" id="mail_1" name="contact[1][mail]" placeholder="" value="<?=$adherentContact[0]->mail?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="space-6"></div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-2">
										<span>Directeur</span>
										<input type="hidden" name="contact[2][statut]" value="Directeur" />
									</div>
									<div class="col-md-10">
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="nom_prenom_2"> Nom & prénom : </label>
											<div class="col-sm-9">
												<input type="text" id="nom_prenom_2" name="contact[2][nom]" placeholder="" value="<?=$adherentContact[1]->nom?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="tel_2"> Tél : </label>
											<div class="col-sm-9">
												<input type="text" id="tel_2" name="contact[2][tel]" placeholder="" value="<?=$adherentContact[1]->tel?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="mail_2"> Mail : </label>
											<div class="col-sm-9">
												<input type="text" id="mail_2" name="contact[2][mail]" placeholder="" value="<?=$adherentContact[1]->mail?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="space-6"></div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-2">
										<span>Resp. administratif</span>
										<input type="hidden" name="contact[3][statut]" value="Resp. administratif" />
									</div>
									<div class="col-md-10">
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="nom_prenom_3"> Nom & prénom : </label>
											<div class="col-sm-9">
												<input type="text" id="nom_prenom_3" name="contact[3][nom]" placeholder="" value="<?=$adherentContact[2]->nom?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="tel_3"> Tél : </label>
											<div class="col-sm-9">
												<input type="text" id="tel_3" name="contact[3][tel]" placeholder="" value="<?=$adherentContact[2]->tel?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="mail_3"> Mail : </label>
											<div class="col-sm-9">
												<input type="text" id="mail_3" name="contact[3][mail]" placeholder="" value="<?=$adherentContact[2]->mail?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="space-6"></div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-2">
										<span>Resp. commercial</span>
										<input type="hidden" name="contact[4][statut]" value="Resp. commercial" />
									</div>
									<div class="col-md-10">
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="nom_prenom_4"> Nom & prénom : </label>
											<div class="col-sm-9">
												<input type="text" id="nom_prenom_4" name="contact[4][nom]" placeholder="" value="<?=$adherentContact[3]->nom?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="tel_4"> Tél : </label>
											<div class="col-sm-9">
												<input type="text" id="tel_4" name="contact[4][tel]" placeholder="" value="<?=$adherentContact[3]->tel?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="mail_4"> Mail : </label>
											<div class="col-sm-9">
												<input type="text" id="mail_4" name="contact[4][mail]" placeholder="" value="<?=$adherentContact[3]->mail?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="space-6"></div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-2">
										<span>Resp. technique</span>
										<input type="hidden" name="contact[5][statut]" value="Resp. technique" />
									</div>
									<div class="col-md-10">
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="nom_prenom_5"> Nom & prénom : </label>
											<div class="col-sm-9">
												<input type="text" id="nom_prenom_5" name="contact[5][nom]" placeholder="" value="<?=$adherentContact[4]->nom?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="tel_5"> Tél : </label>
											<div class="col-sm-9">
												<input type="text" id="tel_5" name="contact[5][tel]" placeholder="" value="<?=$adherentContact[4]->tel?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 control-label no-padding-right" for="mail_5"> Mail : </label>
											<div class="col-sm-9">
												<input type="text" id="mail_5" name="contact[5][mail]" placeholder="" value="<?=$adherentContact[4]->mail?>" class="form-control col-xs-10 col-sm-5">
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					
				</div>
			</div>
			
			
			<div class="col-xs-12 col-sm-6 widget-container-col" id="widget-container-col-7">
				<div class="widget-box">
					<div class="widget-header widget-header-flat">
						<h5 class="widget-title">Production</h5>
					</div>

					<div class="widget-body">
						<div class="widget-main">
						
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="chiffre_affaire"> Chiffre d'affaires: </label>
								<div class="col-sm-8">
									<input type="text" id="chiffre_affaire" name="production[chiffre_affaire]" placeholder="M€" value="<?=$adherentProduction->chiffre_affaire?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="volume_production"> Volume de production total : </label>
								<div class="col-sm-8">
									<input type="text" id="volume_production" name="production[volume_production]" placeholder="" value="<?=$adherentProduction->volume_production?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>				
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="produit_1"> Produits : </label>
								<div class="col-sm-8">
									<input type="text" id="produit_1" name="production[produit_1]" placeholder="" value="<?=$adherentProduction->produit_1?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<!--<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="produit_2"> Produit 2 : </label>
								<div class="col-sm-8">
									<input type="text" id="produit_2" name="production[produit_2]" placeholder="" value="<?=$adherentProduction->produit_2?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="produit_3"> Produit 3 : </label>
								<div class="col-sm-8">
									<input type="text" id="produit_3" name="production[produit_3]" placeholder="" value="<?=$adherentProduction->produit_3?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="produit_4"> Produit 4 : </label>
								<div class="col-sm-8">
									<input type="text" id="produit_4" name="production[produit_4]" placeholder="" value="<?=$adherentProduction->produit_4?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="produit_5"> Produit 5 : </label>
								<div class="col-sm-8">
									<input type="text" id="produit_5" name="production[produit_5]" placeholder="" value="<?=$adherentProduction->produit_5?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="produit_6"> Produit 6 : </label>
								<div class="col-sm-8">
									<input type="text" id="produit_6" name="production[produit_6]" placeholder="" value="<?=$adherentProduction->produit_6?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>		
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-6 widget-container-col" id="widget-container-col-7">
				<div class="widget-box">
					<div class="widget-header widget-header-flat">
						<h5 class="widget-title">Commercialisation</h5>
					</div>

					<div class="widget-body">
						<div class="widget-main">
						
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="marque"> Marques commerciales : </label>
								<div class="col-sm-8">
									<input type="text" id="marque" name="commercialisation[marque]" placeholder="" value="<?=$adherentCommercialisation->marque?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="qualite"> Signes de qualité : </label>
								<div class="col-sm-8">
									<input type="text" id="qualite" name="commercialisation[qualite]" placeholder="préciser" value="<?=$adherentCommercialisation->qualite?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="magasin_de_vente"> Magasin vente directe en propriété : </label>
								<div class="col-sm-8">
									<input type="text" id="magasin_de_vente" name="commercialisation[magasin_de_vente]" placeholder="nombre et communes" value="<?=$adherentCommercialisation->magasin_de_vente?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="agrement_marque"> Agrément marque Sud de France : </label>
								<div class="col-sm-8">
									<input type="text" id="agrement_marque" name="commercialisation[agrement_marque]" placeholder="Oui / Non" value="<?=$adherentCommercialisation->agrement_marque?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>	
							<div class="space-4"></div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right" for="developpement_durable"> Dévéloppement durable / RSE : </label>
								<div class="col-sm-8">
									<input type="text" id="developpement_durable" name="commercialisation[developpement_durable]" placeholder="préciser" value="<?=$adherentCommercialisation->developpement_durable?>" class="form-control col-xs-10 col-sm-5">
								</div>
							</div>						
							
						</div>
					</div>
				</div>
			</div>
			
		</div>	
	
	
	<?php
		
		
	}*/


} ?>