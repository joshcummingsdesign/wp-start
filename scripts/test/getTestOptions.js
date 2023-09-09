const chalk = require('chalk');
const inquirer = require('inquirer');
const minimist = require('minimist');

/**
 * Get the test options from the command line.
 *
 * Valid arguments:
 *
 * ```
 * --lang=<all|js|php>
 * --suite=<all|unit|integration>
 * --watch
 * --no-watch
 * ```
 *
 * @unreleased
 *
 * @return {Promise<{lang: string, suite: string, watch: boolean}>}
 */
const getTestOptions = () =>
    new Promise(async (resolve) => {
        let args = minimist(process.argv.slice(2));

        // Error codes
        const INVALID_ARGUMENT = 1;
        const INVALID_OPTION = 2;

        // Check for invalid args
        let error = false;
        args._.forEach((arg) => {
            if (!!arg) {
                console.log(chalk.red(`${arg} is not a valid argument`));
                error = true;
            }
        });
        if (error) process.exit(INVALID_ARGUMENT);
        delete args._;

        // Valid options (--lang, --suite, --watch, --no-watch)
        const options = {
            lang: ['all', 'js', 'php'],
            suite: ['all', 'unit', 'integration'],
            watch: [true, false],
        };

        // Check for valid args
        Object.keys(args).forEach((arg) => {
            if (!Object.keys(options).includes(arg)) {
                console.log(chalk.red(`${arg} is not a valid argument`));
                error = true;
            }
        });
        if (error) process.exit(INVALID_ARGUMENT);

        Object.keys(args).forEach((arg) => {
            if (!options[arg].includes(args[arg])) {
                console.log(chalk.red(`${args[arg]} is not a valid option for ${arg}`));
                error = true;
            }
        });
        if (error) process.exit(INVALID_OPTION);

        // If CI, run with defaults
        if (process.env.CI) {
            const defaults = {lang: 'all', suite: 'all'};
            args = {...defaults, ...args};
            args.watch = false;
            resolve(args);
        }

        // Otherwise, prompt user
        const questions = [];

        if (args.lang === undefined) {
            questions.push({
                type: 'list',
                name: 'lang',
                message: 'Language',
                choices: ['all', 'js', 'php'],
            });
        }

        if (args.suite === undefined) {
            questions.push({
                type: 'list',
                name: 'suite',
                message: 'Type',
                choices: ['all', 'unit', 'integration'],
            });
        }

        if (args.watch === undefined) {
            questions.push({
                type: 'confirm',
                name: 'watch',
                message: 'Watch?',
                default: false,
                when(answers) {
                    if (answers.lang === 'all') {
                        args.watch = false;
                        return false;
                    }
                    return true;
                },
            });
        }

        const promptUser = (questions) =>
            new Promise((resolve) => {
                inquirer.prompt(questions).then((answers) => {
                    resolve(answers);
                });
            });

        const answers = await promptUser(questions);

        args = {...args, ...answers};

        resolve(args);
    });

module.exports = {getTestOptions};
