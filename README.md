<div align="center">
  <h1>Projet Semalynx 🖥️</h1>

![Logo](https://github.com/Foufou-exe/Semabox/blob/dev/.github/Logo_Banniere.png?raw=true)

  [![License Propriétaire](https://img.shields.io/badge/License-Propri%C3%A9taire-green.svg)](https://github.com/Foufou-exe/Semabox/blob/main/license)
  ![Version Python](https://img.shields.io/badge/Compatible-PHP8.4-blue.svg)

</div>

## Description

L'application Semalynx est une application web qui rescence toutes les sondes Semabox qui sont associer au datacenter CMA4.box, cette application nous permet de lancer des scripts a distance mais surtout récuperer les informations receuillis par les sondes.

### Les fonctionnalités de la Semalynx incluent

- Détection de l'OS utilisé par la sonde
- Identification de l'IP publique et du nom d'hôte de la sonde
- Analyse de la bande passante utilisée par la sonde
- Scan de ports pour détecter les ports ouverts et les services en cours d'exécution sur la semabox
- Analyse de la sécurité réseau client pour détecter les vulnérabilités potentielles de chaque actif réseau

#### Toutes ces fonctionnalités sont gérées par des scripts Python appelés **SemaOS**

Les résultats de ces analyses peuvent être visualisés via une interface graphique web. Cela permet aux administrateurs de systèmes de surveiller facilement leur environnement des semabox et de prendre des mesures pour résoudre les problèmes identifiés.

## Installation Mode Manuel 👩‍🌾

Mise en situation :
*Le serveur ou sera installer samelynx dois posseder un server web apache2 et PHP en version 8.4

#### **Etape 1**: On clone le projet

```bash
git clone https://github.com/Foufou-exe/SemaLynx.git
```

#### **Etape 2**: Tu vas dans le dossier principal

```bash
cd SemaLynx
```
#### **Etape 3**: Tu copie les fichiers dans le chemin web

```bash
cp * /var/www/html
```

#### **Etape 4**: Tu redemmare le server web

```bash
systemctl restart apache2
```

## Support

En cas de problème, veuillez le signaler à cette adresse support@cma4.local .

## Auteur et Developpeur

#### L'entreprise Quadro

Developpeur :

- [@Dylan L](https://github.com/thorbeorn)
- [@Thibaut M](https://github.com/Foufou-exe) 
- [@Mathis L](https://github.com/mathislef34)
- [@Nicolas L](https://github.com/nicolasLlinares)

## License

[License Propriétaire](https://github.com/Foufou-exe/Semabox/blob/main/license)
