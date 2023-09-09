: '
/**
* Push your local environment to a server.
*
* Remember to source environment variables first.
*
* @param string $1 "staging" or "e2e".
*/
'
push() {
    STR=STAGING
    DIR=$STAGING_PATH
    URL=$STAGING_URL
    USERNAME=$STAGING_SSH_USER
    HOSTNAME=$STAGING_SSH_HOST

    if [[ $1 == 'e2e' ]]; then
        STR=E2E
        DIR=$E2E_PATH
        URL=$E2E_URL
        USERNAME=$E2E_SSH_USER
        HOSTNAME=$E2E_SSH_HOST
    fi

    PRIVATE_DIR=$(echo $DIR | sed -e "s/\/html//g")

    # Warn user
    printf "${GREEN}LOCAL => $STR\n\n${NC}"
    printf "${YELLOW}Warning: You are about to replace the $1 database and uploads with that of local.\n\n${NC}"
    printf "${BLUE}Are you sure you want to continue? (y|N): ${NC}"
    read -r PROCEED
    if [[ $PROCEED != "y" ]]; then
        exit $CONFIRMATION_ERROR
    fi

    # Export database
    printf "\n${BLUE}Exporting database...${NC}\n"
    lando export-db
    echo "Success: Exported database."

    # Push database
    printf "\n${BLUE}Pushing database...${NC}\n"
    mv dbexport.sql.gz $DB_FILE.gz
    rsync -aziP --remove-source-files \
        $DB_FILE.gz \
        $USERNAME@$HOSTNAME:$PRIVATE_DIR/
    echo "Success: Pushed database."

    # Push uploads
    printf "\n${BLUE}Pushing uploads...${NC}\n"
    rsync -aziP --delete \
        ./wp-content/uploads/ \
        $USERNAME@$HOSTNAME:$DIR/wp-content/uploads/
    echo "Success: Pushed uploads."

    # Import database
    ssh $USERNAME@$HOSTNAME '
        export STR='"'$1'"'
        export DIR='"'$DIR'"'
        export PRIVATE_DIR='"'$PRIVATE_DIR'"'
        export DB_FILE='"'$DB_FILE'"'
        export URL='"'$URL'"'
        export LOCAL_URL='"'$LOCAL_URL'"'
        export GREEN='"'$GREEN'"'
        export BLUE='"'$BLUE'"'
        export NC='"'$NC'"'

        cd $DIR

        printf "\n${BLUE}Unzipping database...${NC}\n"
        gunzip $PRIVATE_DIR/$DB_FILE.gz
        echo "Success: Unzipped database."

        printf "\n${BLUE}Resetting database...${NC}\n"
        wp db reset --yes

        printf "\n${BLUE}Importing database...${NC}\n"
        wp db import $PRIVATE_DIR/$DB_FILE

        # Cleanup files
        printf "\n${BLUE}Cleaning up files...${NC}\n"
        rm -rf $PRIVATE_DIR/$DB_FILE
        echo "Success: Cleaned up files."

        # Run search replace
        printf "\n${BLUE}Running search replace...${NC}\n"
        wp search-replace $LOCAL_URL $URL --all-tables

        printf "\n${GREEN}Successfully pushed local to $STR!${NC}\n\n"
    '
}
