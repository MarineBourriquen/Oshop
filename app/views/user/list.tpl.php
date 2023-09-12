<a href="<?= $router->generate('user-add') ?>" class="btn btn-success float-end">Ajouter</a>
<h2>Liste des utilisateurs</h2>


<table class="table table-hover mt-4">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Statut</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $currentUser) : ?>
            <tr>
                <th scope="row"><?= $currentUser->getId(); ?></th>
                <td><?= $currentUser->getLastname(); ?></td>
                <td><?= $currentUser->getFirstname(); ?></td>
                <td><?= $currentUser->getEmail(); ?></td>
                <td><?= $currentUser->getRole(); ?></td>
                <td><?= $currentUser->getStatus(); ?></td>
                <td class="text-end">
                    <a href="<?= $router->generate('category-edit', ['id' => $currentUser->getId()]) ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('category-delete', ['id' => $currentUser->getId()]) ?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
  
    </tbody>
</table>