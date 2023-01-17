# Zip the current folder without the .git folder and the build.sh file

# Get the current folder name
FOLDER_NAME=$(basename $(pwd))

# Zip the folder
zip -r $FOLDER_NAME.zip . -x .git/\* build.sh

