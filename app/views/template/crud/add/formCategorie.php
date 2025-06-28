<form class="form" action="<?= Flight::base() ?>/crud/Categorie/add" method="get">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="country-floating">nom de catégorie</label>
                <input type="text" id="country-floating" class="form-control" placeholder="ex: infrastructure" name="nom">
            </div>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-1 mb-1">valider</button>
            <button type="reset" class="btn btn-light-secondary me-1 mb-1">reinitialiser</button>
        </div>
    </div>
</form>