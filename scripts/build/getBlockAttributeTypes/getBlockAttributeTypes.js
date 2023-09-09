const {filterBlockTypes} = require('../filterBlockTypes/filterBlockTypes');

/**
 * Get the block attributes types file data.
 *
 * @unreleased
 *
 * @param {string} blockMeta The contents of the block.json file.
 *
 * @returns {string}
 */
const getBlockAttributeTypes = (blockMeta) => {
    const {attributes} = JSON.parse(blockMeta);
    delete attributes.blockId;
    delete attributes.className;

    let output = "import {BaseAttributes} from '@blocks/types/types';\n\n";
    output += '/**\n';
    output += ' * Note: This is created dynamically from the attributes in block.json.\n';
    output += ' */\n';
    output += `export interface BlockAttributes extends BaseAttributes {\n`;
    Object.keys(attributes).forEach((key) => {
        output += `    ${key}: ${filterBlockTypes('ts', attributes[key].type)};\n`;
    });
    output += '}\n';

    return output;
};

module.exports = {getBlockAttributeTypes};
