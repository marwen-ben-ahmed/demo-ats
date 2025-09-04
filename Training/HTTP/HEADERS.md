# Guide Complet des En-têtes HTTP avec Symfony 7

## 🎯 Astuce : Test mental rapide

**Question magique à se poser** : *"Est-ce que cet en-tête décrit le MESSAGE ou l'EXPÉDITEUR ?"*

### Règle d'or :
- **MESSAGE** → ✅ **Identique** (Content-Type, Date, Cache-Control...)
- **EXPÉDITEUR** → ❌ **Non identique** (User-Agent, Server, Authorization...)

## 📚 Fiche de révision ultracompacte

### ✅ IDENTIQUES (11 en-têtes principaux)

```
CONTENT-* (Type, Length, Encoding, Language)
CACHE-Control
CONNECTION  
DATE
VIA
WARNING
PRAGMA
TRANSFER-Encoding
UPGRADE
```

### ❌ NON-IDENTIQUES

**Request only** : Accept-*, Authorization, Cookie, Host, User-Agent, Referer, Origin, If-*

**Response only** : Set-Cookie, Location, Server, WWW-Authenticate, ETag, Last-Modified, Expires

### Exemples d'application :
| En-tête | Question | Réponse | Conclusion |
|---------|----------|---------|------------|
| Content-Type | "Décrit le message ou l'expéditeur ?" | Le message (JSON/HTML) | ✅ Identique |
| User-Agent | "Décrit le message ou l'expéditeur ?" | L'expéditeur (navigateur) | ❌ Request only |
| Cache-Control | "Décrit le message ou l'expéditeur ?" | Le message (règles cache) | ✅ Identique |
| Authorization | "Décrit le message ou l'expéditeur ?" | L'expéditeur (qui es-tu ?) | ❌ Request only |
| Set-Cookie | "Décrit le message ou l'expéditeur ?" | L'expéditeur (serveur ordonne) | ❌ Response only |

---

## 📋 Tableau 1 : En-têtes IDENTIQUES

| En-tête | Description FR | Description EN | Exemple Request | Exemple Response | Valeurs typiques |
|---------|----------------|----------------|----------------|------------------|------------------|
| **Content-Type** | Type MIME du contenu transmis | MIME type of transmitted content | `$request->headers->get('Content-Type')` | `$response->headers->set('Content-Type', 'application/json')` | `application/json`, `text/html; charset=utf-8`, `multipart/form-data` |
| **Content-Length** | Taille du contenu en octets | Content size in bytes | `$request->headers->get('Content-Length')` | `$response->headers->set('Content-Length', 1024)` | `1024`, `2048`, `0` |
| **Content-Encoding** | Algorithme de compression appliqué | Applied compression algorithm | `$request->headers->get('Content-Encoding')` | `$response->headers->set('Content-Encoding', 'gzip')` | `gzip`, `deflate`, `br` (Brotli) |
| **Content-Language** | Langue naturelle du contenu | Natural language of content | `$request->headers->get('Content-Language')` | `$response->headers->set('Content-Language', 'fr')` | `fr-FR`, `en-US`, `es-ES` |
| **Cache-Control** | Directives de mise en cache HTTP | HTTP caching directives | `$request->headers->get('Cache-Control')` | `$response->setMaxAge(3600)` | `public, max-age=3600`, `no-cache`, `private` |
| **Connection** | Gestion de la connexion TCP | TCP connection management | `$request->headers->get('Connection')` | `$response->headers->set('Connection', 'keep-alive')` | `keep-alive`, `close`, `upgrade` |
| **Date** | Horodatage de création du message | Message creation timestamp | `$request->headers->get('Date')` | `$response->setDate(new \DateTime())` | `Wed, 04 Sep 2025 12:30:00 GMT` |
| **Via** | Chaîne de proxies intermédiaires | Intermediate proxy chain | `$request->headers->get('Via')` | `$response->headers->set('Via', '1.1 proxy.com')` | `1.1 proxy1.com`, `2.0 cache.example.org` |
| **Warning** | Avertissements sur le cache ou contenu | Cache or content warnings | `$request->headers->get('Warning')` | `$response->headers->set('Warning', '199 Misc')` | `110 Response is stale`, `214 Transformation applied` |
| **Pragma** | Directives HTTP/1.0 de compatibilité | HTTP/1.0 compatibility directives | `$request->headers->get('Pragma')` | `$response->headers->set('Pragma', 'no-cache')` | `no-cache` (legacy) |
| **Transfer-Encoding** | Encodage de transfert des données | Data transfer encoding | `$request->headers->get('Transfer-Encoding')` | `$response->headers->set('Transfer-Encoding', 'chunked')` | `chunked`, `gzip, chunked` |

