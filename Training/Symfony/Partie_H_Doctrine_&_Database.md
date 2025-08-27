# 🎯 Symfony 7 – Partie H: Doctrine & Database
## 🧠 Rappel théorique (niveau expert)
## 1. Qu’est-ce que Doctrine ?

* ORM officiel de Symfony (Object Relational Mapper).
* Permet de manipuler des objets PHP au lieu d’écrire directement du SQL.
* Se base sur :

    * Entités (classes PHP représentant les tables)
    * Repositories (requêtes personnalisées)
    * EntityManager (gestionnaire d’entités)

## 2. Création d’une Entité

### Exemple Article :

```php
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $publishedAt;
}
```

## 3. Migrations

Générer une migration après modif d’entité :

```sh
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## 4. Relations

OneToMany / ManyToOne

```php
#[ORM\OneToMany(mappedBy: 'article', targetEntity: Comment::class)]
private Collection $comments;
```

ManyToMany

```php
#[ORM\ManyToMany(targetEntity: Tag::class)]
private Collection $tags;
```
## 5. Repositories & Requêtes

Chaque entité a son repository : src/Repository/ArticleRepository.php.

Exemple avec QueryBuilder :

```php
public function findPublished(): array
{
    return $this->createQueryBuilder('a')
        ->where('a.publishedAt <= :now')
        ->setParameter('now', new \DateTime())
        ->orderBy('a.publishedAt', 'DESC')
        ->getQuery()
        ->getResult();
}
```
## 6. EntityManager

Persister une entité :
```php
$article = new Article();
$article->setTitle("Nouveau");
$article->setContent("Contenu...");

$em = $this->getDoctrine()->getManager();
$em->persist($article);
$em->flush();
```

Supprimer :

```php
$em->remove($article);
$em->flush();
```
## 7. Bonnes pratiques SensioLabs

* ✅ Toujours utiliser les Repositories pour encapsuler les requêtes.
* ✅ Éviter d’appeler l’EntityManager partout → injecter via services.
* ✅ Utiliser les DTO / Form pour séparer validation et entité.
* ✅ Préférer QueryBuilder plutôt que DQL brut.

# 📝 QCM PART H

### 1. Doctrine est principalement utilisé pour :
* a) Gérer les templates
* b) Mapper les objets PHP avec la base de données
* c) Compiler les services

### 2. Quelle commande génère une migration Doctrine ?
* a) php bin/console doctrine:generate
* b) php bin/console make:migration
* c) php bin/console doctrine:schema:update --force

### 3. Quelle annotation/attribut définit une relation OneToMany ?
* a) #[ORM\Column(type: 'one_to_many')]
* b) #[ORM\OneToMany(mappedBy: 'xxx', targetEntity: Yyy::class)]
* c) #[ORM\Relation(type: 'OneToMany')]

### 4. Quelle est la méthode de l’EntityManager pour enregistrer un objet ?
* a) save()
* b) persist() puis flush()
* c) commit()

# 🛠️ Exercice pratique – Doctrine

## 🎯 Objectif : créer une entité Article avec des commentaires et requêtes personnalisées

1. Créer l’entité Article avec :
    * id, title, content, publishedAt
2. Créer l’entité Comment avec :
    * id, author, content, relation ManyToOne vers Article
3. Générer les migrations et appliquer en BDD.
4. Dans ArticleRepository, créer une méthode findLatest(int $limit) qui retourne les derniers articles publiés.
5. Dans le contrôleur ArticleController, afficher les articles via cette méthode.


# 📝 Correction des Questions type certification (PART H)
### 1 -> b ✅
### 2 -> b ✅
### 3 -> b ✅
### 4 -> b ✅