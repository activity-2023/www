<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="sources/logo.png"/>
    <link rel="stylesheet" href="/css/style.css" type="text/css"/>
    <title>Eventity</title>
</head>
<body>
    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary " style="background-color: #e3f2fd;">
          <div class="container-fluid">
              <a class="navbar-brand" href="/">
                  <img src="sources/logo.png" alt="Logo"  class="d-inline-block align-text-top">
              </a>

              <a class="navbar-brand" href="/" style="font-size: 3em">Eventity</a>
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                          <a class="nav-link" href="/activities" style="font-size: 1.2em">Nos Actualités</a>
                      </li>
                      <li class="nav-item d-flex">
                          <a class="nav-link" href="/connexion" style="font-size: 1.2em"><?=isset($_SESSION['connexion'])? 'Mon compte': 'Connexion'?></a>
                      </li>
                  </ul>
          </div>
      </nav>
    </header>
    <main>
        <?=$content?>
    </main>

    <footer>
        <div>
            <a href="/" ><img
                        src="sources/logoEventity.png" alt="Eventity"/></a>
        </div>

        <div>
            <p class="footer-title">Nous contacter</p>
            <div class="footer-contact">
                <div class="footer-mail">
                    <p>dania.oulkadi@etu.cyu.fr</p>
                    <p>thomas.remy@etu.cyu.fr</p>
                    <a href="https://www.cyu.fr/" class="logo_cyu"><img src="sources/logocyu.png" alt="Logo_Cyu"/></a>
                </div>
            </div>
        </div>

    </footer>
</body>
</html>

</body>
</html>