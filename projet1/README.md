## Everything works execpt the database

## INSTALLATION AVEC COMPOSER
composer va uniquement mettre des fichiers dans vendor/
ca suffira pas pour installer symfony. Il va falloir faire plus

## SOURCES D'INFORMATION SUR LE SITE SYNFONY
sur le site de synfony, 3 sources d'infos stylées

--1/book => comment ca fonctionnne
---->symfony and http fundamentals
---->installing and configuring synfony
--2/cookbook => les taches courantes
--3/best practices => faire du bon code

## INSTALLATION SUR UBUNTO

Récupérer l'installer
```
sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
sudo chmod a+x /usr/local/bin/symfony
```

## CREATION D'UN PROJET
```
symfony new ProjetSymfony1
```

## LANCER LE SERVER
```
php bin/console server:run
```

## NOTIONS SUR GIT
github s'appuie sur le programme git

gitlab est privé, et on dit qu'on installe un serveur gitlab sur un serveur
dédié à soit

gitlab et github utilisent tous deux le programme GIT

suivre le tutorial ici : https://www.youtube.com/watch?v=KDt01U859Ik

## METTRE LE PROJET SUR GIT

git init
aller sur gitlab pour créer keyssh + recup url :
it@indus.openbridge.fr:mtc/sessionjuillet2016.git

```
git add -A
git status
git commit -m "Initialisation de synfony"
git config --global user.email "jfolsi@maltem.com"
git config --global user.name "Folsi"
git commit -m "Initialisatin de synfony"
git push
git push --set-upstream origin master
git pull
git branch --set-upstream-to=origin/master master
git pull
git commit
git add .
git commit
```

## Divers

Bundle => une sous application
on utilise plus trop ca maintenant
on recommande de faire 1 bundle par projet maintenance

pour tester la BD : pour mettre à jour la BD
```
php bin/console doctrine:schema:update
```

pour créer une entite
```
php bin/console doctrine:generate:entity
php bin/console doctrine:schema:update --force --dump-sql
```

supprimer une propriété d'une entité déjà créé
maintenant on veut supprimer birthday
on a juste à retirer le champ birtday dans le fichier entite.php
et on relance la commande
```
php bin/console doctrine:schema:update --force --dump-sql
```

## ADDING CONSTRAINTS
formulaire > ajouter des contraintes aux champs
on le faire directement dans l'entity
on importe le namespace
use Symfony\Component\Validator\Constraints as Assert;
attention on lui donne un alias = Assert que l'on va utiliser par la suite

## VERIFICATION DES CHAMPS D'UN FORM
Attention il faut faire une vérification coté client
et coté server absoluement!!

## FORMULAIRE AVEC CLASSE DERIVE
```
 $form = $this->createFormBuilder($newBird)
            ->add("animal", EntityType::class, [
                'class' => 'AppBundle\Entity\Animal',
                'choice_label' => 'name'
            ])
```

--------------------------------------------------------
## UTILISER UN SERVICE DANS TWIG

a/declare the service in service.yml

b/implement the class associated to the service name

c/edit config.yml and create an alias to your service in the twig section

d/in your html.twig file, use the following syntax to call one of your service methods :
{{ service_alias.methode( twig var ) }}

## FILTRE TWIG = EXTENSION TWIG

voir exemple

a/declare the service app.twig_extension: in 'service.yml' file
(on peut le nommer comme un veut)
bien préciser le tag qui est de type TwigExtension

b/create the class associated to the alias name

c/add in the class as many filters as you need

## FORM NOT RELATED TO AN ENTITY

voir le controler 'ContactController'

form with a DropDownList => using ChoiceType (OK)
```
            ->add("Sex", ChoiceType::class, [
                'choices' => [
                    'Female' => 'f',
                    'Male' => 'm',
                ]
            ])
```

## FORM WITH A DROPDOWNLIST

-form with a DropdownList => related to another Entity (OK)

```
            ->add("countries", EntityType::class, [
                'class' => 'AppBundle\Entity\Country',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
```
## PARAM CONVERTER

Use the ParamConverter trick to automatically query for Doctrine entities when it's simple and convenient.

## OPERATIONS EN CASCADE

-create tables Author/Book
-create relation ManyToOne (Book - Author)
-[DELETE] operation en cascade en BD (delete)
-[PERSIST] operation de création de plusieurs livres attachés à un author en cascade

## REPARTITEUR D'EVENEMENT

quand un user depose un message via le formulaire de contact
cela genere un evenement 'new_msg_contact'
---qui sera ecouté par un Service1 -> pour envoyer un mail

1/dans le controller on genere l'envement

```
   $this->get('event_dispatcher')->dispatch(
                'new_contact_msg', new GenericEvent($messageFinal)
            );
```

2/dans le services.yml, on déclare un service de type 'event_listener'
qui écoute l'event 'new_contact_msg'

```
  app.mailservice:
    class: AppBundle\MailService\MailService
    tags:
      -
        name: kernel.event_listener
        event: 'new_contact_msg'
```

pour s'amuser on ajoute aussi dans le services.yml, un service de type 'event_subscriber'
qui écoute l'évent 'new_contact_msg'

Attention :
avec un 'kernel.event_listener' => on définit les parametres au niveau du tag
avec un 'kernel.event_subscriber' => on définit les parametres au niveau du service
