<?php

namespace Pentiminax\DuplicatePost\Controller;

use Pentiminax\DuplicatePost\PentiminaxPlugin;

class AdminController
{
    // Choix possibles dans les paramètres du plugin
	const REDIRECT_TO_LIST = 0;
	const REDIRECT_TO_EDIT = 1;

	/**
	 * Constructeur de AdminController
     *
     * Appel de la méthode init_hooks()
	 */
	public function __construct()
    {
		$this->init_hooks();
	}


    /**
     * Initialise les hooks
     *
     * @return void
    */
	public function init_hooks() : void
    {
        try {
	        add_action( 'admin_init', [$this, 'admin_init']);
	        add_action( 'admin_menu', [$this, 'admin_menu']);

	        add_action( 'post_row_actions', [$this, 'duplicate_post_actions'], 10, 2);
	        add_action( 'admin_action_duplicate', [$this, 'duplicate_post'], 10, 2);
        } catch ( \Exception $e ) {
	        error_log('Erreur dans init_hooks: ' . $e->getMessage());

	        PentiminaxPlugin::render("error", [
		        "message" => "Une <strong>erreur inattendue</strong> est survenue : " . esc_html($e->getMessage())
	        ]);
        }

	}

    /**
     * Initialisation du formulaire pour le paramétrage du plugin
     *
     * @return void
    */
	public function admin_init() : void
	{
		register_setting( 'duplicate_post_general', 'duplicate_post_general' );
		add_settings_section( 'duplicate_post_main', null, null, 'duplicate_post' );
		add_settings_field( 'redirect_to', 'Rediriger vers après avoir cliqué sur "Dupliquer" pour les posts', [
			$this,
			'redirect_to_render'
		], 'duplicate_post', 'duplicate_post_main');
	}


	/**
     * Ajout de la section Duplicate Post dans les paramètres (settings)
     *
     * @return void
     */
	public function admin_menu() : void
    {
		add_options_page( 'DuplicatePost', 'Duplicate Post', 'manage_options', 'duplicate_post', [
			$this,
			'config_page'
		] );
	}

    /**
     * Renvoie la vue de configuration
     *
     * @return void
     */
	public function config_page() : void
    {
		PentiminaxPlugin::render('config');
	}

    /**
     * Ajout de l'action "Dupliquer"
     *
     * @param array $actions
     * @param \WP_Post $post
     *
     * @return array
    */
	public function duplicate_post_actions(array $actions, \WP_Post $post) : array
	{
		if (current_user_can('edit_post', $post->ID))
		{
			$post_id = $post->ID;
			$actions['duplicate_post'] = "<a href='admin.php?post=$post_id&action=duplicate'>Dupliquer</a>";
		}
		return $actions;
	}

    /**
     * Duplication du post
     *
     * @return void
     */
	public function duplicate_post() : void
	{
		$general_options = get_option( 'duplicate_post_general', [
			'redirect_to' => 0
		]);

		// Permet de savoir si on renvoie vers la liste des articles ou le post dupliquer
		$redirect_to = intval($general_options['redirect_to']);

		$post_id = (isset($_GET['post'])) ? intval($_GET['post']) : 0;

		$this->verify_request($post_id);

        // Récupération du post
		$post = get_post($post_id);

		if (!$post)
		{
			wp_die("Une erreur est survenue. L'article $post_id est introuvable.", "Article introuvable !");
		}

        // Récupération des données du post
		$post_data = [
			'post_author' => $post->post_author,
			'post_content' => $post->post_content,
			'post_title' => $post->post_title,
			'post_excerpt' => $post->post_excerpt,
			'post_status' => $post->post_status,
			'comment_status' => $post->comment_status,
			'ping_status' => $post->ping_status,
			'post_password' => $post->post_password,
			'to_ping' => $post->to_ping,
			'post_parent' => $post->post_parent,
			'menu_order' => $post->menu_order
		];

        // Création du nouveau post avec les datas du post que l'on veut dupliquer
		$new_post_id = wp_insert_post($post_data, true);

        // Redirection
		switch ($redirect_to) {
			case self::REDIRECT_TO_LIST:
				wp_safe_redirect(admin_url("edit.php"));
				break;
			case self::REDIRECT_TO_EDIT:
				wp_safe_redirect(admin_url("post.php?post=$new_post_id&action=edit"));

		}
	}

    /**
     * Redirige l'utilisateur en fonction de son choix
     *
     * Choix possibles :
     *       - Liste des posts
     *       - Edition du posts dupliquer
     *
     * @return void
    */
	public function redirect_to_render() : void
    {
        $general_options = get_option( 'duplicate_post_general', [
                'redirect_to' => 0
        ]);
        $selectedValue = $general_options['redirect_to'];
        ?>
        <label>
            <select name="duplicate_post_general[redirect_to]">
                <option value="<?= self::REDIRECT_TO_LIST ?>" <?= selected(self::REDIRECT_TO_LIST, $selectedValue)?>>Vers la liste des articles</option>
                <option value="<?= self::REDIRECT_TO_EDIT ?>" <?= selected(self::REDIRECT_TO_EDIT, $selectedValue)?>>Vers l'écran de modification de l'article dupliqué</option>
            </select>
        </label>
	    <?php
	}

    /**
     * Vérifie si l'utilisateur peut editer les posts sinon, il est renvoie sur l'url de base
     *
     * @param int $post_id
     *
     * @return void
     */
    public function verify_request(int $post_id) : void
    {
        $referer = wp_get_referer();
        $location = $referer ? : get_site_url();

        if (!current_user_can('edit_post', $post_id))
        {
            wp_safe_redirect($location);
        }
    }
}
?>