---

## 📋 Tableau 2 : En-têtes NON-IDENTIQUES

### 🔵 En-têtes de REQUÊTE uniquement

| En-tête | Description FR | Description EN | Exemple Symfony | Valeurs typiques |
|---------|----------------|----------------|-----------------|------------------|
| **Accept** | Types de contenu acceptés par le client | Content types accepted by client | `$request->headers->get('Accept')` | `application/json`, `text/html,*/*;q=0.8` |
| **Accept-Language** | Langues préférées du client | Client preferred languages | `$request->getPreferredLanguage(['fr', 'en'])` | `fr-FR,fr;q=0.9,en;q=0.8` |
| **Accept-Encoding** | Encodages de compression acceptés | Accepted compression encodings | `$request->headers->get('Accept-Encoding')` | `gzip, deflate, br` |
| **Accept-Charset** | Jeux de caractères acceptés | Accepted character sets | `$request->headers->get('Accept-Charset')` | `utf-8,iso-8859-1;q=0.7` |
| **Authorization** | Credentials d'authentification | Authentication credentials | `$request->headers->get('Authorization')` | `Bearer eyJhbGc...`, `Basic dXNlcjpwYXNz` |
| **Cookie** | Cookies HTTP envoyés au serveur | HTTP cookies sent to server | `$request->cookies->get('session_id')` | `sessionid=abc123; csrf_token=xyz789` |
| **Host** | Nom d'hôte et port du serveur cible | Target server hostname and port | `$request->getHost()` | `example.com`, `api.site.com:8080` |
| **User-Agent** | Identification du client HTTP | HTTP client identification | `$request->headers->get('User-Agent')` | `Mozilla/5.0 (Windows NT 10.0...)` |
| **Referer** | URL de la page précédente | Previous page URL | `$request->headers->get('Referer')` | `https://example.com/login` |
| **If-Modified-Since** | Condition de modification temporelle | Temporal modification condition | `$request->headers->get('If-Modified-Since')` | `Wed, 01 Sep 2025 12:00:00 GMT` |
| **If-None-Match** | Condition ETag pour cache | ETag condition for caching | `$request->headers->get('If-None-Match')` | `"686897696a7c876b7e"` |
| **Range** | Plage de données demandée | Requested data range | `$request->headers->get('Range')` | `bytes=200-1023`, `bytes=0-499` |
| **Origin** | Origine de la requête CORS | CORS request origin | `$request->headers->get('Origin')` | `https://mydomain.com` |
| **X-Requested-With** | Indicateur de requête AJAX | AJAX request indicator | `$request->isXmlHttpRequest()` | `XMLHttpRequest` |

### 🔴 En-têtes de RÉPONSE uniquement

