<h1>Gestion des catégories sur la page d'accueil</h1>
<form action="" method="POST" class="mt-5">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="emplacement1">Emplacement #1</label>
                <!-- Pour stocker plusieurs valeurs  de champs sous un meme nom, on utilise la notation "exemple[]". Cela va créer un tableau appelée "exemple" et chaque champ va y ajouter sa valeur. On peut forcer les index de ce tableau avec "exemple[1]". Ici on force les index à commencer à 1 puis s'incrémenter.  -->
                <select class="form-control" id="emplacement1" name="emplacement[1]">
                    <option value="">choisissez :</option>
                    <?php foreach($categories as  $currentCategory) : ?>

                        <?php 
                        // Pour chaque catégorie, on vérifie si elle a le home order correspondant au select qu'on remplit. Si oui, on stocke le mot-clé selected dans la variable, sinon on stocke une chaine vide
                        $selected = ($currentCategory->getHomeOrder() == 1) ? "selected" : ''; ?>

                        <!-- On affiche la variable $selected, elle contient soit le mot-clé qui sélectionne l'option soit rien -->
                        <option  <?= $selected ?>  value="<?= $currentCategory->getId()?>">
                            <?= $currentCategory->getName() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement2">Emplacement #2</label>
                <select class="form-control" id="emplacement2" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <?php foreach($categories as  $currentCategory) : ?>
                        <?php 
                        // Pour chaque catégorie, on vérifie si elle a le home order correspondant au select qu'on remplit. Si oui, on stocke le mot-clé selected dans la variable, sinon on stocke une chaine vide
                        $selected = ($currentCategory->getHomeOrder() == 2) ? "selected" : ''; ?>
                        <option <?= $selected ?> value="<?= $currentCategory->getId()?>">
                            <?= $currentCategory->getName() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="emplacement3">Emplacement #3</label>
                <select class="form-control" id="emplacement3" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <?php foreach($categories as  $currentCategory) : ?>

                        <?php 
                        // Pour chaque catégorie, on vérifie si elle a le home order correspondant au select qu'on remplit. Si oui, on stocke le mot-clé selected dans la variable, sinon on stocke une chaine vide
                        $selected = ($currentCategory->getHomeOrder() == 3) ? "selected" : ''; ?>

                        <option <?= $selected ?> value="<?= $currentCategory->getId()?>">
                            <?= $currentCategory->getName() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement4">Emplacement #4</label>
                <select class="form-control" id="emplacement4" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <?php foreach($categories as  $currentCategory) : ?>

                        <?php 
                        // Pour chaque catégorie, on vérifie si elle a le home order correspondant au select qu'on remplit. Si oui, on stocke le mot-clé selected dans la variable, sinon on stocke une chaine vide
                        $selected = ($currentCategory->getHomeOrder() == 4) ? "selected" : ''; ?>

                        <option <?= $selected ?> value="<?= $currentCategory->getId()?>">
                            <?= $currentCategory->getName() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement5">Emplacement #5</label>
                <select class="form-control" id="emplacement5" name="emplacement[]">
                    <option value="">choisissez :</option>
                    <?php foreach($categories as  $currentCategory) : ?>

                        <?php 
                        // Pour chaque catégorie, on vérifie si elle a le home order correspondant au select qu'on remplit. Si oui, on stocke le mot-clé selected dans la variable, sinon on stocke une chaine vide
                        $selected = ($currentCategory->getHomeOrder() == 5) ? "selected" : ''; ?>


                        <option <?= $selected ?> value="<?= $currentCategory->getId()?>">
                            <?= $currentCategory->getName() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <input type="hidden" name="token" value="<?= $token ?>">
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>