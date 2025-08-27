# 📘 Symfony 7 – Partie D : Container & Compiler Pass
## 🔹 1. Qu’est-ce qu’un Compiler Pass ?

* Le Compiler Pass est une classe qui permet de modifier le container avant qu’il soit compilé en PHP.
* Concrètement : tu peux ajouter, supprimer, remplacer, ou modifier des services dynamiquement.
* Utilisation typique :
    * Récupérer tous les services avec un tag spécifique et les enregistrer dans un registry
    * Modifier la configuration d’un service avant compilation
    * Ajouter un décorateur automatiquement

⚡ Important : le Compiler Pass est exécuté uniquement au moment de compilation du container, pas à chaque requête.

## 🔹 2. Créer un Compiler Pass

Exemple : on veut récupérer tous les handlers taggés app.custom_handler et les injecter dans un HandlerRegistry.

```php
// src/DependencyInjection/Compiler/HandlerCompilerPass.php
namespace App\DependencyInjection\Compiler;

use App\Service\HandlerRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class HandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(HandlerRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(HandlerRegistry::class);

        $taggedServices = $container->findTaggedServiceIds('app.custom_handler');

        $references = [];
        foreach ($taggedServices as $id => $tags) {
            $references[] = new Reference($id);
        }

        $definition->setArgument(0, $references);
    }
}
```

## 🔹 3. Enregistrer le Compiler Pass
```php
// src/Kernel.php
use App\DependencyInjection\Compiler\HandlerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Kernel extends BaseKernel
{
    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new HandlerCompilerPass());
    }
}
```

👉 Chaque fois que le container sera compilé, Symfony exécutera ton HandlerCompilerPass.

## 🔹 4. Exemple complet avec Registry
### Service Registry :

```php
// src/Service/HandlerRegistry.php
namespace App\Service;

class HandlerRegistry
{
    /** @var iterable<HandlerInterface> */
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }

    public function all(): iterable
    {
        return $this->handlers;
    }
}
```

### Services taggés :

```yaml
services:
    App\Service\Handler\*:
        tags: ['app.custom_handler']
```
## 🔹 5. Bonnes pratiques SensioLabs

* Ne modifie jamais un service public directement à runtime → fais-le via Compiler Pass
* Les tags + Compiler Pass sont préférables aux injections manuelles
* Utilise Registry/Manager pour gérer des collections de services
* Toujours vérifier que le service cible existe ($container->has()) pour éviter les erreurs

## 🔹 6. Résumé (Mode Expert)

* Compiler Pass = modifier le container avant compilation
* Tags = grouper services pour injection dynamique
* Registry = centraliser les services taggés
* Bonnes pratiques = sécurité, vérification, injections via DI

# 📝 Questions type certification (PART D)

### 1- Quand un Compiler Pass est-il exécuté ?

* a- À chaque requête
* b- Lors de la compilation du container
* c- Lors de l’appel du premier service

### 2- Pourquoi utiliser un Compiler Pass au lieu d’injecter les services directement ?

* a- Pour modifier dynamiquement le container et gérer des services taggés
* b- Pour améliorer les performances de la requête
* c- Pour sécuriser les services publics

### 3- Que renvoie $container->findTaggedServiceIds('app.custom_handler') ?

* a- La liste des services taggés avec ce tag
* b- Une seule instance de service
* c- Un booléen

### 4- Quelle est la bonne pratique SensioLabs pour gérer plusieurs services similaires ?

* a- Les injecter manuellement dans le constructeur
* b- Les récupérer via tags et Compiler Pass dans un Registry
* c- Les rendre publics et accéder via $container->get()

# 🛠 Exercice pratique – Compiler Pass

### 🎯 Objectif : Créer un Registry dynamique pour tous les services HandlerInterface.

1. Crée un HandlerInterface et 2 services taggés app.custom_handler.
2. Crée un HandlerRegistry qui reçoit tous les handlers via constructeur.
3. Crée un HandlerCompilerPass qui injecte automatiquement les services taggés dans le registry.
4. Teste dans un contrôleur : appelle HandlerRegistry->all() et vérifie que tous les handlers sont présents.

# 📝 Correction des Questions type certification (PART D)
### 1 -> b ✅
### 2 -> a ✅
### 3 -> a ✅
### 4 -> b ✅