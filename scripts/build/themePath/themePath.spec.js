const path = require('path');
const {expect, test} = require('@jest/globals');
const {themePath} = require('./themePath');

test('should get the theme path', () => {
    const root = '/foo/bar';
    const slug = 'hello-world';
    const theme = `wp-content/themes/${slug}`;

    expect(themePath(null, false, root, slug)).toEqual(`${root}/${theme}`);
    expect(themePath('build', false, root, slug)).toEqual(`${root}/${theme}/build`);
    expect(themePath('build', true, '/', slug)).toEqual(`/${theme}/build`);
    expect(themePath(path.join('build', 'client', '/'), true, '/', slug)).toEqual(`/${theme}/build/client/`);
});
