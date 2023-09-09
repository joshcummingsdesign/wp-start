const path = require('path');
const {expect, test} = require('@jest/globals');
const {getBlockEntries} = require('./getBlockEntries');

test('should get block entries', () => {
    const root = path.resolve(__dirname, '..', 'stubs');

    const expected = {
        authorCardBlockEditor: path.resolve(root, 'src/Blocks/AuthorCard/resources/editor/index.ts'),
        footerBlockFrontend: path.resolve(root, 'src/Blocks/Footer/resources/frontend/index.tsx'),
        headerNavBlockEditor: path.resolve(root, 'src/Blocks/HeaderNav/resources/editor/index.tsx'),
        postMetaBlockFrontend: path.resolve(root, 'src/Blocks/PostMeta/resources/frontend/index.tsx'),
    };

    expect(getBlockEntries(root)).toEqual(expected);
});
