# Dynmahaus

## Description

## Notre site web permet aux étudiants de trouver des logements et rentrer en contact avec un organisme ou un particulier.

### Première configuration de Git

```bash
git config --global user.name "Your Name"
git config --global user.email "your-email@example.com"
```

### Cloner le repository et faire ton premier push

Pour obtenir une copie de ce projet sur votre machine locale, suivez les étapes suivantes :

1. **Clone le repository**:

Ouvrez votre terminal, naviguez jusqu'au dossier dans lequel vous souhaitez mettre le projet, et exécutez la commande suivante :

```bash
git clone https://github.com/HelmiAbdelkarim/dynmahaus.git
```

2. **Changer de dossier**

Dans VScode cliquez sur file => open folder et sélectionner le dossier dynmahaus

3. **Vérifier l'état du repository**:

Pour voir l'état actuel de votre repository, utilisez :

```bash
git status
```

4. **Ajouter un remote**:

Si vous avez initialisé un nouveau repository, ajoutez le lien du repository distant :

```bash
git remote add origin git@github.com:HelmiAbdelkarim/dynmahaus.git
```

5. **Vérifier l'état du repository**:

Pour voir l'état actuel de votre repository, utilisez :

```bash
git status
```

6. **Ajouter des fichiers au staging**:

Pour préparer vos fichiers à être commités, utilisez :

```bash
git add .
```

7. **Commiter vos changements**:

Pour enregistrer vos modifications avec un message de commit, exécutez :

```bash
git commit -m "ton message"
```

8. **Push vos changements vers le repository distant**:

Pour envoyer vos commits vers le repository distant, utilisez la commande suivante :

```bash
git push -u origin main
```

### Mettre à jour le repository local (git pull)

Pour récupérer les modifications effectuées sur le repository distant et pousser vos propres modifications, suivez les étapes suivantes :

1. **Vérifier l'état du repository**:

Pour voir l'état actuel de votre repository, utilisez :

```bash
git status
```

2. **Effectuer un git pull**:

Pour mettre à jour votre répertoire local avec les dernières modifications disponibles sur le repository distant, exécutez :

```bash
git pull
```

### Pousser des changements (git push)

Une fois que vous avez fait des modifications localement, vous pouvez les envoyer au repository distant pour les partager avec les autres contributeurs, à travers les étapes suivantes :

1. **Vérifier l'état du repository**:

Pour voir l'état actuel de votre repository, utilisez :

```bash
git status
```

2. **Ajouter des fichiers au staging**:

Pour préparer vos fichiers à être commités, utilisez :

```bash
git add .
```

3. **Commiter vos changements**:

Pour enregistrer vos modifications avec un message de commit, exécutez :

```bash
git commit -m "ton message"
```

4. **Push vos changements vers le repository distant**:

Pour envoyer vos commits vers le repository distant, utilisez la commande suivante :

```bash
git push
```

### Créer/Changer une branche

NE JAMAIS PUSH VERS LA MAIN BRANCH, TOUJOURS CRÉER UNE BRANCHE DE FONCTIONNALITÉ OU DE CORRECTION, ET ENSUITE FAIRE UNE PULL REQUEST POUR QUE TOUT LE MONDE PUISSE REVOIR LE CODE, L'APPROUVER ET ENSUITE MERGE AVEC LA BRANCHE PRINCIPALE.

1. **Pour créer une nouvelle branche, utilisez la commande suivante :**:

Pour voir l'état actuel de votre repository, utilisez :

```bash
git branch nom-de-la-branche
```

2. **Changer de branche (se déplacer vers une branche existante) :**:

Pour passer à la branche que vous venez de créer ou à une autre branche existante, utilisez la commande :

```bash
git checkout nom-de-la-branche
```

3. **Vérifier sur quelle branche vous êtes :**:

Pour voir sur quelle branche vous vous trouvez actuellement, utilisez :

```bash
git branch
```

## Backend

1. **Initialisation et update de la base de données**:

Utiliser le fichier dynamhaus.sql dans le folder backend. Pour cela démarrer phpAdmin, en cas de problème pour démarrer phpAdmin tel que "missing mysqli extension" contacter Donatien. Une fois que phpAdmin est démarré, cliquez sur importer, parcourir puis sélectionner le fichier dynamhaus.sql

2. **Installation de composer et des différentes librairies**

2.1. **Installation de composer**

Aller sur ce lien https://getcomposer.org/
Cliquer sur download, selon votre OS cliquer sur windows installer, pour les macs renseigner vous sur https://stackoverflow.com/questions/21952723/how-to-install-composer-on-a-mac
Pour ceux sur windows, installer sans cocher le dev mode, puis lorsque c'est demandé, ajouter php au path en cochant la case.
Et enfin redémarrer votre vscode si vous l'aviez lancé, puis entrer ses lignes dans le terminal:

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

2.2. **Installation de PHP dotenv**

```bash
$ composer require vlucas/phpdotenv
```

