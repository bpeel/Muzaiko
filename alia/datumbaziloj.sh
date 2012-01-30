#!/bin/bash
# farita por uzi "source SKRIPTO"

# set -eux

##############
# if [ -f /var/muzaiko/datumbazensalutiloj.sh ]; then
#   source /var/muzaiko/datumbazensalutiloj.sh
# fi

source /var/muzaiko/datumbazensalutiloj.sh

# FIELDS="Liveritaj VARCHAR(100), REF VARCHAR(100), Codes_ISRC VARCHAR(100), Noms_albums_complets_et_Titres_par_piste_unitaire VARCHAR(100), Dauxroj VARCHAR(100), Artistoj VARCHAR(100), Auteurs VARCHAR(100), Compositeurs VARCHAR(100), Arrangeurs VARCHAR(100), Adaptateurs VARCHAR(100), Producteurs_Editeurs VARCHAR(100), Jaroj VARCHAR(100), Labels VARCHAR(100), Ligoj_al_diskoservo VARCHAR(100), Ligoj_al_la_elsxutejo VARCHAR(100)"
#FIELDS="REF VARCHAR(100), Codes_ISRC VARCHAR(100), Noms_albums_complets_et_Titres_par_piste_unitaire VARCHAR(100), Dauxroj VARCHAR(100), Artistoj VARCHAR(100), Auteurs VARCHAR(100), Compositeurs VARCHAR(100), Arrangeurs VARCHAR(100), Adaptateurs VARCHAR(100), Producteurs_Editeurs VARCHAR(100), Jaroj VARCHAR(100), Labels VARCHAR(100), Ligoj_al_diskoservo VARCHAR(100), Ligoj_al_la_elsxutejo VARCHAR(100)"

#id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,

FIELDS="ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, Artistoj VARCHAR(100) DEFAULT 0, Titolo VARCHAR(100) DEFAULT 0, Ligoj_al_diskoservo VARCHAR(100) DEFAULT 0, Ligoj_al_la_elsxutejo VARCHAR(100) DEFAULT 0, Ligoj_al_muzikteksto VARCHAR(100) DEFAULT 0, Ligoj_al_retpagxo VARCHAR(100) DEFAULT 0, REF VARCHAR(100) DEFAULT 0, ISRC_Kodoj VARCHAR(100) DEFAULT 0, Dauxroj VARCHAR(100) DEFAULT 0, Verkistoj VARCHAR(100) DEFAULT 0, Komponistoj VARCHAR(100) DEFAULT 0, Arangxistoj VARCHAR(100) DEFAULT 0, Adaptistoj VARCHAR(100) DEFAULT 0, Produktistoj_kaj_redaktantoj VARCHAR(100) DEFAULT 0, Jaroj VARCHAR(100) DEFAULT 0, Eldonejo VARCHAR(100) DEFAULT 0"
# DATABASENAME=vinilkosmo
# TABLENAME=muzaiko_datumbazo
# mysql -u root -p -e "CREATE TABLE $TABLENAME($FIELDS)" $DATABASENAME

function muzaiko_preparuCSV()
{
#   set -eux
  IN=$1
  OUT=$2
  TMP=$(mktemp)


  sed 's/^;/0;/g' $IN >$TMP
  sed -i 's/;;/;0;/g' $TMP
  sed -i 's/;;/;0;/g' $TMP
  sed -i 's/$/;/' $TMP
  # sed -i 's/^[^;]*;//' $TMP
  sed -i 's/; */;/g' $TMP
  sed -i 's/ *;/;/g' $TMP

  # cp -iv $CSVFILE $TABLENAME.csv
  # malcxapeligu.py $TMP > $TABLENAME.csv
  malcxapeligu.py $TMP > $OUT
}

function muzaiko_kreu_datumbazon()
{
  # kreu la datumbazon
  mysql -u $ADMIN -p$ADMIN_PASSWORD -e "CREATE DATABASE $DATABASENAME"
  # aldonu uzanton
  mysql -u $ADMIN -p$ADMIN_PASSWORD -e "GRANT ALL ON $DATABASENAME.* TO $USER@localhost IDENTIFIED BY '$PASSWORD'"
}

function muzaiko_forigu()
{
  # drop table if necessary
  mysql -u $USER -p$PASSWORD -e "DROP TABLE $TABLENAME" $DATABASENAME
}

function muzaiko_kreu_tabelon()
{
  # create table
  mysql -u $USER -p$PASSWORD -e "CREATE TABLE $TABLENAME($FIELDS)" $DATABASENAME
}

function muzaiko_anstatauxigu()
{
  # importu CSV anstatauxigante la antauxan enhavon
  IN=$1
  TMPDIR=$(mktemp -d)
  cp -iv $IN $TMPDIR/$TABLENAME.csv
  mysqlimport -u $USER -p$PASSWORD --verbose --delete --fields-terminated-by=';' --local $DATABASENAME $TMPDIR/$TABLENAME.csv
#   mysqlimport -u $USER -p$PASSWORD --verbose --delete --fields-terminated-by=';' --local $DATABASENAME $IN
}

function muzaiko_aldonu()
{
  # importu CSV aldonante
  IN=$1
  TMPDIR=$(mktemp -d)
  cp -iv $IN $TMPDIR/$TABLENAME.csv
  mysqlimport -u $USER -p$PASSWORD --verbose --fields-terminated-by=';' --local $DATABASENAME $TMPDIR/$TABLENAME.csv
#   mysqlimport -u $USER -p$PASSWORD --verbose --fields-terminated-by=';' --local $DATABASENAME $IN
}

function muzaiko_montru()
{
  # print out table
  mysql -u $USER -p$PASSWORD -e "SELECT * FROM $TABLENAME" $DATABASENAME
}

function muzaiko_sekurkopiu
{
  # kreu sekurkopion
  OUT=$1
#   mysqldump -u $USER -p$PASSWORD $DATABASENAME > $DATABASENAME.sql
  mysqldump -u $USER -p$PASSWORD $DATABASENAME > $OUT
}

function muzaiko_konektu()
{
  # konektu al la datumbazo
  mysql -u $USER -p$PASSWORD $DATABASENAME
}

function muzaiko_nombru
{
  # nombru la linioj
  mysql -u $USER -p$PASSWORD -e "SELECT COUNT(*) FROM $TABLENAME" $DATABASENAME
}

function muzaiko_root_sekurkopiu
{
  # kreu sekurkopion
  DATABASENAME=$1
  mysqldump -u $ADMIN -p$ADMIN_PASSWORD $DATABASENAME
}

function muzaiko_root_konektu()
{
  # konektu al la datumbazo
  mysql -u $ADMIN -p$ADMIN_PASSWORD
}

function muzaiko_root_listu_datumbazojn()
{
  mysql -u $ADMIN -p$ADMIN_PASSWORD -e 'SHOW DATABASES'
}
