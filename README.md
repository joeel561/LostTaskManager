# Lost Task Manager

## Setup Guide

### Prerequisites

Make sure you have installed the following tools:
- nodejs
- composer
- symfony cli

### Setup

- git clone _git-repository_
- create .env.local file with your database user and password
- composer install
- npm run dev
- (optional) docker-compose up -d (edit database user and password according to .env.local file)
- in case of docker, you don't have to create a database, it will be created on first startup of container, otherwise create the database with the user mentioned above
- php bin/console doctrine:schema:update --force 
- symfony server:start