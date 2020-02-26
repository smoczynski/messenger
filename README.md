# The Messenger Component example
This is fully standalone dockerized application which provide 
nginx, php 7.4, mysql, amqp, redis

## Requirements
You need to have `docker` and `docker-compose` installed
If any apache or nginx using your port 80 locally, you need to stop it to prevent conflicts.
 
## How to start?
Clone this repository

```sh
git clone git@github.com:smoczynski/messenger.git
```

Enter project directory and run `docker-compose` command

```sh
docker-compose up -d
```

Project will be available via url `http://messenger.localhost`

You have two endpoints available:

POST - `/api/warriors` 
to create new Warrior call it with json payload like:

```json
{
  "name": "Warrior1",
  "region": "Athens",
  "battleTactics": "archer",
  "armament": "bow"
}
``` 

GET - `/api/warriors/{wariorId}`
to get specified warrior data

## More details are stored in presentation
[`Presentation`](https://docs.google.com/presentation/d/e/2PACX-1vTGIVk9Ihzf9Rtms8l7UUIT5R3_fpgU3szDQd9o2tnpZzqH25K0943zZfigSSQ5XJMgbT5luBv8Xelu/pub?start=true&loop=false&delayms=3000) - More information about this app

## Need help ?
Contact with me: radek.smoczynski@gmail.com
I would be glad to help :)
