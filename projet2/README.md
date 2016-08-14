## Note
This tutorial doesn't involve symfony, it's just a bascic php project with mysql
But it shows how to combine vagrant with docker

## virtual box
make sure you have set up 2 networks : NAT + Reseau privé hote
ex

## launch the vagrant

Launch the vagrant
```
vagrant up
```

## launch the docker containers

```
vagrant ssh
docker-compose build
docker-compose up -d
```
