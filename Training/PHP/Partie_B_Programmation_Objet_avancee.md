# 🔹 Partie B : Programmation Objet avancée
## 1. Classes abstraites

👉 Une classe abstraite est une classe qu’on ne peut pas instancier directement.
Elle sert de base commune pour les classes filles.

    abstract class Animal {
        abstract public function speak(): string;

        public function eat(): string {
            return "Eating...";
        }
    }

    class Dog extends Animal {
        public function speak(): string {
            return "Woof";
        }
    }

    $dog = new Dog();
    echo $dog->speak(); // Woof


✅ Points clés :

Une méthode abstract doit être définie dans la classe fille.

Une classe abstraite peut contenir du code commun réutilisé par ses enfants.

💡 Symfony :

Beaucoup de classes du framework sont abstraites (ex : AbstractController, AbstractType pour les formulaires).

Tu hérites de ces classes pour avoir un socle de fonctionnalités.

## 2. Interfaces

👉 Une interface définit un contrat que la classe doit respecter.
Une classe peut implémenter plusieurs interfaces (héritage multiple impossible avec les classes).

    interface Logger {
        public function log(string $message): void;
    }

    class FileLogger implements Logger {
        public function log(string $message): void {
            echo "Saving log: $message";
        }
    }


✅ Points clés :

Permet d’assurer que toutes les classes qui implémentent une interface exposent la même API.

On code contre une interface, pas une implémentation (principe SOLID).

💡 Symfony :

Exemple : Symfony\Component\EventDispatcher\EventSubscriberInterface.

Quand tu fais implements EventSubscriberInterface, Symfony sait automatiquement quels events ta classe écoute.

## 3. Traits

👉 Un trait permet de réutiliser du code horizontalement (entre classes qui ne partagent pas de parent commun).

    trait LoggerTrait {
        public function log(string $msg) {
            echo "[LOG] $msg\n";
        }
    }

    class Service {
        use LoggerTrait;
    }

    (new Service())->log("Hello"); // [LOG] Hello


✅ Points clés :

Permet d’éviter la duplication de code.

Mais ⚠️ attention : surutilisation → code spaghetti.

💡 Symfony :

    Symfony\Bundle\FrameworkBundle\Controller\AbstractController utilise des traits (ex: CsrfTokenManagerAwareTrait).

Doctrine utilise des traits pour Timestampable, SoftDeleteable.

## 4. final

👉 Mot-clé final bloque l’héritage ou la surcharge.

    final class Logger {} // impossible à hériter

    class Base {
        final public function save() {}
    }

    class User extends Base {
        // public function save() {} ❌ Erreur
    }


✅ Points clés :

On met final quand on ne veut pas que le comportement soit modifié.

Utile pour protéger le framework.

💡 Symfony :

Beaucoup de classes/services Symfony sont final → ça t’oblige à utiliser la composition ou les events au lieu de surcharger directement.

## 5. Polymorphisme

👉 Le polymorphisme permet d’utiliser des classes différentes via le même contrat (interface ou héritage).

    interface Payment {
        public function pay(int $amount): string;
    }

    class Paypal implements Payment {
        public function pay(int $amount): string {
            return "Paid $amount via Paypal";
        }
    }

    class Stripe implements Payment {
        public function pay(int $amount): string {
            return "Paid $amount via Stripe";
        }
    }

    function process(Payment $gateway) {
        echo $gateway->pay(100);
    }

    process(new Paypal()); // Paid 100 via Paypal
    process(new Stripe()); // Paid 100 via Stripe


💡 Symfony :

Service substitution avec autowiring par interface.

Exemple : tu peux déclarer plusieurs services qui implémentent LoggerInterface. Symfony injectera le bon en fonction de la config.

## 6. Late Static Binding (static::)

👉 Permet d’appeler des méthodes de la classe courante, même si elles sont héritées.
⚠️ Différence entre self:: et static::.

    class Base {
        public static function who() {
            echo __CLASS__;
        }

        public static function test() {
            self::who();   // Appelle toujours Base::who
            static::who(); // Appelle la classe réelle
        }
    }

    class Child extends Base {
        public static function who() {
            echo __CLASS__;
        }
    }

    Child::test(); 
    // self:: → Base
    // static:: → Child


✅ Points clés :

    self:: = lié à la classe où c’est défini.

    static:: = lié à la classe qui fait réellement l’appel.

💡 Symfony :

Utilisé dans des classes d’usine (factories) ou des builders.

Exemple : Doctrine et Symfony utilisent static::class pour retourner le bon type d’entité/service.

### ✅ Résumé Partie B

Pour être expert PHP/Symfony tu dois savoir :

* abstract class → base commune avec du code partiel.
* interface → contrat strict, favorise l’injection de dépendances.
* trait → réutilisation horizontale.
* final → interdit héritage/surcharge (framework protégé).
* Polymorphisme → une même API, plusieurs implémentations (très utilisé en Symfony).
* Late Static Binding (static::) → résolution dynamique, Doctrine et Symfony l’utilisent partout.