const {expect, test} = require('@jest/globals');
const {getDotEnv} = require('./getDotEnv');

test('should get .env file path', () => {
    expect(getDotEnv('/foo/bar')).toEqual('/foo/bar/.env');
});
