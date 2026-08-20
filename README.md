# Démarrer le serveur

Pour lancer le serveur en arrière-plan, utilisez la commande suivante :
```sh
docker compose up -d
```
Vous pouvez également démarrer le serveur sans l’option `-d` :
```sh
docker compose up
```
Dans ce cas, le serveur reste actif tant que le terminal est ouvert. Il s’arrêtera automatiquement lorsque vous fermerez le terminal.

# Arrêter le serveur
Pour arrêter le serveur et supprimer les conteneurs associés, utilisez :
```sh
docker compose down
```

# Code
Le code doit être placé dans le dossier [src](/src/).

# Base de données
La base de données est accèssible sur le port `3306` avec `mon_user:mon_password`.