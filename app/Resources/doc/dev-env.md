# Environnement de développement

## Installation

### Sans VM

Si vous ne souhaitez pas vous encombrer d'une VM:
1. Installez :
   * [PHP > 5.5](http://php.net/)
   * [Composer](https://getcomposer.org/)
   * [MySQL](https://www.mysql.fr/)
   * [Git](http://git-scm.com/)
2. Clonez le repo Git du projet et installer les dépendances avec `composer install`
3. Lancer le serveur Symfony: `php app/console server:run`


### Avec VM

L'application utilise [Vagrant][1] et [Ansible][2] pour fournir une VM de développement. Ces VM sont préconfigurée et peuvent vous faciliter le développement. Il est a noté cependant que l'utilisation de [Vagrant][1] requiert un provisioner tel que [VirtualBox][3] ou [VMware](http://www.vmware.com/fr). [Ansible][2] est un outil permettant d'installer et de configurer comme besoin est la VM, mais est connu pour être difficile d'installation sous Windows.

1. Installer [Vagrant][1] et [Ansible][2]
2. Installer un provisioner de VM (par défaut configuré avec [VirtualBox][3])
3. Démarrer la VM : `vagrant up`

**Attention :** le premier démarrage va prendre beaucoup de temps car va télécharger la box pour installer la VM, l'upgrader et installer toutes les dépendances.

Si l'étape du provisioning échoue, vous pouvez décommenter [Cette ligne](../../../Vagrantfile#L20) pour afficher un mode plus verbeux et relancer le provisioning avec `vagrant provision`.


## Utilisation

* accès HTTP : `localhost:8080`
* accès SSH : `vagrant ssh`
* accès MySQL :
    * user : `root`
    * pas de mot de passe
    * remote access: spécifier `127.0.0.1` comme host (port `3307`) (requiert un [client MySQL](http://dev.mysql.com/doc/refman/5.6/en/programs-client.html))

Pour recharger la configuration : `vagrant provision`

Pour exécuter une commande en tant qu'utilisation `root`, utiliser la commande `sudo` avec le mot de passe `vagrant`. Il est aussi possible de se connecter en tant que `root` avec la commande `su`.

Toute configuration de la VM se trouve dans le fichier [`Vagrantfile`](../../../Vagrantfile).

## Configuration par défaut

* [Jessie](https://www.debian.org/releases/jessie/) (Debian 8)
* [Wget](http://www.gnu.org/software/wget/) & [cURL](http://curl.haxx.se/)
* [nginx](http://nginx.org/)
* [Git](http://git-scm.com/)

PHP Environment:
* [PHP5.6](http://php.net/)
* [PHP CLI](http://www.php-cli.com/)
* [PHP5 FPM](http://php-fpm.org/)
* [Pear](http://pear.php.net/)
* [Composer](https://getcomposer.org/)
* [Mcrypt](http://php.net/manual/fr/book.mcrypt.php)
* [Xdebug](http://xdebug.org/)

Database:
* [MySQL](https://www.mysql.fr/)

Git:
* Aliases
* Default push method set to `current`
* Global gitignore preconfigured to ignore `linux`, `intelliJ`, `NetBeans` and `Eclipse` files
* For more: `git config --global --list`

Shell aliases: run `alias` to see the available aliases.

## Problèmes connus

Il est possible que le provisioning de la VM avec Ansible soit extrêmement long sur les tâches `composer install` ou d'update de la VM. Si c'est le cas, ne pas hésiter à arrêter le provisoning et faire cette tâche manuellement.


Si la VM requiert trop de mémoire, commentez la ligne suivante.

```ruby
# Provider-specific configuration
  config.vm.provider "virtualbox" do |vb|
    vb.memory = 2048  # Upgrade memory for package managers
  end
```

[1]: http://docs.vagrantup.com/
[2]: http://docs.ansible.com/
[3]: https://www.virtualbox.org/
