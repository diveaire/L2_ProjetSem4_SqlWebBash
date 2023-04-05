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
    output_script="$1($i).cmp.sh"
    i=$(( $i + 1 ))
  done
fi

# Début de la génération du script
cat << TAGDEFIN > $output_script
#!/bin/bash
#realisation script du désarchiveur

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

# Récupération des variables Site Web
cat << TAGDEFIN >> $output_script
echo "Afin que l'installation se deroule sans pepins, il est necessaire de se trouver dans le dossier public_html de votre serveur"
echo "Continuer ? (Y/N)"
read bol
[ ! \$bol = "Y" ] && exit 2
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

#connexion à la base
mysql -h \$host -u \$user -p\$pass \$base < web/Fichiers/BD/phpmyadmin/bd.sql > /dev/null

#tant que la connexion à la base échoue on redemande les paramètres
while [ \$? -ne 0 ]
do
  #echo "il a des trous de mémoire ? on veut des id valides !!"
  echo "ERREUR veuillez s'il vous plait vérifier les points suivantes :"
  echo -e "\t 1--Les identifiants de connexion soit corrects.\n\t 2--Cet excécutable est à lancer DANS le dossier public_html de votre serveur.\n\t 3--Le chemin d'acces est celui depuis public_html jusqu'à cet executable.\n\t 4-- La base de donnée doit etre deja CREER pour une question de droit mais elle doit aussi etre VIDE.\n"
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
  mysql -h \$host -u \$user -p\$pass \$base < web/Fichiers/BD/phpmyadmin/bd.sql  > /dev/null
done
echo "connexion réussie"
#changement des variables pour les requete du site
sed -i -E "s/serveur/\$host/" Parametres/myparam.inc.php
sed -i -E "s/nom_utilisateur/\$user/" Parametres/myparam.inc.php
sed -i -E "s/mot_de_passe/\$pass/" Parametres/myparam.inc.php
sed -i -E "s/nom_base/\$base/" Parametres/myparam.inc.php

open http://\$host/\$install/web/index.php
TAGDEFIN
# Ajout des droits d'exécution sur le script
chmod u+x $output_script

# Fin du script
echo "Script d'archivage généré dans $output_script"
