<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
        <h2>Modification du produit <span class="text-primary"><?= $product->getName() ?></span></h2>

        <div>
            <span>Tags du produit : </span>

            <?php foreach($product->getTags() as $currentTag): ?>
                <span class="badge bg-primary"><?= $currentTag->getName() ?>  
                    <a href="#" class="btn-close btn-close-white p-1 ms-1" aria-label="Close"></a>
                </span>
            <?php endforeach ?>
         
        </div>

        <form action="" method="POST">
            <div class="row">
                <div class="col">
                    <select class="form-select" aria-label="Default select example" name="tag" id="tag">
                        <option selected>Sélectionner un tag</option>
                        <?php foreach($tags as $currentTag):?>
                            <option value="1"><?= $currentTag->getName()?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>

        
        <form action="<?= $router->generate('product-update', ['id' => $product->getId()]) ?>" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input  value="<?= $product->getName() ?>" type="text" class="form-control" id="name" name="name" placeholder="Nom du produit">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input value="<?= $product->getDescription() ?>"  type="text" class="form-control" name="description" id="description" placeholder="Description" aria-describedby="descriptionHelpBlock">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input value="<?= $product->getPicture() ?>"  type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input value="<?= $product->getPrice() ?>"  type="number" class="form-control" name="price" id="price" placeholder="Prix du produit" min="0" aria-describedby="priceHelpBlock">
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label">Note</label>
                <input value="<?= $product->getRate() ?>"  type="number" class="form-control" name="rate" id="rate" placeholder="Note du produit" min="1" max="5" aria-describedby="rateHelpBlock">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
                <select class="custom-select form-control" name="status" id="status">
                    <option <?= ($product->getStatus() == 1) ? 'selected' : '' ?> value="1">Activé</option>
                    <option <?= ($product->getStatus() == 2) ? 'selected' : '' ?>   value="2">Désactivé</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Catégorie liée</label>
                <select class="custom-select form-control" name="category" id="category">
                    <?php foreach($categories as $currentCategory): ?>

                        <option <?= ($currentCategory->getId() == $product->getCategoryId()) ? 'selected' : '' ?>  value="<?= $currentCategory->getId() ?>">
                            <?= $currentCategory->getName(); ?>
                        </option>

                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type lié</label>
                <select class="custom-select form-control" name="type" id="type">
                    <?php foreach($types as $currentType): ?>
                        <option 
                        <?= ($currentType->getId() == $product->getTypeId()) ? 'selected' : '' ?> 
                        value="<?= $currentType->getId() ?>">
                            <?= $currentType->getName(); ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="marque" class="form-label">Marque liée</label>
                <select class="custom-select form-control" name="brand" id="marque">
                    <?php foreach($brands as $currentBrand): ?>
                        <option 
                        <?= ($currentBrand->getId() == $product->getBrandId()) ? 'selected' : '' ?> 
                        value="<?= $currentBrand->getId() ?>">
                            <?= $currentBrand->getName(); ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>