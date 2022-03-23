<?php
// Navigation pour les listes
if (isset($_GET['primary'])) {
	$_SESSION['wagaia']['pagelist'] = [];
}
if ($parent) {
	$_SESSION['wagaia']['pagelist'][$parent]['url'] = 'pages.php?show=list&parent='.$parent.'&type='.$type;
	$_SESSION['wagaia']['pagelist'][$parent]['titre'] = $parentType->titre;
}

//dump($_SESSION['wagaia']);

if (isset($_SESSION['wagaia'])) {

	$list_nav = array_filter(
		$_SESSION['wagaia']['pagelist'],
		function ($key) use ($parent) {
			return $key < $parent;
		},
		ARRAY_FILTER_USE_KEY
		);

	//dump($parentType);

	?>

		<div id="pagelist-nav">
			<?php
			$i=0;

			if (!empty($list_nav)) {
				foreach($list_nav as $v) { ++$i; ?>
					<a href='<?=$v['url'] .($i==1 ? '&primary' : null);?>'><?=$v['titre'];?></a> <i class="ace-icon fa fa-angle-double-right"></i>
					<?php
				}
			}
			echo $parentType->titre;?>
		</div>
		<?php

} ?>