<?php

class PdoEpsiLink{   		
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=epsilink';   		
    private static $user='root' ;    		
    private static $mdp='' ;	
	private static $monPdo;
	private static $monPdoEpsiLink=null;
		
		
	private function __construct(){
          
    	PdoEpsiLink::$monPdo = new PDO(PdoEpsiLink::$serveur.';'.PdoEpsiLink::$bdd, PdoEpsiLink::$user, PdoEpsiLink::$mdp); 
		PdoEpsiLink::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoEpsiLink::$monPdo = null;
	}

	public  static function getPdoEpsiLink(){
		if(PdoEpsiLink::$monPdoEpsiLink==null){
			PdoEpsiLink::$monPdoEpsiLink= new PdoEpsiLink();
		}
		return PdoEpsiLink::$monPdoEpsiLink;  
	}

    public function checkUser($login,$pwd):bool {
    $user=false;
    $pdo = PdoEpsiLink::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT mdpUser, idPrivilege FROM utilisateur WHERE mailUser= :login"); // requete
    $mail = array('login'=>$login); // data
    if ($monObjPdoStatement->execute($mail)) { // execution de la requete avec les datas
        $unUser=$monObjPdoStatement->fetch();
        if (is_array($unUser)){ // si il retourne un tableau ( donc un utilisateur )
            if (password_verify($pwd,$unUser['mdpUser'])) // on verifie le mdp
                $user=true;
        }
    }
    else
        throw new Exception("erreur dans la requête");
    return $user;   
}


    public function tailleChampsMail(){
        $pdoStatement = PdoEpsiLink::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'utilisateur' AND COLUMN_NAME = 'mail'");
        $execution = $pdoStatement->execute();
        $leResultat = $pdoStatement->fetch();
            
        return $leResultat[0];
    }


    public function creeUser($email, $mdp, $nom, $prenom, $tel) // crée un utilisateur et son espace medecin
    {
        $mdp = password_hash($mdp,PASSWORD_DEFAULT); // hash le mdp
        $pdoStatement = PdoEpsiLink::$monPdo->prepare("INSERT INTO utilisateur(idUser,nomUser,prenomUser, mailUser, mdpUser, tel) VALUES (null, :nom,:prenom,:leMail, :leMdp,:leTel)");
        $data = array('nom'=>$nom,'prenom'=>$prenom,'leMail'=>$email,'leMdp'=>$mdp,'leTel'=>$tel); // datas
        $execution = $pdoStatement->execute($data);
        return $execution;
    }

    public function existUser($id){ // verifie si l'id en entrée correspond à un user
        $pdo = PdoEpsiLink::$monPdo;
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
        $pdo = PdoEpsiLink::$monPdo;
        $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM utilisateur WHERE mailUser = :leMail");
        $bv1 = $pdoStatement->bindValue(':leMail', $email);
        $execution = $pdoStatement->execute();
        $resultatRequete = $pdoStatement->fetch();
        if ($resultatRequete['nbMail']==0) // si aucun retour
            $mailTrouve = false; // n'existe pas
        else
            $mailTrouve=true; // existe
        
        return $mailTrouve; // retourne la valeur
    }
    
function donneLeUserParMail($login) {
    
    $pdo = PdoEpsiLink::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT idUser, nom, prenom,mail,idRole FROM utilisateur WHERE mail= :login;");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        if(!is_array($unUser)){
            throw new Exception("L\'adresse saisie ne corespond à aucun utilisateur.");}
    }
    else
        throw new Exception("erreur dans la requÃªte");
    return $unUser;   
}


}
?>