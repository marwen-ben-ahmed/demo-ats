# 🔹 Partie D : Outils PHP Essentiels (niveau expert)
## 1. Composer

👉 Composer est le gestionnaire de dépendances PHP.
Il permet :

* d’installer des bibliothèques depuis Packagist
* de gérer l’autoloading
* de verrouiller les versions avec composer.lock

### Commandes essentielles

* composer init → crée un composer.json
* composer require symfony/http-foundation → installe une lib
* composer install → installe à partir du composer.lock
* composer update → met à jour selon les contraintes de composer.json

### ⚠️ Différence importante :

* composer install = reproductible (prod)
* composer update = recalcul des versions (risque de casser la compatibilité)

### 💡 Symfony :

* Les recettes Symfony (Flex) automatisent la config (config/packages/, bin/console etc.)
* Exemple : composer require symfony/security-bundle installe et configure automatiquement.

## 2. Autoloading et PSR-4

👉 PHP moderne n’utilise plus require_once partout.
Composer gère l’autoloading avec la norme PSR-4.

### Exemple de composer.json
    {
        "autoload": {
            "psr-4": {
            "App\\": "src/"
            }
        }
    }


➡️ Signifie : toute classe commençant par App\ sera cherchée dans /src/.

### Exemple de classe
    src/Service/Mailer.php

    namespace App\Service;

    class Mailer {
        public function send() {}
    }


👉 Autoload automatique :

    require __DIR__.'/vendor/autoload.php';

    $mailer = new App\Service\Mailer();
    $mailer->send();


💡 Symfony :

Symfony utilise strictement PSR-4 → toutes tes classes dans src/ suivent cette règle.

Si une classe est mal nommée (namespace ≠ chemin), autowiring échoue.

## 3. PSR standards (PHP-FIG)

👉 PSR = PHP Standards Recommendations.
Le PHP-FIG définit des standards pour rendre les libs interopérables.

Les plus importants pour Symfony :

* PSR-1 / PSR-12 → normes de code (style, conventions).
* PSR-3 (Logger Interface)
    * Définit une interface standard pour les logs.
    * Symfony fournit LoggerInterface, mais tu peux utiliser Monolog ou autre.


        public function __construct(LoggerInterface $logger) {
            $this->logger->info("Message logué");
        }

* PSR-4 (Autoloading)
    * Base du système d’autoload.
* PSR-6 / PSR-16 (Cache)
    * PSR-6 : interfaces complexes (CacheItemPoolInterface).
    * PSR-16 : plus simple (CacheInterface).
    * Symfony Cache supporte les deux.

* PSR-7 (HTTP Message Interfaces)
    * Définit RequestInterface et ResponseInterface.
    * Symfony HttpFoundation ≠ PSR-7, mais Symfony a des bridges pour convertir.

* PSR-11 (Container Interface)
    * Définit un container DI minimal (get() et has()).
    * Symfony’s ContainerInterface l’implémente.

💡 Symfony :

* Respecte ces PSR pour rester compatible avec des libs externes.
* Exemple : tu peux brancher un autre logger PSR-3 que Monolog → Symfony ne verra pas la différence.

## 4. Gestion des environnements & autoload

Symfony charge ses dépendances via vendor/autoload.php.

* En prod : composer install --no-dev --optimize-autoloader
* En dev : autoload optimisé ≠ nécessaire

⚠️ Erreur fréquente en certification :
Confondre autoload PSR-4 avec classmap.

* psr-4 → mapping namespace ↔ dossier.
* classmap → scan des fichiers, plus lent.

## 5. .env et configuration

Même si ce n’est pas du pur PHP, SensioLabs peut tester :

* Symfony charge .env pour définir les variables d’environnement.
* PHP utilise $_ENV et $_SERVER.
* Composer gère parfois l’autoload des dotenv avec symfony/dotenv.

### ✅ Résumé Partie D

Pour être expert Symfony/PHP, tu dois maîtriser :

1- Composer :

* install vs update
* require
* composer.lock (version figée en prod)

2- Autoloading PSR-4 :
* mapping namespace → chemin
* App\Service\Foo → src/Service/Foo.php

3- PSR standards :
* PSR-1/12 (style)
* PSR-3 (logs)
* PSR-4 (autoload)
* PSR-6/16 (cache)
* PSR-7 (HTTP)
* PSR-11 (DI container)

4- Optimisation en prod :
* --optimize-autoloader
* --no-dev