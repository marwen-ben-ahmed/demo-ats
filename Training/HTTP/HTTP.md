# Cours HTTP pour Certification Symfony 7

## Introduction

Le protocole HTTP (HyperText Transfer Protocol) est le fondement du web et un pilier essentiel de Symfony. Cette formation vous prépare à maîtriser tous les concepts HTTP nécessaires pour réussir votre certification Symfony 7.

---

## 1. Client / Server Interaction

### Définition
L'interaction client/serveur HTTP suit un modèle **request-response** où le client (navigateur, application) initie toujours la communication en envoyant une requête au serveur, qui répond avec une réponse.

### Schéma mental : Cycle de vie d'une requête HTTP

```
CLIENT                    RÉSEAU                    SERVEUR
  |                         |                         |
  |------ HTTP Request ----->|----------------------->|
  |       (URL + Headers)    |                       |
  |                          |                       | Traitement
  |                          |                       | de la requête
  |                          |                       |
  |<----- HTTP Response -----|<----------------------|
  |       (Status + Body)    |                       |
```

### Caractéristiques fondamentales

#### 1. **Stateless (Sans état)**
- Chaque requête est indépendante
- Le serveur ne conserve aucune information entre les requêtes
- Nécessite des mécanismes supplémentaires (cookies, sessions) pour maintenir l'état

#### 2. **Connectionless (Sans connexion permanente)**
- Connexion TCP fermée après chaque échange (HTTP/1.0)
- HTTP/1.1 introduit les connexions persistantes (Keep-Alive)
- HTTP/2 et HTTP/3 optimisent davantage les connexions

#### 3. **Text-based (Basé sur du texte)**
- Headers et métadonnées lisibles par l'homme
- Facilite le debugging et la compréhension
- Le body peut être binaire ou textuel

### Tableau comparatif des versions HTTP

| Version | Année | Principales caractéristiques |
|---------|-------|------------------------------|
| HTTP/1.0 | 1996 | Une requête = une connexion |
| HTTP/1.1 | 1997 | Connexions persistantes, chunked encoding |
| HTTP/2 | 2015 | Multiplexage, compression des headers |
| HTTP/3 | 2022 | Protocole QUIC, performance améliorée |

### ⚠️ Attention : Pièges d'examen
- **Piège 1** : Confondre "stateless" avec "sans cookies" - HTTP est stateless mais peut utiliser des cookies
- **Piège 2** : Croire que le serveur peut initier une communication - seul le client peut démarrer un échange HTTP
- **Piège 3** : Oublier que HTTP/1.1 permet les connexions persistantes

### Points clés à retenir
✅ **HTTP est stateless et connectionless par design**
✅ **Le client initie toujours la communication**
✅ **Une requête génère exactement une réponse**
✅ **Les versions HTTP améliorent les performances mais conservent le modèle request-response**

---

## 2. Status Codes

### Définition
Les codes de statut HTTP sont des codes numériques à 3 chiffres qui indiquent le résultat du traitement d'une requête par le serveur. Ils sont regroupés en 5 classes selon leur premier chiffre.

### Classification des codes de statut

#### **1xx - Informatifs (Informational)**
Indiquent que la requête a été reçue et que le processus continue.

| Code | Message | Usage |
|------|---------|-------|
| 100 | Continue | Client peut continuer à envoyer le corps de la requête |
| 101 | Switching Protocols | Changement de protocole (WebSocket) |
| 102 | Processing | Traitement en cours (WebDAV) |

#### **2xx - Succès (Success)**
La requête a été reçue, comprise et acceptée avec succès.

| Code | Message | Usage typique |
|------|---------|---------------|
| 200 | OK | Requête réussie standard |
| 201 | Created | Ressource créée avec succès (POST) |
| 202 | Accepted | Requête acceptée mais traitement asynchrone |
| 204 | No Content | Succès sans contenu à retourner (DELETE) |
| 206 | Partial Content | Contenu partiel (Range requests) |

