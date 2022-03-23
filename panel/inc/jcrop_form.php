<?php

	$image_fail = $resized_img = false;

	if ($jcrop) {

		$image = '<input class="input-file" name="image" type="file">';

		if (!empty($data->image)) {

			$temp_file = IMG_FOLDER.'tmp_'.$data->image;

			$image = null;


			if (file_exists($temp_file) && !file_exists(IMG_FOLDER.$data->image) ) {

				$resized_img = list($temp_width, $temp_height) = getimagesize($temp_file);

				if($temp_width < $jcrop['w']) {
					$image_fail = true;
					$image .= '<div class="alert alert-danger">ATTENTION ! Votre image est en dessous de la largeur minimale requise - '.$jcrop['w'].'px ( la vôtre fait '. $temp_width.'px ).</div>';
				}
				if($temp_height < $jcrop['h']) {
					$image_fail = true;
					$image .= '<div class="alert alert-danger">ATTENTION ! Votre image est en dessous de <b>la hauteur minimale requise</b> - '.$jcrop['h'].'px (la vôtre fait '. $temp_height.'px).</div>';
				}

				if (!$image_fail) {
				$image .= '<div class="alert alert-danger">ATTENTION ! Vous n\'avez pas encore recadr&eacute; votre photo. Celle-ci n\'apparaitra pas sur le site.</div>';
				}

				if($jcrop) {

				$image .= '<input type="hidden" id="x1" name="x1image" />
					 		<input type="hidden" id="y1" name="y1image" />
					  		<input type="hidden" id="w" name="wimage" />
					  		<input type="hidden" id="h" name="himage" />
					  		<input type="hidden" id="wi" name="wiimage" value="'.$jcrop['w'].'" />
					  		<input type="hidden" id="he" name="heimage" value="'.$jcrop['h'].'" />';
				$image .= '<div><img alt="150x150" src="'.IMG_URL.'tmp_'.$data->image.'" id="crop_image" style="width: 100%;" /></div>';
				$image .= '<div class="space-4"></div>
							<div class="form-group">
								<a href="'.$_SERVER['PHP_SELF'].'?act=delete_photo&id='.$identifiant.'&num=1" class="btn btn-danger"> <i class="white icon-trash bigger-110"></i> Supprimer la photo </a>';
							if($temp_width >= $jcrop['w'] && !$image_fail) {
								$image .= '<button class="btn btn-warning" name="simg" type="submit"><i class="icon-ok bigger-110"></i> Valider le recadrage</button>';
							}
							$image .= '</div>';
					}

			} else {

				$image = '<ul class="ace-thumbnails">
							  <li>
								<div> <img alt="150x150" src="'.IMG_URL.$data->image.'" style="max-height:300px; max-width: 100%;" />
								  <div class="text">
									<a href="'.IMG_URL.$data->image.'" data-rel="colorbox"> <i class=" white icon-zoom-in bigger-160"></i> </a>
									<a href="'.$_SERVER['PHP_SELF'].'?act=delete_photo&id='.$identifiant.'&num=1"> <i class="white icon-trash bigger-160"></i> </a> </div>
								</div>
							  </li>
							</ul>';
			}
		}
		
		
		
		$image2 = '<input class="input-file" name="image2" type="file">';

		if (!empty($data->image2)) {
			
			$jcropW = 375;
			$jcropH = 225;

			$temp_file2 = IMG_FOLDER.'tmp_'.$data->image2;

			$image2 = null;


			if (file_exists($temp_file2) && !file_exists(IMG_FOLDER.$data->image2) ) {

				$resized_img = list($temp_width, $temp_height) = getimagesize($temp_file2);

				if($temp_width < $jcropW) {
					$image_fail2 = true;
					$image2 .= '<div class="alert alert-danger">ATTENTION ! Votre image est en dessous de la largeur minimale requise - '.$jcropW.'px ( la vôtre fait '. $temp_width.'px ).</div>';
				}
				if($temp_height < $jcropH) {
					$image_fail2 = true;
					$image2 .= '<div class="alert alert-danger">ATTENTION ! Votre image est en dessous de <b>la hauteur minimale requise</b> - '.$jcropH.'px (la vôtre fait '. $temp_height.'px).</div>';
				}

				if (!$image_fail2) {
					$image2 .= '<div class="alert alert-danger">ATTENTION ! Vous n\'avez pas encore recadr&eacute; votre photo. Celle-ci n\'apparaitra pas sur le site.</div>';
				}

				if($jcrop) {

				$image2 .= '<input type="hidden" id="x1" name="x1image" />
					 		<input type="hidden" id="y1" name="y1image" />
					  		<input type="hidden" id="w" name="wimage" />
					  		<input type="hidden" id="h" name="himage" />
					  		<input type="hidden" id="wi" name="wiimage" value="375" />
					  		<input type="hidden" id="he" name="heimage" value="225" />';
				$image2 .= '<div><img alt="150x150" src="'.IMG_URL.'tmp_'.$data->image2.'" id="crop_image" style="width: 100%;" /></div>';
				$image2 .= '<div class="space-4"></div>
							<div class="form-group">
								<a href="'.$_SERVER['PHP_SELF'].'?act=delete_photo_2&id='.$identifiant.'&num=1" class="btn btn-danger"> <i class="white icon-trash bigger-110"></i> Supprimer la photo </a>';
							if($temp_width >= $jcropW && !$image_fail) {
								$image2 .= '<button class="btn btn-warning" name="simg2" type="submit"><i class="icon-ok bigger-110"></i> Valider le recadrage</button>';
							}
							$image2 .= '</div>';
					}

			} else {

				$image2 = '<ul class="ace-thumbnails">
							  <li>
								<div> <img alt="150x150" src="'.IMG_URL.$data->image2.'" style="max-height:300px; max-width: 100%;" />
								  <div class="text">
									<a href="'.IMG_URL.$data->image2.'" data-rel="colorbox"> <i class=" white icon-zoom-in bigger-160"></i> </a>
									<a href="'.$_SERVER['PHP_SELF'].'?act=delete_photo_2&id='.$identifiant.'&num=1"> <i class="white icon-trash bigger-160"></i> </a> </div>
								</div>
							  </li>
							</ul>';
			}
		}
		
		
	}