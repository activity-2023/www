<h1>Me connecter</h1>
<section>
    <h2>Vous avez déjà un compte</h2>
    <form method="post" action="/connexion">
        <div style="display: grid; justify-content:left;">
            <div class="row g-2 align-items-center" style="padding: 1em">
                <div class="col-auto">
                    <label for="login" class="form-label">Nom d'utilisateur</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
            </div>
            <div class="row g-2 align-items-center" style="padding: 1em">
                <div class="col-auto">
                    <label for="pswd" class="form-label">Mot de passe</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="pswd" name="pswd" required>
                </div>
            </div>
            <div class="row g-2 align-items-center" style="padding: 1em">
                <button class="btn btn-success" type="submit">Se connecter</button>
            </div>
        </div>
    </form>
    <div>
        <span>Vous avez pas encore de compte?</span>
        <a class="navbar-brand" href="/register">Créer un compte</a>
    </div>
</section>
