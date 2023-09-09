import {BlockConfiguration, registerBlockType} from '@wordpress/blocks';
import {BlockAttributes} from '../types/types';
import {Editor} from './Editor';
import blockMeta from '../../block.json';

registerBlockType<BlockAttributes>(blockMeta as BlockConfiguration<BlockAttributes>, {
    edit: Editor,
});
