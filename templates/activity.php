<h1>Plus de détails sur : <?=$activity_info['name'] ?></h1>
<section>
    <div class="card" style="width: 80%;margin: 2em">
        <div class="card">
            <div class="card-body">
                <p class="card-text"> <?=$activity_info['name'] ?></p>
                <ul class="list-group">
                    <li class="list-group-item">Age Prérequis :<?=$activity_info['minAge'] ?></li>
                    <li class="list-group-item">Prix d'inscription : <?=$activity_info['price'] ?></li>
                </ul>
                <div style="padding:1em; display: flex ">
                    <a href="/subscribe/<?=$activity_info['id'] ?>" class="btn btn-primary" >S'inscrire</a>
                    <a href="/event/<?=$activity_info['id'] ?>" class="btn btn-primary" >Créer un événement</a>
                </div>
            </div>
        </div>
        <?php if(!empty($events)) :?>
            <h4>Evénement prévu pour cette activité</h4>
        <?php endif; ?>
        <div class="row" style="padding: 1em;">
            <?php foreach ($events as $event ):
                $event_info = $this->getEventInfo($event);?>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Date : <?=$event_info['date']?></li>
                                <li class="list-group-item">Heure de début : <?=$event_info['start_time']?></li>
                                <li class="list-group-item">Durée: <?=$event_info['duration']?></li>
                                <li class="list-group-item">Nombre maximum de participants: <?=$event_info['max_participant']?></li>
                            </ul>
                            <div style="padding:1em; ">
                                <a href="/inscription/event=<?=$event_info['id']?>" class="btn btn-primary" >s'inscrire</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>