| En-tête | Description FR | Description EN | Exemple Symfony | Valeurs typiques |
|---------|----------------|----------------|-----------------|------------------|
| **Set-Cookie** | Définition de cookies HTTP | HTTP cookie definition | `$response->headers->setCookie(Cookie::create('name', 'value'))` | `sessionid=abc123; Path=/; HttpOnly; Secure` |
| **Location** | URL de redirection HTTP | HTTP redirection URL | `$response->headers->set('Location', '/dashboard')` | `https://example.com/dashboard`, `/relative/path` |
| **Server** | Information sur le serveur web | Web server information | `$response->headers->set('Server', 'nginx/1.18')` | `nginx/1.18.0`, `Apache/2.4.41` |
| **WWW-Authenticate** | Challenge d'authentification HTTP | HTTP authentication challenge | `$response->headers->set('WWW-Authenticate', 'Bearer realm="API"')` | `Basic realm="Protected"`, `Bearer realm="API"` |
| **ETag** | Identifiant de version de ressource | Resource version identifier | `$response->setEtag('unique-hash')` | `"686897696a7c876b7e"`, `W/"weak-etag"` |
| **Last-Modified** | Date de dernière modification | Last modification date | `$response->setLastModified(new \DateTime())` | `Wed, 01 Sep 2025 15:30:00 GMT` |
| **Expires** | Date d'expiration du cache | Cache expiration date | `$response->setExpires(new \DateTime('+1 day'))` | `Thu, 05 Sep 2025 12:00:00 GMT` |
| **Vary** | En-têtes de variation du cache | Cache variation headers | `$response->setVary(['Accept-Encoding'])` | `Accept-Encoding`, `Accept-Language, User-Agent` |
| **Content-Disposition** | Disposition du fichier téléchargé | Downloaded file disposition | `$response->headers->set('Content-Disposition', 'attachment; filename="file.pdf"')` | `attachment; filename="report.pdf"`, `inline` |
| **X-Frame-Options** | Protection contre le clickjacking | Clickjacking protection | `$response->headers->set('X-Frame-Options', 'DENY')` | `DENY`, `SAMEORIGIN`, `ALLOW-FROM uri` |
| **Access-Control-Allow-Origin** | CORS - Origines autorisées | CORS - Allowed origins | `$response->headers->set('Access-Control-Allow-Origin', '*')` | `*`, `https://trusted-domain.com` |
| **Access-Control-Allow-Methods** | CORS - Méthodes HTTP autorisées | CORS - Allowed HTTP methods | `$response->headers->set('Access-Control-Allow-Methods', 'GET,POST')` | `GET, POST, PUT, DELETE, OPTIONS` |
| **Strict-Transport-Security** | Politique de sécurité HTTPS | HTTPS security policy | `$response->headers->set('Strict-Transport-Security', 'max-age=31536000')` | `max-age=31536000; includeSubDomains; preload` |

---

## 🛠️ Module de référence : Toutes les méthodes Symfony 7

### 📥 REQUÊTE (Request) - Méthodes de récupération

#### En-têtes génériques
```php
// Récupération basique avec HeaderBag
$request->headers->get('Header-Name');
$request->headers->get('Header-Name', 'default-value');

// Vérifier l'existence
$request->headers->has('Header-Name');

// Récupérer tous les en-têtes
$request->headers->all();
$request->headers->all('Header-Name'); // Toutes les valeurs d'un en-tête multivalué

// Récupération insensible à la casse
$request->headers->get('content-type'); // équivalent à Content-Type

// En-têtes spécifiques
$request->headers->get('Content-Type');
$request->headers->get('Authorization');
$request->headers->get('User-Agent');
$request->headers->get('Accept');
$request->headers->get('Cache-Control');
```

#### Méthodes spécialisées Request
```php
// Host et URI
$request->getHost(); // Nom d'hôte uniquement
$request->getSchemeAndHttpHost(); // https://example.com
$request->getUri(); // URI complète
$request->getPort(); // Port (80, 443, 8080...)

// Cookies avec ParameterBag
$request->cookies->get('cookie_name');
$request->cookies->get('cookie_name', 'default');
$request->cookies->all();
$request->cookies->has('cookie_name');

// Langue préférée avec négociation de contenu
$request->getPreferredLanguage(['fr', 'en', 'es']);
$request->getLanguages(); // Toutes les langues par ordre de préférence

// Type de requête et détection
$request->isXmlHttpRequest(); // Détecte X-Requested-With: XMLHttpRequest
$request->getMethod(); // GET, POST, PUT, DELETE...
$request->isMethod('POST'); // Vérification spécifique

// Authentification et sécurité
$request->headers->get('Authorization');
$request->getUser(); // Si Basic Auth
$request->getPassword(); // Si Basic Auth

// Conditions de cache
$request->headers->get('If-Modified-Since');
$request->headers->get('If-None-Match');
$request->headers->get('If-Match');

// CORS et origines
$request->headers->get('Origin');
$request->headers->get('Access-Control-Request-Method');
$request->headers->get('Access-Control-Request-Headers');

// Accept headers avec négociation
$request->headers->get('Accept');
$request->headers->get('Accept-Language');
$request->headers->get('Accept-Encoding');
$request->headers->get('Accept-Charset');
$request->getAcceptableContentTypes(); // Parse et ordonne Accept

// Content headers
$request->headers->get('Content-Type');
$request->headers->get('Content-Length');
$request->getContentType(); // Parse le Content-Type
```

