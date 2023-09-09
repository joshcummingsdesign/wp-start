/**
 * Slugify a string.
 *
 * @unreleased
 */
export const slugify = (str: string, prefix: string = ''): string => {
    prefix = !prefix ? '' : `${prefix}-`;

    return (
        prefix +
        str
            // Convert anything that's not a letter or number to a hyphen.
            .replace(/[^\p{L}\p{N}]+/gu, '-')
            // Convert to lowercase.
            .toLowerCase()
            // Remove any remaining leading or trailing hyphens.
            .replace(/(^-+)|(-+$)/g, '')
    );
};
