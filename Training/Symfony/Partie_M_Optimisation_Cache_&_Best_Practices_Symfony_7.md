# 🎯 Symfony 7 – Partie M:  Optimisation, Cache & Best Practices Symfony 7
🧠 Rappel théorique (expert level)
1. Cache Symfony

Symfony supporte plusieurs types de cache :

Cache HTTP / Reverse Proxy : pour les pages publiques (Cache-Control)

Cache Doctrine : optimiser les requêtes / métadonnées

Cache de services : compilation du container (var/cache/prod)

Cache Twig : templates compilés pour performance

Exemple de cache d’un controller :

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;

public function index(CacheInterface $cache): Response
{
    $data = $cache->get('homepage_data', function() {
        return ['time' => time()];
    });

    return $this->render('home/index.html.twig', ['data' => $data]);
}

2. Optimisation Doctrine

Requêtes optimisées : JOIN et select spécifiques plutôt que findAll().

Lazy-loading pour éviter les requêtes inutiles.

Query Caching pour les requêtes fréquentes.

3. Optimisation Twig

Compilation en cache (var/cache/prod/twig) → pages plus rapides.

Macro et includes au lieu de répéter le code.

cache tag pour fragments HTML avec render() ou esi.

4. Meilleures pratiques SensioLabs

Container privé par défaut → éviter $container->get() pour performance.

Services immutables → injecter uniquement ce qui est nécessaire.

Eviter les requêtes répétitives → précharger les relations (Eager Loading).

Utiliser autoconfigure et autowire pour simplifier et optimiser le container.

Profiler / Debug Toolbar → identifier les goulets d’étranglement (slow queries, templates lourds).

5. Commandes utiles pour production
# Clear cache prod
php bin/console cache:clear --env=prod

# Warmup cache
php bin/console cache:warmup

# Analyse performance
php bin/console debug:container --show-arguments

📝 QCM Jour 12 (sans correction)

1. Où Symfony stocke les templates compilés pour optimiser les performances ?
a) var/cache/prod/twig
b) templates/cache
c) public/cache

2. Quelle pratique Doctrine évite les requêtes inutiles sur les relations ?
a) Lazy-loading
b) Eager-loading
c) Direct-loading

3. Quel type de cache est utilisé pour des pages publiques côté HTTP ?
a) Cache Twig
b) Cache HTTP / Reverse Proxy
c) Cache Doctrine

4. Quelle est la bonne pratique pour les services dans Symfony pour optimiser le container ?
a) Les rendre publics
b) Les rendre privés et immutables
c) Toujours les récupérer via $container->get()

5. Pour identifier les goulets d’étranglement en dev, quel outil utiliser ?
a) Symfony Profiler / Debug Toolbar
b) PHP CS Fixer
c) PHPUnit

# 📝 Correction des Questions type certification (PART M)
### 1 -> c ✅
### 2 -> b ✅
### 3 -> a ✅
### 4 -> a ✅
### 5 -> a ✅