#### **3xx - Redirection (Redirection)**
Une action supplémentaire est nécessaire pour compléter la requête.

| Code | Message | Type de redirection |
|------|---------|---------------------|
| 301 | Moved Permanently | Redirection permanente |
| 302 | Found | Redirection temporaire |
| 304 | Not Modified | Ressource non modifiée (cache) |
| 307 | Temporary Redirect | Redirection temporaire (méthode préservée) |
| 308 | Permanent Redirect | Redirection permanente (méthode préservée) |

#### **4xx - Erreur Client (Client Error)**
La requête contient une erreur ou ne peut être satisfaite.

| Code | Message | Cause typique |
|------|---------|---------------|
| 400 | Bad Request | Syntaxe de requête invalide |
| 401 | Unauthorized | Authentification requise |
| 403 | Forbidden | Accès interdit |
| 404 | Not Found | Ressource inexistante |
| 405 | Method Not Allowed | Méthode HTTP non autorisée |
| 409 | Conflict | Conflit avec l'état actuel |
| 422 | Unprocessable Entity | Données valides mais logique incorrecte |

#### **5xx - Erreur Serveur (Server Error)**
Le serveur a échoué à traiter une requête valide.

| Code | Message | Cause typique |
|------|---------|---------------|
| 500 | Internal Server Error | Erreur générique du serveur |
| 501 | Not Implemented | Méthode non implémentée |
| 502 | Bad Gateway | Erreur de passerelle |
| 503 | Service Unavailable | Service temporairement indisponible |
| 504 | Gateway Timeout | Timeout de passerelle |

### Schéma mental : Choix du code de statut

```
REQUÊTE REÇUE
     |
     v
Est-elle valide syntaxiquement ?
     |                    |
   NON                  OUI
     |                    |
   400                    v
Bad Request         Puis-je la traiter ?
                         |              |
                       NON            OUI
                         |              |
                    4xx/5xx             v
                  (selon cause)    Traitement réussi ?
                                       |          |
                                     NON        OUI
                                       |          |
                                     5xx        2xx
                                  (erreur)   (succès)
```

### Relations logiques importantes

#### **Codes et méthodes HTTP**
- GET réussi → 200
- POST créant une ressource → 201
- DELETE réussi → 204 ou 200
- PUT/PATCH réussi → 200 ou 204

#### **Codes et caching**
- 304 utilisé avec les requêtes conditionnelles (If-Modified-Since)
- 200 avec cache-control pour définir la mise en cache
- 3xx pour rediriger vers des versions mises en cache

### ⚠️ Attention : Pièges d'examen
- **Piège 1** : Confondre 401 (non authentifié) et 403 (authentifié mais non autorisé)
- **Piège 2** : Utiliser 200 au lieu de 201 pour une création de ressource
- **Piège 3** : Confondre 302 et 307 - le 307 préserve la méthode HTTP originale
- **Piège 4** : Oublier que 422 indique des données syntaxiquement correctes mais sémantiquement incorrectes

### Points clés à retenir
✅ **Le premier chiffre détermine la classe du statut**
✅ **2xx = succès, 4xx = erreur client, 5xx = erreur serveur**
✅ **Le code 304 est essentiel pour la gestion du cache**
✅ **Les codes 3xx nécessitent souvent une action du client (redirection)**

---

## 3. HTTP Request

### Définition
Une requête HTTP est un message envoyé par le client au serveur pour demander une action sur une ressource. Elle est composée de quatre parties principales : la ligne de requête, les headers, une ligne vide et optionnellement un body.

### Structure d'une requête HTTP

```
METHOD /path/to/resource HTTP/version    ← Ligne de requête
Header-Name: Header-Value                ← Headers
Another-Header: Another-Value
                                         ← Ligne vide obligatoire
[Body optionnel]                         ← Corps de la requête
```

