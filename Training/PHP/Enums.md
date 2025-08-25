readonly:
	- Le readonly propriétés:
		=> Introduit avec PHP8.1
		=> Permet de déclarer des propriétés immutable aprés son intialisation
		=> Une proprieté readonly, doit étre typée (string, int, bool..)
		=> Elle peut étre initialisé une seul fois, soit directement dans la déclaration, 
			soit dans le constructeur
		=> Une fois initialisé, toute tentative de modification declenche une erreur
		=> compatible avec la promotion de prop dans le constructeur
		
	- Le readonly Classes:
		=> Introduit a partir de php8.2
		=> toute les propriétés de la class son en readonly
		
	=> Impossible de l’utiliser avec unset() (erreur fatale)

Enums:
	=> Type spéciale qui represente un ensemble fini de valuers possibles
	=> Methods:
		::cases() → renvoie tous les cas d’un enum (array d’instances).
		->name → le nom du cas.
		->value → la valeur.
	=> Un enum ne peut pas être instancié avec new.
	=>Les enums sont des objets singletons (chaque case est une instance unique).
	=>Pas d’héritage entre enums (mais on peut implémenter des interfaces).
	=>tryFrom vs from : from → Exception si valeur invalide, tryFrom → null.