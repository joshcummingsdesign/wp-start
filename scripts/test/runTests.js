const {getTestOptions} = require('./getTestOptions');
const {runCommand} = require('./runCommand');

const runTests = async () => {
    const options = await getTestOptions();

    // Error codes
    const SUCCESS = 0;

    // If all tests
    if (options.lang === 'all' && options.suite === 'all') {
        await runCommand('./scripts/test/js/unit/run.sh');
        await runCommand('./scripts/test/php/all/run.sh');
        process.exit(SUCCESS);
    }

    // If all unit tests
    if (options.lang === 'all' && options.suite === 'unit') {
        await runCommand('./scripts/test/js/unit/run.sh');
        await runCommand('./scripts/test/php/unit/run.sh');
        process.exit(SUCCESS);
    }

    // If all integration tests
    if (options.lang === 'all' && options.suite === 'integration') {
        await runCommand('./scripts/test/php/integration/run.sh');
        process.exit(SUCCESS);
    }

    // If all js tests
    if (options.lang === 'js' && options.suite === 'all') {
        if (options.watch) {
            await runCommand('./scripts/test/js/unit/watch.sh');
        } else {
            await runCommand('./scripts/test/js/unit/run.sh');
        }
        process.exit(SUCCESS);
    }

    // If js unit tests
    if (options.lang === 'js' && options.suite === 'unit') {
        if (options.watch) {
            await runCommand('./scripts/test/js/unit/watch.sh');
        } else {
            await runCommand('./scripts/test/js/unit/run.sh');
        }
        process.exit(SUCCESS);
    }

    // If js integration tests
    if (options.lang === 'js' && options.suite === 'integration') {
        console.log('There are no js integration tests to run.');
        process.exit(SUCCESS);
    }

    // If all php tests
    if (options.lang === 'php' && options.suite === 'all') {
        if (options.watch) {
            await runCommand('./scripts/test/php/all/watch.sh');
        } else {
            await runCommand('./scripts/test/php/all/run.sh');
        }
        process.exit(SUCCESS);
    }

    // If php unit tests
    if (options.lang === 'php' && options.suite === 'unit') {
        if (options.watch) {
            await runCommand('./scripts/test/php/unit/watch.sh');
        } else {
            await runCommand('./scripts/test/php/unit/run.sh');
        }
        process.exit(SUCCESS);
    }

    // If php integration tests
    if (options.lang === 'php' && options.suite === 'integration') {
        if (options.watch) {
            await runCommand('./scripts/test/php/integration/watch.sh');
        } else {
            await runCommand('./scripts/test/php/integration/run.sh');
        }
        process.exit(SUCCESS);
    }
};

runTests();
