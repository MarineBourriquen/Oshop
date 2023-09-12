<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-end">Retour</a>
<h2>Ajouter un utilisateur</h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="lastname">Nom</label>
        <input  name="lastname" type="text" class="form-control" id="lastname" placeholder="Nom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="firstname">Prénom</label>
        <input name="firstname"  type="text" class="form-control" id="firstname" placeholder="Prénom de l'utilisateur" >
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email"  type="email" class="form-control" id="email" placeholder="Email de l'utilisateur" >
    </div>
    <div class="form-group">
        <label for="password">Mot de passe </label>
        <input name="password"  type="password" class="form-control" id="password" placeholder="Mot de passe complexe" >
    </div>

    <div class="form-group">
        <label for="status">Statut</label>
        <select name="status"  class="custom-select form-select" id="status" >
            <option value="1">Actif</option>
            <option value="0">Inactif</option>
        </select>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role"  class="custom-select form-select" id="role" >
            <option value="catalog-manager">Gestionnaire de catalogue</option>
            <option value="admin">Administrateur</option>
        </select>
    </div>

    <input name="token" type="hidden" value="<?= $token ?>">

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>