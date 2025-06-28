<?php $categorie = Flight::get('categorie'); ?>
<form class="form" method="get" action="<?= Flight::base() ?>/crud/TypeCategorie/add">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="first-name-column">catégorie</label>
                <select class="form-select" id="basicSelect" name="categorie_id">
                    <?php foreach ($categorie as $x) { ?>
                        <option value="<?= $x['id'] ?>"><?= $x['nom'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="last-name-column">nom</label>
                <input type="text" id="last-name-column" class="form-control" placeholder="ex: hopital" name="nom">
            </div>
        </div>
         <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-1 mb-1">valider</button>
            <button type="reset" class="btn btn-light-secondary me-1 mb-1">reinitialiser</button>
        </div>
    </div>
</form>