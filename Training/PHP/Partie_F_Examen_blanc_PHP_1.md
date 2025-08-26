# 📘 Examen blanc PHP – 25 questions
## 🔹 Q1. Typage

### Quel sera le résultat de ce code ?

    function test(int|string $id): string {
        return "ID: $id";
    }

    echo test(42);


* ✅ ID: 42
* Erreur de typage
* 42

## 🔹 Q2. Nullable

### Quel prototype de fonction est correct pour accepter un User ou null ?

* function setUser(User $user = null)
* function setUser(?User $user)
* ✅ Les deux

## 🔹 Q3. Enums

### Quel est l’avantage principal d’un enum par rapport à une constante de classe ?

* Plus rapide
* ✅ Vérification stricte par PHP
* Peut contenir du HTML

## 🔹 Q4. readonly

### Que se passe-t-il ici ?

    class Foo {
        public function __construct(public readonly string $bar) {}
    }

    $f = new Foo("test");
    $f->bar = "new"; 


* Change la valeur
* ✅ Erreur
* Ignore l’opération

## 🔹 Q5. match

### Que retournera ce code ?

    $status = 'draft';

    $result = match($status) {
        'draft' => 'In progress',
        'published' => 'Visible',
        default => 'Unknown'
    };
    echo $result;


* ✅ In progress
* Visible
* Unknown

## 🔹 Q6. Abstract

### Quelle affirmation est vraie ?

* Une classe abstraite peut être instanciée.
* ✅ Une méthode abstraite doit être implémentée dans les classes filles.
* Une classe abstraite ne peut pas contenir de méthode concrète.

## 🔹 Q7. Interface

### Quelle est la bonne signature pour forcer une classe à implémenter une méthode log(string $msg) ?

* ✅ interface Logger { public function log(string $msg); }
* abstract class Logger { public abstract function log($msg); }
* Les deux

## 🔹 Q8. Trait

### Que va afficher ce code ?

```php
trait Logger {
    public function log($m) { echo $m; }
}

class Service {
    use Logger;
}

(new Service())->log("Hi");
```

* ✅ Hi
* Erreur
* Rien

## 🔹 Q9. final

### Que fait le mot-clé final ?

* Empêche l’instanciation d’une classe
* ✅ Empêche l’héritage ou la surcharge
* Supprime la visibilité

## 🔹 Q10. Late static binding

### Dans ce code :

```php
class A {
    public static function who() { echo __CLASS__; }
    public static function test() { static::who(); }
}

class B extends A {
    public static function who() { echo __CLASS__; }
}

B::test();
```

### Résultat ?

* A
* ✅ B
* Erreur

## 🔹 Q11. Closures

### Quelle est la différence entre une closure et une arrow function (fn) ?

* Arrow function capture automatiquement les variables extérieures.
* Closure nécessite toujours use().
* ✅ Les deux affirmations sont vraies.

## 🔹 Q12. array_map

### Quel est le résultat ?

```php
$nums = [1, 2, 3];
$r = array_map(fn($n) => $n*2, $nums);
print_r($r);
```

* ✅ [2, 4, 6]
* [1, 2, 3]
* Erreur

## 🔹 Q13. array_filter

### Résultat ?

```php
$nums = [1,2,3,4];
$r = array_filter($nums, fn($n) => $n%2===0);
print_r($r);
```

* [2, 4] avec clés [1,3]
* ✅ [2, 4] avec clés réindexées
* Erreur

## 🔹 Q14. array_reduce

### Que fait array_reduce ?

* Transforme un tableau en objet
* ✅ Réduit un tableau en une seule valeur
* Réduit un tableau en plusieurs valeurs

## 🔹 Q15. Générateurs

### Quelle est la sortie ?

```php
function gen() {
    yield 1;
    yield 2;
}
foreach(gen() as $v) echo $v;
```

* ✅ 12
* 21
* Erreur

## 🔹 Q16. Variadiques

### Quel est le bon prototype ?

```php 
function sum(...$n) { return array_sum($n); }
```


* sum([1,2,3]);
* ✅ sum(1,2,3);
* Les deux avec unpacking

## 🔹 Q17. Composer

### Quelle commande installe une dépendance sans mettre à jour les autres ?

* composer update
* ✅ composer require
* composer install

## 🔹 Q18. PSR-3

### À quoi correspond PSR-3 ?

* ✅ Logger Interface
* Container Interface
* Autoload

## 🔹 Q19. Symfony et extensions

### Quelle extension est obligatoire pour Symfony ?

* intl
*✅ mbstring
* curl

## 🔹 Q20. SPL

### Quelle classe SPL représente une pile (LIFO) ?

* SplQueue
* ✅ SplStack
* SplObjectStorage

## 🔹 Q21. SPL Iterators

### Quel est l’avantage de IteratorAggregate ?

* ✅ Implémenter getIterator() et déléguer à un autre Iterator.
* Éviter les exceptions.
* Générer automatiquement du JSON.

## 🔹 Q22. Exceptions

### Quelle classe racine regroupe toutes les erreurs et exceptions ?

* Exception
* Error
* ✅ Throwable

## 🔹 Q23. try/catch

### Quel bloc est toujours exécuté ?

* try
* catch
* ✅ finally

## 🔹 Q24. Namespaces

### Où doivent être placés les use dans un fichier PHP ?

* N’importe où
* ✅ En haut du fichier, après namespace
* Après chaque classe

## 🔹 Q25. OOP

### Lequel correspond à la composition over inheritance (bonne pratique Symfony) ?

* Étendre une classe Mailer pour ajouter une méthode.
* ✅ Injecter un service Mailer dans le constructeur et le réutiliser.
* Copier/coller le code du Mailer.