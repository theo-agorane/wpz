# Installation (local)

### Vhost Apache
```
<VirtualHost *>
    DocumentRoot "PATH_TO_WWW\wpz\www"
    ServerName wpz.test
    
    <Directory "PATH_TO_WWW\wpz\www">
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>
</VirtualHost>
```

### Setup NPM
```
cd PATH_TO_WWW/wpz
npm install
npm run build
```

### Développement
```
cd PATH_TO_WWW/wpz
npm run dev
```

# Assets
- Les SASS et JS sont compilés en un fichier unique, on peut en rajouter à l'infini.
- Importer chaque fichier SASS dans `/www/wp-content/themes/wpz/assets/css/style.scss`
- Importer chaque fichier JS dans `/www/wp-content/themes/wpz/assets/js/app.js`
- Lancer `npm run build` pour lancer la génération des fichiers compilés
- Les fichiers compilés (`/www/wp-content/themes/wpz/dist`) ne sont pas commités dans le git

### Images
Ajouter l'image dans `/www/wp-content/themes/wpz/assets/img` puis lancer la commande `npm run build`

### Icônes
Préparer l'icône propre en SVG :
- contours vectorisés (sur Illustrator : Tracé > Vectoriser le contour)
- pas d'espace transparent autour (sur Illustrator : Plan de travail > Ajuster aux limites du document)
- pas de couleur (sur Illustrator : mettre la couleur neutre `#000000`)
- exporter en SVG (sur Illustrator : Enregistrer sous .svg)

Ajouter l'icône dans `/www/wp-content/themes/wpz/assets/icons` puis lancer la commande `npm run build`

# Couleurs
Pour ajouter la couleur id: `new_color`, hex: `#new_color_hex`, nom: `new_color_name`

### Champ ACF
```
éditer : /www/wp-content/themes/wpz/includes/config/config-acf.php

$field['choices'] = [
  ...
  'new_color' => '<div class="acf-wpz-color" style="background: #new_color_hex;"></div> new_color_name',
];
```

### Variable SASS
```
éditer : `/www/wp-content/themes/wpz/includes/assets/css/_variables.scss`

:root {
  ...
  --wpz-color-new_color: #new_color_hex;
}
```

### Block style
```
éditer : `/www/wp-content/themes/wpz/includes/assets/css/components/_blocks.scss`

.background {
  ...
  &_new_color {
    --block-background: #{color(yellow)};
    --block-color: #{color(black)};
    --block-title-color: #{color(white)};
    margin: 0;
    padding: var(--block-spacing-top) 0 var(--block-spacing-bottom);
    background: var(--block-background);
    color: var(--block-color);

    .button.__primary {
      --btn-color: #{color(white)};
      --btn-border: #{color(black)};
      --btn-background: #{color(black)};
      --btn-color-hover: #{color(yellow)};
      --btn-background-hover: #{color(black-dark)};
      --btn-border-hover: #{color(black-dark)};
    }

    .button.__secondary {
      --btn-color: #{color(black)};
      --btn-border: #{color(black)};
      --btn-background: transparent;
      --btn-color-hover: #{color(yellow)};
      --btn-background-hover: #{color(black-dark)};
      --btn-border-hover: #{color(black-dark)};
    }

    .button-icon {
      --btn-color: #{color(green)};
      --btn-icon: #{color(white)};
      --btn-background: #{color(white)};
      --btn-background-icon: #{color(green)};
      --btn-color-hover: #{color(green-dark)};
      --btn-background-hover: #{color(white)};
      --btn-icon-hover: #{color(white)};
      --btn-background-icon-hover: #{color(green-dark)};
    }

    .__color_highlight,
    .__color_highlight_hover:hover {
      color: #{color(white)};
    }
  }
}
```

# Déploiement

### Fichiers
- Compiler les assets avec la commande `npm run build` si besoin
- Récupérer les uploads depuis la préprod si besoin
- Pousser en FTP tout le contenu du dossier `www` à la racine du serveur
- Editer le `www/wp-config.php` avec les infos de base de données

### Base de données
Utiliser le plugin **WP Migrate** (`wp-admin > Outils > WP Migrate > Migrate > Export`) puis importer le fichier sql.gz  

- **Local > Prod**
  - Find : `http://wpz.test` > Replace : `https://wpz.com`
  - Find : `wpz.test` > Replace : `wpz.com`

### Admin Wordpress
- Regénérer les permaliens (`wp-admin > Réglages > Permaliens > Enregistrer`)
- Vider le cache WP Rocket (`wp-admin > WP Rocket > Vider et précharger le cache + Purger le CSS utilisé`)
