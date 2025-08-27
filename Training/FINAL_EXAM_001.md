# Section 1: True / False (25 questions)

1. Symfony 7 is fully compatible with PHP 8.2+.
2. The HttpFoundation component handles HTTP requests and responses.
3. In Symfony, a controller must always extend the AbstractController class.
4. Services declared in services.yaml are automatically injected by type thanks to autowiring.
5. A route parameter can have a default value defined directly in annotations or YAML.
6. Symfony 7 no longer supports route annotations.
7. Events in Symfony are always synchronous by default.
8. Symfony forms must always be linked to an entity.
9. Role-based security only works with roles that start with ROLE_.
10. Doctrine supports lazy loading by default for ManyToOne and OneToMany relationships.
11. Symfony functional tests can use an HTTP client to simulate requests.
12. Voters are used to manage access to entities in Symfony Security.
13. ParamConverter can automatically convert URL IDs to Doctrine entities.
14. A bundle can contain services, routes, and configuration.
15. The bin/console make:entity command creates an entity and its repository.
16. Doctrine migrations must be generated before modifying an entity.
17. Symfony 7 recommends using PHP attributes for routes instead of annotations.
18. An EventSubscriber is triggered for every event it listens to, even if it is unrelated to the current request.
19. Twig templates can include other templates using include or extends.
20. 404 errors can be intercepted and customized via an EventListener on kernel.exception.
21. The addFlash() method stores messages that only persist for the next request.
22. Symfony uses the Cache component to improve Twig template compilation perforance.
23. Symfony forms can handle collections of objects using CollectionType.
24. Symfony validation can be applied directly using annotations on entity properties.
25. autoconfigure allows Symfony to automatically register services that implement specific interfaces.

# Section 2: Single Answer (25 questions)

1. Which class in Symfony is responsible for creating HTTP responses?
    * a) Request
    * b) Response
    * c) Controller
    * d) Kernel

2. Which annotation or attribute is used to define a route in Symfony 7?
    * a) @Route / #[Route]
    * b) @Path
    * c) @Endpoint
    * d) @Controller

3. Which service allows automatic dependency injection based on type?
    * a) autowiring
    * b) autoconfigure
    * c) autoload
    * d) service_locator

4. Which command generates a new controller?
    * a) bin/console make:controller
    * b) bin/console make:service
    * c) bin/console generate:controller
    * d) bin/console make:bundle

5. Which method is used in a controller to redirect a user to another route?
    * a) render()
    * b) redirectToRoute()
    * c) forward()
    * d) sendRedirect()

6. Which Doctrine relation is used when an entity can belong to multiple categories and a category can have multiple entities?
    * a) OneToMany
    * b) ManyToOne
    * c) ManyToMany
    * d) OneToOne

7. How do you enable Symfony security authentication using a custom user provider?
    * a) Configure security.yaml with providers
    * b) Override AbstractController
    * c) Use ParamConverter
    * d) Add Voter

8. Which command generates Doctrine migrations after entity changes?
    * a) bin/console make:migration
    * b) bin/console doctrine:generate-migrations
    * c) bin/console make:entity
    * d) bin/console doctrine:migrate

9. How can you pass data from a controller to a Twig template?
    * a) Use render() with parameters
    * b) Use redirectToRoute()
    * c) Use forward()
    * d) Use addFlash()

10. Which method retrieves a repository for a Doctrine entity?
    * a) $this->getRepository()
    * b) $this->getDoctrine()->getRepository(Entity::class)
    * c) $this->repository()
    * d) $this->findRepository()

11. Which annotation or attribute allows automatic conversion of URL parameters to Doctrine entities?
    * a) ParamConverter
    * b) Route
    * c) Autowire
    * d) Inject

12. Which type is used in Symfony forms to handle email input?
    * a) TextType
    * b) EmailType
    * c) InputType
    * d) EmailInput

13. What is the purpose of a Voter in Symfony?
    * a) Manage entity access permissions
    * b) Send emails
    * c) Generate routes
    * d) Cache templates

14. Which service is used to send emails in Symfony 7?
    * a) MailerInterface
    * b) EmailSender
    * c) MessageBus
    * d) MailService

15. How do you define a service as public in services.yaml?
    * a) public: true
    * b) shared: true
    * c) autowire: true
    * d) private: false

16. Which component allows caching of data or responses?
    * a) Cache
    * b) HttpClient
    * c) Security
    * d) Validator

17. Which type of test uses KernelBrowser to simulate requests?
    * a) Functional test
    * b) Unit test
    * c) Integration test
    * d) End-to-end test

18. How do you inject a service into a controller in Symfony 7?
    * a) Constructor injection
    * b) use statement
    * c) Extend AbstractController
    * d) Call getService()

19. Which method adds a flash message in Symfony?
    * a) addFlash()
    * b) setFlash()
    * c) flashMessage()
    * d) notify()

20. Which YAML section defines route parameters?
    * a) defaults
    * b) services
    * c) imports
    * d) packages

21. Which method in a repository allows you to find one entity by criteria?
    * a) findOneBy()
    * b) getBy()
    * c) findById()
    * d) fetchOne()

22. Which option allows a form to handle a collection of entities?
    * a) CollectionType
    * b) EntityType
    * c) ArrayType
    * d) MultipleType

23. Which method of the Kernel handles HTTP requests in Symfony?
    * a) handle()
    * b) process()
    * c) dispatch()
    * d) serve()

24. What is the recommended way to define route attributes in Symfony 7?
    * a) PHP 8 attributes #[Route(...)]
    * b) XML routes
    * c) YAML routes only
    * d) PHP comments

25. Which service automatically registers services implementing a certain interface?
    * a) autoconfigure
    * b) autowire
    * c) autoload
    * d) service_locator

# 📝 Correction des Questions Section 1
### 1 -> True ✅
### 2 -> True ✅
### 3 -> false ❌
### 4 -> True ✅
### 5 -> True ✅
### 6 -> false ❌
### 7 -> True ✅
### 8 -> True ✅
### 9 -> True ✅
### 10 -> True ✅
### 11-> True ✅
### 12 -> True ✅
### 13 -> True ✅
### 14 -> True ✅
### 15 -> True ✅
### 16 -> false ❌
### 17 -> True ✅
### 18 -> True ✅
### 19-> True ✅
### 20 -> True ✅
### 21 -> True ✅
### 22 -> True ✅
### 23 -> True ✅
### 24 -> True ✅
### 55 -> True ✅

# 📝 Correction des Questions Section 2
### 1 -> b✅ 
### 2 -> a✅ 
### 3 -> a✅ 
### 4 -> a✅ 
### 5 -> b✅ 
### 6 -> c✅ 
### 7 -> a✅ 
### 8 -> a✅ 
### 9 -> a✅ 
### 10 -> b✅ 
### 11-> a✅ 
### 12 -> b✅ 
### 13 -> a✅ 
### 14 -> a✅ 
### 15 -> a✅ 
### 16 -> a✅
### 17 -> a✅ 
### 18 -> a✅ 
### 19-> a✅ 
### 20 -> a✅ 
### 21 -> a✅ 
### 22 -> a✅ 
### 23 -> a✅ 
### 24 -> a✅ 
### 55 -> a✅