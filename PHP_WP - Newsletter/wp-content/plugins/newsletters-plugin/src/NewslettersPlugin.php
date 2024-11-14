<?php

namespace Jules\NewslettersPlugin;

use Exception;
use WP_REST_Response;
use WP_Error;

use Jules\NewslettersPlugin\AdminController\AdminController;
use Jules\NewslettersPlugin\Shortcodes\NewslettersShortcode;

class NewslettersPlugin {
    const TRANSIENT_PLUGINTEST_ACTIVATED = "newsletters_plugin_activated";
	const DB_NAME = "np_inscription";

    /**
     * Constructeur de NewslettersPlugin
     * 
     * @param string $file Habituellement __FILE__ 
     * @param string $db_name Nom de la base de données
     *  
     * @return void
     */
    public function __construct(string $file)
    {
        register_activation_hook($file, array($this, 'plugin_activation'));
        add_action('admin_notices', array($this, 'notice_activation'));    

        register_deactivation_hook($file, array($this, 'plugin_deactivation'));

        // Shortcode de newsletters
        require_once NEWSLETTERS_PLUGIN_DIR . 'src/includes/shortcodes/sc_newslettersForm.php';
        new NewslettersShortcode($this);

        require_once NEWSLETTERS_PLUGIN_DIR . 'src/includes/admin/AdminController.php';
        new AdminController();

        add_action('rest_api_init', array($this, 'subscribers_api_routes')); // Ajout de la route pour récupérer les utilisateurs inscrits

        add_action('wp_enqueue_scripts', array($this, 'enqueue_maplibre_scripts')); // Ajout de maplibre
    }

    /**
     * Activation du plugin
     *
     * @return void
     */
    public function plugin_activation() {
        set_transient(self::TRANSIENT_PLUGINTEST_ACTIVATED, true); // Ajout d'un transient dans wp_options
        $this->add_newsletters_table(); // Ajout de la table qui enregistre les utilisateurs inscrits à la newsletters.
        $this->enqueue_maplibre_scripts();
    }

    /**
     * Désactivation du plugin
     *
     * @return void
     */
    public function plugin_deactivation() {
        $this->remove_newsletters_table(); // Suppression de la table qui enregistre les utilisateurs inscrits à la newsletters.
    }

    /**
     * Affiche un message pour l'activation du plugin
     *
     * @return void
     */
    public function notice_activation() : void
    {
        try {
            $transient_value = get_transient(self::TRANSIENT_PLUGINTEST_ACTIVATED); // On retrouve le transient
            if ($transient_value) { // Si il existe
                self::render('notices', [
                    'message' => "Merci d'avoir activé <strong>Newsletters Plugin</strong> !" // Message personnalisé
                ]);
                delete_transient(self::TRANSIENT_PLUGINTEST_ACTIVATED); 
            } else {
                throw new Exception("PluginTest : erreur lors de l'activation");
            }
        } catch (Exception $e) { // Récupération d'erreur
            error_log('Erreur dans notice_activation: ' . $e->getMessage());
        }
    }

    /**
     * Crée la base de données qui contient les utilisateurs inscrits à la newsletters
     * 
     * @return void
     */
    public function add_newsletters_table() : void
    {
        global $wpdb;
		$table_name = self::DB_NAME;

        try {
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                id SMALLINT(6) NOT NULL AUTO_INCREMENT,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL,
                latitude DECIMAL(10,8),
                longitude DECIMAL(11,8),
                PRIMARY KEY (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        } catch (Exception $e) {
            error_log('Erreur dans add_newsletters_table: ' . $e->getMessage());
        }
    }

    /**
     * Supprime la base de données qui contient les utilisateurs inscrits à la newsletters
     * 
     * @return void
     */
    public function remove_newsletters_table() : void
    {
        global $wpdb;
		$table_name = self::DB_NAME;

        try {
            $sql = "DROP TABLE IF EXISTS $table_name;";
            $wpdb->query($sql);
        } catch (Exception $e) {
            error_log('Erreur dans remove_newsletters_table: ' . $e->getMessage());
        }
    }

    /**
     * Affichage d'un message en fonction d'un fichier
     *
     * @param string $name Nom du fichier
     * @param array $args Message a afficher
     *
     * @return void
     */
    public static function render(string $name, array $args = []) : void
    {
        extract($args);

        $file = NEWSLETTERS_PLUGIN_DIR . "views/$name.php";

        ob_start(); // Start output buffering

        include_once ($file);

        echo ob_get_clean(); // Clear output buffer
    }

	/**
	 * Ajout d'un utilisateur dans la base de données
	 * 
	 * @param string $first_name Prénom
	 * @param string $last_name Nom
	 * @param string $email Email
	 * @param float $latitude
     * @param float $longitude
     * 
	 * @return bool Succès ou non
	 */
	public function add_subscriber(string $first_name, string $last_name, string $email, float $latitude, float $longitude) : bool
	{
		global $wpdb;
		$table_name = self::DB_NAME;

		try {
			// Donnée de l'utilisateur
			$user_data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'      => $email,
                'latitude'   => $latitude,
                'longitude'  => $longitude,
			];

			// Vérifie si l'utilisateur n'est pas déjà dans la base
			$user_existing = $wpdb->get_var($wpdb->prepare(
				"SELECT COUNT(*) FROM $table_name WHERE email = %s",
				$user_data['email']
			));

			if ($user_existing > 0) {
				throw new Exception("Utilisateur déjà présent dans la base de données !");
			}

			// Ajout de l'utilisateur
			$add_user = $wpdb->insert("$table_name", $user_data);
		
			if ($add_user === false)
			{
				throw new Exception("Erreur lors de l'insertion de l'utilisateur !");
			}

			return true;

		} catch(Exception $e) {
			error_log("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
			return false;
		}
	}


    /**
     * Enregistrement de l'api route pour récupérer les utilisateurs inscrits à la newsletter.
     * 
     * @return void
     */
    public function subscribers_api_routes() : void
    {
        register_rest_route(
            'newsletters/v1',          // Namespace de l'API
            '/subscribers',            // Endpoint de la route
            array(
                'methods'  => 'GET',
                'callback' => array($this, 'get_subscribers'),
                'permission_callback' => '__return_true'
            )
        );
    }

    /**
     * Récupère l'ensemle des utilisateurs inscrits à la newsletter
     * 
     * @return WP_REST_Response|WP_Error
     */
    public function get_subscribers()
    {
        global $wpdb;
        $table_name = self::DB_NAME;

        try {
            $sql = "SELECT * FROM $table_name";
            $user_list = $wpdb->get_results($sql); // get_results car plusieurs résultats et pas de requêtes préparés car pas de paramètres

            return rest_ensure_response($user_list);

        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des utilisateurs inscrits à la newsletter !");

            return new \WP_Error(
                'newsletter_error',
                'Une erreur est survenue lors de la récupération des données',
                array('status' => 500)
            );
        }
    }

    /**
     * Ajout de MapLibre
     * 
     * @return void
     */
    public function enqueue_maplibre_scripts() : void
    {
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_style('maplibre-css', 'https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css');
            wp_enqueue_script('maplibre-js', 'https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js', array(), null, true);
        });
    }
}
