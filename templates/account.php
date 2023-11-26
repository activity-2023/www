
<section style="padding: 2%;">
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
                <li class="list-group-item">Nom : <?=$nom?></li>
                <li class="list-group-item">Prénom : <?=$prenom?></li>
                <li class="list-group-item">Date de naissance : <?=date_format($birth,"Y/m/d")?></li>
                <li class="list-group-item">Genre : <?=$gender?>
                <li class="list-group-item">Votre adresse : <?=$parent_info['address']['st-num'].', '.
                    $parent_info['address']['st-name'].', '. $parent_info['address']['zip'].' '. $parent_info['address']['city']?></li>
                <li class="list-group-item"> Job : <?=$parent_info['job']?>
            </ul>
        </div>
    </div>
    <?php if(isset($activities) && !empty($activities)): ?>
    <div class="card" style="width: 80%; padding:2em;margin-top: 2em; align-items: center; text-align: center; ">
        <h5>Activités associées à ce compte</h5>
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
                            <a href="/activity/<?=$activity_info['id']?>" class="btn btn-primary" >Voir les détails</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        </div>
        <?php endif;?>
        <div style="padding:2em; align-items: center">
            <a href="/activitycreation" class="btn btn-primary" >Créer une activité</a>
        </div>
    </div>

     <?php if(isset($events) && !empty($events)): ?>
        <h5>événements à l'approche</h5>
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
                                <a href="/inscription/<?=$event_info['id']?>" class="btn btn-primary" >Annuler</a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif;?>

    <div class="card" style="width: 80%; padding:2em; margin-top: 2em; align-items: center; text-align: center; ">
        <h5>Informations sur le compte</h5>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">Mail : <?=$parent_info['mail']?></li>
                <li class="list-group-item">Numéro de téléphone : <?=$parent_info['tel']?></li>
                <li class="list-group-item">login : <?=$login?></li>
            </ul>
        </div>
    </div>

    <div class="list-group" style="width: 80%; padding:2em; margin-top: 2em; align-items: center; text-align: center; ">
        <a href="/deconnexion" class="btn btn-success" >Se déconnecter</a>
    </div>


</section>

