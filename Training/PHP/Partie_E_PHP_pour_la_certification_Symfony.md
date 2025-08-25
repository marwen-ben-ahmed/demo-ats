# 📘 PHP pour la certification Symfony – Partie finale
## 1. PHP Extensions

👉 Une extension PHP est un module compilé ou installé qui ajoute des fonctionnalités au langage.
Elles peuvent être natives (installées avec PHP) ou ajoutées via PECL / OS package manager.

### Extensions importantes pour Symfony

* json → encodage/décodage JSON (utilisé partout).
* ctype → utilisé par Symfony Validator.
* mbstring → gestion des chaînes UTF-8 (obligatoire pour Symfony).
* openssl → sécurité (HTTPS, JWT, Password hashing).
* pdo_mysql (ou pgsql, sqlite) → Doctrine ORM.
* xml → parsing XML (config, serializer).
* curl → utilisé par HttpClient.
* intl → localisation, formats de dates, nombres.

### Commandes utiles
* php -m          # liste des extensions installées
* php -i | grep -i extension


💡 Exam tip : la certification peut te demander quelle extension est obligatoire pour Symfony → réponse = mbstring.

## 2. SPL (Standard PHP Library)

👉 La SPL fournit des classes et interfaces de base.

### a) Iterators

* Iterator → interface pour parcourir un objet avec foreach.
* IteratorAggregate → permet de retourner un Traversable.

Exemple :

    class Collection implements IteratorAggregate {
        private array $items = [];

        public function add($item) { $this->items[] = $item; }

        public function getIterator(): Traversable {
            return new ArrayIterator($this->items);
        }
    }

    $c = new Collection();
    $c->add("A");
    $c->add("B");

    foreach ($c as $item) {
        echo $item; // A B
    }

### b) Datastructures

* SplStack → pile (LIFO).
* SplQueue → file (FIFO).
* SplObjectStorage → associer des objets à des données (clé = objet).

$stack = new SplStack();
$stack->push("a");
$stack->push("b");
echo $stack->pop(); // b

### c) SPL Exceptions

PHP définit des exceptions standards (héritées de Exception), ex :

* LogicException (erreur de logique : InvalidArgumentException, OutOfRangeException)
* RuntimeException (erreur d’exécution : UnexpectedValueException)

💡 Symfony :

* Utilise IteratorAggregate pour les collections.
* Doctrine implémente aussi les Iterator SPL.

## 3. Exceptions et gestion des erreurs

👉 Avant PHP 7 : erreurs = E_WARNING, E_NOTICE etc.
Depuis PHP 7+ : tout est objet → Throwable est la racine.

### Hiérarchie
    Throwable
    ├── Error
    └── Exception


* Error → erreurs fatales (ex: appel méthode inexistante).
* Exception → erreurs applicatives (ex: division par zéro).

### Gestion des exceptions

    try {
        throw new RuntimeException("Erreur");
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    } finally {
        echo "Toujours exécuté";
    }


💡 Symfony :

* Kernel écoute ExceptionEvent.
* Tu peux créer un ExceptionListener ou un ErrorController.
* Les exceptions Symfony héritent souvent de HttpException.

## 4. Namespaces

👉 Permettent d’organiser le code et d’éviter les collisions.

### Déclaration

    namespace App\Service;

    class Mailer {}

### Utilisation

    use App\Service\Mailer;

    $mailer = new Mailer();

### Alias
    use App\Service\Mailer as MyMailer;


⚠️ Points clés pour la certif :

* namespace doit être la première instruction du fichier (après declare).
* use doit être déclaré en haut du fichier.
* Les fonctions et constantes peuvent aussi être namespaced.

💡 Symfony :

* L’autoload repose sur PSR-4 → namespace = chemin du fichier.
* Toutes tes classes doivent avoir un namespace correct.

## 5. Object Oriented Programming (récap certif)

Déjà vu en profondeur (Partie B), mais voici ce qu’il faut savoir pour la certif :

### Concepts clés

* Encapsulation → public, protected, private.
* Héritage → extends.
* Polymorphisme → interface / classes abstraites.
* Abstraction → méthodes abstraites.
* Composition over Inheritance → Symfony privilégie la composition (services).

### PHP modernes

* Traits
* final
* static:: vs self:: (late static binding)
* readonly
* enum

💡 Symfony :

* Tout le framework est construit sur OOP + DI.
* Les services Symfony = des objets simples respectant OOP + PSR.

### ✅ Résumé – Derniers modules PHP pour la certif

1- Extensions PHP :

* Obligatoires : json, ctype, mbstring, openssl, pdo_*, intl.

2- SPL :

* Iterator, IteratorAggregate, ArrayIterator
* SplStack, SplQueue, SplObjectStorage
* Exceptions SPL (LogicException, RuntimeException).
* Exceptions & Erreurs :
* Throwable = racine.
* Error vs Exception.
* try/catch/finally.

3- Namespaces :

* Organisation du code.
* use, alias, PSR-4.

4- OOP :

* Encapsulation, Héritage, Polymorphisme, Abstraction.
* Traits, final, late static binding.
* Enums, readonly.
