<section style="padding: 2%;">
    <?php $parent = $this->personInfo($parent['personId']) ?>
    <h1>Choisir la personne à inscrire</h1>
    <div class="row" style="padding: 1em;">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Nom : <?=$parent['lname']?></li>
                        <li class="list-group-item">Prénom : <?=$parent['fname']?></li>
                        <li class="list-group-item">Genre : <?=$parent['gender']?></li>
                        <li class="list-group-item">Date de naissance : <?=$parent['birth']?></li>
                    </ul>
                </div>
            </div>
            <div style="padding:1em; ">
                <?php if(empty($this->allreadyParticipate($id_event, $parent['id']))):?>
                <a href="/inscription/id=<?=$id_event?>/<?=$parent['id']?>" class="btn btn-primary" >Choisir</a>
                <?php else : ?>
                <a href="/unsubscribe_event/id=<?=$id_event?>/<?=$parent['id']?>" class="btn btn-primary" >désinscrire</a>
                <?php endif;?>
            </div>
        </div>

        <?php if(isset($children)): foreach ($children as $child ): $person = $this->personInfo($child['personId']) ?>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Nom : <?=$person['lname']?></li>
                            <li class="list-group-item">Prénom : <?=$person['fname']?></li>
                            <li class="list-group-item">Genre : <?=$person['gender']?></li>
                            <li class="list-group-item">Date de naissance : <?=$person['birth']?></li>
                        </ul>

                    </div>
                </div>
                <div style="padding:1em; ">
                    <?php if(empty($this->allreadyParticipate($id_event, $person['id']))):?>
                        <a href="/inscription/id=<?=$id_event?>/<?=$person['id']?>" class="btn btn-primary" >Choisir</a>
                    <?php else : ?>
                        <a href="/unsubscribe_event/id=<?=$id_event?>/<?=$person['id']?>" class="btn btn-primary" >désinscrire</a>
                    <?php endif;?>
                </div>
            </div>
        <?php endforeach; endif;?>
    </div>
</section>