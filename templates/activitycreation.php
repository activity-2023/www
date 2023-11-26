<h1>Créer Une activité</h1>
<section>
    <p>Renseigner les informations de votre activité pour l'ajouter aux propositions générales </p>
    <div>
        <form action="/activitycreation" method="post">
            <div style="display: grid; justify-content:center;" >
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="name" class="col-form-label">Donner un nom à votre activité</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="name" class="form-control" name="name"  maxlength="50"
                               required placeholder="Nom de l'activité"
                               value="<?= (isset($name)) ? $name : '' ?>">
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="description" class="col-form-label" >Description du contenu</label>
                    </div>
                    <div class="col-auto">
                        <textarea id="description" class="form-control" name="description"
                                  placeholder="Petite description ..." rows="10" required ></textarea>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="minAge" class="col-form-label">Age minimum prérequis</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="minAge" class="form-control" min="0"
                               max="20" name="minAge" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="price" class="col-form-label">Prix de l'inscription</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="price" class="form-control" min="0"
                               max="20" name="price" step="0.01" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <button class="btn btn-success" type="submit">Enregister</button>
                </div>
            </div>
        </form>
    </div>
</section>

