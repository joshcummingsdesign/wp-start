import {renderToString} from 'react-dom/server';
import {BlockAttributes, BlockData} from '../types/types';
import {Frontend} from '../frontend/Frontend';

declare var context: BlockAttributes & BlockData;

const html = renderToString(<Frontend ssr={true} {...context} />);

// Server-side render the output, required for functionality
console.log(html);
