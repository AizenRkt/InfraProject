<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.html"><img src="<?= Flight::base() ?>/public/assets/assets/compiled/svg/logo.svg" alt="InfraProject" srcset=""></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu"> 
                <li class="sidebar-title">Home</li>   
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/" class='sidebar-link'>
                        <i class="bi bi-map"></i>
                        <span>Carte d'Antananarivo</span>
                    </a>
                </li>    
            
                <li class="sidebar-title">Fonctionnalité</li>   
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/dashboard" class='sidebar-link'>
                        <i class="bi bi-bar-chart-line"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/edition" class='sidebar-link'>
                        <i class="bi bi-table"></i>
                        <span>mode edition</span>
                    </a>
                </li>

                <li class="sidebar-title">Paramètres</li>   
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/crud/Categorie" class='sidebar-link'>
                        <i class="bi bi-tags"></i>
                        <span>Catégories</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/crud/Type" class='sidebar-link'>
                        <i class="bi bi-diagram-3"></i>
                        <span>Types</span>
                    </a>
                </li>

                <!-- <li class="sidebar-item  has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-clock"></i>
                        <span>configuration des périodes</span>
                    </a>
                
                    <ul class="submenu submenu-closed" style="--submenu-height: 86px;">
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/crud/SoldeDebut" class="submenu-link">solde de début</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/crud/Periode" class="submenu-link">période</a>
                        </li>
                    </ul>
                </li>   -->
            </ul>
        </div>
    </div>
</div>
