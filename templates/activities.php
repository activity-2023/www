<h1>Les événements à venir </h1>
<section>
    <div class="card" style="width: 80%;margin: 2em">
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
                            <a href="/activity/<?=$activity_info['id']?>" class="btn btn-primary" >Découvrir plus</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


</section>