<h1>Créer Un événement</h1>
<section>
    <h2>Activité concernée : <?=$activityName?></h2>
    <p>Renseigner les informations d'événement pour l'ajouter aux propositions générales </p>
    <div>
        <form action="/event" method="post">
            <div style="display: grid; justify-content:center;">
                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="eventdate" class="col-form-label">Date de l'événement</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" id="eventdate" class="form-control" max="2024-12-31"
                               min="<?=date('Y-m-d');?>" name="eventdate" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="startTime" class="col-form-label">Heure de début</label>
                    </div>
                    <div class="col-auto">
                        <input type="time" id="startTime" class="form-control" name="startTime" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="duration" class="col-form-label">Durée</label>
                    </div>
                    <div class="col-auto">
                        <input type="time" id="duration" class="form-control" name="duration" required>
                    </div>
                </div>

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <div class="col-auto">
                        <label for="maxParticipants" class="col-form-label">Le nombre maximum de participants</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="maxParticipants" class="form-control" min="1"
                                name="maxParticipants" required>
                    </div>
                </div>
                <input hidden="hidden" value="<?=$activityId ?>" name="activityId" >

                <div class="row g-2 align-items-center" style="padding: 1em">
                    <button class="btn btn-success" type="submit">Enregister</button>
                </div>
            </div>
        </form>
    </div>
</section>

