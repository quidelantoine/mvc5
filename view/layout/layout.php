<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Framework POO</title>
    <link rel="stylesheet" type="text/css" href="<?= $view->asset('css/style.css'); ?>">
  </head>
  <body>


    <header>
      <nav>
          <ul>
              <li><a href="<?= $view->path('home'); ?>">Home</a></li>
              <li><a href="<?= $view->path('contact'); ?>">Contact</a></li>
              <li><a href="<?= $view->path('single',array(12)); ?>">Single</a></li>
              <li><a href="<?= $view->path('single2',array(12,'dedede')); ?>">Single2</a></li>
          </ul>
      </nav>
    </header>

    <div class="container">
        <?= $content; ?>
    </div>

    <footer>

    </footer>

    <script src="<?= $view->asset('js/main.js'); ?>"></script>
  </body>
</html>
