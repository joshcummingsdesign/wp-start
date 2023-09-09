/**
 * @jest-environment jsdom
 */
import {beforeEach, expect, jest, test} from '@jest/globals';
import {getBlockScriptData} from './getBlockScriptData';

interface BlockAttributes {
    blockId: string;
    className: string;
}

interface BlockData {
    heading: string;
    text: string;
}

let windowSpy;

beforeEach(() => {
    windowSpy = jest.spyOn(window, 'window', 'get');
});

test('should get block script data', () => {
    windowSpy.mockImplementation(() => ({
        abcd_1234: {
            blockId: 'abcd-1234',
            className: 'my-custom-class',
        },
        app: {
            root: 'wpstart-test-block',
            data: {
                heading: 'Hello World',
                text: 'Lorem ipsum...',
            },
        },
    }));

    const {
        root,
        data: {heading, text},
        getAttributes,
    } = getBlockScriptData<BlockAttributes, BlockData>();

    const attributes = getAttributes('abcd_1234');

    const expectedAttributes = {
        blockId: 'abcd-1234',
        className: 'my-custom-class',
    };

    expect(root).toEqual('wpstart-test-block');
    expect(heading).toEqual('Hello World');
    expect(text).toEqual('Lorem ipsum...');
    expect(attributes).toEqual(expectedAttributes);
});
