
	<?php

		use Wagaia\Lib;
		
	
		$sql = "SELECT b.titre, b.intro, a.id, a.date, b.sous_titre, b.texte FROM wagaia_pages a 
					LEFT JOIN wagaia_pages_data b ON a.id = b.page_id 
					WHERE a.parent = '".$parent."' AND b.lg = 'fr' AND a.type = 'demande-contact' ORDER BY date DESC";
		$data = $db->select($sql);
		
	?>
	
	<thead>
		<tr>
			<th>Nom</th>
			<th>E-mail</th>
			<th>Message</th>
			<th>Date</th>
			<th width="200">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $k=>$v) : ?>
			<tr>
				<td><?=$v->titre?></td>
				<td><a href="mailto:<?=$v->sous_titre?>"><?=$v->sous_titre?></a></td>
				<td><?=nl2br($v->texte)?></td>
				<td><?=date('d/m/Y H:i:s', strtotime($v->date))?></td>
				<td class="nowrap" width="200">
					<div class="action-buttons">
						<a title="Supprimer" data-placement="top" rel="tooltip" href="#" role="button" data-target="#myModal<?=$v->id?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="icon-trash bigger-120"></i></a>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
	</tbody>