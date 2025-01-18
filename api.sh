#!/bin/bash

# Variables
SOURCEDIR="$HOME/S301-API"
TARGETDIR="$HOME/projets"
TARGET="$TARGETDIR/S301-API"
REMOTEDIR="/var/www/html/prj-mmorich"

clear

# Check if the source directory exists
if [ ! -d "$SOURCEDIR" ]; then
    echo "Error: Folder $SOURCEDIR not found."
    exit 2
fi

# Check if the target directory exists
if [ ! -d "$TARGETDIR" ]; then
    echo "Error: Folder $TARGETDIR not found."
    exit 2
fi

# Check if the target already exists
if [ -d "$TARGET" ]; then
    echo "Folder $TARGET already exists. Removing..."
    rm -rf "$TARGET"
    if [ $? -ne 0 ]; then
        echo "Error: Failed to remove $TARGET."
        exit 3
    fi
fi

# Proceed with the main logic
echo "Copying $SOURCEDIR to $TARGET..."
cp -r "$SOURCEDIR" "$TARGET"
if [ $? -ne 0 ]; then
    echo "Error: Failed to copy $SOURCEDIR to $TARGET."
    exit 4
fi

echo "Removing $TARGET/.git..."
rm -rf "$TARGET/.git/"
if [ $? -ne 0 ]; then
    echo "Error: Failed to remove $TARGET/.git."
    exit 5
fi

echo "Done!"

echo -e "\nConnecting to remote server..."
echo "URL: $URL"
echo "LOCAL: $SOURCEDIR"
read -p "Press enter to continue"

exit 0
