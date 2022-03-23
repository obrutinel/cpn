
    <?php

        $showBloc1 = $showBloc2 = $showBloc3 = $showBloc4 = true;

        $typesSelected = $db->select("SELECT * FROM wagaia_pages WHERE parent = ".$_GET['parent']);
        if(!empty($typesSelected)) {
            foreach ($typesSelected as $selected) {
                if($selected->type == 'bloc_1') $showBloc1 = false;
                if($selected->type == 'bloc_2') $showBloc2 = false;
                if($selected->type == 'bloc_3') $showBloc3 = false;
                if($selected->type == 'bloc_4') $showBloc4 = false;
            }
        }
		
    ?>

    <div class="space-16"></div>
    <div class="text-right">
        <a class="btn" href="pages.php?show=list&parent=<?=$_GET['parent']?>&type=<?=$_GET['type']?>">
            < Retour
        </a>
    </div>
    <div class="space-16"></div>

    <?php if(!$showBloc1 && !$showBloc2 && !$showBloc3 && !$showBloc4) { ?>

        <div class="alert alert-info">
            Vous avez déjà créé les 4 blocs sur ce secteur d'activité
        </div>

    <?php } else { ?>

        <div id="pagelist-nav">
            Sélectionnez le type de bloc que vous souhaitez créer :
        </div>

        <form method="POST" action="pages.php?act=add&parent=<?=$_GET['parent']?>&type=<?=$_GET['type']?>">

            <input type="hidden" name="submit_form" value="add_value">

            <?php if(!empty($error)) { ?>
                <div class="alert alert-danger">
                    <?php foreach ($error as $err) { ?>
                        <?=$err?><br />
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-md-2 control-label no-padding-right" for="bloctype">Type de bloc : </label>
                <div class="col-md-4">
                    <select name="bloctype" class="form-control" id="bloctype">
                        <?php if($showBloc1) { ?><option value="bloc_1">Bloc liste simple</option><?php } ?>
                        <?php if($showBloc2) { ?><option value="bloc_2">Bloc 4 vignettes</option><?php } ?>
                        <?php if($showBloc4) { ?><option value="bloc_4">Bloc 4 vignettes</option><?php } ?>
                        <?php if($showBloc3) { ?><option value="bloc_3">Bloc liste multiple</option><?php } ?>
                    </select>
                </div>
            </div>
            <div class="space-6"></div>
            <div class="form-group">
                <label class="col-md-2 control-label no-padding-right" for="title">Titre : </label>
                <div class="col-md-4">
                    <input type="text" id="title" name="title" class="form-control">
                </div>
            </div>
            <div class="space-6"></div>
            <div class="form-group text-center">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-info">Valider</button>
                </div>
            </div>

        </form>

    <?php } ?>
