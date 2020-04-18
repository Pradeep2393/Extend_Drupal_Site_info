<?php
/**
 * @file
 * Contains \Drupal\axelerant_code\Controller\SiteApiController.
 */
 
namespace Drupal\axelerant_code\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\NodeInterface; 
use Drupal\Core\Controller\ControllerBase;
 
class SiteApiController extends ControllerBase {
  /**
   * Json representation of Node.
   *
   * @param string $siteapikey_in_url
   *   - Site api value added to url.
   * @param \Drupal\node\NodeInterface $node
   *   - Node id in url.
   *
   */
  public function content($siteapikey_in_url, NodeInterface $node_id) {
	  
    // Retrieve siteapikey field value from system.site config.
    $api_value = \Drupal::configFactory()->get('system.site')->get('siteapikey');
	
	//print_r($api_value);

    // JSON response based on incoming page url
	// If node type is 'page' and site api key coming from the url matches with that of added in config via site-info form 
    if ($node_id->bundle() == 'page' && $siteapikey_in_url == $api_value) {
	  return new JsonResponse($node_id->toArray());
    }
    else {
      // Access Denied.
	  return array(
        '#type' => 'markup',
        '#markup' => t("Access Denied, Either it's an API mismatch or you tried accessing a node made using a content type other than page"),
      );
    }
  }	

}