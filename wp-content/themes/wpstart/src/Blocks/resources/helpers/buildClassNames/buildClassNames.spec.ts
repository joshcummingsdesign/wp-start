import {expect, test} from '@jest/globals';
import {buildClassNames} from './buildClassNames';

test('should build class names', () => {
    const classNames = [
        'column',
        'column_inner',
        'item',
        'category',
        'category_text',
        'label',
        'date',
        'reading_time',
        'text',
    ] as const;

    type ClassNames = Record<(typeof classNames)[number], string>;

    const actual = buildClassNames<ClassNames>('wpstart-post-meta', classNames);

    const expected = {
        category: 'wpstart-post-meta__category',
        category_text: 'wpstart-post-meta__category_text',
        column: 'wpstart-post-meta__column',
        column_inner: 'wpstart-post-meta__column_inner',
        date: 'wpstart-post-meta__date',
        item: 'wpstart-post-meta__item',
        label: 'wpstart-post-meta__label',
        reading_time: 'wpstart-post-meta__reading_time',
        root: 'wpstart-post-meta__root',
        text: 'wpstart-post-meta__text',
    };

    expect(actual).toEqual(expected);
});
