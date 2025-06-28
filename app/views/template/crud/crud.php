<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?></title>
    
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app-dark.css">

    <!-- modul css -->
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/extensions/flatpickr/flatpickr.min.css">
</head>
<style>
    #floatingBtn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #3950A2;
        color: white;
        border: none;
        font-size: 30px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s;
    }
    
    #floatingBtn:hover {
        background-color: rgb(88, 108, 181);
    }
    
    #fileModal {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 300px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        padding: 20px;
        z-index: 99;
    }
    
    #fileForm {
        display: flex;
        flex-direction: column;
    }
    
    #fileForm > * {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    #fileInput {
        padding: 10px;
        border: 2px dashed #ddd;
        text-align: center;
    }
    
    #fileInput:hover {
        background-color: #f9f9f9;
    }
    
    #submitFile {
        background-color: #3950A2;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    
    #submitFile:hover {
        background-color: rgb(88, 108, 181);
    }
    
    #fileList {
        margin-top: 10px;
        font-size: 0.9em;
    }
    
    .fadeIn {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
<body>
    <div id="app">
        <?= Flight::menu() ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?= $titre ?></h3>
                            <p class="text-subtitle text-muted"><?= $minititre ?></p>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="row" id="table-hover-row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table id="tabToExport" class="table table-bordered mb-0">
                                            <thead>
                                                <!-- non bouclable -->
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#large">
                                                            <i class="bi bi-plus-lg"></i> faire un ajout de <?= $type ?>
                                                        </button>
                                                    </td>
                                                    <!-- fenetre d'exemple -->
                                                    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel17">faire un ajout de <?= $type ?></h4>
                                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i data-feather="x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <section id="multiple-column-form">
                                                                        <div class="row match-height">
                                                                            <div class="col-12">
                                                                                <div class="card">
                                                                                    <div class="card-content">
                                                                                        <div class="card-body">
                                                                                            <?php Flight::render($formAjout) ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">annuler</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <?php foreach ($col as $x) { ?>
                                                        <?php
                                                            $isForeignKey = false;
                                                            foreach ($foreignKey as $fk) {
                                                                if ($x['field'] == $fk['column']) {
                                                                    $isForeignKey = true;
                                                                    break;
                                                                }
                                                            }
                                                        ?>

                                                        <?php if ($x['field'] != $primaryKey && !$isForeignKey) { ?>
                                                            <th><?= $x['field'] ?></th>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $x) { ?>
                                                <tr>
                                                    <?php foreach ($col as $y) { ?>
                                                        <?php 
                                                            $isForeignKey = false;
                                                            foreach ($foreignKey as $fk) {
                                                                if ($y['field'] == $fk['column']) {
                                                                    $isForeignKey = true;
                                                                    break;
                                                                }
                                                            }
                                                        ?>

                                                        <?php if ($y['field'] != $primaryKey && !$isForeignKey) { ?>
                                                            <td><?= $x[$y['field']] ?></td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <td>
                                                        <!-- bouton de modification -->
                                                        <div class="modal-primary me-1 mb-1 d-inline-block">
                                                            <!-- Button trigger for primary theme modal -->
                                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#large-<?= $x[$primaryKey] ?>">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>

                                                            <div class="modal fade text-left" id="large-<?= $x[$primaryKey] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel17">faire une modification pour <?= $type ?></h4>
                                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <i data-feather="x"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <section id="multiple-column-form">
                                                                                <div class="row match-height">
                                                                                    <div class="col-12">
                                                                                        <div class="card">
                                                                                            <div class="card-content">
                                                                                                <div class="card-body">
                                                                                                    <?php Flight::render($formModif, ['id' => $x[$primaryKey], 'primaryKey' => $primaryKey, 'objet' => $x]) ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light-secondary"
                                                                                data-bs-dismiss="modal">
                                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                                <span class="d-none d-sm-block">annuler</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- bouton de suppression -->
                                                        <div class="modal-danger me-1 mb-1 d-inline-block">
                                                            <!-- Button trigger for danger theme modal -->
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#danger-<?= $x[$primaryKey] ?>">
                                                                <i class="bi bi-x"></i>
                                                            </button>

                                                            <!-- fenetre de confirmation -->
                                                            <div class="modal fade text-left" id="danger-<?= $x[$primaryKey] ?>" tabindex="-1" aria-labelledby="myModalLabel120" style="display: none;" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-danger">
                                                                            <h5 class="modal-title white" id="myModalLabel120">suppression de <?= $type ?>
                                                                            </h5>
                                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            voulez-vous vraiment le supprimer définitivement ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="<?= Flight::base() ?>/crud/<?= $type ?>/delete" method="get" style="display:inline;">
                                                                                <input type="hidden" name="id" value="<?= $x[$primaryKey] ?>">
                                                                                <button type="submit" class="btn btn-danger ms-1">
                                                                                    <i class="bx bx-trash d-block d-sm-none"></i>
                                                                                    <span class="d-none d-sm-block">supprimer</span>
                                                                                </button>
                                                                            </form>
                                                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                                <span class="d-none d-sm-block">annuler</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div> 
</body>
    <script src="<?= Flight::base() ?>/public/assets/static/js/components/dark.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>

    <!-- modul js -->
    <script src="<?= Flight::base() ?>/public/assets/extensions/flatpickr/flatpickr.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/static/js/pages/date-picker.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/extensions/jquery/jquery.min.js"></script>

    <!-- script js -->
</html>