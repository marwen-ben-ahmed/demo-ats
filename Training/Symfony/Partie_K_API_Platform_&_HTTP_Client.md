# 🎯 Symfony 7 – Partie K:  API Platform & HTTP Client
🧠 Rappel théorique (niveau expert SensioLabs)
1. API Platform

API Platform est un framework basé sur Symfony pour exposer des APIs REST et GraphQL.

Il fonctionne par annotations/attributs sur les entités.

Exemple :

#[ApiResource]
class Product
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;
}


➡️ Automatiquement : endpoints /api/products, /api/products/{id} (CRUD).

2. Opérations et configuration

On peut configurer les opérations disponibles :

#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete']
)]


Sécurité par attribut :

#[ApiResource(security: "is_granted('ROLE_ADMIN')")]

3. Serialisation & Normalisation

API Platform utilise le serializer Symfony :

Groupes pour contrôler l’exposition des données :

#[Groups(['product:read'])]
private string $name;


Configuré via normalizationContext et denormalizationContext.

4. HTTP Client Symfony

Symfony fournit un HTTP Client moderne (symfony/http-client).

Usage simple :

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService {
    public function __construct(private HttpClientInterface $client) {}

    public function fetchData() {
        $response = $this->client->request('GET', 'https://api.example.com/data');
        return $response->toArray();
    }
}


Méthodes clés :

request(method, url, options)

$response->getStatusCode()

$response->getContent()

$response->toArray()

5. Bonnes pratiques SensioLabs

Toujours utiliser les DTOs (Data Transfer Objects) pour mapper les données externes.

Valider les données reçues via le Validator Symfony.

Séparer la logique métier de la logique d’appel HTTP.

📝 QCM Jour 10 (sans correction)

1. Quelle annotation/attribut transforme une entité Doctrine en ressource exposée par l’API ?
a) #[EntityResource]
b) #[ApiResource]
c) #[ApiEntity]

2. Avec API Platform, comment limiter les champs exposés dans la réponse JSON ?
a) Utiliser des DTO obligatoires
b) Utiliser des groupes de sérialisation avec #[Groups]
c) Cacher les colonnes dans la base de données

3. Quelle méthode du HttpClient permet de directement décoder une réponse JSON en tableau PHP ?
a) getContent()
b) toArray()
c) jsonDecode()

4. Dans quelle config définit-on les opérations disponibles pour une ressource (ex: GET, POST, PUT) ?
a) Dans services.yaml
b) Dans l’attribut #[ApiResource(...)]
c) Dans doctrine.yaml

5. Quelle bonne pratique est recommandée pour travailler avec des APIs externes ?
a) Appeler directement l’API dans le contrôleur
b) Utiliser un service dédié + DTO pour mapper les données
c) Stocker la réponse brute dans la session

# 📝 Correction des Questions type certification (PART K)
### 1 -> b ✅
### 2 -> b ✅
### 3 -> b ✅
### 4 -> b ✅
### 5 -> b ✅