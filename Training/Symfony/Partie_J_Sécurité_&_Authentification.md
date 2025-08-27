# 🎯 Symfony 7 – Partie J: Sécurité & Authentification
🧠 Rappel théorique (niveau expert SensioLabs)
1. Sécurité dans Symfony

Le Security Component gère :

L’authentification (qui est l’utilisateur ?)

L’autorisation (a-t-il le droit ?)

Configurée via config/packages/security.yaml.

2. Authentification

Symfony 7 utilise les authenticators.

Exemple de config security.yaml :

security:
    providers:
        app_user_provider:
            entity:
                class: App\Entity\User
                property: email

    firewalls:
        main:
            lazy: true
            provider: app_user_provider
            custom_authenticator: App\Security\LoginFormAuthenticator
            logout:
                path: app_logout


Un authenticator implémente Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface.

3. Autorisation

Vérifie les rôles/permissions.

Accès par annotations/attributs :

#[IsGranted('ROLE_ADMIN')]
public function adminDashboard() { ... }


Ou via access_control :

access_control:
    - { path: ^/admin, roles: ROLE_ADMIN }

4. Utilisateur & UserInterface

L’utilisateur doit implémenter UserInterface :

class User implements UserInterface
{
    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];
    
    public function getUserIdentifier(): string { return $this->email; }
    public function getRoles(): array { return $this->roles; }
}

5. Outils pratiques

is_granted() dans Twig :

{% if is_granted('ROLE_ADMIN') %}
   <a href="/admin">Admin</a>
{% endif %}


denyAccessUnlessGranted() dans les contrôleurs :

$this->denyAccessUnlessGranted('ROLE_USER');

📝 QCM Jour 9 (sans correction)

1. Dans Symfony 7, quel est le mécanisme recommandé pour gérer l’authentification personnalisée ?
a) Guard authenticator
b) Security Voter
c) Custom Authenticator basé sur AuthenticatorInterface

2. Quelle méthode d’un UserInterface retourne l’identifiant unique de l’utilisateur ?
a) getUsername()
b) getUserIdentifier()
c) getEmail()

3. Quelle annotation/attribut utiliser pour restreindre l’accès d’une action à ROLE_ADMIN ?
a) #[Role('ROLE_ADMIN')]
b) #[IsGranted('ROLE_ADMIN')]
c) #[Secure('ROLE_ADMIN')]

4. Où configure-t-on les firewalls et providers dans Symfony ?
a) .env
b) security.yaml
c) services.yaml

5. Quelle méthode permet de refuser l’accès à un contrôleur si l’utilisateur n’a pas un rôle donné ?
a) $this->blockAccess('ROLE_USER')
b) $this->denyAccessUnlessGranted('ROLE_USER')
c) $this->refuseIfNoRole('ROLE_USER')

# 📝 Correction des Questions type certification (PART I)
### 1 -> c ✅
### 2 -> b ✅
### 3 -> b ✅
### 4 -> b ✅
### 5 -> b ✅