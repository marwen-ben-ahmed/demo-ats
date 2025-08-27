# 🎯 Symfony 7 – Partie L: Tests & Qualité du code Symfony 7
🧠 Rappel théorique (expert level)
1. Types de tests

Unitaires : testent une seule classe ou fonction, isolée du reste.

Fonctionnels : testent un workflow complet (ex: un controller + DB).

End-to-End / UI : testent le système complet (souvent avec Panther ou Selenium).

2. PHPUnit dans Symfony

Installé par défaut via symfony/phpunit-bridge.

Commandes principales :

# Lancer tous les tests
php bin/phpunit

# Lancer un fichier spécifique
php bin/phpunit tests/Controller/ArticleControllerTest.php

3. Tests unitaires

Exemple : tester une méthode d’un service :

use PHPUnit\Framework\TestCase;
use App\Service\Calculator;

class CalculatorTest extends TestCase
{
    public function testAdd(): void
    {
        $calc = new Calculator();
        $this->assertEquals(5, $calc->add(2, 3));
    }
}

4. Tests fonctionnels (WebTestCase)

Permet de simuler des requêtes HTTP :

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/articles');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Articles');
    }
}

5. Bonnes pratiques SensioLabs

Toujours tester les services métiers séparément (unit test).

Les controllers et routes via tests fonctionnels.

Mocker les dépendances pour isoler les tests.

Vérifier la couverture de code (--coverage-html) pour identifier les zones non testées.

CI/CD → automatiser l’exécution des tests à chaque push.

6. Code Quality & Tools

PHPStan / Psalm → analyse statique pour trouver les erreurs potentielles.

PHP CS Fixer / PHP_CodeSniffer → respecter les standards de code PSR.

EasyCodingStandard → combiner lint et fixer le code automatiquement.

📝 QCM Jour 11 (sans correction)

1. Quel type de test vérifie uniquement une seule classe ou fonction isolée ?
a) Fonctionnel
b) End-to-End
c) Unitaire

2. Quelle classe étend-on pour tester un controller Symfony avec HTTP simulé ?
a) TestCase
b) WebTestCase
c) ControllerTestCase

3. Quelle commande lance tous les tests PHPUnit dans Symfony ?
a) php bin/phpunit
b) php bin/test
c) php bin/run-tests

4. Quel outil permet d’analyser statiquement le code pour détecter les erreurs potentielles ?
a) PHPStan
b) PHPUnit
c) PHP CS Fixer

5. Pour vérifier la couverture de code des tests, quelle option PHPUnit utilise-t-on ?
a) --coverage-html
b) --check-coverage
c) --coverage-report

# 📝 Correction des Questions type certification (PART L)
### 1 -> c ✅
### 2 -> b ✅
### 3 -> a ✅
### 4 -> a ✅
### 5 -> a ✅