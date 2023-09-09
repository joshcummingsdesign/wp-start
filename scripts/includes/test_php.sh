: '
/**
* Run PHP tests.
*
* Remember to source environment variables first.
*
* @param string $1 "all", "unit", or "integration".
*/
'
test_php() {
    if [[ $1 == 'unit' ]]; then
        SUITE="--testsuite unit"
    elif [[ $1 == 'integration' ]]; then
        SUITE="--testsuite integration"
    fi

    THEME_DIR=wp-content/themes/$THEME_SLUG

    CMD="$THEME_DIR/vendor/bin/phpunit -c $THEME_DIR/phpunit.xml $SUITE"

    if [[ $CI == true ]]; then
        eval $CMD
    else
        eval "lando php $CMD"
    fi
}
