const spawn = require('child_process').spawn;

/**
 * Run a shell command.
 *
 * @unreleased
 *
 * @param {string} command The command to run.
 * @param {?string[]} options The command options.
 *
 * @return {Promise<void>}
 */
const runCommand = async (command, options = null) =>
    new Promise((resolve) => {
        const cmd = spawn(command, options, {stdio: 'inherit'});

        cmd.on('exit', (code) => {
            // Success
            if (code === 0) {
                resolve();
            } else {
                process.exit(code);
            }
        });
    });

module.exports = {runCommand};
