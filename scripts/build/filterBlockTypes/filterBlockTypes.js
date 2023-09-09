/**
 * Filter block types for different languages.
 *
 * @param {string} language
 * @param {string} input
 *
 * @returns {string}
 */
const filterBlockTypes = (language, input) => {
    if (language === 'php') {
        if (input === 'number' || input === 'integer') {
            return 'int';
        }

        if (input === 'boolean') {
            return 'bool';
        }
    }

    if (language === 'ts') {
        if (input === 'integer') {
            return 'number';
        }

        if (input === 'array') {
            return 'any[]';
        }

        if (input === 'object') {
            return 'any';
        }
    }

    return input;
};

module.exports = {filterBlockTypes};
