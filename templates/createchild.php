
<h1>Ajouter une personne à mon compte</h1>

<section>
    <?php if(isset($erreur)):?>
        <div class="card" style=" background-color: burlywood; align-items: center">
            <div class="card-body" >
                <p><?=$erreur?></p>
            </div>
        </div>
    <?php endif?>
    <div>
        <form action="/addchild" method="post">
            <div style="display: grid; justify-content:center;" >
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="lname" class="col-form-label">Nom</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="lname" class="form-control" name="lname"  pattern="[A-Z][A-Z ]*"
                               required placeholder="NOM" title="Son nom tout en majuscule éventuellement un espace">
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="fname" class="col-form-label" >Prénom</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="fname" class="form-control" name="fname"  pattern="[A-Z][a-z ]*"
                               placeholder="Prenom" required title="Son prénom commence par une majuscule puis tout en minuscule sans espace">
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="br-date" class="col-form-label">Date de Naissance</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" id="br-date" class="form-control" min="1930-01-01"
                               max="<?=date('Y-m-d');?>" name="br-date" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="gender" class="col-form-label">Genre</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="FEMALE">FEMME</option>
                            <option value="MALE">HOMME</option>
                        </select>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="school_level" class="col-form-label">Niveau scolaire (facultatif)</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-control" id="school_level" name="school_level">
                            <option value="NONE">NONE</option>
                            <?php for ($i = 1; $i <=12; $i++) :?>
                            <option value="YEAR<?=$i?>">YEAR<?=$i?></option>
                            "<?php endfor;?>
                        </select>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="pin" class="col-form-label">Choisir un pin (4 chiffres)</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="pin" type="password"  id="pin" inputmode="numeric"
                               title="4 chiffres de 0000 à 9999" pattern="[0-9]{4}" required>
                    </div>
                </div>

                <input hidden="hidden" name="parent_id" value="<?=$parent_id?>">

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <button class="btn btn-success" type="submit">Enregister</button>
                </div>

            </div>
        </form>
    </div>
</section>
