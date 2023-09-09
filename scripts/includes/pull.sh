#!/usr/bin/env bash

: '
/**
* Pull a server to your local environment.
*
* Remember to source environment variables first.
*
* @param string $1 "staging" or "prod".
*/
'
pull() {
    STR=STAGING
    DIR=$STAGING_PATH
    URL=$STAGING_URL
    USERNAME=$STAGING_SSH_USER
    HOSTNAME=$STAGING_SSH_HOST

    if [[ $1 == 'prod' ]]; then
        STR=PROD
        DIR=$PROD_PATH
        URL=$PROD_URL
        USERNAME=$SSH_USER
        HOSTNAME=$SSH_HOST
    fi

    PRIVATE_DIR=$(echo $DIR | sed -e "s/\/html//g")

    # Warn user
    printf "${GREEN}$STR => LOCAL\n\n${NC}"
    printf "${YELLOW}Warning: You are about to replace your local database and uploads with that of $1.\n\n${NC}"
    printf "${BLUE}Are you sure you want to continue? (y|N): ${NC}"
    read -r PROCEED
    if [[ $PROCEED != "y" ]]; then
        exit $CONFIRMATION_ERROR
    fi

    if [[ $1 == 'prod' ]]; then
        # Pull database
        printf "\n${BLUE}Pulling database...${NC}\n"
        rsync -aziP $SSH_USER@$SSH_HOST:$CLEANUP_DB_PATH/clean.sql.gz ./
        echo "Success: Pulled database."

        # Unzipping database
        printf "\n${BLUE}Unzipping database...${NC}\n"
        gunzip clean.sql.gz
        mv clean.sql $DB_FILE
        echo "Success: Unzipped database."
    else
        # Export database
        ssh $USERNAME@$HOSTNAME '
            export PRIVATE_DIR='"'$PRIVATE_DIR'"'
            export DIR='"'$DIR'"'
            export DB_FILE='"'$DB_FILE'"'
            export BLUE='"'$BLUE'"'
            export NC='"'$NC'"'

            cd $DIR

            printf "\n${BLUE}Exporting database...${NC}\n"
            wp db export - | gzip -9 - > $PRIVATE_DIR/$DB_FILE.gz
        '

        # Pull database
        printf "\n${BLUE}Pulling database...${NC}\n"
        rsync -aziP --remove-source-files \
            $USERNAME@$HOSTNAME:$PRIVATE_DIR/$DB_FILE.gz \
            ./
        echo "Success: Pulled database."

        # Unzipping database
        printf "\n${BLUE}Unzipping database...${NC}\n"
        gunzip $DB_FILE.gz
        echo "Success: Unzipped database."
    fi

    # Reset database
    printf "\n${BLUE}Resetting database...${NC}\n"
    lando wp db reset --yes

    # Import database
    printf "\n${BLUE}Importing database...${NC}\n"
    lando wp db import $DB_FILE

    # Cleanup files
    printf "\n${BLUE}Cleaning up files...${NC}\n"
    rm -rf $DB_FILE
    echo "Success: Cleaned up files."

    # Run search replace
    printf "\n${BLUE}Running search replace...${NC}\n"
    lando wp search-replace $URL $LOCAL_URL --all-tables

    # Pull uploads
    printf "\n${BLUE}Pulling uploads...${NC}\n"
    rsync -aziP --delete \
        --exclude='*.log' \
        --exclude='affiliate-wp-export*' \
        --exclude='form-uploads' \
        --exclude='gravity_forms' \
        --exclude='ithemes-security' \
        --exclude='wp-offload-ses' \
        $USERNAME@$HOSTNAME:$DIR/wp-content/uploads/ \
        ./wp-content/uploads/
    echo "Success: Pulled uploads."
}
