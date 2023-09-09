const {resolve, join} = require('path');
const {getProjectRoot} = require('../getProjectRoot/getProjectRoot');
const {exportDotEnv} = require('../exportDotEnv');
exportDotEnv(); // Export the .env file

/**
 * Get the path relative to the theme directory.
 *
 * @unreleased
 *
 * @param {?string} path The path relative to the theme directory.
 * @param {?boolean} relative Whether to use a relative path.
 * @param {string} root The project's root directory path.
 * @param {?string} themeSlug The theme slug.
 *
 * @returns {string}
 */
const themePath = (path = null, relative = false, root = '', themeSlug = null) => {
    const theme = themeSlug || process.env.THEME_SLUG;
    const relativePath = join(root, 'wp-content', 'themes', theme);
    const themeDir = relative ? relativePath : resolve(root || getProjectRoot(), relativePath);
    return path ? join(themeDir, path) : themeDir;
};

module.exports = {themePath};
