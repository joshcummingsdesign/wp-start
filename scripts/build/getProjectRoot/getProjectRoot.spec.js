const path = require('path');
const {expect, test} = require('@jest/globals');
const {getProjectRoot} = require('./getProjectRoot');

test('should get project root', () => {
    expect(getProjectRoot()).toEqual(path.resolve(__dirname, '..', '..', '..'));
});
