const glob = require('glob');
const path = require('path');
const {themePath} = require('../themePath/themePath');

/**
 * Get block entries.
 *
 * For example:
 *
 * ```
 * {
 *   authorCardBlockFrontend: 'src/Blocks/AuthorCard/resources/frontend/index.ts',
 *   postMetaBlockEditor: 'src/Blocks/PostMeta/resources/editor/index.tsx',
 * }
 * ```
 *
 * @unreleased
 *
 * @param {?string} root The root directory in which to search.
 *
 * @returns {object}
 */
const getBlockEntries = (root = null) => {
    if (!root) root = themePath();

    return glob.sync(path.resolve(root, 'src/Blocks/**/resources/**/index.{ts,tsx}')).reduce((entries, path) => {
        // Block Editor
        const blockEditor = path.match(/src\/Blocks\/(.*)\/resources\/editor/);
        if (blockEditor && blockEditor.length > 1) {
            const entry = blockEditor[1].charAt(0).toLowerCase() + blockEditor[1].slice(1);
            entries[`${entry}BlockEditor`] = path;
        }

        // Block Frontend
        const blockFrontend = path.match(/src\/Blocks\/(.*)\/resources\/frontend/);
        if (blockFrontend && blockFrontend.length > 1) {
            const entry = blockFrontend[1].charAt(0).toLowerCase() + blockFrontend[1].slice(1);
            entries[`${entry}BlockFrontend`] = path;
        }

        return entries;
    }, {});
};

module.exports = {getBlockEntries};
