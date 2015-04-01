# Getting started

* Install [Vagrant](http://docs.vagrantup.com/v2/installation/) and [Ansible](http://docs.ansible.com/intro_installation.html).
* Start the Vagrant VM: `vagrant up`
* Configure the VM: `vagrant provision`

# Default configuration

The VM container is configured via Ansible:

* Latest version of [Jessie](https://www.debian.org/releases/jessie/index.en.html) (Debian 8)
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

Databases:
* [Redis](http://redis.io/)
* [MySQL](https://www.mysql.fr/)

# TODO

* nginx
    * Configure nginx vhost for Symfony with HTTPS in dev mode and redirection of HTTPS to HTTP.
    * in dev mode
    * check nginx version
* PHP
    * Configure dev mode
    * Test Xdebug
    * Check Mcrypt
    * check PHP version
* Git
    * check version
    * configure default push branch
    * configure pre-commit hook
* MySQL
    * dev mode?
    * distant access (check + howto in doc)
    * check version
* System packages
    * check update & upgrade
    * check Wget & cURL
* vim preconf
* nano
* aliases
    * config
    * update
    * sf
    * ...
