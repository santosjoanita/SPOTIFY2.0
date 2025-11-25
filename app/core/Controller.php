<?php
namespace app\core;
use app\models\Movies;

/**
* Classe que instancia um model e invoca uma view
*/
class Controller {

  /**
  * Método para a invocação de um model.
  *
  * @param  string  $model   Model que será instanciado para usar numa view
  */
  public function model($model) {
    require 'app/models/' . $model . '.php';
    $classe = 'app\\models\\' . $model; // *
    return new $classe();
    // *  o duplo backslash deve-se ao facto de estar a ser referenciada uma classe numa string
    //    o primeiro backslash "escapa" o segundo
  }

  /**
  * Método para a invocação de uma view (página).
  *
  * @param  string  $view   A view que será invocada
  * @param  array   $data   Dados a exibir na view
  */
  public function view(string $view, $data = []) {
    $url_alias = '/pw/tab1_pw/SPOTIFY2.0';

    // Determine if this is an auth view (we don't inject header or assets on auth pages)
    $isAuthView = strpos($view, 'auth/') === 0;

    // Render the view to a string
    ob_start();
    require 'app/views/' . $view . '.php';
    $content = ob_get_clean();

    if (!$isAuthView) {
      // Capture header partial
      ob_start();
      require 'app/views/partials/header.php';
      $headerHtml = ob_get_clean();

      // Insert header HTML right after opening <body> tag (if exists)
      if (preg_match('/<body[^>]*>/i', $content, $matches)) {
        $content = preg_replace('/(<body[^>]*>)/i', '$1' . $headerHtml, $content, 1);
      } else {
        // If no body tag found, prepend header
        $content = $headerHtml . PHP_EOL . $content;
      }

      // Insert main.css link into head (before </head>) if not already included
      $mainCss = "\n<link rel=\"stylesheet\" href=\"" . $url_alias . "/assets/css/main.css\">\n";
      if (stripos($content, $mainCss) === false) {
        if (stripos($content, '</head>') !== false) {
          $content = str_ireplace('</head>', $mainCss . '</head>', $content);
        } else {
          // fallback: inject inline style at top
          $content = '<style>/* main.css fallback */</style>' . $content;
        }
      }

      // Insert main.js script before closing body
      $mainJs = "\n<script src=\"" . $url_alias . "/assets/js/main.js\"></script>\n";
      if (stripos($content, $mainJs) === false) {
        if (stripos($content, '</body>') !== false) {
          $content = str_ireplace('</body>', $mainJs . '</body>', $content);
        } else {
          $content .= $mainJs;
        }
      }
    }

    echo $content;
  }

  /**
  * Método herdado em todas as subclasses.
  * É invocado quando o método ou classe não são encontrados.
  */
  public function pageNotFound() {
    $this->view('erro404');
  }
}