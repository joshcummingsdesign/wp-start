import {expect, test} from '@jest/globals';
import {scale} from './scale';

test('should scale values', () => {
    expect(scale(5, [0, 10], [-50, 50])).toEqual(0);
    expect(scale(-1, [-20, 0], [-100, 100])).toEqual(90);
    expect(scale(600, [0, 500], [0, 1])).toEqual(1);
    expect(scale(-200, [0, 500], [0, 1])).toEqual(0);
    expect(scale(-100, [0, 500], [1, 0])).toEqual(1);
    expect(scale(600, [0, 500], [1, 0])).toEqual(0);
});
