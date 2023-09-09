const path = require('path');
const {expect, test} = require('@jest/globals');
const {getResourceEntries} = require('./getResourceEntries');

test('should get resource entries', () => {
    const root = path.resolve(__dirname, '..', 'stubs');

    const expected = {
        eddCheckout: path.resolve(root, 'src/EDD/checkout/resources/index.ts'),
        eddPricing: path.resolve(root, 'src/EDD/resources/pricing/index.ts'),
        eddLicensing: path.resolve(root, 'src/EDD/Licensing/resources/index.tsx'),
        eddLicensingDashboard: path.resolve(root, 'src/EDD/Licensing/Dashboard/resources/index.tsx'),
        eddLicensingDashboardFrontend: path.resolve(root, 'src/EDD/Licensing/Dashboard/resources/frontend/index.tsx'),
        postStyle: path.resolve(root, 'src/Post/resources/index.scss'),
    };

    expect(getResourceEntries(root)).toEqual(expected);
});
