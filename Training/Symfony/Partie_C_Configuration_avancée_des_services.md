# 📘 Symfony 7 – Partie C : Configuration avancée des services
## 🔹 1. Alias de services

Un alias permet de dire : « quand je demande cette interface, utilise tel service concret ».

### Exemple :

```yaml
services:
    App\Service\SmtpMailer:
        arguments:
            $host: 'smtp.gmail.com'

    App\Service\MailerInterface: '@App\Service\SmtpMailer'
```

### Ainsi :

```php
public function __construct(MailerInterface $mailer) { ... }
```

👉 Symfony injectera SmtpMailer.

⚡ Important : la certification aime tester ça, car sans alias, Symfony ne sait pas choisir entre plusieurs implémentations.

## 🔹 2. Service Factory

* Une ```factory``` est utilisée quand la création d’un service est complexe et ne peut pas se faire par un simple ```__construct```.

### Exemple :

```php
class ConnectionFactory {
    public function create(string $dsn): Connection {
        return new Connection($dsn);
    }
}
```

### Config :

```yaml
services:
    App\Service\ConnectionFactory: ~
    App\Service\Connection:
        factory: ['@App\Service\ConnectionFactory', 'create']
        arguments:
            - '%env(DB_DSN)%'
```

👉 Ici, Symfony appelle ConnectionFactory::create('%env(DB_DSN)%') pour créer le service.

## 🔹 3. Décorateur de service

* Le decorator permet d’envelopper un service existant pour ajouter un comportement.
* Pattern très utilisé chez SensioLabs pour la sécurité, logs, cache.

### Exemple :

```php
class LoggingMailer implements MailerInterface
{
    public function __construct(
        private MailerInterface $inner,
        private LoggerInterface $logger
    ) {}

    public function send(string $message): void
    {
        $this->logger->info("Envoi d’un email : $message");
        $this->inner->send($message);
    }
}
```

### Config :

```yaml
services:
    App\Service\LoggingMailer:
        decorates: App\Service\MailerInterface
        arguments:
            $inner: '@App\Service\LoggingMailer.inner'
            $logger: '@logger'
```

👉 Résultat : chaque appel à MailerInterface passera d’abord par LoggingMailer, qui appelle ensuite l’ancien.

## 🔹 4. Tagged Services

* Les tags permettent de déclarer un groupe de services, récupérables ensemble.
* Très utile pour les Event Subscribers, Console Commands, Twig extensions.

### Exemple :

```yaml
services:
    App\Command\SendEmailCommand:
        tags: ['console.command']
```

* Symfony scanne les services avec ce tag et les enregistre dans la console.

➡️ On peut aussi créer nos propres tags :

```yaml
services:
    App\Service\Handler\*:
        tags: ['app.custom_handler']
```

Puis :

```php
class HandlerRegistry {
    /** @param iterable<HandlerInterface> $handlers */
    public function __construct(iterable $handlers) {
        foreach ($handlers as $handler) {
            // Symfony injecte tous les services taggés
        }
    }
}
```

## 🔹 5. Paramètres & ENV

* Les services peuvent recevoir des paramètres statiques ou des variables d’environnement.

### Exemple :

```yaml
parameters:
    app.admin_email: 'admin@example.com'

services:
    App\Service\Mailer:
        arguments:
            $adminEmail: '%app.admin_email%'
```

Avec env :

```yaml
services:
    App\Service\Mailer:
        arguments:
            $dsn: '%env(MAILER_DSN)%'
```

# 🎯 Résumé (Mode Expert)

* Alias = lie une interface à une implémentation.
* Factory = permet de créer un service via une méthode custom.
* Decorator = enveloppe un service existant → ajoute du comportement.
* Tags = regroupent des services → très utilisé en interne Symfony.
* Paramètres/env = permettent de passer de la config externe aux services.

# 📝 Questions type certification (PART C)

### 1- Si deux services implémentent MailerInterface, comment dire à Symfony d’injecter SmtpMailer par défaut ?

* a- Ajouter un alias de MailerInterface vers SmtpMailer
* b- Marquer SmtpMailer comme public
* c- Symfony choisit arbitrairement

### 2- Quelle est l’utilité d’un service décorateur ?

* a- Remplacer un service existant sans toucher son code
* b- Supprimer un service inutile
* c- Créer un service statique

### 3- Comment Symfony enregistre-t-il automatiquement une Console\Command ?

* a- Grâce au nom de la classe
* b- Grâce au tag console.command
* c- Grâce à l’autowiring

### 4- Quelle syntaxe YAML permet d’utiliser une factory pour créer un service ?
* a-

    ```yaml
    services:
        App\Service\Connection:
            factory: ['@App\Service\ConnectionFactory', 'create']
    ```

* b- 
    ```yaml
    services:
        App\Service\Connection:
            use_factory: App\Service\ConnectionFactory
    ```

* c- 
    ```yaml
    services:
        App\Service\Connection:
            construct_from: factory
    ```

# 🛠 Exercice pratique Symfony – Décorateur de service

🎯 Objectif : Créer un **service décorateur** pour ajouter des logs sur l’envoi d’emails.

---

## Étape 1 – Créer une interface et un service de base

```php
// src/Service/MailerInterface.php
namespace App\Service;

interface MailerInterface
{
    public function send(string $message): void;
}
```

```php
// src/Service/SmtpMailer.php
namespace App\Service;

class SmtpMailer implements MailerInterface
{
    public function send(string $message): void
    {
        // simulation envoi
        echo "Email envoyé : $message";
    }
}
```
## Étape 2 – Créer le décorateur

```php
// src/Service/LoggingMailer.php
namespace App\Service;

use Psr\Log\LoggerInterface;

class LoggingMailer implements MailerInterface
{
    public function __construct(
        private MailerInterface $inner,
        private LoggerInterface $logger
    ) {}

    public function send(string $message): void
    {
        $this->logger->info("📧 Email en préparation : " . $message);
        $this->inner->send($message);
        $this->logger->info("✅ Email envoyé avec succès !");
    }
}
```

## Étape 3 – Configurer les services

```yaml
# config/services.yaml
services:
    App\Service\SmtpMailer: ~

    App\Service\LoggingMailer:
        decorates: App\Service\MailerInterface
        arguments:
            $inner: '@App\Service\LoggingMailer.inner'
            $logger: '@logger'

```
👉 Ici App\Service\LoggingMailer remplace MailerInterface et utilise l’ancien service sous le nom LoggingMailer.inner.

## Étape 4 – Tester dans un contrôleur

```php
// src/Controller/MailController.php
namespace App\Controller;

use App\Service\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    #[Route('/test-mail')]
    public function test(MailerInterface $mailer): Response
    {
        $mailer->send("Hello Symfony!");

        return new Response("Mail envoyé (voir logs).");
    }
}

```

## ✅ Résultat attendu :
* Tu vois "Mail envoyé (voir logs)." dans ton navigateur.
* Dans les logs (var/log/dev.log), tu retrouves :
    * 📧 Email en préparation : Hello Symfony!
    * ✅ Email envoyé avec succès !

# 📝 Correction des Questions type certification (PART C)
### 1 -> a ✅
### 2 -> a ✅
### 3 -> b ✅
### 4 -> a ✅