### Composants détaillés

#### **1. Ligne de requête (Request Line)**
Format : `MÉTHODE URI VERSION`

**Exemples :**
- `GET /users HTTP/1.1`
- `POST /api/users HTTP/1.1`
- `DELETE /users/123 HTTP/1.1`

#### **2. Headers de requête**
Métadonnées qui fournissent des informations supplémentaires sur la requête.

##### **Headers essentiels**

| Header | Description | Exemple |
|--------|-------------|---------|
| `Host` | Domaine cible (obligatoire en HTTP/1.1) | `Host: api.example.com` |
| `User-Agent` | Information sur le client | `User-Agent: Mozilla/5.0...` |
| `Accept` | Types de contenu acceptés | `Accept: application/json` |
| `Content-Type` | Type du contenu envoyé | `Content-Type: application/json` |
| `Content-Length` | Taille du body en octets | `Content-Length: 1024` |
| `Authorization` | Informations d'authentification | `Authorization: Bearer token` |

##### **Headers de négociation de contenu**

| Header | Usage |
|--------|-------|
| `Accept` | Types MIME acceptés |
| `Accept-Language` | Langues préférées |
| `Accept-Encoding` | Encodages acceptés (gzip, deflate) |
| `Accept-Charset` | Jeux de caractères acceptés |

##### **Headers conditionnels**

| Header | Usage |
|--------|-------|
| `If-Modified-Since` | Requête conditionnelle basée sur la date |
| `If-None-Match` | Requête conditionnelle basée sur l'ETag |
| `If-Match` | Validation de l'ETag pour les modifications |

#### **3. Body (Corps de la requête)**
Optionnel, contient les données à envoyer au serveur.

**Formats courants :**
- **application/json** : Données JSON
- **application/x-www-form-urlencoded** : Données de formulaire
- **multipart/form-data** : Fichiers et formulaires
- **text/plain** : Texte brut
- **application/xml** : Données XML

### Schéma mental : Traitement d'une requête

```
CLIENT prépare la requête
     |
     v
1. Choisit la MÉTHODE (GET, POST, etc.)
     |
     v
2. Construit l'URI (/path?params)
     |
     v
3. Ajoute les HEADERS nécessaires
     |
     v
4. Ajoute le BODY si nécessaire
     |
     v
5. Envoie via le réseau
     |
     v
SERVEUR reçoit et parse
```

### Types de requêtes par usage

#### **Requêtes de lecture**
- Méthode : GET, HEAD
- Body : Généralement absent
- Idempotente : Oui
- Cacheable : Oui

#### **Requêtes de modification**
- Méthode : POST, PUT, PATCH, DELETE
- Body : Souvent présent
- Idempotente : Variable selon la méthode
- Cacheable : Non (sauf exceptions)

### Paramètres de requête

#### **Query Parameters (Paramètres d'URL)**
```
GET /users?page=2&limit=10&sort=name HTTP/1.1
```

#### **Path Parameters (Paramètres de chemin)**
```
GET /users/123/posts/456 HTTP/1.1
```

#### **Headers Parameters**
```
X-Custom-Parameter: value
```

#### **Body Parameters**
```json
{
  "name": "John",
  "email": "john@example.com"
}
```

### ⚠️ Attention : Pièges d'examen
- **Piège 1** : Oublier que le header `Host` est obligatoire en HTTP/1.1
- **Piège 2** : Confondre Content-Type (ce que j'envoie) et Accept (ce que j'accepte)
- **Piège 3** : Mettre un body dans une requête GET (techniquement possible mais déconseillé)
- **Piège 4** : Oublier la ligne vide entre headers et body
- **Piège 5** : Mal encoder l'URL (caractères spéciaux non échappés)

### Points clés à retenir
✅ **Structure fixe : Ligne de requête + Headers + Ligne vide + Body optionnel**
✅ **Le header Host est obligatoire en HTTP/1.1**
✅ **Les headers de négociation permettent l'adaptation du contenu**
✅ **Le Content-Type doit correspondre au format du body**

