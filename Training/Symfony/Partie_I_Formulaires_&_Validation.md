# 🎯 Symfony 7 – Partie I: Formulaires & Validation
## 🧠 Rappel théorique (expert level)
## 1. Création d’un formulaire

* Symfony fournit un composant puissant pour gérer les formulaires.

### Exemple :

```php
$article = new Article();
$form = $this->createForm(ArticleType::class, $article);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $entityManager->persist($article);
    $entityManager->flush();
}
```

## 2. Classe FormType

Fichier src/Form/ArticleType.php :

```php
class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('publishedAt', DateTimeType::class)
        ;
    }
}
```

## 3. Validation

Via contraintes dans entité :

```php
#[Assert\NotBlank]
#[Assert\Length(min: 5)]
private string $title;
```

Ou via validation.yaml.

## 4. Affichage dans Twig

```html
{{ form_start(form) }}
  {{ form_row(form.title) }}
  {{ form_row(form.content) }}
  {{ form_row(form.publishedAt) }}
  <button type="submit">Enregistrer</button>
{{ form_end(form) }}
```

## 5. Bonnes pratiques

* ✅ Toujours valider via le Validator Component.
* ✅ Séparer les formulaires d’admin et de front si logique différente.
* ✅ Utiliser des Form Events pour adapter dynamiquement.
* ✅ Utiliser DTO quand la donnée ne mappe pas directement une entité.

# 📝 QCM PART I
### 1. Quelle méthode est utilisée pour lier une requête à un formulaire ?
* a) $form->bind($request)
* b) $form->handleRequest($request)
* c) $form->submit($request)

### 2. Quelle contrainte permet de vérifier qu’un champ n’est pas vide ?
* a) @Assert\NotNull
* b) @Assert\Required
* c) @Assert\NotBlank

### 3. Quelle est la bonne syntaxe pour afficher un champ dans Twig ?
* a) {{ form_field(form.title) }}
* b) {{ form_row(form.title) }}
* c) {{ form_input(form.title) }}

###  4. Si tu veux valider une entité avec une règle min:5 caractères sur un titre, quelle contrainte utilises-tu ?
* a) @Assert\MinLength(5)
* b) @Assert\Length(min=5)
* c) @Assert\String(min=5)

### 5. Où peut-on définir les règles de validation dans Symfony ?
* a) Directement dans Twig
* b) Dans les entités via attributs/annotations ou fichiers YAML/XML
* c) Dans le fichier .env

# 📝 Correction des Questions type certification (PART I)
### 1 -> b ✅
### 2 -> c ✅
### 3 -> b ✅
### 4 -> a ✅
### 5 -> b ✅