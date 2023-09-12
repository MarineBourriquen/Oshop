# Plan de connexion

## On a besoin de 

- Une table avec tous les utilisateurs : [lien ici](https://gist.github.com/Fabioclock/c2d003c3d81d1a93705d915f9e9b0a00)
- Un model `AppUser` qui représente la table `app_user` (ne pas oublier de coder les méthodes abstraites)
- Un [formulaire de connexion](https://getbootstrap.com/docs/5.2/forms/overview/#overview), donc une page qui affiche ce formulaire.
- Une page qui traite les données envoyées par le formulaire.
  
## Marche à suivre

- Finir le model `AppUser` en créant les méthodes abstraites (liste dans le CoreModel)
- Créer une route en GET pour afficher le formulaire (Ex: `/login`)
- Coder la route en POST qui est appelée par le formulaire de connexion. En POST car on ne veut pas que le mot de passe transite en clair dans l'URL.
- On récupère les données inscrites dans le formulaire par l'utilisateur (email et mot de passe)
- On va chercher dans la BDD un utilisateur portant l'email demandé. Pour ça, on va devoir créer une méthode dédiée `findByEmail` dans le model `AppUser`. Exemple d'utilisation : `$user = AppUser::findByEmail('jeaneudes@gmail.com');`.
- Si on ne trouve aucun utilisateur avec cette adresse, on affiche un message d'erreur avec un `echo`.
- Sinon, on compare le mot de passe de l'utilisateur retrouvée avec le mot de passe récupéré depuis le formulaire. S'ils sont indentiques, on affiche OK. Sinon un message d'erreur.