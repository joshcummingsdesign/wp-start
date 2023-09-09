import {BlockEditProps} from '@wordpress/blocks';
import {useBlockProps} from '@wordpress/block-editor';
import {useEffect} from '@wordpress/element';
import {BlockAttributes} from '../types/types';

/**
 * The editor component.
 *
 * @unreleased
 */
export const Editor = ({setAttributes, clientId}: BlockEditProps<BlockAttributes>) => {
    useEffect(() => setAttributes({blockId: clientId}), [clientId]);

    return (
        <div {...useBlockProps()} style={{padding: 10, backgroundColor: '#dadada'}}>
            <h3 style={{marginTop: 0}}>Hello World</h3>
        </div>
    );
};
