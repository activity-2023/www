<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Activity</title>
</head>
<body>
    <header>
      <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
              <div class="nav navbar-nav">
                  <li>
                      <a href="/">Accueil</a>
                  </li>
                  <li>
                      <a href="/account">Mes informations</a>
                  </li>
                  <li>
                      <a href="/register">Inscription</a>
                  </li>
              </div>
          </div>
      </nav>
    </header>
    <main>
        <?=$content?>
    </main>
    <footer>
        <span>DANIA & THOMAS</span>
    </footer>
</body>
</html>