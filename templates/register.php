
<h1>Créer mon compte</h1>
<section>
    <h2>Mes informations</h2>
    <?php if(isset($indispo)):?>
        <div class="card" style=" background-color: burlywood; align-items: center">
            <div class="card-body" >
                <p><?= $indispo?></p>
            </div>
        </div>
    <?php endif?>

    <div>
        <form action="/register" method="post">
            <div style="display: grid; justify-content:center;" >
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="lname" class="col-form-label">Nom</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="lname" class="form-control" name="lname" pattern="[A-Z][A-Z ]*"
                               required placeholder="NOM" title="Votre nom tout en majuscule éventuellement un espace"
                                value="<?= (isset($lname)) ? $lname : '' ?>">
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="fname" class="col-form-label" >Prénom</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="fname" class="form-control" name="fname" pattern="[A-Z][a-z ]*"
                               placeholder="Prenom" required title="Votre prénom commence par une majuscule puis tout en minuscule sans espace"
                               value="<?= (isset($fname)) ? $fname : '' ?>">
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
                        <label for="mail" class="col-form-label">Adresse Mail</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="email" id="mail"
                               placeholder="name@exemple.com" value="<?= $mail ?? '' ?>"
                               pattern="[a-z0-9]+@[a-z]+.[a-z]+" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="mail" class="col-form-label" >Numéro de téléphone</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="tel" name="tel" id="tel" placeholder="0125639842"
                               pattern="[0][1-9][0-9]{8}" title="Numéro avec 0 puis 9 chiffres"
                               value="<?= $tel ?? '' ?>" required>
                    </div>
                </div>
                <?php if($account_type=="user"):?>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="job" class="col-form-label" >Votre job (facultatif)</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="job" class="form-control" name="job" pattern="[a-z ]*"
                               value="<?= (isset($job)) ? $job : '' ?>">
                    </div>
                </div>
                <?php endif; ?>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="ad-st-nam" class="col-form-label">Nom de rue</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="ad-st-nam" type="text" id="ad-st-nam" maxlength="50"
                               value="<?= $address['st-name'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="ad-st-num" class="col-form-label">Numéro de rue</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="ad-st-num" type="number" id="ad-st-num" max="10000" min="0"
                               value="<?= $address['st-num'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="ad-zip_code" class="col-form-label">Code postal</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="ad-zip-code" type="text" id="ad-zip-code"
                               pattern="[0-9]{5}" title="5 chiffres" value="<?= $address['zip'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="ad-city" class="col-form-label">Ville</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="ad-city" type="text" id="ad-city" pattern="[A-Z ]+" maxlength="50"
                               title="Tout en majuscule"  value="<?= $address['city'] ?? '' ?>" required>
                    </div>
                </div>
                <?php if($account_type!="user") :?>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="contract_type" class="col-form-label">Type de contrat</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-control" id="contract_type" name="contract_type" required>
                            <option value="PERMANENT">PERMANENT</option>
                            <option value="INTERIM">INTERIM</option>
                            <option value="TEMPORARY">TEMPORARY</option>
                            <option value="SERVICE">SERVICE</option>
                        </select>
                    </div>
                </div>
                <?php endif;?>

                <?php if($account_type =="staff") :?>
                    <div class="row g-2 align-items-center" style="padding: 1em">
                        <div class="col-auto">
                            <label for="hr_number" class="col-form-label">Numéro RH</label>
                        </div>
                        <div class="col-auto">
                            <input class="form-control" name="hr_number" type="number" id="hr_number" max="10000" min="0"
                                   value="<?= $staff_info['hr_number'] ?? '' ?>" required>
                        </div>
                    </div>
                    <div class="row g-2 align-items-center" style="padding: 1em">
                        <div class="col-auto">
                            <label for="staff_function" class="col-form-label">Fonction dans l'entreprise</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-control" id="staff_function" name="staff_function" required>
                                <option value="EMPLOYEE">EMPLOYEE</option>
                                <option value="SECRETARY">SECRETARY</option>
                                <option value="EXECUTIVE">EXECUTIVE</option>
                            </select>
                        </div>
                    </div>

                <?php endif;?>
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="login" class="col-form-label">Votre login</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="login" type="text" maxlength="20" id="login"
                               title="Tout en minuscule sans espaces ni caractères spéciaux" pattern="[a-z]+" value="<?= $login ?? '' ?>" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="pin" class="col-form-label">Choisir un pin (4 chiffres)</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" name="pin" type="password"  id="pin" inputmode="numeric"
                               title="4 chiffres de 0000 à 9999" pattern="[0-9]{4}" value="<?= $pin ?? '' ?>" required>
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
                <input hidden="hidden" name="account_type" value="<?=$account_type?>">

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <button class="btn btn-success" type="submit">Enregister</button>
                </div>

            </div>
        </form>
    </div>
</section>