### 📤 RÉPONSE (Response) - Méthodes de définition

#### En-têtes génériques avec HeaderBag
```php
// Définition et manipulation
$response->headers->set('Header-Name', 'value');
$response->headers->set('Header-Name', ['value1', 'value2']); // Multivalué
$response->headers->add('Header-Name', 'additional-value');
$response->headers->replace(['Header1' => 'value1', 'Header2' => 'value2']);

// Suppression
$response->headers->remove('Header-Name');

// Vérification et récupération
$response->headers->has('Header-Name');
$response->headers->get('Header-Name');
$response->headers->all();
```

#### Content-* Headers
```php
// Content-Type avec méthodes spécialisées
$response->headers->set('Content-Type', 'application/json');
$response->headers->set('Content-Type', 'text/html; charset=utf-8');

// Content-Length automatique ou manuelle
$response->headers->set('Content-Length', strlen($content));
$response->prepare($request); // Calcule automatiquement

// Content-Encoding pour compression
$response->headers->set('Content-Encoding', 'gzip');
$response->headers->set('Content-Encoding', 'br'); // Brotli

// Content-Language pour i18n
$response->headers->set('Content-Language', 'fr-FR');

// Content-Disposition pour téléchargements
$response->headers->set('Content-Disposition', 'attachment; filename="report.pdf"');
$response->headers->set('Content-Disposition', 'inline; filename="document.html"');
```

#### Cache et temps avec méthodes spécialisées
```php
// Cache-Control - Méthodes Symfony dédiées
$response->setPublic(); // Cache-Control: public
$response->setPrivate(); // Cache-Control: private
$response->setMaxAge(3600); // max-age=3600
$response->setSharedMaxAge(7200); // s-maxage=7200
$response->setMustRevalidate(); // must-revalidate

// Cache-Control - Directives personnalisées
$response->headers->addCacheControlDirective('no-cache');
$response->headers->addCacheControlDirective('no-store');
$response->headers->addCacheControlDirective('stale-while-revalidate', 60);

// Date et temps avec DateTime
$response->setDate(new \DateTime()); // Date courante
$response->setLastModified(new \DateTime()); // Last-Modified
$response->setExpires(new \DateTime('+1 day')); // Expires
$response->setNotModified(); // 304 Not Modified

// ETag avec validation
$response->setEtag('unique-hash'); // Strong ETag
$response->setEtag('unique-hash', true); // Weak ETag: W/"unique-hash"

// Vary pour la négociation de contenu
$response->setVary('Accept-Encoding');
$response->setVary(['Accept-Encoding', 'Accept-Language']);
```

#### Cookies avec Cookie class
```php
use Symfony\Component\HttpFoundation\Cookie;

// Cookie basique
$cookie = Cookie::create('name', 'value');
$response->headers->setCookie($cookie);

// Cookie avec toutes les options
$cookie = Cookie::create('session_id', 'abc123')
    ->withExpires(strtotime('+1 month'))
    ->withPath('/')
    ->withDomain('.example.com')
    ->withSecure(true) // HTTPS uniquement
    ->withHttpOnly(true) // Pas accessible en JS
    ->withSameSite('Strict'); // CSRF protection

$response->headers->setCookie($cookie);

// Supprimer un cookie
$response->headers->clearCookie('cookie_name');
$response->headers->clearCookie('cookie_name', '/', '.example.com');
```

#### Redirection
```php
// Redirection avec Location header
$response->headers->set('Location', '/dashboard');
$response->headers->set('Location', 'https://example.com/page');

// Ou utiliser RedirectResponse (recommandé)
use Symfony\Component\HttpFoundation\RedirectResponse;
$response = new RedirectResponse('/dashboard', 302);
$response = new RedirectResponse('https://external.com', 301); // Permanent
```

