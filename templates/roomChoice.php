<h1>Choix d'une salle disponible </h1>
<section>
    <div class="card" style="width: 80%;margin: 2em">
        <div class="row" style="padding: 1em;">
            <?php foreach ($rooms as $room_info ):?>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?=$room_info['type']?></h5>
                            <ul class="list-group">
                                <li class="list-group-item">Adresse : <?=$room_info['ad_st_num']?>,
                                    <?=$room_info['ad_st_name']?>, <?=$room_info['ad_zip']?> <?=$room_info['city']?> </li>
                                <li class="list-group-item">Nom de la salle : <?=$room_info['name']?></li>
                                <li class="list-group-item">Numéro de la salle: <?=$room_info['number']?></li>
                                <li class="list-group-item">Etage : <?=$room_info['floor']?></li>
                                <li class="list-group-item">Capacité maximal : <?=$room_info['capacity']?></li>
                            </ul>
                            <h5 class="card-title">Informations sur le bâtiment </h5>
                            <ul class="list-group">
                                <li class="list-group-item">Nom du bâtiment: <?=$room_info['building_name']?></li>
                                <li class="list-group-item">Nombre d'étage : <?=$room_info['building_floors']?></li>
                                <li class="list-group-item">Disponibilité d'un ascenseur: <?=$room_info['building_has_elevator']?></li>
                            </ul>
                            <div style="padding:1em; ">
                                <a href="/reserve/id_room=<?=$room_info['id']?>/event_date=<?=$info['eventdate']?>/event_start=<?=$info['startTime']?>/event_duration=<?=$info['duration']?>/event_max_participant=<?= $info['maxParticipants']?>/id_activity=<?=$info['activityId']?>" class="btn btn-primary" >Réserver</a>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>