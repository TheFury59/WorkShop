<?php

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbextranet';   		
      	private static $user='gsbextranet' ;    		
      	private static $mdp='1' ;	
	private static $monPdo;
	private static $monPdoGsb=null;
		
		
	private function __construct(){
          
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}

	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}

function checkUser($login,$pwd):bool {
    $user=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse, idRole FROM utilisateur WHERE mail= :login"); // requete
    $mail = array('login'=>$login); // data
    if ($monObjPdoStatement->execute($mail)) { // execution de la requete avec les datas
        $unUser=$monObjPdoStatement->fetch();
        if (is_array($unUser)){ // si il retourne un tableau ( donc un utilisateur )
            if (password_verify($pwd,$unUser['motDePasse'])) // on verifie le mdp
                $user=true;
        }
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $user;   
}


    public function tailleChampsMail(){
        

        
        $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
    WHERE table_name = 'utilisateur' AND COLUMN_NAME = 'mail'");
        $execution = $pdoStatement->execute();
    $leResultat = $pdoStatement->fetch();
        
        return $leResultat[0];
        
        
        
    }


    public function creeUser($email, $mdp, $nom, $prenom) // crée un utilisateur et son espace medecin
    {
        $mdp = password_hash($mdp,PASSWORD_DEFAULT); // hash le mdp
        $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO utilisateur(idUser,nom,prenom, mail, motDePasse,dateConsentement) VALUES (null, :nom,:prenom,:leMail, :leMdp, now())");
        $data = array('nom'=>$nom,'prenom'=>$prenom,'leMail'=>$email,'leMdp'=>$mdp); // datas
        $execution = $pdoStatement->execute($data);
        if($execution){
            $created = $this->donneLeUserParMail($email); // recupère l'utilisateur créé
            $this->creeMedecin($created['idUser']); // crée un espace medecin pour l'utilisateur
        }
        return $execution;
    }


    public function creeMedecin($id){ // crée le medecin à partir d'un utilisateur : retourne vrai si succes
        $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(idMedecin,dateCreation) VALUES (:idMedecin,now())"); // requete
        $data = array('idMedecin'=>$id);
        $execution = $pdoStatement->execute($data);
        return $execution;
    }


    public function existUser($id){ // verifie si l'id en entrée correspond à un user
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT nom FROM utilisateur WHERE idUser=:id;"); // requete
        $data = array('id'=>$id);
        // Exécute la requête en lui passant les valeurs récupérées du formulaire
        if ($monObjPdoStatement->execute($data)) {
            $fetch = $monObjPdoStatement->fetch();
            if(is_array($fetch)) // si revoit un tableau donc un utilisateur
                return true; // vrai
            else
                return false; // sinon faux
        }
    }


    function testMail($email){ // test si mail existe déja
        $pdo = PdoGsb::$monPdo;
        $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM utilisateur WHERE mail = :leMail");
        $bv1 = $pdoStatement->bindValue(':leMail', $email);
        $execution = $pdoStatement->execute();
        $resultatRequete = $pdoStatement->fetch();
        if ($resultatRequete['nbMail']==0) // si aucun retour
            $mailTrouve = false; // n'existe pas
        else
            $mailTrouve=true; // existe
        
        return $mailTrouve; // retourne la valeur
    }
}