<?php
namespace Jules\NewslettersPlugin\Shortcodes;

use Jules\NewslettersPlugin\NewslettersPlugin;

class NewslettersShortcode {

    private $m_newslettersplugin;

    /**
     * Constructeur de NewslettersShortcode
     *  
     * @param NewslettersPlugin $newlettersplugin
     * 
     * @return void
     */
    public function __construct(NewslettersPlugin $newslettersplugin) 
    {
        $this->m_newslettersplugin = $newslettersplugin;

        add_shortcode('newsletters_form', array($this, 'newsletters_form')); // Ajout du shortcode
        add_action('init', array($this, 'add_newsletters_form_data'));
    }

    /**
     * Formulaire d'inscription à la newsletters
     * 
     * @return string|false
     */
    public function newsletters_form() : ?string
    {
        ob_start(); // Output buffering ?>

        <!-- Form -->
        <form id="newsletters_form" method="post" action="">
            <input type="text" name="first_name" placeholder="Prénom" required>
            <input type="text" name="last_name" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div id="map" style="width: 100%; height: 400px;"></div>

            <button type="submit">S'inscrire</button>
        </form>

        <script src="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.js"></script>
        <link href="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.css" rel="stylesheet" />
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const map = new maplibregl.Map({
                    container: 'map',
                    style: 'https://api.maptiler.com/maps/streets/style.json?key=Jeb04tCk3RTY9RpbGz9r',
                    center: [0, 0],
                    zoom: 2
                });

                const marker = new maplibregl.Marker()
                    .setLngLat([0, 0])
                    .addTo(map);

                map.on('click', (event) => {
                    const lngLat = event.lngLat;
                    marker.setLngLat(lngLat);
                        
                    document.getElementById('latitude').value = lngLat.lat.toFixed(8); 
                    document.getElementById('longitude').value = lngLat.lng.toFixed(8);
                });
            });
        </script>

        <?php return ob_get_clean(); // Clear output buffer
    }

    /**
     * Ajout des données du formulaire dans la base de données
     * 
     * @return void
     */
    public function add_newsletters_form_data() : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['latitude'], $_POST['longitude']))
        {
            // sanitize pour sécurité (input user)
            $firstName = sanitize_text_field(trim($_POST['first_name']));
            $lastName = sanitize_text_field(trim($_POST['last_name']));

            // trim permet d'enlever les espaces blancs et les autres caractères au début
            $email = sanitize_email(trim($_POST['email']));

            $latitude = floatval(trim($_POST['latitude']));
            $longitude = floatval(trim($_POST['longitude']));

            $this->m_newslettersplugin->add_subscriber($firstName, $lastName, $email, $latitude, $longitude);
        }
    }
}
