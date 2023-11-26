<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Activity</title>
</head>
<body>
    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary " style="background-color: #e3f2fd;">
          <div class="container-fluid">
              <a class="navbar-brand" href="/">Activity</a>
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                          <a class="nav-link" href="/activities">Actualité</a>
                      </li>
                      <li class="nav-item d-flex">
                          <a class="nav-link" href="/connexion">Connexion</a>
                      </li>
                  </ul>
          </div>
      </nav>
    </header>
    <main>
        <?=$content?>
    </main>
    <footer>
    </footer>
</body>
</html>