#!/usr/bin/env bash

#
# This file is part of the Incipio package.
#
# (c) Florian Lefevre
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#

LANG=fr_FR.ANSI COPYRIGHT_PHP="\
/*\n\
 * This file is part of the Incipio package.\n\
 *\n\
 * (c) Florian Lefevre\n\
 *\n\
 * For the full copyright and license information, please view the LICENSE\n\
 * file that was distributed with this source code.\n\
 */\n"

LANG=fr_FR.ANSI COPYRIGHT_YML="\n\
#\n\
# This file is part of the Incipio package.\n\
#\n\
# (c) Florian Lefevre\n\
#\n\
# For the full copyright and license information, please view the LICENSE\n\
# file that was distributed with this source code.\n\
#\n"

LANG=fr_FR.ANSI COPYRIGHT_TWIG="\n\
{#\n\
 # This file is part of the Incipio package.\n\
 #\n\
 # (c) Florian Lefevre\n\
 #\n\
 # For the full copyright and license information, please view the LICENSE\n\
 # file that was distributed with this source code.\n\
 #}\n"




echo '\nTraitement des fichiers yml :\n'

for file in $(find src/ app/Resources/ -name '*.yml')
do 
    if ! grep -q Copyright $file
    then
        echo YML file : $file
        LANG=fr_FR.UTF-8 sed -i "1i\\
        $COPYRIGHT_YML" $file
    fi
done



echo '\nTraitement des fichiers php :\n'

for file in $(find src/ app/Resources/ -name '*.php')
do
    if ! grep -q Copyright $file
    then
        echo PHP file : $file
        LANG=fr_FR.UTF-8 sed -i "/<?php/a\\
        \n$COPYRIGHT_PHP" $file
    fi
done



echo '\nTraitement des fichiers css :\n'

for file in $(find src/ app/Resources/ -name '*.css')
do
    if ! grep -q Copyright $file
    then
        echo PHP file : $file
        LANG=fr_FR.UTF-8 sed -i "1i\\
        $COPYRIGHT_PHP" $file
    fi
done



echo '\nTraitement des fichiers js :\n'

for file in $(find src/ app/Resources/ -name '*.js')
do
    if ! grep -q Copyright $file
    then
        echo PHP file : $file
        LANG=fr_FR.UTF-8 sed -i "1i\\
        $COPYRIGHT_PHP" $file
    fi
done



echo '\nTraitement des fichiers twig :\n'

for file in $(find src/ app/Resources/ -name '*.twig');
do
    if ! grep -q Copyright $file
    then
        echo TWIG file : $file
        LANG=fr_FR.UTF-8 sed -i "1i\\
        $COPYRIGHT_TWIG" $file
    fi
done


