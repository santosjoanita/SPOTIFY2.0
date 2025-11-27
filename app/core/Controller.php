<?php
namespace app\core;
use app\models\Movies;


class Controller {

  /**
  * @param  string 
  */
  public function model($model) {
    require 'app/models/' . $model . '.php';
    $classe = 'app\\models\\' . $model; // *
    return new $classe();
  
  }

  /**
  * Método para a invocação de uma view (página).
  *
  * @param  string  
  * @param  array   
  */
  public function view(string $view, $data = []) {
    $url_alias = '/pw/tab1_pw/SPOTIFY2.0';

    //aqui verifica se a view é de autenticação
    $isAuthView = strpos($view, 'auth/') === 0;

    // vai capturar o conteúdo da view
    ob_start();
    require 'app/views/' . $view . '.php';
    $content = ob_get_clean();

    if (!$isAuthView) {
      //aqui vai buscar o header á pasta partials
      ob_start();
      require 'app/views/partials/header.php';
      $headerHtml = ob_get_clean();

    
      if (preg_match('/<body[^>]*>/i', $content, $matches)) {
        $content = preg_replace('/(<body[^>]*>)/i', '$1' . $headerHtml, $content, 1);
      } else {
       
        $content = $headerHtml . PHP_EOL . $content;
      }

    
      $mainCss = "\n<link rel=\"stylesheet\" href=\"" . $url_alias . "/assets/css/main.css\">\n";
      if (stripos($content, $mainCss) === false) {
        if (stripos($content, '</head>') !== false) {
          $content = str_ireplace('</head>', $mainCss . '</head>', $content);
        } else {
      
          $content = '<style>/* main.css fallback */</style>' . $content;
        }
      }

    
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