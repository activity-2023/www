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
                    <?php if(!isset($_SESSION['connexion']) || $_SESSION['account_type']=="user"):?>
                        <?php if(isset($_SESSION['connexion']) && !empty($this->allreadySubscribe($activity_info['id'], $_SESSION['connexion']))):?>
                            <a href="/unsubscribe_activity/id=<?=$activity_info['id'] ?>" class="btn btn-primary" >Se désinscrire</a>
                        <?php else : ?>
                            <a href="/subscribe/id=<?=$activity_info['id'] ?>" class="btn btn-primary" >S'inscrire</a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['connexion']) && $_SESSION['account_type']=="staff"):?>
                        <div style="padding:1em; ">
                            <a href="/event/id=<?=$activity_info['id'] ?>/name=<?=$activity_info['name'] ?>" class="btn btn-primary" >Créer un événement</a>
                        </div>
                        <?php if(empty($this->allreadyPropose($activity_info['id']))):?>
                            <div style="padding:1em; ">
                                <a href="/join_activity/id=<?=$activity_info['id'] ?>" class="btn btn-primary" >Rejoindre</a>
                            </div>
                        <?php else: ?>
                            <div style="padding:1em; ">
                                    <a href="/cancel_activity/id=<?=$activity_info['id']?>" class="btn btn-primary" >Annuler</a>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php if(!empty($events)) :?>
            <h4>Événements prévus pour cette activité</h4>
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
                            <?php if(!isset($_SESSION['connexion']) || $_SESSION['account_type']=="user"):?>
                                <?php if(isset($_SESSION['connexion']) && !empty($this->allreadyParticipate($event_info['id'], $_SESSION['connexion']))):?>
                                    <div style="padding:1em; ">
                                        <a href="/unsubscribe_event/id=<?=$event_info['id'] ?>" class="btn btn-primary" >Se désinscrire</a>
                                    </div>
                                <?php else : ?>
                                    <div style="padding:1em; ">
                                        <a href="/inscription/id=<?=$event_info['id']?>" class="btn btn-primary" >s'inscrire</a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(isset($_SESSION['connexion']) && $_SESSION['account_type']=="staff" &&
                            empty($this->allreadyOrganize($event_info['id']))):?>
                                <div style="padding:1em; ">
                                    <a href="/join_event/id=<?=$event_info['id'] ?>" class="btn btn-primary" >Rejoindre</a>
                                </div>
                            <?php else: ?>
                                <div style="padding:1em; ">
                                    <a href="/cancel_event/id=<?=$event_info['id']?>" class="btn btn-primary" >Annuler</a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>