#!/bin/bash
# Vérification du paramètre
[ $# -ne 1 ] || [ ! -d $1 ] && echo "Usage: $0 <folder>" && exit 1

# Définition des variables
folder=$1
output_script="$1.cmp.sh"

#vérification de output_script
if [ -f $output_script ]
then
  i=1
  while [ -f $output_script ]
  do
    output_script="$1_$i.cmp.sh"
    i=$(( $i + 1 ))
  done
fi

# Début de la génération du script
cat << TAGDEFIN > $output_script
#!/bin/bash
#realisation script du désarchiveur
echo "Afin que l'installation se deroule sans pepins, il est necessaire de verifier les points suivants :"
echo -e "\t 1--Les identifiants de connexion soit corrects.\n\t 2--Le chemin d'acces demander est celui depuis public_html jusqu'à cet executable.\n\t 3-- La base de donnée doit etre deja CREER pour une question de droit. elle doit aussi etre VIDE.\n"
echo "Continuer ? (Y/N)"
read bol
[ ! \$bol = "Y" ] && exit 2
TAGDEFIN

# Parcours récursif du dossier sur tous les fichiers
find $folder -type f | while read file
do
#on decode chaque fichiers dans son dossier courant
cat << TAGDEFIN >> $output_script
[ ! -d `dirname $file` ] && mkdir -p `dirname $file`
uudecode -o $file << TAGDECODE
`uuencode -m $file $file`
TAGDECODE

TAGDEFIN
done


cat << TAGDEFIN >> $output_script

#copie des fichiers sur le serveur
echo "Le serveur est-il distant ? Y/N"
read bol
if [ \$bol == "Y" ] ;then
	echo "Donner l'identifiant de connexion au serveur"
	read idServ
else
	echo "Donner le chemin absolu de votre dossier \"public_html\""
	read chemin
	while [ ! -d \$chemin ] ;do
		echo "Le chemin n'existe pas"
		read chemin
	done
fi

# Récupération des variables Site Web
echo "Quel est votre serveur d'hebergement ?"
read host
echo "Quel est votre identifiant mysql ?"
read user
echo "Quel est votre mot de passe mysql ?"
read pass
echo "Quel base voulez-vous utilisez ?"
read base
echo "Donnez le chemin d'installation depuis public_html ?"
read install


#changement des variables pour les requete du site

sed -E -i -e 's/("MYHOST",")[^"]+"/\1\$host"/' $folder/Parametres/myparam.inc.php
sed -E -i -e 's/("MYUSER",")[^"]+"/\1\$user"/' $folder/Parametres/myparam.inc.php
sed -E -i -e 's/("MYPASS",")[^"]+"/\1\$pass"/' $folder/Parametres/myparam.inc.php
sed -E -i -e 's/("MYBASE",")[^"]+"/\1\$base"/' $folder/Parametres/myparam.inc.php


#connexion à la base
if [ \$bol == "Y" ] ;then
	ssh \$idServ@\$host mysql -h \$host -u \$user -p\$pass \$base < web/Fichiers/BD/phpmyadmin/bd.sql > /dev/null
else
	mysql -h \$host -u \$user -p\$pass \$base < web/Fichiers/BD/phpmyadmin/bd.sql > /dev/null
fi


#tant que la connexion à la base échoue on redemande les paramètres
while [ \$? -ne 0 ]
	do
	  echo -e "ERREUR\n Veuillez s'il vous plait vérifier les points suivantes :"
	  echo -e "\t 1--Les identifiants de connexion soit corrects.\n\t 2--Le chemin d'acces est celui depuis public_html jusqu'à cet executable.\n\t 3-- La base de donnée doit etre deja CREER pour une question de droit mais elle doit aussi etre VIDE.\n"
	  echo "quel est votre serveur d'hebergement"
	  read host
	  echo "quel est votre identifiant mysql"
	  read user
	  echo "quel est votre mot de passe mysql"
	  read pass
	  echo "quel base voulez-vous utilisez"
	  read base
	  echo "Donnez le chemin d'installation depuis public_html ?"
	  read install
	  
	#changement des variables pour les requete du site
	sed -E -i -e 's/("MYHOST",")[^"]+"/\1\$host"/' $folder/Parametres/myparam.inc.php
	sed -E -i -e 's/("MYUSER",")[^"]+"/\1\$user"/' $folder/Parametres/myparam.inc.php
	sed -E -i -e 's/("MYPASS",")[^"]+"/\1\$pass"/' $folder/Parametres/myparam.inc.php
	sed -E -i -e 's/("MYBASE",")[^"]+"/\1\$base"/' $folder/Parametres/myparam.inc.php


	#connexion à la base
	if [ \$bol == "Y" ] ;then
		ssh \$idServ@\$host mysql -h \$host -u \$user -p\$pass \$base < web/Fichiers/BD/phpmyadmin/bd.sql > /dev/null
	else
		mysql -h \$host -u \$user -p\$pass \$base < web/Fichiers/BD/phpmyadmin/bd.sql > /dev/null
	fi
done
echo "connexion réussie"

#connexion à la base
if [ \$bol == "Y" ] ;then
	ssh \$idServ@\$host mkdir -p public_html/\$install
	scp -r $folder \$idServ@\$host:public_html/\$install/
else
	[ ! -d \$chemin/\$install ] && mkdir -p \$chemin/\$install 
	mv $folder \$chemin/\$install	
fi


#connexion à la base
if [ \$bol == "Y" ] ;then
	xdg-open "http://\$host/~\$idServ/\$install/web/index.php"
else
	open "http://\$host/\$install/web/index.php"
fi

TAGDEFIN
# Ajout des droits d'exécution sur le script
chmod u+x $output_script

# Fin du script
echo "Script d'archivage généré dans $output_script"
