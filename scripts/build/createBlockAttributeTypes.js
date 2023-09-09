const glob = require('glob');
const fs = require('fs');
const {themePath} = require('./themePath/themePath');
const {getBlockAttributeTypes} = require('./getBlockAttributeTypes/getBlockAttributeTypes');

/**
 * Create the block attributes type files.
 *
 * @unreleased
 *
 * @returns {void}
 */
const createBlockAttributeTypes = () => {
    console.log('Generating block attribute types...\n');

    glob.sync(themePath('src/Blocks/**/block.json')).forEach((file) => {
        const outputPath = file.replace('block.json', 'resources/types/BlockAttributes.ts');
        const blockMeta = fs.readFileSync(file, {encoding: 'utf-8'});
        const output = getBlockAttributeTypes(blockMeta);

        fs.writeFileSync(outputPath, output);

        console.log(`${outputPath}\n`);
    });

    console.log('Generated block attribute types!\n');
};

createBlockAttributeTypes();
