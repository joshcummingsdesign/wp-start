import {FC} from 'React';
import {BlockConfiguration, BlockEditProps, registerBlockType} from '@wordpress/blocks';
import {InnerBlocks} from '@wordpress/block-editor';
import {BaseAttributes} from '@blocks/types/types';
import {getBlockScriptData} from '@blocks/helpers/getBlockScriptData';

/**
 * Register a block.
 *
 * @unreleased
 */
export const registerBlock = <A extends BaseAttributes, D = {}>(
    blockMeta: BlockConfiguration<A>,
    EditorComponent: FC<BlockEditProps<A>>,
    FrontendComponent: FC<A & D>,
    hasInnerBlock?: boolean
) => {
    const {root, data} = getBlockScriptData<A, D>();

    registerBlockType<A>(blockMeta, {
        edit: EditorComponent,
        save: ({attributes}) => (
            <div id={attributes.blockId} className={root}>
                {hasInnerBlock ? (
                    <FrontendComponent {...attributes} {...data}>
                        <InnerBlocks.Content />
                    </FrontendComponent>
                ) : (
                    <FrontendComponent {...attributes} {...data} />
                )}
            </div>
        ),
    });
};
