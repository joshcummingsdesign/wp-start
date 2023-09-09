const path = require('path');
const {expect, test} = require('@jest/globals');
const {getServerEntries} = require('./getServerEntries');

test('should get server entries', () => {
    const root = path.resolve(__dirname, '..', 'stubs');

    const expected = {
        eddCheckoutServer: path.resolve(root, 'src/EDD/checkout/resources/server/index.ts'),
        eddLicensingServer: path.resolve(root, 'src/EDD/Licensing/resources/server/index.tsx'),
        eddLicensingDashboardServer: path.resolve(root, 'src/EDD/Licensing/Dashboard/resources/server/index.tsx'),
        postServer: path.resolve(root, 'src/Post/resources/server/index.ts'),
        authorCardBlockServer: path.resolve(root, 'src/Blocks/AuthorCard/resources/server/index.tsx'),
        postMetaBlockServer: path.resolve(root, 'src/Blocks/PostMeta/resources/server/index.tsx'),
        headerNavBlockServer: path.resolve(root, 'src/Blocks/HeaderNav/resources/server/index.tsx'),
        footerBlockServer: path.resolve(root, 'src/Blocks/Footer/resources/server/index.tsx'),
    };

    expect(getServerEntries(root)).toEqual(expected);
});