#### Sécurité et CORS
```php
// CORS Headers
$response->headers->set('Access-Control-Allow-Origin', '*');
$response->headers->set('Access-Control-Allow-Origin', 'https://trusted.com');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
$response->headers->set('Access-Control-Max-Age', '86400'); // 24h preflight cache
$response->headers->set('Access-Control-Allow-Credentials', 'true');

// Security Headers
$response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
$response->headers->set('X-Frame-Options', 'DENY');
$response->headers->set('X-Frame-Options', 'SAMEORIGIN');
$response->headers->set('X-Content-Type-Options', 'nosniff');
$response->headers->set('X-XSS-Protection', '1; mode=block');
$response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

// Content Security Policy
$csp = "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'";
$response->headers->set('Content-Security-Policy', $csp);
```

#### Authentification
```php
// WWW-Authenticate challenges
$response->headers->set('WWW-Authenticate', 'Basic realm="Protected Area"');
$response->headers->set('WWW-Authenticate', 'Bearer realm="API", charset="UTF-8"');
$response->headers->set('WWW-Authenticate', 'Digest realm="API", qop="auth", nonce="'.uniqid().'"');
```

#### Métadonnées serveur
```php
// Informations serveur (éviter en production)
$response->headers->set('Server', 'nginx/1.18.0');
$response->headers->set('X-Powered-By', 'Symfony 7.0');

// Headers personnalisés (convention X-)
$response->headers->set('X-Request-ID', uniqid());
$response->headers->set('X-Response-Time', microtime(true) - $startTime);
```

#### Connexion et transport
```php
// Connexion HTTP
$response->headers->set('Connection', 'keep-alive');
$response->headers->set('Connection', 'close');
$response->headers->set('Keep-Alive', 'timeout=5, max=1000');

// Transfer encoding
$response->headers->set('Transfer-Encoding', 'chunked');

// Via pour proxies
$response->headers->set('Via', '1.1 varnish, 2.0 nginx');

// Warnings
$response->headers->set('Warning', '110 Response is stale');
$response->headers->set('Warning', '214 Transformation applied');
```

### 🔧 Méthodes utilitaires avancées Symfony 7

```php
// Vérifications avec méthodes spécialisées
$request->headers->has('Authorization');
$response->headers->has('Set-Cookie');
$request->isSecure(); // HTTPS check
$request->isMethodSafe(); // GET, HEAD, OPTIONS

// Récupération avec parsing
$contentType = $request->headers->get('Content-Type', 'text/html');
$acceptTypes = $request->getAcceptableContentTypes();
$preferredLanguage = $request->getPreferredLanguage(['fr', 'en']);

// Itération sur HeaderBag
foreach ($request->headers as $name => $values) {
    echo "$name: " . implode(', ', $values);
}

// Clonage et modification
$newResponse = clone $response;
$newResponse->headers->set('X-Custom', 'modified');

// Préparation automatique de la réponse
$response->prepare($request); // Calcule Content-Length, gère HEAD, etc.

// Envoi de la réponse
$response->send(); // Envoie headers + contenu

// Debug et inspection
if ($request->isMethod('POST')) {
    dump($request->headers->all());
}
dump($response->headers->all());

// Validation de cache
$response->isNotModified($request); // Compare ETag et Last-Modified
$response->isCacheable(); // Vérifie si la réponse est cacheable
$response->mustRevalidate(); // Vérifie must-revalidate

// Streaming et responses spéciales
use Symfony\Component\HttpFoundation\StreamedResponse;
$streamedResponse = new StreamedResponse(function() {
    echo "Data chunk 1\n";
    flush();
    echo "Data chunk 2\n";
});
```

## ⚠️ AVERTISSEMENT IMPORTANT : Disponibilité des méthodes

### 📥 REQUÊTE (Request) - Toujours en LECTURE SEULE
```php
// ✅ TOUJOURS DISPONIBLE - HeaderBag lecture
$request->headers->get('Header-Name');
$request->headers->get('Header-Name', 'default');
$request->headers->has('Header-Name');
$request->headers->all();
$request->headers->all('Header-Name'); // Valeurs multiples

// ⚠️ MODIFICATION POSSIBLE mais déconseillée
// Les Request peuvent être modifiées mais c'est une pratique dangereuse
$request->headers->set('X-Custom', 'value'); // Fonctionnel mais anti-pattern

// ✅ CRÉATION de nouvelles Request (tests, sous-requêtes)
use Symfony\Component\HttpFoundation\Request;
$newRequest = Request::create('/path', 'GET', [], [], [], ['HTTP_ACCEPT' => 'application/json']);
```

