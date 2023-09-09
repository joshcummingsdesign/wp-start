const path = require('path');
const {getProjectRoot} = require('../getProjectRoot/getProjectRoot');

/**
 * Get the .env file path.
 *
 * @unreleased
 *
 * @param {?string} root The project's root directory path.
 *
 * @returns {string}
 */
const getDotEnv = (root = null) => {
    return path.resolve(root || getProjectRoot(), '.env');
};

module.exports = {getDotEnv};
