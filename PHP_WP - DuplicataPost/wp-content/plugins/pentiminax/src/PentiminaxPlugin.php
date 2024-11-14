<?php

namespace Pentiminax\DuplicatePost;

use Exception;
use Pentiminax\DuplicatePost\Controller\AdminController;

class PentiminaxPlugin
{
	// Suivit dans wp_options
	const TRANSIENT_DUPLICATE_POST_ACTIVATED = "pentiminax_duplicate_post_activated";

	/**
	 * Constructeur de PentiminaxPlugin
	 *
	 * Vérifie si la page actuelle est admin
	 *
	 * @param string $file
	 */
	public function __construct(string $file)
	{
		// is_admin() vérifie que la page actuelle est une page admin
		$adminController = is_admin() ? new AdminController() : null;

		if ($adminController) {
			register_activation_hook( $file, [$this, "plugin_activation"] );
			add_action('admin_notices', [$this, "notice_activation"]);
		} else {
			add_action('admin_notices', [$this, "not_admin"]);
		}
	}

	/**
	 * Suivit de l'activation du plugin
	 *
	 * @return void
	 * */
	public function plugin_activation() : void
	{
		// Suivit de l'activation du plugin
		set_transient(self::TRANSIENT_DUPLICATE_POST_ACTIVATED, true);
	}

	/**
	 * Envoie d'un message si l'activation du plugin est un succès
	 *
	 * @return void
	 */
	public function notice_activation() : void
	{
		try {
			// Debug: Check if transient is set
			$transient_value = get_transient(self::TRANSIENT_DUPLICATE_POST_ACTIVATED);
			if ($transient_value) {
				self::render('notices', [
					'message' => "Merci d'avoir activé <strong>Pentiminax Duplicate Post</strong> !"
				]);
				delete_transient(self::TRANSIENT_DUPLICATE_POST_ACTIVATED); // Remove transient after use
			} else {
				throw new Exception("PentiminaxPlugin : erreur lors de l'activation");
			}
		} catch (Exception $e) {
			error_log('Erreur dans notice_activation: ' . $e->getMessage());
		}
	}


	/**
	 * Envoie d'un message si l'interface où a été activé le plugin n'est pas admin
	 *
	 * @return void
	 */
	public function not_admin() : void
	{
		// Message d'erreur si l'utilisateur n'est pas administrateur
		self::render("error", [
			"message" => "Il faut être <strong>administrateur</strong> pour activer ce plugin !"
		]);
	}

	/**
	 * Inclure et afficher des vues
	 *
	 * @param string $name
	 * @param array $args
	 *
	 * @return void
	 */
	public static function render(string $name, array $args = []) : void
	{
		extract($args);

		$file = PENTIMINAX_PLUGIN_DIR . "views/$name.php";

		ob_start(); // Démarrage de la mémoire tampon

		include_once ($file);

		echo ob_get_clean(); // Clear de la mémoire tampon
	}
}