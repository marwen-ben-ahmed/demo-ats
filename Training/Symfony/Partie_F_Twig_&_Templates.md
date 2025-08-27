# 🎯 Symfony 7 – Partie F: Twig & Templates
## 🧠 Rappel théorique (expert level)

## 1. Twig Basics

Moteur de template officiel Symfony, installé par défaut.

### Syntaxe :

* {{ ... }} → afficher une variable
* {% ... %} → instructions (if, for, include…)
* {# ... #} → commentaires

## 2. Passer des données au template

Dans un contrôleur :

```php 
return $this->render('article/show.html.twig', [
    'article' => $article,
]);
```

Dans Twig :

```html
<h1>{{ article.title }}</h1>
<p>{{ article.content }}</p>
```
## 3. Héritage & Layouts

Twig supporte l’héritage :

```html
{# base.html.twig #}
<!DOCTYPE html>
<html>
  <head>{% block title %}Titre par défaut{% endblock %}</head>
  <body>
    <header>Menu</header>
    <main>{% block body %}{% endblock %}</main>
  </body>
</html>
```

```html
{# article/show.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Article - {{ article.title }}{% endblock %}
{% block body %}
  <h1>{{ article.title }}</h1>
  <p>{{ article.content }}</p>
{% endblock %}
```
## 4. Boucles, Conditions & Filtres

* Boucle :

```html
{% for comment in article.comments %}
  <p>{{ comment.author }} : {{ comment.content }}</p>
{% endfor %}
```

* Condition :

```html
{% if article.isPublished %}
  <span>Publié</span>
{% else %}
  <span>Brouillon</span>
{% endif %}
```

* Filtres Twig (transformer une valeur) :

```html
{{ "symfony"|upper }}   {# SYMFONY #}
{{ article.publishedAt|date('d/m/Y') }}
```

## 5. Inclusion & Macros

* Inclusion :

```html
{% include 'partials/_menu.html.twig' %}
```

* Macros (comme des fonctions Twig) :

```html
{# forms.html.twig #}
{% macro input(name, value) %}
  <input type="text" name="{{ name }}" value="{{ value }}">
{% endmacro %}
```

```html
{% import 'forms.html.twig' as forms %}
{{ forms.input('username', 'Marwen') }}
```

## 6. Sécurité & Bonnes pratiques

* Par défaut, Twig échappe toutes les variables → safe contre XSS.
* Si une valeur est déjà safe :

```html
{{ variable|raw }}
```

⚠️ À éviter sauf si 100% sûr.

* Ne jamais mettre de logique métier dans Twig → juste présentation.

# 📝 QCM PART F

### 1. Quel est le rôle principal de Twig dans Symfony ?
a) Gérer la sécurité des utilisateurs
b) Générer la vue (templates)
c) Compiler le container de services

### 2. Que fait le filtre |raw dans Twig ?
a) Échappe les caractères HTML
b) Affiche la valeur brute sans échappement
c) Transforme en texte brut

### 3. Quelle est la bonne syntaxe pour étendre un layout ?
a) {{ extends "base.html.twig" }}
b) {% extends 'base.html.twig' %}
c) {# extends 'base.html.twig' #}

### 4. Comment importer un macro Twig ?
a) {% macro 'forms.html.twig' as f %}
b) {% include 'forms.html.twig' as f %}
c) {% import 'forms.html.twig' as f %}

# 🛠️ Exercice pratique – Twig en action

## 🎯 Objectif : créer un layout + une page article avec des commentaires dynamiques

1. Créer un layout global base.html.twig avec un menu et un bloc body.
2. Créer un template article/show.html.twig qui hérite du layout.
3. Afficher un article (title, content, publishedAt).
4. Boucler sur une liste de commentaires (author, content).
5. Si pas de commentaires, afficher "Aucun commentaire pour le moment.".

# 📝 Correction des Questions type certification (PART F)
### 1 -> b ✅
### 2 -> b ✅
### 3 -> b ✅
### 4 -> c ✅