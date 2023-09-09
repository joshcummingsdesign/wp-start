const {getDotEnv} = require('./getDotEnv/getDotEnv');

/**
 * Export the .env file.
 *
 * @unreleased
 *
 * @returns {void}
 */
const exportDotEnv = () => {
    require('dotenv').config({path: getDotEnv()});
};

module.exports = {exportDotEnv};
