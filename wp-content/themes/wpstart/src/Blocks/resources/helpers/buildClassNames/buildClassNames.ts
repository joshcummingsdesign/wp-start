/**
 * Build css class names.
 *
 * For Example:
 * ```
 * const classNames = ['heading'] as const;
 * type ClassNames = Record<(typeof classNames)[number], string>;
 * const s = buildClassNames<ClassNames>('code-snippet', classNames);
 * ```
 * Will give you:
 * ```
 * s.root => "code-snippet__root"
 * s.heading => "code-snippet__heading"
 * ```
 *
 * @unreleased
 */
export const buildClassNames = <T>(root: string, keys: any): T & {root: string} => {
    const classNames = keys.reduce((acc, key) => {
        acc[key] = `${root}__${key}`;
        return acc;
    }, {});

    classNames.root = `${root}__root`;

    return classNames;
};
