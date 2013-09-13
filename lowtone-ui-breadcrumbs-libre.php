<?php
/*
 * Plugin Name: UI: Libre Support for Breadcrumbs
 * Plugin URI: http://wordpress.lowtone.nl/plugins/ui-breadcrumbs-libre/
 * Description: Add breadcrumbs to the Libre document.
 * Version: 1.0
 * Author: Lowtone <info@lowtone.nl>
 * Author URI: http://lowtone.nl
 * License: http://wordpress.lowtone.nl/license
 */
/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2013, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\plugins\lowtone\ui\breadcrumbs\libre
 */

namespace lowtone\ui\breadcrumbs\libre {

	use lowtone\content\packages\Package,
		lowtone\types\objects\collections\out\CollectionDocument;

	// Includes
	
	if (!include_once WP_PLUGIN_DIR . "/lowtone-content/lowtone-content.php") 
		return trigger_error("Lowtone Content plugin is required", E_USER_ERROR) && false;

	$__i = Package::init(array(
			Package::INIT_PACKAGES => array("lowtone"),
			Package::INIT_MERGED_PATH => __NAMESPACE__,
			Package::INIT_SUCCESS => function() {
				
				add_action("init", function() {
					if (!function_exists("lowtone\\libre\\filterName"))
						return false;

					add_action("build_" . \lowtone\libre\filterName("document"), function($document) {
						if (!function_exists("lowtone\\ui\\breadcrumbs\\trail"))
							return;

						$trail = \lowtone\ui\breadcrumbs\trail();

						$trailDocument = $trail
							->__toDocument()
							->build(array(
								CollectionDocument::COLLECTION_ELEMENT_NAME => "trail"
							));

						$document->documentElement->appendCreateElement("breadcrumbs", array(
								$trailDocument,
								"locales" => array(
									"title" => __("You're here"),
								),
							));

					});
				});

				return true;
			}
		));

}