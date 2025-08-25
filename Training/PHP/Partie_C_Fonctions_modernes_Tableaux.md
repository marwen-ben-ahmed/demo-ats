# 🔹 Partie C : Fonctions modernes & Tableaux (Expert)
## 1. Closures & Fonctions anonymes

👉 Une closure est une fonction anonyme (sans nom) qui peut capturer des variables extérieures.

    $message = "Hello";

    $closure = function() use ($message) {
        return $message . " World!";
    };

    echo $closure(); // Hello World!


✅ Points clés :

    use ($var) capture la variable par valeur.

    use (&$var) capture par référence (si la variable change après, la closure la voit).

    $count = 0;
    $closure = function() use (&$count) {
        $count++;
    };
    $closure();
    echo $count; // 1


💡 Symfony :

Utilisé dans les middlewares, les event listeners et les tests ($this->runInTransaction(fn() => ...)).

## 2. Arrow functions (fn)

Introduites en PHP 7.4.
👉 Version courte des closures.

    $nums = [1, 2, 3];
    $result = array_map(fn($n) => $n * 2, $nums);
    print_r($result); // [2, 4, 6]


✅ Différence avec closure classique :

Pas besoin de use() → les variables extérieures sont capturées automatiquement par valeur.

    $factor = 10;
    $result = array_map(fn($n) => $n * $factor, [1, 2, 3]); 
    // [10, 20, 30]


💡 Symfony :

Très utilisé dans les transformations rapides de collections (ex : $users->map(fn(User $u) => $u->getEmail())).

## 3. array_map, array_filter, array_reduce

👉 Fonctions fonctionnelles de manipulation de tableaux.

array_map

Applique une fonction à chaque élément.

    $nums = [1, 2, 3];
    $doubles = array_map(fn($n) => $n * 2, $nums);
    print_r($doubles); // [2, 4, 6]

array_filter

Filtre un tableau en gardant seulement les valeurs où le callback retourne true.

    $nums = [1, 2, 3, 4, 5];
    $even = array_filter($nums, fn($n) => $n % 2 === 0);
    print_r($even); // [2, 4]


⚠️ Attention : les clés d’origine sont conservées.
Si tu veux réindexer → array_values().

array_reduce

Réduit un tableau à une seule valeur.

    $nums = [1, 2, 3];
    $sum = array_reduce($nums, fn($carry, $n) => $carry + $n, 0);
    echo $sum; // 6


💡 Symfony :

Très utilisé avec des collections Doctrine (map/filter/reduce).

Exemple : $orders->reduce(fn($carry, $order) => $carry + $order->getAmount(), 0).

## 4. Générateurs (yield)

👉 Alternative ultra-optimisée aux tableaux → permet de produire des valeurs paresseusement (lazy).

    function counter($max) {
        for ($i = 1; $i <= $max; $i++) {
            yield $i;
        }
    }

    foreach (counter(3) as $n) {
        echo $n . " "; // 1 2 3
    }


✅ Avantages :

Pas besoin de stocker tout le tableau en mémoire.

Idéal pour traiter de grosses collections (fichiers, requêtes DB).

⚠️ Différence avec return []:

yield retourne un Generator, pas un tableau.

    $gen = counter(3);
    var_dump($gen); // object(Generator)


💡 Symfony :

Utilisé dans Messenger (consommation des messages), HttpClient (streaming des réponses), Console (progress bar).

## 5. Fonctions variadiques (...$args)

👉 Permet de recevoir un nombre illimité d’arguments.

    function sum(int ...$numbers): int {
        return array_sum($numbers);
    }

    echo sum(1, 2, 3); // 6


👉 On peut aussi déstructurer un tableau avec ... :

    $nums = [1, 2, 3];
    echo sum(...$nums); // 6


💡 Symfony :

Utilisé dans la configuration (ex: new ChoiceConstraint(...$choices)).

Très utile avec les events où on passe plusieurs arguments.

## 6. Callback avancés

👉 PHP accepte plusieurs formats de callbacks :

    array_map('strtoupper', ['a','b']);   // fonction globale
    array_map([new UserService(), 'format'], $users); // méthode d’instance
    array_map([UserService::class, 'format'], $users); // méthode statique


⚠️ Pour Symfony, il faut bien distinguer :

    [Class::class, 'method'] → appel statique ou autoload possible.

    [new Class(), 'method'] → objet déjà instancié.

### ✅ Résumé Partie C

Pour être expert PHP/Symfony tu dois maîtriser :

* Closures (function() use ($x)) et passage par référence.
* Arrow functions (fn) avec capture automatique.
* array_map, filter, reduce → transformations fonctionnelles.
* Générateurs (yield) pour des flux paresseux.
* Fonctions variadiques (...$args) et unpacking (...$array).
* Callback avancés ('function', [Class::class, 'method']).
