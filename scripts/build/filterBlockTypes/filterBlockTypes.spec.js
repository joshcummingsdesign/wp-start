const {expect, test} = require('@jest/globals');
const {filterBlockTypes} = require('./filterBlockTypes');

test('should filter block types', () => {
    expect(filterBlockTypes('php', 'number')).toEqual('int');
    expect(filterBlockTypes('php', 'integer')).toEqual('int');
    expect(filterBlockTypes('php', 'boolean')).toEqual('bool');
    expect(filterBlockTypes('ts', 'integer')).toEqual('number');
    expect(filterBlockTypes('ts', 'array')).toEqual('any[]');
    expect(filterBlockTypes('ts', 'object')).toEqual('any');
});
