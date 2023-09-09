const path = require('path');
const fs = require('fs');
const {expect, test} = require('@jest/globals');
const {getBlockAttributeTypes} = require('./getBlockAttributeTypes');

test('should create base block attribute types', () => {
    const blockMeta = JSON.stringify({
        attributes: {
            blockId: {
                type: 'string',
                default: '',
            },
            className: {
                type: 'string',
                default: '',
            },
        },
    });

    const baseTemplate = fs.readFileSync(path.resolve(__dirname, 'templates', 'template-base.txt'), {
        encoding: 'utf-8',
    });

    expect(getBlockAttributeTypes(blockMeta)).toEqual(baseTemplate);
});

test('should create custom block attribute types', () => {
    const blockMeta = JSON.stringify({
        attributes: {
            blockId: {
                type: 'string',
                default: '',
            },
            className: {
                type: 'string',
                default: '',
            },
            content: {
                type: 'string',
                default: '',
            },
            size: {
                type: 'integer',
                default: 0,
            },
            posts: {
                type: 'array',
                default: [],
            },
            item: {
                type: 'object',
                default: {},
            },
            isOpen: {
                type: 'boolean',
                default: true,
            },
        },
    });

    const template = fs.readFileSync(path.resolve(__dirname, 'templates', 'template.txt'), {encoding: 'utf-8'});

    expect(getBlockAttributeTypes(blockMeta)).toEqual(template);
});
