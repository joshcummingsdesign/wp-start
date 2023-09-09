const path = require('path');

/**
 * Get the project root directory.
 *
 * @unreleased
 *
 * @returns {string}
 */
const getProjectRoot = () => {
    return path.resolve(__dirname, '..', '..', '..');
};

module.exports = {getProjectRoot};
