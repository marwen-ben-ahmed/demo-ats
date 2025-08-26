# 📘 Symfony 7 – Partie A : Architecture & Kernel
## 🔹 1. Cycle Request → Response

Symfony repose sur une architecture HTTP-centric.
Chaque requête HTTP suit ce chemin :

### 1- Entrée dans public/index.php

* C’est le front controller, point d’entrée unique.

* Il récupère la requête avec :

    ```php
    $request = Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    ```
### 2- Passage dans le Kernel

* Le Kernel (src/Kernel.php) orchestre :

    * Chargement des bundles
    * Enregistrement de la config
    * Création du Service Container

### 3- Routing

* Le Router cherche quelle route correspond à l’URL.
* Il assigne : contrôleur + paramètres.

### 4- Controller

* Le contrôleur exécute la logique métier.
* Il retourne un objet Response.

### 5- HttpKernel Events

* Symfony déclenche une série d’événements (Events) :

    * kernel.request (avant le routing)
    * kernel.controller (juste avant d’appeler le contrôleur)
    * kernel.response (avant d’envoyer la réponse)
    * kernel.terminate (après réponse envoyée au client)

### 6- Envoi de la réponse

* L’objet Response est renvoyé au navigateur.

## 🔹 2. Le rôle du Kernel

Le Kernel est la colonne vertébrale de Symfony.

* Classe située dans src/Kernel.php :

    ```php
    use Symfony\Component\HttpKernel\Kernel as BaseKernel;
    use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

    class Kernel extends BaseKernel
    {
        use MicroKernelTrait;
    }
    ```

* Ses responsabilités :

    * Charger les Bundles (registerBundles()).
    * Charger les configurations (configureContainer()).
    * Charger les routes (configureRoutes()).

💡 En résumé : le Kernel prépare l’application et délègue le traitement des requêtes au HttpKernel.

## 🔹 3. Environnements & Config

Symfony fonctionne avec des environnements (souvent : dev, prod, test).

* Définis dans .env :

    ```php
    APP_ENV=dev
    APP_DEBUG=1
    ```

* Chaque environnement peut avoir une config spécifique :

    * config/packages/doctrine.yaml
    * config/packages/prod/doctrine.yaml (écrase certaines valeurs en prod).

## 🔹 4. Bundles

Un bundle = comme un plugin ou un package Symfony.
### Exemples :

* FrameworkBundle → cœur du framework.
* DoctrineBundle → intégration Doctrine ORM.
* SecurityBundle → gestion authentification.

Tu peux créer tes propres bundles (rare dans projets modernes, plus utile pour libs partagées).

## 🔹 5. Exemple concret d’un cycle

👉 URL : http://localhost:8000/hello/Marwen

* Navigateur → index.php reçoit /hello/Marwen.
* Le Kernel est instancié.
* Le routeur trouve la route :

    ```php
    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response {
        return new Response("Hello $name");
    }
    ```


* Controller exécuté → retourne Response("Hello Marwen").
* kernel.response event → possibilité de modifier la réponse (ex: middleware).
* Le navigateur reçoit "Hello Marwen".

# 🎯 Résumé à retenir (mode certification)

* Front controller : public/index.php → unique point d’entrée.
* Kernel : charge bundles, configs, routes.
* HttpKernel : gère les events et appelle les controllers.
* Request/Response : tout est basé sur ces objets.
* Environnements : dev, prod, test.
* Bundles : modules réutilisables, cœur de Symfony.

# 📝 Questions type certification (SF - PART A)

### 1 - Quel est le rôle du fichier public/index.php ?

* a- Définir les routes de l’application
* b- Être le point d’entrée unique qui crée la Request et appelle le Kernel
* c- Configurer la base de données

### 2 - Quand est déclenché l’événement kernel.response ?

* a- Avant l’appel du contrôleur
* b- Juste après que le contrôleur retourne une Response, mais avant l’envoi au client
* c- Après que le navigateur ait reçu la réponse

### 3 - Dans quel fichier configure-t-on l’environnement par défaut (APP_ENV et APP_DEBUG) ?

* a- src/Kernel.php
* b- .env
* c- config/packages/framework.yaml

### 4 - Que fait le Kernel lors de son initialisation ?

* a- Il exécute directement les controllers
* b- Il charge les bundles, la configuration et les routes
* c- Il démarre le serveur interne PHP


# 📝 Correction des Questions type certification (PART A)
### 1 -> b ✅
### 2 -> b ✅
### 3 -> b ✅
### 4 -> b ✅