---

## 4. HTTP Response

### Définition
Une réponse HTTP est le message envoyé par le serveur au client en réponse à une requête. Elle contient le résultat du traitement de la requête avec un code de statut, des métadonnées (headers) et optionnellement un contenu (body).

### Structure d'une réponse HTTP

```
HTTP/version status-code reason-phrase   ← Ligne de statut
Header-Name: Header-Value                ← Headers de réponse
Another-Header: Another-Value
                                         ← Ligne vide obligatoire
[Body optionnel]                         ← Corps de la réponse
```

### Composants détaillés

#### **1. Ligne de statut (Status Line)**
Format : `VERSION CODE PHRASE`

**Exemples :**
- `HTTP/1.1 200 OK`
- `HTTP/1.1 404 Not Found`
- `HTTP/1.1 500 Internal Server Error`

#### **2. Headers de réponse**

##### **Headers informatifs**

| Header | Description | Exemple |
|--------|-------------|---------|
| `Server` | Information sur le serveur | `Server: nginx/1.18.0` |
| `Date` | Date et heure de la réponse | `Date: Wed, 21 Oct 2023 07:28:00 GMT` |
| `Content-Length` | Taille du body en octets | `Content-Length: 348` |
| `Content-Type` | Type MIME du contenu | `Content-Type: application/json` |

##### **Headers de contrôle**

| Header | Usage |
|--------|-------|
| `Location` | URL de redirection (codes 3xx) |
| `Set-Cookie` | Définition de cookies |
| `WWW-Authenticate` | Méthodes d'authentification (401) |
| `Retry-After` | Délai avant nouvelle tentative (503) |

##### **Headers de cache**

| Header | Description |
|--------|-------------|
| `Cache-Control` | Directives de mise en cache |
| `ETag` | Identifiant de version de la ressource |
| `Last-Modified` | Date de dernière modification |
| `Expires` | Date d'expiration du cache |

##### **Headers CORS (Cross-Origin Resource Sharing)**

| Header | Usage |
|--------|-------|
| `Access-Control-Allow-Origin` | Origines autorisées |
| `Access-Control-Allow-Methods` | Méthodes autorisées |
| `Access-Control-Allow-Headers` | Headers autorisés |

#### **3. Body (Corps de la réponse)**
Contient la représentation de la ressource demandée.

