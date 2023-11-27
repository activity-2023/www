<section style="padding: 2%; text-align: center">
    <h1>Mon compte</h1>
    <div style="align-items: center; text-align: center; padding: 2em">
        <div class="card" style="width: 80%;">
            <div class="card-body">
                <h3>Votre nom d'utilisateur : <?=$login?></h3>
            </div>
        </div>
    </div>
    <div class="card" style="width: 80%;align-items: center; text-align: center;">
        <h5>Informations personnelles</h5>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">Nom : <?=$adminInfo['lname']?></li>
                <li class="list-group-item">Prénom : <?=$adminInfo['fname']?></li>
                <li class="list-group-item">Date de naissance : <?=$adminInfo['birth']?></li>
                <li class="list-group-item">Genre : <?=$adminInfo['gender']?></li>
                <li class="list-group-item">Votre adresse : <?=$account['address']['st-num'].', '.$account['address']['st-name'].', '.
                    $account['address']['zip'].' '. $account['address']['city']?></li>
                <?php if($_SESSION['account_type']=="user"): ?>
                    <li class="list-group-item"> Job : <?=$account['job']?></li>
                <?php endif;?>
                <?php if($_SESSION['account_type']=="staff"): ?>
                <li class="list-group-item">Type de contrat : <?=$account['contract_type']?></li>
                <li class="list-group-item">Votre numéro RH : <?=$account['hr_number']?></li>
                <li class="list-group-item">Fonction : <?=$account['fonction']?></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
    <?php if(isset($activities) && !empty($activities)): ?>
        <h5 style="font-size: 1.5em; align-items: center; padding: 1em; color: #0077b3">Activités associées à ce compte</h5>
        <div class="row" style="padding: 1em;">
        <?php foreach ($activities as $activity ):
            $activity_info = $this->getActivityInfo($activity);?>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?=$activity_info['name']?></h5>
                        <p class="card-text"> <?=$activity_info['description']?></p>
                        <ul class="list-group">
                            <li class="list-group-item">Age Prérequis : <?=$activity_info['minAge']?></li>
                            <li class="list-group-item">Prix d'inscription : <?=$activity_info['price']?></li>
                        </ul>
                        <div style="padding:1em; ">
                            <a href="/activity/id=<?=$activity_info['id']?>" class="btn btn-primary" >Voir les détails</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif;?>


     <?php if(isset($events) && !empty($events)): ?>
        <h5 style="font-size: 1.5em; align-items: center; padding: 1em; color: #0077b3">Événements à l'approche</h5>
        <div class="row" style="padding: 1em;">
            <?php foreach ($events as $event ):
                $event_info = $this->getEventInfo($event);?>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?=$event_info['activity_name']?></h5>
                            <ul class="list-group">
                                <li class="list-group-item">Date : <?=$event_info['date']?></li>
                                <li class="list-group-item">Heure de début : <?=$event_info['start_time']?></li>
                                <li class="list-group-item">Durée: <?=$event_info['duration']?></li>
                                <li class="list-group-item">Nombre maximum de participants: <?=$event_info['max_participant']?></li>
                            </ul>
                            <div style="padding:1em; ">
                                <?php if($_SESSION['account_type']=="staff") :?>
                                    <a href="/cancel_event/id=<?=$event_info['id']?>" class="btn btn-primary" >Annuler</a>
                                <?php endif;?>
                                <?php if($_SESSION['account_type']=="user") :?>
                                    <a href="/unsubscribe_event/id=<?=$event_info['id']?>" class="btn btn-primary" >Se désinscrire</a>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif;?>

    <?php if($_SESSION['account_type']=="staff") :?>
        <div style="display: flex">
            <div style="padding:2em; align-items: center">
                <a href="/activitycreation" class="btn btn-primary" >Créer une activité</a>
            </div>
            <div style="padding:2em; align-items: center">
                <a href="/user_account_creation" class="btn btn-primary" >Créer un compte utilisateur</a>
            </div>
            <div style="padding:2em; align-items: center">
                <a href="/staff_account_creation" class="btn btn-primary" >Créer un compte professionnel</a>
            </div>
        </div>
    <?php endif;?>

    <?php if($_SESSION['account_type']=="user" && isset($children) && !empty($children)) :?>
        <h5 style="font-size: 1.5em; align-items: center; padding: 1em; color: #0077b3">Les personnes associées à mon compte</h5>
        <div class="row" style="padding: 1em;">
            <?php foreach ($children as $child ):
                $child_info = $this->getChildInfo($child);?>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <li class="list-group-item">Nom : <?=$child_info['lname']?></li>
                            <li class="list-group-item">Prénom : <?=$child_info['fname']?></li>
                            <li class="list-group-item">Date de naissance : <?=$child_info['birth']?></li>
                            <li class="list-group-item">Genre : <?=$child_info['gender']?></li>
                            <li class="list-group-item">Niveau Scolaire : <?=$child_info['school_level']?></li>
                            <div style="padding:1em; ">
                                <a href="/removechild/id=<?=$child_info['id']?>" class="btn btn-primary" >Retirer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif;?>
    <?php if($_SESSION['account_type']=="user" ) :?>
        <div style="padding:2em; align-items: center">
            <a href="/addchild/id=<?=$_SESSION['connexion']?>" class="btn btn-primary" >Ajouter une personne</a>
        </div>
    <?php endif;?>

    <div class="card" style="width: 80%; padding:2em; margin-top: 2em; align-items: center; text-align: center; ">
        <h5>Informations sur le compte</h5>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">Mail : <?=$account['mail']?></li>
                <li class="list-group-item">Numéro de téléphone : <?=$account['tel']?></li>
                <li class="list-group-item">login : <?=$login?></li>
            </ul>
        </div>
    </div>

    <div class="list-group" style="width: 80%; padding:2em; margin-top: 2em; align-items: center; text-align: center; ">
        <a href="/deconnexion" class="btn btn-success" >Se déconnecter</a>
    </div>


</section>

