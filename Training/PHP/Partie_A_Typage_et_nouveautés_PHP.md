# 🔹 Partie A : Typage et nouveautés PHP (niveau expert)
## 1. Union types

Introduit en PHP 8.0
👉 Permet de déclarer qu’un paramètre/retour peut avoir plusieurs types.

    function formatId(int|string $id): string {
        return "ID: $id";
    }


✅ Avantages :

Améliore la lisibilité → tu sais exactement quels types sont acceptés.

Plus robuste que mixed → limite les cas possibles.

❌ Mauvaise pratique :

    function bad(mixed $value) {}


⚠️ mixed rend ton code flou. On préfère int|string si on connaît les cas.

💡 Symfony :

Beaucoup de services Symfony utilisent des union types (par ex. string|\Stringable).

Cela améliore l’autowiring et évite des bugs silencieux.

## 2. Nullable types

Un type précédé de ? signifie que la valeur peut être null.

    function findUser(?int $id): ?User {
        return $id ? new User($id) : null;
    }


➡️ Ici, $id peut être int ou null.
➡️ Le retour peut être User ou null.

✅ Bon usage : utile pour les cas où une valeur est optionnelle.

❌ Mauvais usage : mettre ? partout → diminue la robustesse.

💡 Symfony :

Très utilisé dans les entités Doctrine (ex: ?DateTimeImmutable $deletedAt).

En injection de dépendances, Symfony évite les services ?Service sauf cas précis.

## 3. Return type : void, never, mixed

void : la fonction ne retourne rien.

    function logMessage(string $msg): void {
        echo $msg;
    }


never : introduit en PHP 8.1 → la fonction ne retourne jamais (elle fait throw ou exit).

    function fail(string $msg): never {
        throw new Exception($msg);
    }


mixed : équivalent à "peut être n’importe quoi".
👉 À éviter sauf si vraiment nécessaire (ex: librairies génériques).

💡 Symfony :

never est utilisé dans certains cas du Kernel (ex : Kernel::terminate() peut faire un exit).

void est courant dans les EventListeners (ex : méthode onKernelRequest).

## 4. readonly property

Introduit en PHP 8.1.
👉 Une propriété déclarée readonly peut être écrite uniquement dans le constructeur. Après, elle est immuable.

    class User {
        public function __construct(
            public readonly string $id
        ) {}
    }

    $user = new User("123");
    // $user->id = "456"; ❌ Fatal error


✅ Avantages :

Garantit l’immuabilité.

Idéal pour des Value Objects (ex: UUID, Email, Money).

💡 Symfony :

Utilisé dans les DTOs et les Value Objects (domain-driven design).

Très utile avec messenger (ex: un Message avec des champs immuables).

## 5. Enums

Introduit en PHP 8.1.
👉 Remplacent les constantes de classe en apportant plus de sécurité.

    enum Status: string {
        case Draft = 'draft';
        case Published = 'published';
    }


✅ Avantages :

Plus lisible qu’un tableau de constantes.

Vérification stricte par PHP (impossible de passer une valeur hors enum).

💡 Symfony :

Très utilisé avec Doctrine (Symfony 7 supporte les enums comme type de colonne).

Exemple : un champ status dans une entité peut être une enum.

    #[ORM\Column(enumType: Status::class)]
    private Status $status;

## 6. Attributes (annotations modernes)

Introduits en PHP 8.0 → remplacent les annotations Doctrine/Twig/Symfony.

    #[Route('/home', name: 'homepage')]
    public function index() {}


✅ Avantages :

Natif PHP → pas besoin de doctrine/annotation parser.

Plus performant.

💡 Symfony :

Routes, entités Doctrine, events, validators, security → tout peut utiliser les attributes.

## 7. match expression

Introduit en PHP 8.0 → meilleure alternative à switch.

    $status = 'draft';

    $message = match($status) {
        'draft' => 'In progress',
        'published' => 'Visible',
        default => 'Unknown'
    };


✅ Avantages :

Exhaustif (tu dois gérer tous les cas).

Retourne une valeur (contrairement à switch).

Plus lisible.

💡 Symfony :

Utile pour mapper des enums vers des labels dans un service.

✅ Résumé (Partie A)

Pour être expert PHP tu dois maîtriser :

* Union types (int|string)
* Nullable (?Type)
* void, never, mixed (et quand les utiliser)
* readonly pour l’immuabilité
* enum pour remplacer des constantes
* #[Attributes] (routes, doctrine, validators)
* match au lieu de switch