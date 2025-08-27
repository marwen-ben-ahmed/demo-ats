# 📘 Symfony 7 – Partie E : Routing & Controllers
## 🔹 1. Le Routing Symfony

Le routing relie une URL à un controller.

### Déclaration classique :

```php
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DemoController
{
    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        return new Response("Hello $name");
    }
}
```

* ```php {name} ```→ paramètre dynamique injecté automatiquement dans la méthode.
* ```yaml name: 'app_hello' ``` → nom unique de la route pour générer des URLs via generateUrl().

### Routing YAML (optionnel) :

```yaml
# config/routes.yaml
app_hello:
    path: /hello/{name}
    controller: App\Controller\DemoController::hello
```

## 🔹 2. ParamConverters

* Les ParamConverters permettent de convertir automatiquement un paramètre URL en objet Doctrine ou autre.

### Exemple :

```php
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/user/{id}', name: 'user_show')]
#[ParamConverter('user', class: User::class)]
public function show(User $user): Response
{
    return new Response("Utilisateur : " . $user->getName());
}
```

* Symfony récupère automatiquement l’entité correspondante en base via l’ID.

💡 Très pratique pour éviter find($id) manuellement.

## 🔹 3. Controllers

* Un Controller = classe ou fonction qui renvoie une Response.

* 2 types :

    * Controller basé sur classe (méthodes) → recommandé.

    * Controller fonction (callable) → pour petites routes simples.

### Exemple avec services injectés :

```php
use App\Service\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    #[Route('/send-mail', name: 'send_mail')]
    public function send(MailerInterface $mailer): Response
    {
        $mailer->send("Hello Symfony 7!");
        return new Response("Mail envoyé !");
    }
}
```

* Ici, MailerInterface est injecté automatiquement grâce à autowiring.

## 🔹 4. Paramètres optionnels et types

```php
#[Route('/hello/{name?Marwen}', name: 'hello_default')]
public function helloDefault(string $name): Response
{
    return new Response("Hello $name");
}
```

* ```php ?Marwen ``` → valeur par défaut si le paramètre n’est pas fourni.

💡 Symfony 7 permet aussi de typer les paramètres (int $id, string $slug) pour validation automatique.

## 🔹 5. Redirections et URL Generation

* Générer une URL à partir du nom de la route :

```php
$url = $this->generateUrl('app_hello', ['name' => 'Marwen']);
```

### Redirection simple :

```php
return $this->redirectToRoute('app_hello', ['name' => 'Marwen']);
```

## 🔹 6. Bonnes pratiques SensioLabs

* Toujours nommer les routes pour faciliter l’URL generation.
* Utiliser ParamConverters pour réduire le code répétitif.
* Injecter les services via constructeur ou argument de méthode.
* Préférer les controllers orientés classe pour la maintenabilité.

## 🔹 7. Résumé (Mode Expert)

* Routing → URL ↔ Controller
* ParamConverters → paramètres URL convertis automatiquement en objets
* Controllers → doivent toujours retourner un Response
* Services → injectés via autowiring
* URL generation & redirection → éviter le hardcode

# 📝 Questions type certification (PART E)

### 1- Quelle annotation permet de définir une route dans Symfony 7 ?

* a- @Route
* b- @Path
* c- @Url

### 2- Comment convertir automatiquement un paramètre URL en objet Doctrine ?

* a- ParamConverter
* b- Autowiring
* c- Service Tag

### 3- Quelle est la valeur par défaut si un paramètre optionnel n’est pas fourni ?

```php 
#[Route('/hello/{name?Marwen}')]
```


* a- null
* b- Marwen
* c- vide string

### 4- Quelle est la meilleure pratique pour injecter un service dans un controller ?

* a- $this->get('service')
* b- Injection via constructeur ou argument de méthode
* c- $container->get()

🛠 Exercice pratique – Routing & Controller

# 🎯 Objectif : Créer un mini-module utilisateur.

1. Crée une entité User avec id, name, email.
2. Crée un controller UserController avec :
    *  Route /user/{id} → affiche le nom de l’utilisateur
    * Route /user → liste tous les utilisateurs
3. Utilise ParamConverter pour la route /user/{id}.
4. Injecte un service UserMailer pour envoyer un mail de bienvenue dans la méthode /user.
5. Génère les URLs dynamiquement via generateUrl() pour chaque utilisateur dans la liste.

💡 Avec cet exercice, tu combines : Routing, Controllers, ParamConverters, Services et URL generation, exactement comme un module Symfony réel.

# 📝 Correction des Questions type certification (PART E)
### 1 -> a ✅
### 2 -> a ✅
### 3 -> b ✅
### 4 -> b ✅