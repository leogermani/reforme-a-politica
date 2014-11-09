reforme-a-politica
==================

Plataforma WordPress para http://reformeapolitica.tk/

Para montar o ambiente
----------------------

* Clone o repositorio

* Na pasta src, copie wp-config-sample.php para wp-config.php e _htaccess para .htaccess

* configure os dados do seu banco de dados no wp-config.php

* configure a url de desenvolvimento na variavel DOMAIN_CURRENT_SITE e no .htaccess

* faça um link simbolico de wp-content/uploads para a pasta dev_uploads na raiz do repo

* na pasta db tem uma base de dados em base.sql com os dados de desenvolvimento

* Se necessario, migre sua base de dados para o seu endereco local. Vc pode usar os scripts em wp-scripts ou a funcao search replace do wp-cli (http://wp-cli.org/commands/search-replace/)

