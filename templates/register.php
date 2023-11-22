
<h1>Créer mon compte</h1>
<section>
    <h2>Mes informations</h2>
    <p>Renseigner les informations pour ajouter à la base</p>
    <div>
        <form action="/register" method="post">
            <div style="display: grid; justify-content:center;">
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="fname" class="col-form-label">Nom</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="fname" class="form-control" name="fname" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="lname" class="col-form-label" >Prénom</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="lname" class="form-control" name="lname" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="br-date" class="col-form-label">Date de Naissance</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" id="br-date" class="form-control" name="br-date" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="gender" class="col-form-label">Genre</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="FEMME">FEMME</option>
                            <option value="HOMME">HOMME</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="mail" class="col-form-label">Adresse Mail</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="email" id="mail" placeholder="name@example.com" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="login" class="col-form-label">Votre login</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="login" type="text" id="login" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="psswd" class="col-form-label">Mot de passe</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="pswd" type="password" id="psswd" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <button class="btn btn-success" type="submit">Enregister</button>
                </div>
            </div>
        </form>
    </div>
</section>
