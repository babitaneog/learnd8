<?php

namespace Drupal\test_composer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Nayjest\StrCaseConverter\Str;

/**
 * Class DefaultController.
 *
 * @package Drupal\test_composer\Controller
 * 
 * Controller for building the block instance add form.
 */
class DefaultController extends ControllerBase {

  /**
   * Build the block instance add form.
   *
   * @param string $plugin_id
   * The plugin ID for the block instance.
   * @param string $theme
   * The name of the theme for the block instance.
   *
   * @return array
   * The block instance edit form.
   */
  public function general() {
    // These keys won’t actually work… on purpose. Create your OWN!
    $encryptionKey = 'pTUgV9Qx09EuJ+GcleRU5aD9i5ge2mdriCLkH8xTfV0=';
    $macKey = 'uanShOJZ6YV7j0jD0iCZodrOmmaqMS+aPzi3BluhkM0=';
    $phpcrypt = new \PHPEncryptData\Simple($encryptionKey, $macKey);
    $ciphertext = $phpcrypt->encrypt('Testing Package using composer');
    $decrypted = $phpcrypt->decrypt($ciphertext);
    return [
      '#markup' => "Original Text: Testing Package using composer <br> Cipher text: $ciphertext <br> Decrypted text: $decrypted",
    ];
  }

}