### 📤 RÉPONSE (Response) - Dépend du contexte

#### ✅ Response que VOUS créez/contrôlez
```php
// Responses Symfony standards
$response = new Response();
$response = new JsonResponse($data);
$response = $this->json($data); // Dans un contrôleur
$response = $this->render('template.html.twig');

// ✅ TOUTES les méthodes HeaderBag disponibles
$response->headers->get('Header-Name');           // ✅ Lecture
$response->headers->has('Header-Name');           // ✅ Vérification
$response->headers->all();                        // ✅ Liste complète
$response->headers->set('Header-Name', 'value');  // ✅ Définir/Remplacer
$response->headers->add('Header-Name', 'value');  // ✅ Ajouter
$response->headers->remove('Header-Name');        // ✅ Supprimer
$response->headers->replace($headers);            // ✅ Remplacer tout
```

#### ⚠️ Response HTTP externe (HttpClient)
```php
use Symfony\Contracts\HttpClient\HttpClientInterface;

$httpClient->request('GET', 'https://api.example.com');
$response = $httpClient->request('GET', 'https://api.com');

// ✅ Méthodes de LECTURE via ResponseInterface
$response->getHeaders(); // Tous les headers
$response->getHeaders(false); // Sans normalisation
$response->getInfo('response_headers'); // Headers bruts

// ❌ Pas de méthodes d'ÉCRITURE sur ResponseInterface
// L'objet ResponseInterface n'a pas de HeaderBag modifiable
```

### 🎯 Règle d'or pour la certification Symfony 7

| Type d'objet | Interface | Lecture | Écriture | Cas d'usage |
|-------------|-----------|---------|----------|-------------|
| **Request HTTP entrant** | `RequestInterface` | ✅ HeaderBag complet | ⚠️ Possible mais déconseillé | Contrôleurs, middleware |
| **Request créée manuellement** | `Request` | ✅ HeaderBag complet | ✅ HeaderBag complet | Tests, sous-requêtes |
| **Response Symfony** | `Response` | ✅ HeaderBag complet | ✅ HeaderBag complet | Contrôleurs, services |
| **Response HttpClient** | `ResponseInterface` | ✅ Méthodes spécialisées | ❌ Non disponible | API externes |

---

## 🧪 Quiz de certification Symfony 7

### Question 1 : HeaderBag et méthodes
```php
// Quel code est correct pour récupérer un header avec valeur par défaut ?
$request->headers->get('Accept-Language', 'en');
$request->headers->getDefault('Accept-Language', 'en');
$request->headers->fetch('Accept-Language') ?? 'en';
```

### Question 2 : Cache-Control
```php
// Comment définir une réponse publique avec max-age de 1 heure ?
$response->setPublic()->setMaxAge(3600);
$response->headers->set('Cache-Control', 'public, max-age=3600');
$response->setPublic() && $response->setMaxAge(3600);
```

### Question 3 : ETag
```php
// Comment créer un ETag faible ?
$response->setEtag('abc123', true);
$response->setEtag('W/"abc123"');
$response->setWeakEtag('abc123');
```

**Réponses** :
1. `$request->headers->get('Accept-Language', 'en')` ✅
2. Les deux premières sont correctes ✅ (méthode fluide recommandée)
3. `$response->setEtag('abc123', true)` ✅

### 🎓 Points clés pour la certification :

1. **HeaderBag** est l'objet central pour manipuler les en-têtes
2. **Request** utilise toujours des méthodes de lecture sur les headers
3. **Response** permet modification complète via HeaderBag  
4. **Cache-Control** a des méthodes spécialisées (`setPublic()`, `setMaxAge()`)
5. **Cookies** utilisent la classe `Cookie` avec méthodes fluides
6. **CORS** nécessite plusieurs headers `Access-Control-*`
7. **Content negotiation** utilise les headers `Accept-*`
8. **Security headers** sont critiques (`X-Frame-Options`, `HSTS`, `CSP`)

La clé du succès : comprendre que Symfony 7 utilise **HeaderBag** comme abstraction unifiée pour tous les en-têtes HTTP, avec des méthodes spécialisées pour les cas d'usage courants.
