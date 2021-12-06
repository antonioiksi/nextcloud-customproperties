#!/bin/bash

if [ -z "$1" ]; then
    echo "Please point out the app name as 1-st argument, for ex: copy_dictionar.sh dictone"
    exit 1;
fi

echo "User: $(whoami)";
echo "Cloning app notestutorial with name $1";

PROJECT=$1;

if [ ! -d "apps/notestutorial" ] 
then 
    echo "App notestutorial not installed. Please install notestutorial app.";
    exit 1;
fi

if [ -d "apps/$PROJECT" ] 
then
    echo "App apps/$PROJECT already exists.";
    exit 1;
fi

echo "Copying files..."
cp -r apps/notestutorial/ apps/$PROJECT/
echo "Copying files...Ok"

echo "Replacing content..."
sed -i "s/notestutorial/$PROJECT/g" apps/$PROJECT/src/App.vue
sed -i "s/notestutorial/$PROJECT/g" apps/$PROJECT/appinfo/info.xml
sed -i "s/NotesTutorial/$PROJECT/g" apps/$PROJECT/appinfo/info.xml
sed -i "s/Notes Tutorial/$PROJECT/g" apps/$PROJECT/appinfo/info.xml
sed -i "s/notestutorial/$PROJECT/g" apps/$PROJECT/lib/AppInfo/Application.php
sed -i "s/notestutorial/$PROJECT/g" apps/$PROJECT/package.json

find apps/$PROJECT -type f -name "*" -print0 | xargs -0 sed -i "s/NotesTutorial/$PROJECT/g"
find apps/$PROJECT/lib -type f -name "*" -print0 | xargs -0 sed -i "s/notestutorial/$PROJECT/g"
echo "Replacing content...Ok"

echo "Change permission..."
chmod -R g+w apps/$PROJECT
echo "Change permission...Ok"

echo "Build project..."
cd apps/$PROJECT && sudo -u user make dev-setup && sudo -u user make build-js
echo "Current dir: $(pwd)"
cd ../../
echo "Build project...Ok"


echo "Enable app $PROJECT..."
php occ app:enable $PROJECT
echo "Enable app $PROJECT...Ok"
