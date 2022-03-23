<?php

use Wagaia\Tables;

/*----------------------------------
 * TRAITEMENT GLOBAL DES BLOCS
 * ---------------------------------
 */

if ($_POST) {

	//dump($_POST);

	$db->query('delete from '.Tables::$blocs.' where page_data_id='.$_POST['page_data_id'][$k]);

	foreach($website_lg as $k=>$v) {
		foreach($_POST['bloc_titre'][$v] as $key=>$bloc) {
			$db->query("insert into ".Tables::$blocs." (titre, texte, page_data_id) values ('".$db->escape($bloc)."', '".$db->escape($_POST['bloc_texte'][$v][$key])."', ".$db->escape($_POST['page_data_id'][$k]).")");
		}
	}
} else {
	if (!$db->is_table('wagaia_blocs')) {
		$db->query('CREATE TABLE `wagaia_blocs` (
			`id` int(10) unsigned DEFAULT NULL,
			`page_data_id` int(10) unsigned DEFAULT NULL,
			`titre` TEXT NULL,
			`texte` text COLLATE utf8_unicode_ci,
			KEY `FK_wagaia_blocs_wagaia_pages_data` (`page_data_id`),
			CONSTRAINT `FK_wagaia_blocs_wagaia_pages_data` FOREIGN KEY (`page_data_id`) REFERENCES `wagaia_pages_data` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
	}

	?>
	<script>
		$(function() {

			var WagaiaDeleteBloc = function() {
				$('.wagaia-delete-bloc').off().on('click', function(e) {
					e.preventDefault();
					$(this).parents().eq(1).remove();
				});
			}

			WagaiaDeleteBloc();

			$('.WagaiaAddBloc').click(function(e) {
				e.preventDefault();
				console.log('HELLO');

				var lg = ['fr'],
				blocs = $('.WagaiaBlocs:first div.col-sm-6').length,
				bloc_id = (blocs+1);

				tinymce.init(simpleMce_settings);

				$('.WagaiaBlocs').each(function() {
					var  lg = $(this).attr('data-lg'),
					bloc = '<div class="col-sm-6"><h4 class="header blue smaller">Bloc N° '+bloc_id+':</h4><input class="form-control" type="text" name="bloc_titre['+lg+'][]" placeholder="Titre"/><br><textarea style="height: 100px" id="bloc_'+bloc_id+'" class="simpleMce form-control" name="bloc_texte['+lg+'][]"></textarea></div>';
					$(this).append(bloc);
					tinymce.execCommand('mceAddEditor',false, 'bloc_'+bloc_id);
				});
				WagaiaDeleteBloc();
			});


		});
	</script>
<?php } ?>