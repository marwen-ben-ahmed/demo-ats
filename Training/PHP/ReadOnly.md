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
