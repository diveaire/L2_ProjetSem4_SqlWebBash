#!/bin/bash
#On note que Pour la fonction archivage sire : n'importe quel projet web avec une configuration semblable au projet web du semestre 4 peut être : archiver / installer (automatiquement)

# Vérification du paramètre
[ $# -ne 1 ] || [ ! -d $1 ] && echo "Usage: $0 <folder>" && exit 1

# Définition des variables

echo "Comment voulez-vous nommer le script de sortie ? (entrer pour ignorer)"
read dos
echo "Que voulez-vous Archiver ? Dossier ou Site Web ? (D/S)"
read arch
while [[ $arch != "D" ]] && [[ $arch != "S" ]] ;do echo -e "option non valable.\nQue voulez-vous Archiver ? Dossier ou Site Web ? (D/S)";read arch;done
if [[ $dos == "" ]]
then
    dos=$1
fi
output_script="$dos.cmp.sh"
folder=$1

#vérification de output_script
if [ -f $output_script ]
then
  i=1
  while [ -f $output_script ]
  do
    output_script="`echo $dos`_$i.cmp.sh"
    i=$(( $i + 1 ))
  done
fi

#ARCHIVAGE WEB
if [[ $arch == "S" ]]
then
    echo "Donner le chemin et nom de votre fichier \"myparam.inc.php\". (syntaxe : dossier_web/chemin/nom.inc.php)"
    read param
    while [ ! -f $param ] || [ `grep 'define' $param | wc -l` -lt 4 ] ;do
        echo "Erreur, le fichier n'existe pas ou n'est pas correct. (syntaxe : dossier_web/chemin/nom.inc.php)"
        read param
    done
    param=`echo $param | sed -E "s/$folder(.*)/$dos\1/"`
    echo "Donner le chemin de votre fichier base de donnée \"fichier.sql\".(syntaxe : dossier_web/chemin/nom.bd)"
    read bd
    while [ ! -f $bd ] || [ `grep '\-\- phpMyAdmin SQL Dump' -B 0 $bd | wc -l` -ne 1 ];do
        echo "Erreur, le fichier n'existe pas ou n'est pas correct. (Le fichier .sql doit être une exportation de phpmyadmin)(syntaxe : dossier_web/chemin/bd.sql)"
        read bd
    done
    bd=`echo $bd | sed -E "s/$folder(.*)/$dos\1/"`
fi

# Début de la génération du script
#Archive = Site web
if [[ $arch == "S" ]]
then
cat << TAGDEFIN > $output_script
#!/bin/bash
#realisation script du désarchiveur
echo "Afin que l'installation se déroule sans pépins, il est nécessaire de vérifier les points suivants :"
echo -e "\t 1--Les identifiants de connexion soit corrects.\n\t 2--Le chemin d'accès demander est celui depuis public_html jusqu'à cet exécutable.\n\t 3--La base de données doit être déjà CREER pour une question de droit. Elle doit aussi être VIDE.\n\t 4--Afin que la commande \"uudecode\" fonctionne, il est néccessaire d'avoir le paquet sharutils d'installer.\n\t\t(Linux : apt-get install sharutils)\n\t\t(MacOS : brew install sharutils)\n"
echo "Continuer ? (Y/N)"
read bol
[ ! \$bol = "Y" ] && exit 2
echo -e "~~Début du désarchivage~~\n"
TAGDEFIN

# Parcours récursif du dossier sur tous les fichiers
find $folder -type f | while read file
do
fileSrc=`echo $file | sed -E "s/$folder(.*)/$dos\1/"`
#on decode chaque fichiers dans son dossier courant
cat << TAGDEFIN >> $output_script
[ ! -d `dirname $fileSrc` ] && mkdir -p `dirname $fileSrc`
uudecode -o $fileSrc << TAGDECODE
`uuencode -m $file $file`
TAGDECODE
echo "Fichier : $fileSrc (Validé)"
TAGDEFIN
done


cat << TAGDEFIN >> $output_script

echo -e "\n~~Extraction des fichiers réussie~~"
echo "Le serveur est-il distant ? Y/N"
read bol
if [ \$bol == "Y" ] ;then
	echo "Donner l'identifiant de connexion au serveur"
	read idServ
else
	echo "Quel est le chemin absolu de votre dossier \"public_html\" (syntaxe : /.../.../public_html)."
	read chemin
	while [ ! -d \$chemin ] ;do
		echo -e "Le chemin n'existe pas.\nQuel est le chemin absolu de votre dossier \"public_html\" (syntaxe : /.../.../public_html)."
		read chemin
	done
fi

# Récupération des variables Site Web
echo "Quel est votre serveur d'hébergement ? (localhost en serveur local)"
read host
while [[ \$host == "" ]] ;do echo -e "Erreur, serveur ne peut pas être vide.\nQuel est votre serveur d'hébergement ? (localhost en serveur local)";read host;done
echo "Quel est votre identifiant mysql ?"
read user
while [[ \$user == "" ]] ;do echo -e "Erreur, identifiant sql ne peut pas être vide.\nQuel est votre identifiant mysql ?";read user;done
echo "Quel est votre mot de passe mysql ?"
read pass
echo "Quelle base voulez-vous utiliser ? (Existante et Vide)"
read base
while [[ \$base == "" ]] ;do echo -e "Erreur, Indiquer le nom de la base sql à utiliser.\nQuelle base voulez-vous utiliser ? (Existante et Vide)";read base;done
echo "Quel est le chemin d'installation depuis public_html ? (syntaxe : lien/vers/installation)"
read install


#changement des variables pour les requete sql du site
sed -E -i -e "s/(\"MYHOST\",\")[^\"]+\"/\1\$host\"/" $param
sed -E -i -e "s/(\"MYUSER\",\")[^\"]+\"/\1\$user\"/" $param
sed -E -i -e "s/(\"MYPASS\",\")[^\"]+\"/\1\$pass\"/" $param
sed -E -i -e "s/(\"MYBASE\",\")[^\"]+\"/\1\$base\"/" $param


#connexion + importation dans la base sql
if [ \$bol == "Y" ] ;then
	ssh \$idServ@\$host mysql -h \$host -u \$user -p\$pass \$base < $bd > /dev/null
else
	mysql -h \$host -u \$user -p\$pass \$base < $bd > /dev/null
fi


#tant que la connexion à la base échoue, on redemande les paramètres
while [ \$? -ne 0 ] ;do
    echo -e "ERREUR\n Veuillez s'il vous plaît vérifier les points suivants :"
    echo -e "\t 1--Les identifiants de connexion soit corrects.\n\t 2--Le chemin d'accès demander est celui depuis public_html jusqu'à cet exécutable.\n\t 3--La base de données doit être déjà CREER pour une question de droit. Elle doit aussi être VIDE.\n\t 4--Afin que la commande \"uudecode\" fonctionne, il est néccessaire d'avoir le paquet sharutils d'installer.\n\t\t(Linux : apt-get install sharutils)\n\t\t(MacOS : brew install sharutils)\n"
    if [ \$bol == "Y" ] ;then
        echo "Donner l'identifiant de connexion au serveur"
        read idServ
    else
        echo "Quel est le chemin absolu de votre dossier \"public_html\" (syntaxe : /.../.../public_html)."
        read chemin
        while [ ! -d \$chemin ] ;do
            echo -e "Le chemin n'existe pas.\nQuel est le chemin absolu de votre dossier \"public_html\" (syntaxe : /.../.../public_html)."
            read chemin
        done
    fi

    # Récupération des variables Site Web
    echo "Quel est votre serveur d'hébergement ? (localhost en serveur local)"
    read host
    while [[ \$host == "" ]] ;do echo -e "Erreur, serveur ne peut pas être vide.\nQuel est votre serveur d'hébergement ? (localhost en serveur local)";read host;done
    echo "Quel est votre identifiant mysql ?"
    read user
    while [[ \$user == "" ]] ;do echo -e "Erreur, identifiant sql ne peut pas être vide.\nQuel est votre identifiant mysql ?";read user;done
    echo "Quel est votre mot de passe mysql ?"
    read pass
    echo "Quelle base voulez-vous utiliser ? (Existante et Vide)"
    read base
    while [[ \$base == "" ]] ;do echo -e "Erreur, Indiquer le nom de la base sql à utiliser.\nQuelle base voulez-vous utiliser ? (Existante et Vide)";read base;done
    echo "Quel est le chemin d'installation depuis public_html ? (syntaxe : lien/vers/installation)"
    read install


    #changement des variables pour les requete sql du site
    sed -E -i -e "s/(\"MYHOST\",\")[^\"]+\"/\1\$host\"/" $param
    sed -E -i -e "s/(\"MYUSER\",\")[^\"]+\"/\1\$user\"/" $param
    sed -E -i -e "s/(\"MYPASS\",\")[^\"]+\"/\1\$pass\"/" $param
    sed -E -i -e "s/(\"MYBASE\",\")[^\"]+\"/\1\$base\"/" $param


    #connexion + importation dans la base sql
    if [ \$bol == "Y" ] ;then
        ssh \$idServ@\$host mysql -h \$host -u \$user -p\$pass \$base < $bd > /dev/null
    else
        mysql -h \$host -u \$user -p\$pass \$base < $bd > /dev/null
    fi
done


echo "connexion réussie"

#copie des fichiers sur le serveur
if [ \$bol == "Y" ] ;then
	ssh \$idServ@\$host mkdir -p public_html/\$install
	scp -r $dos \$idServ@\$host:public_html/\$install/
else
	[ ! -d \$chemin/\$install ] && mkdir -p \$chemin/\$install
	mv $dos \$chemin/\$install/
fi


#ouverture du site sur un navigateur
if [ \$bol == "Y" ] ;then
	xdg-open "http://\$host/~\$idServ/\$install/$dos/index.php"
else
	open "http://\$host/\$install/$dos/index.php"
fi

TAGDEFIN

#ARCHIVAGE DOSSIER
elif [[ $arch == "D" ]]
then
cat << TAGDEFIN > $output_script
#!/bin/bash
#realisation script du désarchiveur
echo "Quel est le chemin d'extraction ?"
read chemin
while [ -d \$chemin/$dos ];do echo -e "Erreur, le dossier existe déjà dans le chemin.\nQuel est le chemin d'extraction ?";read chemin;done
[[ \$chemin == "" ]] && chemin="."
echo -e "~~Début du désarchivage~~\n"
TAGDEFIN
# Parcours récursif du dossier sur tous les fichiers
find $folder -type f | while read file
do
fileSrc=`echo $file | sed -E "s/$folder(.*)/$dos\1/"`
#on decode chaque fichiers dans son dossier courant
cat << TAGDEFIN >> $output_script
[ ! -d \$chemin/`dirname $fileSrc` ] && mkdir -p \$chemin/`dirname $fileSrc`
uudecode -o \$chemin/$fileSrc << TAGDECODE
`uuencode -m $file $file`
TAGDECODE
echo "Fichier : $fileSrc (Validé)"
TAGDEFIN
done

cat << TAGDEFIN >> $output_script
#message fin de script
echo -e "\n~~Extraction des fichiers réussie~~"
TAGDEFIN
fi

# Ajout des droits d'exécution sur le script
chmod u+x $output_script

# message fin de script
echo -e "Script d'archivage généré dans $output_script"
