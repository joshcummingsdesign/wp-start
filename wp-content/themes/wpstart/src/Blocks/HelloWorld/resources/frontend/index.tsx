import {renderBlock} from '@blocks/helpers/renderBlock';
import {BlockAttributes, BlockData} from '../types/types';
import {Frontend} from './Frontend';

renderBlock<BlockAttributes, BlockData>(Frontend);
