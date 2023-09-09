const glob = require('glob');
const path = require('path');
const {themePath} = require('../themePath/themePath');

/**
 * Get resource entries.
 *
 * For example:
 *
 * ```
 * {
 *   eddLicensing: 'src/EDD/Licensing/resources/index.ts',
 *   eddLicensingDashboard: 'src/EDD/Licensing/Dashboard/resources/index.tsx',
 *   postStyle: 'src/Post/resources/index.scss',
 * }
 * ```
 *
 * @unreleased
 *
 * @param {?string} root The root directory in which to search.
 *
 * @returns {object}
 */
const getResourceEntries = (root = null) => {
    if (!root) root = themePath();

    return glob.sync(path.resolve(root, 'src/**/resources/**/index.{ts,tsx,scss}')).reduce((entries, path) => {
        const matches = path.match(/src\/(?!Blocks)(.*)\/resources\/(?!server)(.*)(\/?)index\.(ts|tsx|scss)/);
        if (matches && matches.length > 1) {
            const suffix = matches[4] === 'scss' ? 'Style' : '';
            const entry = matches
                .slice(1, 3)
                .join('/')
                .split('/')
                .map((part, i) => {
                    const p = part.toLowerCase();

                    if (i === 0) {
                        return p;
                    }

                    return p.charAt(0).toUpperCase() + p.slice(1);
                })
                .join('');
            entries[entry + suffix] = path;
        }
        return entries;
    }, {});
};

module.exports = {getResourceEntries};