**Formats courants selon le Content-Type :**
- **application/json** : Données JSON (API)
- **text/html** : Page HTML (navigateur)
- **text/css** : Feuilles de style
- **application/javascript** : Code JavaScript
- **image/*** : Images (jpeg, png, svg, etc.)
- **application/pdf** : Documents PDF

### Schéma mental : Construction d'une réponse

```
SERVEUR reçoit la requête
     |
     v
1. Traite la requête
     |
     v
2. Détermine le CODE DE STATUT
     |
     v
3. Prépare le BODY si nécessaire
     |
     v
4. Ajoute les HEADERS appropriés
     |
     v
5. Envoie la réponse complète
     |
     v
CLIENT reçoit et interprète
```

### Relations entre composants

#### **Code de statut ↔ Headers requis**

| Code | Headers obligatoires/recommandés |
|------|----------------------------------|
| 201 | `Location` (URL de la ressource créée) |
| 3xx | `Location` (URL de redirection) |
| 401 | `WWW-Authenticate` |
| 503 | `Retry-After` |

#### **Content-Type ↔ Body**
- Si body présent → Content-Type obligatoire
- Content-Type doit correspondre au format réel
- Charset spécifié si nécessaire : `text/html; charset=utf-8`

### Types de réponses courantes

#### **Réponses de données (API)**
```
HTTP/1.1 200 OK
Content-Type: application/json
Content-Length: 156

{
  "id": 123,
  "name": "John Doe",
  "email": "john@example.com"
}
```

#### **Réponses de redirection**
```
HTTP/1.1 301 Moved Permanently
Location: https://example.com/new-path
Content-Length: 0
```

#### **Réponses d'erreur**
```
HTTP/1.1 400 Bad Request
Content-Type: application/json

{
  "error": "Invalid request format",
  "details": "Missing required field: email"
}
```

#### **Réponses de cache**
```
HTTP/1.1 304 Not Modified
ETag: "686897696a7c876b7e"
Cache-Control: max-age=3600
```

### Négociation de contenu dans les réponses

Le serveur adapte sa réponse selon les headers `Accept*` de la requête :

#### **Accept → Content-Type**
- Requête : `Accept: application/json`
- Réponse : `Content-Type: application/json`

#### **Accept-Language → Content-Language**
- Requête : `Accept-Language: fr-FR, en;q=0.8`
- Réponse : `Content-Language: fr-FR`

#### **Accept-Encoding → Content-Encoding**
- Requête : `Accept-Encoding: gzip, deflate`
- Réponse : `Content-Encoding: gzip`

### ⚠️ Attention : Pièges d'examen
- **Piège 1** : Oublier le header `Location` avec les codes de redirection (3xx)
- **Piège 2** : Mettre un body avec un code 204 (No Content)
- **Piège 3** : Confondre `Content-Length` (taille) et `Content-Type` (format)
- **Piège 4** : Oublier que 304 ne doit pas avoir de body
- **Piège 5** : Mal gérer l'encodage des caractères dans Content-Type

### Points clés à retenir
✅ **Structure fixe : Ligne de statut + Headers + Ligne vide + Body optionnel**
✅ **Le code de statut détermine les headers requis**
✅ **Content-Type obligatoire si body présent**
✅ **Les headers de cache contrôlent la mise en cache côté client**

---

## 5. HTTP Methods

### Définition
Les méthodes HTTP (ou verbes HTTP) définissent l'action que le client souhaite effectuer sur une ressource identifiée par l'URI. Chaque méthode a des caractéristiques spécifiques concernant la sémantique, l'idempotence et la sécurité.

### Méthodes principales

#### **GET**
**Objectif :** Récupérer une représentation d'une ressource

**Caractéristiques :**
- **Safe** : N'a pas d'effet de bord
- **Idempotent** : Plusieurs appels = même résultat
- **Cacheable** : Oui
- **Body** : Non recommandé

**Usage typique :**
- Récupérer une page web
- Obtenir des données via une API
- Télécharger un fichier

**Codes de réponse courants :** 200, 304, 404

#### **POST**
**Objectif :** Soumettre des données pour traitement

**Caractéristiques :**
- **Safe** : Non
- **Idempotent** : Non
- **Cacheable** : Non (sauf indication explicite)
- **Body** : Oui, généralement requis

**Usage typique :**
- Créer une nouvelle ressource
- Soumettre un formulaire
- Déclencher une action

**Codes de réponse courants :** 200, 201, 400, 422

#### **PUT**
**Objectif :** Créer ou remplacer complètement une ressource

**Caractéristiques :**
- **Safe** : Non
- **Idempotent** : Oui
- **Cacheable** : Non
- **Body** : Oui, représentation complète

**Usage typique :**
- Remplacer une ressource existante
- Créer une ressource avec un ID connu

**Codes de réponse courants :** 200, 201, 204, 409

#### **PATCH**
**Objectif :** Modifier partiellement une ressource

**Caractéristiques :**
- **Safe** : Non
- **Idempotent** : Non (généralement)
- **Cacheable** : Non
- **Body** : Oui, modifications partielles

**Usage typique :**
- Mettre à jour certains champs seulement
- Modifications incrémentielles

**Codes de réponse courants :** 200, 204, 400, 404

#### **DELETE**
**Objectif :** Supprimer une ressource

**Caractéristiques :**
- **Safe** : Non
- **Idempotent** : Oui
- **Cacheable** : Non
- **Body** : Généralement absent

**Usage typique :**
- Supprimer une ressource existante

**Codes de réponse courants :** 200, 204, 404, 410

#### **HEAD**
**Objectif :** Comme GET mais sans le body de réponse

**Caractéristiques :**
- **Safe** : Oui
- **Idempotent** : Oui
- **Cacheable** : Oui
- **Body** : Non (ni requête ni réponse)

**Usage typique :**
- Vérifier l'existence d'une ressource
- Obtenir les métadonnées (headers)
- Vérifier la taille ou la date de modification

#### **OPTIONS**
**Objectif :** Obtenir les méthodes supportées par une ressource

**Caractéristiques :**
- **Safe** : Oui
- **Idempotent** : Oui
- **Cacheable** : Non
- **Body** : Optionnel

**Usage typique :**
- Preflight CORS
- Découvrir les capacités d'une API

### Concepts fondamentaux

#### **Safe Methods (Méthodes sûres)**
Méthodes qui ne modifient pas l'état du serveur.
- ✅ **Safe :** GET, HEAD, OPTIONS
- ❌ **Non-safe :** POST, PUT, PATCH, DELETE

#### **Idempotent Methods (Méthodes idempotentes)**
Méthodes dont l'effet est le même qu'on les appelle 1 fois ou N fois.

| Méthode | Idempotent | Explication |
|---------|------------|-------------|
| GET | ✅ | Lire n'a pas d'effet de bord |
| HEAD | ✅ | Comme GET sans body |
| PUT | ✅ | Remplace toujours par la même valeur |
| DELETE | ✅ | Supprimer quelque chose déjà supprimé = même état |
| POST | ❌ | Peut créer plusieurs ressources |
| PATCH | ❌ | Dépend de l'implémentation |

### Schéma mental : Choix de la méthode HTTP

```
Que veux-tu faire ?
     |
     v
LIRE des données ?
     |         |
   OUI       NON
     |         |
    GET        v
             MODIFIER des données ?
                   |              |
                 OUI            NON
                   |              |
                   v              |
             Modification complète ? |
             |              |      |
           OUI            NON      |
             |              |      |
           PUT            PATCH    |
                                   |
                                   v
                            SUPPRIMER ?
                            |        |
                          OUI      NON
                            |        |
                         DELETE   OPTIONS/HEAD
```

### Relations méthodes ↔ codes de statut

#### **Matrice des combinaisons courantes**

| Méthode | Succès | Création | Erreur client | Erreur serveur |
|---------|--------|----------|---------------|----------------|
| GET | 200 | - | 404 | 500 |
| POST | 200 | 201 | 400, 422 | 500 |
| PUT | 200, 204 | 201 | 400, 409 | 500 |
| PATCH | 200, 204 | - | 400, 404 | 500 |
| DELETE | 200, 204 | - | 404 | 500 |
| HEAD | 200 | - | 404 | 500 |

### Bonnes pratiques REST

#### **Cohérence sémantique**
- **GET /users** : Liste des utilisateurs
- **GET /users/123** : Utilisateur spécifique
- **POST /users** : Créer un utilisateur
- **PUT /users/123** : Remplacer l'utilisateur 123
- **PATCH /users/123** : Modifier l'utilisateur 123
- **DELETE /users/123** : Supprimer l'utilisateur 123

#### **Gestion des collections vs ressources**

| Action | Collection (/users) | Ressource (/users/123) |
|--------|---------------------|------------------------|
| GET | Liste | Détail |
| POST | Créer nouveau | 405 Method Not Allowed |
| PUT | 405 ou remplacer tout | Remplacer |
| PATCH | 405 ou modification globale | Modifier |
| DELETE | 405 ou supprimer tout | Supprimer |

### ⚠️ Attention : Pièges d'examen
- **Piège 1** : Confondre PUT (remplacement complet) et PATCH (modification partielle)
- **Piège 2** : Croire que POST est toujours pour la création - il peut faire n'importe quelle action
- **Piège 3** : Oublier que DELETE est idempotent (supprimer du déjà supprimé = même état)
- **Piège 4** : Utiliser GET avec des effets de bord (non-safe)
- **Piège 5** : Confondre HEAD (metadata seulement) avec GET (données complètes)

### Points clés à retenir
✅ **GET et HEAD sont safe et idempotent**
✅ **PUT et DELETE sont idempotent mais pas safe**
✅ **POST n'est ni safe ni idempotent**
✅ **La méthode détermine la sémantique de l'action**
✅ **OPTIONS sert à la découverte des capacités**

---

## 6. Cookies

### Définition
Les cookies HTTP sont de petits fragments de données stockés par le navigateur et envoyés automatiquement avec chaque requête vers le même domaine. Ils permettent de maintenir un état entre les requêtes dans un protocole stateless.

### Mécanisme de fonctionnement

#### **Cycle de vie d'un cookie**

```
1. SERVEUR → CLIENT : Set-Cookie: name=value; options
2. CLIENT stocke le cookie
3. CLIENT → SERVEUR : Cookie: name=value (automatique)
4. SERVEUR lit la valeur et traite
```

### Syntaxe et structure

#### **Création de cookie (Set-Cookie)**
```
Set-Cookie: nom=valeur[; attribut=valeur][; attribut]
```

#### **Envoi de cookie (Cookie)**
```
Cookie: nom1=valeur1; nom2=valeur2; nom3=valeur3
```

### Attributs des cookies

#### **Attributs temporels**

| Attribut | Description | Exemple |
|----------|-------------|---------|
| `Expires` | Date d'expiration absolue | `Expires=Wed, 09 Jun 2024 10:18:14 GMT` |
| `Max-Age` | Durée de vie en secondes | `Max-Age=3600` (1 heure) |

**Priorité :** Max-Age > Expires

#### **Attributs de portée**

| Attribut | Description | Exemple |
|----------|-------------|---------|
| `Domain` | Domaine(s) autorisé(s) | `Domain=.example.com` |
| `Path` | Chemin(s) autorisé(s) | `Path=/admin` |

#### **Attributs de sécurité**

| Attribut | Description | Impact |
|----------|-------------|--------|
| `Secure` | HTTPS uniquement | Transmission chiffrée |
| `HttpOnly` | Inaccessible via JavaScript | Protection XSS |
| `SameSite` | Contrôle des requêtes cross-site | Protection CSRF |

#### **Valeurs SameSite**

| Valeur | Comportement |
|--------|--------------|
| `Strict` | Jamais envoyé en cross-site |
| `Lax` | Envoyé sur navigation top-level |
| `None` | Toujours envoyé (nécessite Secure) |

### Types de cookies

#### **Par durée de vie**

**Session Cookies (cookies de session)**

Définition

Un cookie est un petit fichier texte envoyé par le serveur au client, stocké dans le navigateur, et renvoyé lors des requêtes ultérieures. Il permet de maintenir l’état entre plusieurs requêtes HTTP, qui sont par nature stateless.

Types de cookies
Type	Description	Exemple
Session cookie	Stocké en mémoire, détruit à la fermeture du navigateur	ID de session utilisateur
Persistent cookie	Stocké sur disque avec une date d’expiration	Préférences de langue
Secure cookie	Transmis uniquement via HTTPS	Token d’authentification
HttpOnly	Inaccessible via JavaScript	Protection contre XSS
⚠️ Attention

Ne pas stocker d’informations sensibles en clair dans un cookie.

Confondre session cookie et persistent cookie peut mener à des fuites de session.

Le cookie influence directement la logique d’authentification et de personnalisation.

Points clés à retenir

Cookies = mécanisme pour maintenir l’état dans HTTP.

Respecter les flags (Secure, HttpOnly) pour la sécurité.

Durée de vie et portée (domain, path) déterminent quand le cookie est envoyé.

3. Caching
Définition

Le caching HTTP consiste à stocker temporairement des réponses côté client ou intermédiaire pour réduire les temps de chargement et la charge serveur.

Concepts principaux
Concept	Description	Exemple
Cache-Control	Directives générales de mise en cache	Cache-Control: max-age=3600
ETag	Identifiant unique de la version d’une ressource	ETag: "abc123"
Last-Modified	Date de dernière modification	Last-Modified: Wed, 04 Sep 2025 10:00:00 GMT
Expires	Date d’expiration de la ressource	Expires: Thu, 05 Sep 2025 10:00:00 GMT
Types de caches

Client-side cache : navigateur ou application.

Proxy cache : serveur intermédiaire entre client et serveur.

Server-side cache : serveur stocke les réponses pour réduire le calcul.

⚠️ Attention

Ne pas combiner Expires et Cache-Control de façon contradictoire.

Mauvaise gestion des ETag peut empêcher la mise à jour des ressources.

Les méthodes POST ne devraient généralement pas être mises en cache.

Schéma conceptuel
Client <---(cache hit)--- Navigateur/Proxy
Client ---> Serveur ---(cache miss)---> Serveur (calcul de la réponse)

Points clés à retenir

Le cache optimise la performance mais doit respecter la fraîcheur des données.

Cache-Control, ETag et Expires sont les principaux mécanismes.

Idempotence des méthodes HTTP influence le caching.

4. Content Negotiation
Définition

La content negotiation permet au serveur de choisir le format de la réponse en fonction des préférences du client, exprimées via les headers HTTP.

Principales stratégies
Header	Usage	Exemple
Accept	Type de média préféré	Accept: application/json
Accept-Language	Langue préférée	Accept-Language: fr-FR
Accept-Encoding	Compression préférée	Accept-Encoding: gzip, deflate
Accept-Charset	Jeu de caractères préféré	Accept-Charset: utf-8
⚠️ Attention

Si le client ne fournit pas de header, le serveur choisit un format par défaut.

Confondre Accept-Language et Content-Language est fréquent : le premier est la préférence client, le second indique la langue de la réponse.

Points clés à retenir

Content negotiation = adapter la réponse selon les préférences du client.

Principaux headers : Accept, Accept-Language, Accept-Encoding, Accept-Charset.

Toujours prévoir une valeur par défaut pour la réponse.

5. Language Detection
Définition

La détection de la langue permet au serveur de déterminer la langue la plus appropriée pour répondre au client.

Méthodes

Header Accept-Language : préférences du navigateur ou client.

Paramètres URL : ex. ?lang=fr

Cookies : langue mémorisée d’une session précédente.

Détection automatique : basée sur l’IP ou le contenu.

⚠️ Attention

Ne jamais supposer qu’Accept-Language est exact : toujours prévoir un fallback.

La détection automatique par IP est approximative et peut être incorrecte.

Combiner plusieurs méthodes est conseillé pour fiabilité.

Points clés à retenir

Priorité : Header → Paramètre URL → Cookie → Détection automatique.

Toujours fournir un fallback si la langue préférée n’est pas disponible.

La cohérence entre la langue détectée et les contenus restitués est essentielle pour l’expérience utilisateur et la certification.

✅ Synthèse générale

HTTP Methods : définissent l’action → influencent caching et codes de statut.

Cookies : maintiennent l’état → sécurité via Secure et HttpOnly.

Caching : performance → directives via Cache-Control, ETag, Expires.

Content Negotiation : adapter la réponse → headers Accept, Accept-Language, etc.

Language Detection : répondre dans la bonne langue → combiner headers, URL, cookies.
