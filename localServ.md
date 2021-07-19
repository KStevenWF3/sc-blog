# HELP

php -S 127.0.0.1:8000 -t public

cd sc-blog

git add --all && git commit -m 'relation entité + fixtures + dev templates'

git push origin dev_steven_0707

git checkout master

git branch -d dev_steven_0707

<!-- pour forcer le delete -->
git branch -D dev_steven_0707

git pull origin master

git clone <https://github.com/KStevenWF3/sc-blog>

REPLAY MATIN DU 08/07

php bin/console doctrine:schema:validate
php bin/console d:s:v

php bin/console make:entity
pbc make:entity Tag (avec dmmder edition de fichier à la racine du site)

php bin/console doctrine:schema:update --force
<!-- => comaprer toute les modif faite dans les entité avec les dernier changement de la BDD, générer le code SQL necessaire, l'executer et donner une confirmatiion. -->
!! SYSTEMATIQUE QUAND ON RECUPERE LE PROJET DE QUELQU'UN (pour la strucute de la BDD)

php bin/console d:s:u -f

php bin/console d:f:l -q
ajouter les fixture

SELECT2 (liste déroulante avec barre de recherche selection)

<!-- php bin/console doctrine:schema:update  -->

<!-- Doctrine ORM O R Manager -->