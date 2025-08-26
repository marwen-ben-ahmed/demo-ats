# 📘 Symfony 7 – Partie B : Service Container & Autowiring
## 🔹 1. Qu’est-ce qu’un Service ?

* Un service = un objet réutilisable qui fait une tâche précise.
    * Exemples : envoyer un email, logger, gérer une requête HTTP, accès DB.
* Avantage : découpler ton code → tu n’écris pas new Mailer() partout, tu demandes au container.

👉 En Symfony, presque tout est un service : le router, Doctrine, Twig, Security, ton propre code métier.

## 🔹 2. Le Service Container

Le container est l’usine centrale qui :

* Enregistre les services disponibles
* Gère leurs dépendances
* Fournit une instance quand tu en as besoin

📦 Il est compilé au cache → Symfony ne lit pas les configs à chaque requête, mais génère un container PHP optimisé.

### Exemple :

```php
# config/services.yaml
services:
    App\Service\Mailer:
        arguments:
            $transport: 'smtp'
```

Puis dans un controller :

```php
public function index(Mailer $mailer) {
    $mailer->send("Hello");
}
```

Symfony injecte automatiquement la bonne instance.

## 🔹 3. Autowiring

* Symfony peut deviner automatiquement quel service injecter grâce au type-hint (nom de la classe).
* Pas besoin de config si ta dépendance est unique et connue.

### Exemple :

```php
namespace App\Controller;

use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DemoController extends AbstractController
{
    public function send(Mailer $mailer): Response
    {
        $mailer->send("Test");
        return new Response("Email envoyé !");
    }
}
```

👉 Ici, Mailer est injecté automatiquement si c’est une classe existante dans ton namespace App\Service.

## 🔹 4. Autoconfiguration

* Symfony sait appliquer des tags automatiquement si ta classe implémente une interface connue.
### Exemple :

```php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    // ...
}
```


👉 Pas besoin de déclarer le tag kernel.event_subscriber, Symfony le fait via autoconfiguration.

## 🔹 5. Les différents types de services

* 1- Privés (par défaut)

    * Non accessibles via $container->get().
    * Utilisables uniquement via injection.

* 2- Publics

    * Déclarés explicitement public: true.
    * Exemples : doctrine, twig.

* 3- Alias

    * Permettent de donner plusieurs noms au même service.
    * Exemple : mailer → alias de Symfony\Component\Mailer\MailerInterface.

## 🔹 6. Bonnes pratiques SensioLabs

✅ Toujours injecter des abstractions (interfaces) et non des implémentations directes.
### Exemple :

```php 
public function __construct(MailerInterface $mailer) { ... }
```


➡️ Plus facile à tester / remplacer (mock).

✅ Ne jamais utiliser ```php $this->get('service')``` → considéré comme un anti-pattern.
➡️ Utilise injection par constructeur ou par méthode.

✅ Garde ```php services.yaml``` minimal → profite d’autowiring + autoconfiguration.

🔹 7. Exemple complet

👉 Déclarons un service custom :

```php
// src/Service/Mailer.php
namespace App\Service;

class Mailer
{
    private string $transport;

    public function __construct(string $transport = 'smtp')
    {
        $this->transport = $transport;
    }

    public function send(string $message): void
    {
        dump("Send via {$this->transport}: $message");
    }
}
```


👉 Config (optionnel si autowiring) :

```php
# config/services.yaml
    services:
        App\Service\Mailer:
            arguments:
                $transport: '%env(MAILER_TRANSPORT)%'
```


👉 Utilisation :

```php
#[Route('/send', name: 'app_send')]
public function send(Mailer $mailer): Response
{
    $mailer->send("Hello World");
    return new Response("Mail envoyé !");
}
```

# 🎯 Résumé à retenir (mode expert)

* Service = objet réutilisable.
* Container = enregistre et fournit des services, compilé pour perf.
* Autowiring = injection auto par type-hint.
* Autoconfiguration = ajout auto de tags/interfaces.
* Privé par défaut → injection recommandée.
* Best practice SensioLabs : injecter interfaces et non classes concrètes.

# 📝 Questions type certification (PART B)

### 1- Pourquoi Symfony compile le container de services en PHP ?

* a- Pour améliorer la sécurité
* b- Pour améliorer les performances en évitant de parser YAML/XML à chaque requête
* c- Pour générer automatiquement les tests

### 2- Quelle est la meilleure manière d’obtenir un service dans un contrôleur Symfony moderne ?

* a- ```php $this->get('service')```
* b- Injection de dépendance via constructeur ou argument de méthode
* c- ```php Container::get()``` statique

### 3- Si deux services implémentent la même interface, comment Symfony sait lequel injecter ?

* a- Il choisit arbitrairement
* b- Il demande via un prompt en console
* c- Tu dois configurer un alias ou utiliser l’attribut #[Autowire] pour préciser

### 4- Dans services.yaml, quel est le comportement par défaut des services déclarés ?

* a- Publics et autowirés
* b- Privés, autowirés et autoconfigurés
* c- Inaccessibles sauf si déclarés explicitement

# 📝 Correction des Questions type certification (PART B)
### 1 -> b ✅
### 2 -> b ✅
### 3 -> c ✅
### 4 -> b ✅
