const glob = require('glob');
const path = require('path');
const {themePath} = require('../themePath/themePath');

/**
 * Get server entries.
 *
 * For example:
 *
 * ```
 * {
 *   eddCheckoutServer: 'src/EDD/checkout/resources/server/index.ts',
 *   authorCardBlockServer: 'src/Blocks/AuthorCard/resources/server/index.tsx',
 * }
 * ```
 *
 * @unreleased
 *
 * @param {?string} root The root directory in which to search.
 *
 * @returns {object}
 */
const getServerEntries = (root = null) => {
    if (!root) root = themePath();

    return glob.sync(path.resolve(root, 'src/**/resources/**/server/index.{ts,tsx}')).reduce((entries, path) => {
        // Resource Matches
        const resourceMatches = path.match(/src\/(?!Blocks)(.*)\/resources\/(.*)(\/?)server\/index.(ts|tsx)/);
        if (resourceMatches && resourceMatches.length > 1) {
            const resourceEntry = resourceMatches
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
            entries[resourceEntry + 'Server'] = path;
        }

        // Block Matches
        const blockMatches = path.match(/src\/Blocks\/(.*)\/resources\/(.*)(\/?)server\/index.(ts|tsx)/);
        if (blockMatches && blockMatches.length > 1) {
            const blockEntry = blockMatches[1].charAt(0).toLowerCase() + blockMatches[1].slice(1);
            entries[blockEntry + 'BlockServer'] = path;
        }

        return entries;
    }, {});
};

module.exports = {getServerEntries};
