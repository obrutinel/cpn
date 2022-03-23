<?php

if(
    !in_array($identifiant, $options_disable['tinymce']['page']) &&
    !in_array($type, $options_disable['tinymce']['type'])
  ) {

  include (ABSPATH . 'panel/inc/tinymce.php');
}


if (isset($resized_img)) { ?>
	<script src="<?=HTTP?>panel/js/wagaia_jcrop.js"></script>
<?php } ?>
<script src="<?=HTTP?>panel/js/wagaia_sortable.js"></script>