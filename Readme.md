# **FOLLOW_JOB**

## Fonctionnalités
Suivi de Candidatures : Enregistrez et retrouvez facilement toutes vos candidatures avec des détails sur les postes, les entreprises et les statuts.
Notes Personnelles : Ajoutez des notes détaillées pour chaque candidature afin de garder une trace de vos impressions, des étapes suivantes et des retours reçus.
Réseautage : Gérez vos contacts en ajoutant des informations sur les recruteurs, les responsables RH ou toute personne qui pourrait vous aider dans votre recherche d'emploi.
Candidatures Spontanées : Ajoutez des entreprises dans votre liste cible pour les candidatures spontanées et suivez votre progression avec elles.
Intégration avec les Jobboards : Facilitez vos candidatures en ajoutant des offres provenant de sites tels qu'Indeed, HelloWork, et d'autres jobboards populaires.
Objectif
L'objectif de Follow_Job est de fournir un outil centralisé et intuitif pour les chercheurs d'emploi, leur permettant de gérer efficacement toutes les étapes de leur recherche d'emploi, du suivi des candidatures à la gestion des contacts et des notes personnelles.

## Technologies Utilisées
- Framework : Symfony
- Base de Données : MySQL
- Frontend : HTML, CSS, JavaScript
- Intégrations : API des Jobboards (Indeed, HelloWork, etc.)
- Autres : 
  - [Cocur/Slugify](github.com/cocur/slugifyl)

## Installation
Pour installer et exécuter Follow_Job localement, veuillez suivre les étapes ci-dessous :

### Clonez ce repository :

````
git clone https://github.com/votre-utilisateur/follow_job.git
````

### Installez les dépendances avec Composer :
````
composer install
````

### Configurez votre base de données dans le fichier .env.

### Exécutez les migrations pour créer les tables nécessaires :

````
php bin/console doctrine:migrations:migrate
````

### Démarrez le serveur de développement :
````
symfony server:start
````

### Accédez à l'application via http://localhost:8000.

### Contribution

Les contributions sont les bienvenues !
🫶 🖖