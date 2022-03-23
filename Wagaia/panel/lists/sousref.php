
	<?php
		
		$sql = "SELECT a.type, a.parent, b.titre, b.intro, a.id, a.date, b.sous_titre, b.texte, a.id, a.icon FROM wagaia_pages a 
					LEFT JOIN wagaia_pages_data b ON a.id = b.page_id 
					WHERE a.parent = '".$parent."' AND b.lg = 'fr' AND a.type IN('ref_1', 'ref_2', 'ref_3') ORDER BY position";
		$data = $db->select($sql);
		
	?>	

	<thead>
		<tr>
			<th>Titre</th>
			<th width="200">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $k=>$v) : ?>
			<tr>
				<td>
					<input type="hidden" name='order[<?php echo $v->id;?>]' class="order" value="">
					<?=$v->titre?>
				</td>
				<td class="nowrap" width="200">
					<div class="action-buttons">
						<a title="Modifier" data-toggle="tooltip" rel="tooltip" href="pages.php?show=edit&id=<?=$v->id?>" class="btn btn-xs btn-info"><i class="icon-pencil bigger-120"></i></a>
                        <a title="Sous blocs" data-toggle="tooltip" rel="tooltip" href="pages.php?show=list&content_type=list&parent=<?=$v->id?>&type=sous<?=$v->type?>" class="btn btn-xs btn-success"><i class="fa fa-th-large bigger-120"></i></a>
						<a title="Supprimer" data-placement="top" rel="tooltip" href="#" role="button" data-target="#myModal<?=$v->id?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="icon-trash bigger-120"></i></a>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
	</tbody>