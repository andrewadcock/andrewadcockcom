#!/bin/bash
set -xe

if [ $TRAVIS_BRANCH == 'master' ] ; then

  cd ../ # move up a dir after composer install
  echo "Deploying to production"
  eval "$(ssh-agent -s)"
  ssh-add ~/.ssh/id_rsa

  echo "Clear current git information"
  rm -rf .git

  echo $(pwd) #debug
  git init

  git remote add deploy "travis@165.227.179.245:/var/repo/andrewadcock.git"
  git config user.name "Andrew Adcock"
  git config user.email "andrewadcock+travis@gmail.com"

  git add .
  git status # debug
  git commit -m "Deploy"


  openssl aes-256-cbc -K $encrypted_e626a03f7ac6_key -iv $encrypted_e626a03f7ac6_iv -in travis_rsa.enc -out travis_rsa -d
  eval "$(ssh-agent -s)"
  chmod 600 travis_rsa
  ssh-add travis_rsa

  git push --force deploy HEAD:master

else
  echo "Not deploying, since this branch isn't master."
fi