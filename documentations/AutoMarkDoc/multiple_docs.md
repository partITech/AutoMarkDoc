# Quick Start

Vous avez la possibilité d'utiliser la même application pour plusieurs documentations. 
Voici un exemple de mise en place
```shell
cd documentations
git submodule add https://github.com/partITech/sonata-extra

## update docs later
git submodule update --remote
```

La documentation dans le dépot sonata-extra se trouve dans [/docs](https://github.com/partITech/sonata-extra/tree/main/docs)

Dans votre environnement ou dans le dotenv de votre projet :

**DOCUMENTATION_PROJECTS** contient une structure JSON avec chaque projet et son chemin associé. 
Le chemin est relatif au document root de AutoMarkDoc.
```.dotenv
DOCUMENTATION_PROJECTS='{
    "automarkoc": {"path": "documentations/AutoMarkDoc"},
    "sonata-extra": {"path": "documentations/sonata-extra/docs"},
}'
```


