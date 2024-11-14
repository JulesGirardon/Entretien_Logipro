<?php

namespace Jules\NewslettersPlugin\AdminController;

use Jules\NewslettersPlugin\NewslettersPlugin;

class AdminController {

    /**
     * Constructeur d'AdminController
     * 
     * @param NewslettersPlugin $newlettersplugin
     * 
     * @return void
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    /**
     * Ajout de la page où l'on peut voir la liste des utilisateurs inscrits à la newsletter.
     * 
     * @return void
     */
    public function add_admin_menu() : void
    {
        add_menu_page(
            'Newsletters Plugin',
            'Liste des inscrits',
            'manage_options',
            'newsletters_liste_user',
            array($this, 'admin_menu_content')
        );
    }

    /**
     * Ajout du contenu dans le tableau des utilisateurs inscrits à la newsletter.
     * 
     * @return void
     */
    public function admin_menu_content() : void
    {
        // Récupération des inscrits
        $response = wp_remote_get(rest_url('newsletters/v1/subscribers'));

        if (is_wp_error($response)) {
            // Gestion des erreurs si la requête échoue
            echo '<div class="error"><p>Erreur lors de la récupération des données des inscrits.</p></div>';
            return;
        }

        // On récupère uniquement ce qui nous intéresse.
        $subscribers = json_decode(wp_remote_retrieve_body($response));
        ?>
        
        <div class="wrap">
        <h1>Liste des utilisateurs inscrits à la newsletter !</h1>

        <?php if (!empty($subscribers)): ?>
            <script src="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.js"></script>
            <link href="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.css" rel="stylesheet" />
            
            <table class="widefat fixed" cellspacing="0">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Localisation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $index => $subscriber): ?>
                        <tr>
                            <td><?= esc_html($subscriber->first_name) ?></td>
                            <td><?= esc_html($subscriber->last_name) ?></td>
                            <td><?= esc_html($subscriber->email) ?></td>
                            <td>
                                <div id="map-<?= $index ?>" style="width: 100%; height: 200px;"></div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const map = new maplibregl.Map({
                                            container: 'map-<?= $index ?>',
                                            style: 'https://api.maptiler.com/maps/streets/style.json?key=Jeb04tCk3RTY9RpbGz9r',
                                            center: [<?= $subscriber->longitude; ?>, <?= $subscriber->latitude; ?>],
                                            zoom: 14
                                        });
                                        
                                        const marker = new maplibregl.Marker()
                                        .setLngLat([<?= $subscriber->longitude; ?>, <?= $subscriber->latitude; ?>])
                                        .addTo(map);
                                    });
                                </script>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun utilisateur inscrit à la newsletter.</p>
        <?php endif; ?>
        </div>
        <?php
    }
}

