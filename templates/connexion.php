<?php
    if(isset($_SESSION['connexion'])){
        header("Location: /account");
        exit();
    }
?>
<h1>Me connecter</h1>
<section>
    <?php if(isset($login)):?>
    <div class="card" style=" background-color: burlywood; align-items: center">
        <div class="card-body" >
            <p>Nom d'utilisateur ou mot de passe incorrecte</p>
        </div>
    </div>
    <?php endif?>
    <form method="post" action="/connexion">
        <div style="display: grid; justify-content:left;">
            <div class="row g-2 align-items-center" style="padding: 1em">
                <div class="col-auto">
                    <label for="login" class="form-label">Nom d'utilisateur</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="login" name="login" value="<?= $login ?? ''?>" required>
                </div>
            </div>
            <div class="row g-2 align-items-center" style="padding: 1em">
                <div class="col-auto">
                    <label for="pswd" class="form-label">Mot de passe</label>
                </div>
                <div class="col-auto">
                    <input type="password" class="form-control" id="pswd" name="pswd" required>
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
