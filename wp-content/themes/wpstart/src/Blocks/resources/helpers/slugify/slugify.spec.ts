import {expect, test} from '@jest/globals';
import {slugify} from './slugify';

test('should slugify a string', () => {
    expect(slugify('Hello World')).toEqual('hello-world');
    expect(slugify('Lorem!@#$%^&*()_+ to the...Ipsum')).toEqual('lorem-to-the-ipsum');
    expect(slugify('Hello World', 'h')).toEqual('h-hello-world');
    expect(slugify('Lorem!@#$%^&*()_+ to the...Ipsum', 'h')).toEqual('h-lorem-to-the-ipsum');
});
